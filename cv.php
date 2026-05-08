<?php
declare(strict_types=1);

$recipient = 'aouras.soufiane@gmail.com';
$redirect = 'index.html#candidature';
$maxSize = 5 * 1024 * 1024;
$allowedExtensions = ['pdf', 'doc', 'docx'];
$allowedMimeTypes = [
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: {$redirect}");
    exit;
}

if (trim((string)($_POST['company'] ?? '')) !== '') {
    header("Location: {$redirect}");
    exit;
}

$name = trim((string)($_POST['name'] ?? ''));
$email = trim((string)($_POST['email'] ?? ''));
$message = trim((string)($_POST['message'] ?? ''));
$captcha = trim((string)($_POST['captcha_answer'] ?? ''));
$file = $_FILES['cv_file'] ?? null;

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $captcha !== '11' || !$file || $file['error'] !== UPLOAD_ERR_OK) {
    header("Location: {$redirect}");
    exit;
}

if ((int)$file['size'] > $maxSize) {
    header("Location: {$redirect}");
    exit;
}

$originalName = (string)$file['name'];
$extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
$mimeType = mime_content_type($file['tmp_name']) ?: '';

if (!in_array($extension, $allowedExtensions, true) || !in_array($mimeType, $allowedMimeTypes, true)) {
    header("Location: {$redirect}");
    exit;
}

$safeName = preg_replace("/[\r\n]+/", ' ', $name) ?: 'Candidat';
$safeEmail = filter_var($email, FILTER_SANITIZE_EMAIL) ?: '';
$safeFileName = preg_replace('/[^A-Za-z0-9._-]/', '_', $originalName) ?: 'cv.pdf';

$subject = "Nouvelle candidature - {$safeName}";
$messageBody = implode("\n", [
    "Nom : {$safeName}",
    "Email : {$safeEmail}",
    "",
    "Message :",
    $message,
]);

$fileContent = chunk_split(base64_encode((string)file_get_contents($file['tmp_name'])));
$boundary = md5((string)microtime(true));

$headers = [
    "From: Agir Partner <no-reply@{$_SERVER['HTTP_HOST']}>",
    "Reply-To: {$safeEmail}",
    'MIME-Version: 1.0',
    "Content-Type: multipart/mixed; boundary=\"{$boundary}\"",
];

$body = "--{$boundary}\r\n";
$body .= "Content-Type: text/plain; charset=UTF-8\r\n";
$body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
$body .= $messageBody . "\r\n";
$body .= "--{$boundary}\r\n";
$body .= "Content-Type: {$mimeType}; name=\"{$safeFileName}\"\r\n";
$body .= "Content-Disposition: attachment; filename=\"{$safeFileName}\"\r\n";
$body .= "Content-Transfer-Encoding: base64\r\n\r\n";
$body .= $fileContent . "\r\n";
$body .= "--{$boundary}--";

mail($recipient, $subject, $body, implode("\r\n", $headers));
header("Location: {$redirect}");
exit;
