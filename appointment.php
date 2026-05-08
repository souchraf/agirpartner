<?php
declare(strict_types=1);

$recipient = 'aouras.soufiane@gmail.com';
$redirect = 'index.html#contact-client';

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

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $message === '' || $captcha !== '9') {
    header("Location: {$redirect}");
    exit;
}

$safeName = preg_replace("/[\r\n]+/", ' ', $name) ?: 'Contact';
$safeEmail = filter_var($email, FILTER_SANITIZE_EMAIL) ?: '';

$subject = "Demande de contact client - {$safeName}";
$body = implode("\n", [
    "Nom : {$safeName}",
    "Email : {$safeEmail}",
    "",
    "Besoin :",
    $message,
]);

$headers = [
    'MIME-Version: 1.0',
    'Content-Type: text/plain; charset=UTF-8',
    "From: Agir Partner <no-reply@{$_SERVER['HTTP_HOST']}>",
    "Reply-To: {$safeEmail}",
    'X-Mailer: PHP/' . phpversion(),
];

mail($recipient, $subject, $body, implode("\r\n", $headers));
header("Location: {$redirect}");
exit;
