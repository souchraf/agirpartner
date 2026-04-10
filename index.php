<?php
session_start();

$contactEmail = 'contact@agirpartner.com';
$candidatureEmail = 'candidature@agirpartner.com';
$maxUploadSize = 5 * 1024 * 1024;
$allowedCvExtensions = ['pdf', 'doc', 'docx'];

function generateCaptcha(string $key): string
{
    $a = random_int(2, 9);
    $b = random_int(1, 8);
    $_SESSION['captcha_' . $key] = (string) ($a + $b);

    return "{$a} + {$b}";
}

function cleanValue(string $value): string
{
    return trim(str_replace(["\r", "\n"], ' ', $value));
}

function sendPlainMail(string $to, string $subject, string $body, string $replyTo): bool
{
    $headers = [
        'From: Agir Partner <no-reply@agirpartner.com>',
        'Reply-To: ' . $replyTo,
        'Content-Type: text/plain; charset=UTF-8',
    ];

    return @mail($to, $subject, $body, implode("\r\n", $headers));
}

function sendMailWithAttachment(string $to, string $subject, string $body, string $replyTo, array $file): bool
{
    $boundary = 'agirpartner_' . md5((string) microtime(true));
    $headers = [
        'From: Agir Partner <no-reply@agirpartner.com>',
        'Reply-To: ' . $replyTo,
        'MIME-Version: 1.0',
        'Content-Type: multipart/mixed; boundary="' . $boundary . '"',
    ];

    $filename = basename($file['name']);
    $fileContent = chunk_split(base64_encode((string) file_get_contents($file['tmp_name'])));
    $mimeType = $file['type'] ?: 'application/octet-stream';

    $message = "--{$boundary}\r\n";
    $message .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $message .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    $message .= $body . "\r\n\r\n";
    $message .= "--{$boundary}\r\n";
    $message .= "Content-Type: {$mimeType}; name=\"{$filename}\"\r\n";
    $message .= "Content-Transfer-Encoding: base64\r\n";
    $message .= "Content-Disposition: attachment; filename=\"{$filename}\"\r\n\r\n";
    $message .= $fileContent . "\r\n";
    $message .= "--{$boundary}--";

    return @mail($to, $subject, $message, implode("\r\n", $headers));
}

$contactStatus = null;
$candidatureStatus = null;
$contactValues = ['name' => '', 'email' => '', 'company' => '', 'message' => ''];
$candidateValues = ['name' => '', 'email' => '', 'phone' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formType = $_POST['form_type'] ?? '';
    $honeypot = trim($_POST['website'] ?? '');

    if ($formType === 'contact') {
        $contactValues = [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'company' => trim($_POST['company'] ?? ''),
            'message' => trim($_POST['message'] ?? ''),
        ];

        $captchaAnswer = trim($_POST['captcha_answer'] ?? '');
        $expectedCaptcha = $_SESSION['captcha_contact'] ?? '';

        if ($honeypot !== '') {
            $contactStatus = ['type' => 'success', 'message' => "Merci, votre message a bien ete transmis."];
        } elseif (
            $contactValues['name'] === '' ||
            $contactValues['email'] === '' ||
            $contactValues['message'] === '' ||
            !filter_var($contactValues['email'], FILTER_VALIDATE_EMAIL)
        ) {
            $contactStatus = ['type' => 'error', 'message' => "Merci de verifier vos informations avant l'envoi."];
        } elseif ($captchaAnswer === '' || $captchaAnswer !== $expectedCaptcha) {
            $contactStatus = ['type' => 'error', 'message' => "Le captcha de contact est incorrect."];
        } else {
            $subject = 'Nouveau message de contact - agirpartner.com';
            $body = "Nom : " . cleanValue($contactValues['name']) . "\n";
            $body .= "Email : " . cleanValue($contactValues['email']) . "\n";
            $body .= "Societe : " . cleanValue($contactValues['company']) . "\n\n";
            $body .= "Message :\n" . trim($contactValues['message']) . "\n";

            $sent = sendPlainMail($contactEmail, $subject, $body, $contactValues['email']);
            $contactStatus = $sent
                ? ['type' => 'success', 'message' => "Merci, votre message a bien ete transmis."]
                : ['type' => 'error', 'message' => "L'envoi n'a pas abouti pour le moment. Merci de reessayer dans quelques instants."];
        }
    }

    if ($formType === 'candidature') {
        $candidateValues = [
            'name' => trim($_POST['candidate_name'] ?? ''),
            'email' => trim($_POST['candidate_email'] ?? ''),
            'phone' => trim($_POST['candidate_phone'] ?? ''),
            'message' => trim($_POST['candidate_message'] ?? ''),
        ];

        $captchaAnswer = trim($_POST['candidate_captcha_answer'] ?? '');
        $expectedCaptcha = $_SESSION['captcha_candidate'] ?? '';
        $cvFile = $_FILES['cv_file'] ?? null;

        if ($honeypot !== '') {
            $candidatureStatus = ['type' => 'success', 'message' => "Merci, votre candidature a bien ete transmise."];
        } elseif (
            $candidateValues['name'] === '' ||
            $candidateValues['email'] === '' ||
            !filter_var($candidateValues['email'], FILTER_VALIDATE_EMAIL) ||
            !$cvFile ||
            ($cvFile['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK
        ) {
            $candidatureStatus = ['type' => 'error', 'message' => "Merci de completer le formulaire et de joindre votre CV."];
        } elseif ($captchaAnswer === '' || $captchaAnswer !== $expectedCaptcha) {
            $candidatureStatus = ['type' => 'error', 'message' => "Le captcha de candidature est incorrect."];
        } else {
            $extension = strtolower(pathinfo((string) $cvFile['name'], PATHINFO_EXTENSION));

            if (!in_array($extension, $allowedCvExtensions, true)) {
                $candidatureStatus = ['type' => 'error', 'message' => "Le CV doit etre au format PDF, DOC ou DOCX."];
            } elseif (($cvFile['size'] ?? 0) > $maxUploadSize) {
                $candidatureStatus = ['type' => 'error', 'message' => "Le CV depasse la taille maximale de 5 Mo."];
            } else {
                $subject = 'Nouvelle candidature - agirpartner.com';
                $body = "Nom : " . cleanValue($candidateValues['name']) . "\n";
                $body .= "Email : " . cleanValue($candidateValues['email']) . "\n";
                $body .= "Telephone : " . cleanValue($candidateValues['phone']) . "\n\n";
                $body .= "Message :\n" . trim($candidateValues['message']) . "\n";

                $sent = sendMailWithAttachment(
                    $candidatureEmail,
                    $subject,
                    $body,
                    $candidateValues['email'],
                    $cvFile
                );

                $candidatureStatus = $sent
                    ? ['type' => 'success', 'message' => "Merci, votre candidature a bien ete transmise."]
                    : ['type' => 'error', 'message' => "L'envoi n'a pas abouti pour le moment. Merci de reessayer dans quelques instants."];
            }
        }
    }
}

$contactCaptchaQuestion = generateCaptcha('contact');
$candidateCaptchaQuestion = generateCaptcha('candidate');

$services = [
    [
        'title' => 'Conseil SIRH',
        'description' => "Cadrage, aide au choix, gouvernance et roadmap pour aligner les enjeux RH, IT et metier.",
    ],
    [
        'title' => 'IT Consulting',
        'description' => "Pilotage de projets, AMOA, coordination delivery et renfort sur les phases sensibles des programmes.",
    ],
    [
        'title' => 'Run et optimisation',
        'description' => "Stabilisation, accompagnement des usages et optimisation continue des dispositifs SIRH.",
    ],
];

$trustedCompanies = [
    ['name' => 'Eiffage', 'logo' => 'assets/logos/eiffage.svg'],
    ['name' => 'TotalEnergies', 'logo' => 'assets/logos/totalenergies.svg'],
    ['name' => 'Banque de France', 'logo' => 'assets/logos/banque-de-france.svg'],
    ['name' => 'Paris Habitat', 'logo' => 'assets/logos/paris-habitat.svg'],
    ['name' => 'Sanofi', 'logo' => 'assets/logos/sanofi.svg'],
    ['name' => 'Engie', 'logo' => 'assets/logos/engie.svg'],
];

$testimonials = [
    [
        'text' => "Agir Partner a remis de la clarte dans un programme SIRH qui patinait. En quelques semaines, nous avions une gouvernance lisible et des decisions plus rapides.",
        'name' => 'Directrice Transformation RH',
        'role' => 'Groupe energie',
    ],
    [
        'text' => "Leur force a ete de relier les besoins metier, les contraintes IT et les attentes des utilisateurs sans complexifier le projet.",
        'name' => 'Responsable SIRH',
        'role' => 'Acteur immobilier public',
    ],
    [
        'text' => "Nous cherchions un partenaire capable de cadrer, challenger et accelerer. La mission a apporte un vrai cap au programme.",
        'name' => 'DRH adjointe',
        'role' => 'Industrie sante',
    ],
    [
        'text' => "Le pilotage a gagne en fluidite et les points d'arbitrage sont devenus beaucoup plus simples. Les livrables etaient vraiment actionnables.",
        'name' => 'Directeur de programme',
        'role' => 'Grande infrastructure',
    ],
    [
        'text' => "L'approche est premium mais tres concrete. On sent une vraie maitrise des sujets SIRH et une excellente lecture des enjeux delivery.",
        'name' => 'DSI RH',
        'role' => 'Services financiers',
    ],
    [
        'text' => "Agir Partner a su remettre de la confiance dans un contexte tendu. Les equipes se sont rapidement re-alignees.",
        'name' => 'Cheffe de projet transformation',
        'role' => 'Grand compte industrie',
    ],
];

$columns = array_chunk($testimonials, 2);
?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Agir Partner accompagne les entreprises en conseil SIRH et IT consulting avec une approche premium, claire et orientee execution."
    />
    <title>Agir Partner | Conseil SIRH et IT Consulting</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div class="page-orb orb-left" aria-hidden="true"></div>
    <div class="page-orb orb-right" aria-hidden="true"></div>

    <header class="hero" id="accueil">
      <div class="container">
        <div class="nav-shell reveal">
          <nav class="nav">
            <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="mobile-menu" data-menu-toggle>
              <span class="sr-only">Ouvrir le menu</span>
              <span></span>
              <span></span>
              <span></span>
            </button>

            <a class="brand" href="#accueil" aria-label="Agir Partner">
              <img src="assets/brand/logo-agir-partner-modern.png" alt="Logo Agir Partner" />
            </a>

            <div class="nav-links-desktop" aria-label="Navigation principale">
              <a class="nav-link current" href="#accueil" aria-current="page">Accueil</a>
              <a class="nav-link" href="#services">Services</a>
              <a class="nav-link" href="#candidature">Candidature</a>
            </div>

            <a class="nav-cta" href="#contact">Parlez-nous</a>
          </nav>
        </div>

        <div class="mobile-menu" id="mobile-menu" data-mobile-menu hidden>
          <div class="mobile-menu-panel">
            <button class="mobile-close" type="button" aria-label="Fermer le menu" data-menu-close>&times;</button>
            <a href="#accueil" data-mobile-link>Accueil</a>
            <a href="#services" data-mobile-link>Services</a>
            <a href="#candidature" data-mobile-link>Candidature</a>
            <a href="#contact" data-mobile-link>Parlez-nous</a>
          </div>
        </div>

        <section class="hero-grid">
          <div class="hero-copy reveal">
            <p class="eyebrow">Conseil SIRH et IT Consulting</p>
            <h1><span class="hero-brand">Agir Partner</span><span class="hero-sub">vous aide a agir.</span></h1>
            <p class="lead">
              Nous aidons les organisations a cadrer, piloter et remettre en mouvement leurs
              programmes RH et IT avec une execution claire, senior et directement utile.
            </p>

            <div class="hero-actions">
              <a class="btn btn-primary" href="#contact">Parler a un consultant</a>
              <a class="btn btn-secondary" href="#candidature">Deposer un CV</a>
            </div>

            <div class="hero-facts">
              <div class="fact">
                <strong>Clarte de pilotage</strong>
                <span>Un cap plus lisible pour les directions RH, DSI et metiers.</span>
              </div>
              <div class="fact">
                <strong>Intervention senior</strong>
                <span>Des missions menees avec exigence, rythme et sens du delivery.</span>
              </div>
              <div class="fact">
                <strong>Execution concrete</strong>
                <span>Des arbitrages actionnables et une mise en mouvement immediate.</span>
              </div>
            </div>
          </div>

          <aside class="hero-panel reveal">
            <div class="panel-visual">
              <img
                src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1200&q=80"
                alt="Equipe en reunion autour d'un programme de transformation"
              />
            </div>
            <div class="hero-note">
              <strong>Cabinet de transformation RH et IT</strong>
              <p>Des interventions concues pour les contextes exigeants, avec une culture claire du resultat.</p>
            </div>
            <div class="panel-content">
              <p class="eyebrow subtle">ADN du cabinet</p>
              <h2>Relier vision, gouvernance et execution sans alourdir les projets.</h2>
              <ul class="panel-list">
                <li>Conseil SIRH de cadrage, choix, pilotage et optimisation continue</li>
                <li>IT consulting avec une forte culture delivery et gouvernance</li>
                <li>Accompagnement premium, humain et structure autour de decisions utiles</li>
              </ul>
            </div>
          </aside>
        </section>
      </div>
    </header>

    <main>
      <section class="section" id="services">
        <div class="container">
          <div class="section-heading reveal">
            <p class="eyebrow">Services</p>
            <h2>Des interventions de conseil concues pour remettre les programmes en mouvement.</h2>
            <p>
              Nous intervenons sur les moments qui comptent: cadrer un programme, arbitrer les
              priorites, securiser l'execution et installer une trajectoire durable.
            </p>
          </div>

          <div class="services-grid">
            <?php foreach ($services as $index => $service): ?>
              <article class="service-card reveal">
                <span class="service-index">0<?= $index + 1; ?></span>
                <h3><?= htmlspecialchars($service['title']); ?></h3>
                <p><?= htmlspecialchars($service['description']); ?></p>
              </article>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section class="section section-soft" id="references">
        <div class="container">
          <div class="section-heading narrow reveal">
            <p class="eyebrow">Ils nous font confiance</p>
            <h2 class="trusted-headline">Des organisations exigeantes nous ont confie des enjeux de transformation et de pilotage.</h2>
          </div>

          <div class="trusted-line reveal">
            <?php foreach ($trustedCompanies as $company): ?>
              <div class="trusted-logo" aria-label="<?= htmlspecialchars($company['name']); ?>">
                <img
                  src="<?= htmlspecialchars($company['logo']); ?>"
                  alt="Logo <?= htmlspecialchars($company['name']); ?>"
                  loading="lazy"
                />
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section class="section dual-section" id="candidature">
        <div class="container dual-grid">
          <div class="contact-spotlight reveal">
            <p class="eyebrow">Candidature</p>
            <h2>Deposez votre CV pour rejoindre Agir Partner.</h2>
            <p>
              Nous etudions les profils en conseil SIRH, pilotage de projets, AMOA, PMO,
              transformation RH et accompagnement delivery.
            </p>
            <ul>
              <li>Missions a forte valeur ajoutee sur des contextes RH et IT exigeants</li>
              <li>Recherche de profils autonomes, fiables et orientes execution</li>
              <li>CV et message transmis directement a candidature@agirpartner.com</li>
            </ul>
            <div class="mini-actions">
              <a class="mini-link" href="#services">Voir nos expertises</a>
            </div>
          </div>

          <div class="contact-card reveal">
            <form class="contact-form" method="post" action="#candidature" enctype="multipart/form-data">
              <input type="hidden" name="form_type" value="candidature" />
              <div class="field-trap" aria-hidden="true">
                <label>Site web
                  <input type="text" name="website" tabindex="-1" autocomplete="off" />
                </label>
              </div>
              <label>
                Nom
                <input type="text" name="candidate_name" placeholder="Votre nom" value="<?= htmlspecialchars($candidateValues['name']); ?>" required />
              </label>
              <label>
                Email
                <input type="email" name="candidate_email" placeholder="vous@domaine.fr" value="<?= htmlspecialchars($candidateValues['email']); ?>" required />
              </label>
              <label>
                Telephone
                <input type="text" name="candidate_phone" placeholder="Votre numero" value="<?= htmlspecialchars($candidateValues['phone']); ?>" />
              </label>
              <label>
                CV
                <input type="file" name="cv_file" accept=".pdf,.doc,.docx" required />
              </label>
              <label>
                Message
                <textarea name="candidate_message" rows="4" placeholder="Quelques lignes sur votre parcours, votre disponibilite ou le type de mission recherche."><?= htmlspecialchars($candidateValues['message']); ?></textarea>
              </label>
              <label>
                Captcha: combien font <?= htmlspecialchars($candidateCaptchaQuestion); ?> ?
                <input type="text" name="candidate_captcha_answer" placeholder="Votre reponse" required />
              </label>
              <button class="contact-mail" type="submit">Envoyer ma candidature</button>
              <?php if ($candidatureStatus): ?>
                <p class="form-feedback <?= htmlspecialchars($candidatureStatus['type']); ?>">
                  <?= htmlspecialchars($candidatureStatus['message']); ?>
                </p>
              <?php else: ?>
                <p class="form-feedback">Formats acceptes : PDF, DOC, DOCX. Taille maximale : 5 Mo. Le captcha protege le formulaire contre les envois automatises.</p>
              <?php endif; ?>
            </form>
          </div>
        </div>
      </section>

      <section class="section" id="contact">
        <div class="container">
          <div class="contact-shell reveal">
            <div class="contact-copy">
              <p class="eyebrow">Parlez-nous</p>
              <h2>Parlons de votre prochain sujet SIRH, gouvernance ou IT consulting.</h2>
              <p>
                Pour un besoin de cadrage, de pilotage, de renfort conseil ou d'optimisation,
                laissez-nous un message. Nous revenons vers vous rapidement avec un premier
                niveau de lecture du besoin.
              </p>
              <div class="mini-actions">
                <a class="mini-link" href="#candidature">Vous souhaitez nous rejoindre ?</a>
              </div>
            </div>

            <div class="contact-card">
              <form class="contact-form" method="post" action="#contact">
                <input type="hidden" name="form_type" value="contact" />
                <div class="field-trap" aria-hidden="true">
                  <label>Site web
                    <input type="text" name="website" tabindex="-1" autocomplete="off" />
                  </label>
                </div>
                <label>
                  Nom
                  <input type="text" name="name" placeholder="Votre nom" value="<?= htmlspecialchars($contactValues['name']); ?>" required />
                </label>
                <label>
                  Email
                  <input type="email" name="email" placeholder="vous@entreprise.fr" value="<?= htmlspecialchars($contactValues['email']); ?>" required />
                </label>
                <label>
                  Societe
                  <input type="text" name="company" placeholder="Votre societe" value="<?= htmlspecialchars($contactValues['company']); ?>" />
                </label>
                <label>
                  Votre besoin
                  <textarea name="message" rows="5" placeholder="Parlez-nous de votre contexte, de votre projet ou de votre besoin." required><?= htmlspecialchars($contactValues['message']); ?></textarea>
                </label>
                <label>
                  Captcha: combien font <?= htmlspecialchars($contactCaptchaQuestion); ?> ?
                  <input type="text" name="captcha_answer" placeholder="Votre reponse" required />
                </label>
                <button class="contact-mail" type="submit">Envoyer la demande</button>
                <?php if ($contactStatus): ?>
                  <p class="form-feedback <?= htmlspecialchars($contactStatus['type']); ?>">
                    <?= htmlspecialchars($contactStatus['message']); ?>
                  </p>
                <?php else: ?>
                  <p class="form-feedback">Une reponse rapide pour cadrer le besoin et definir le bon format d'accompagnement. Le captcha limite les sollicitations automatiques.</p>
                <?php endif; ?>
              </form>
            </div>
          </div>
        </div>
      </section>

      <section class="section testimonials-section" id="temoignages">
        <div class="container">
          <div class="section-heading narrow reveal">
            <p class="eyebrow">Temoignages</p>
            <h2>Ce que nos clients retiennent de nos interventions.</h2>
            <p>
              Une mise en mouvement rapide, un pilotage plus lisible et une execution mieux
              alignee entre les acteurs RH, IT et metier.
            </p>
          </div>

          <div class="testimonials-mask">
            <div class="testimonials-columns">
              <?php foreach ($columns as $columnIndex => $column): ?>
                <div class="testimonials-column <?= $columnIndex > 0 ? 'desktop-only' : ''; ?>">
                  <div class="testimonials-track speed-<?= $columnIndex + 1; ?>">
                    <?php for ($loop = 0; $loop < 2; $loop++): ?>
                      <?php foreach ($column as $testimonial): ?>
                        <article class="testimonial-card">
                          <p class="testimonial-text">"<?= htmlspecialchars($testimonial['text']); ?>"</p>
                          <div class="testimonial-person">
                            <div class="testimonial-avatar"><?= strtoupper(substr($testimonial['name'], 0, 1)); ?></div>
                            <div>
                              <strong><?= htmlspecialchars($testimonial['name']); ?></strong>
                              <span><?= htmlspecialchars($testimonial['role']); ?></span>
                            </div>
                          </div>
                        </article>
                      <?php endforeach; ?>
                    <?php endfor; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </section>
    </main>

    <footer class="site-footer">
      <div class="container footer-grid">
        <div class="footer-copy-block">
          <p class="footer-brand">Agir Partner</p>
          <p class="footer-meta">Cabinet de conseil en transformation, pilotage et accompagnement des programmes RH et IT.</p>
          <p class="footer-copy">Conseil SIRH et IT consulting. Un accompagnement premium, clair et oriente execution.</p>
        </div>
        <div class="footer-links">
          <a href="mentions-legales.php">Mentions legales</a>
          <a href="politique-confidentialite.php">Politique de confidentialite</a>
          <a href="#contact">Contact</a>
        </div>
      </div>
      <div class="container footer-bottom">
        <p>Hebergement : OVHcloud</p>
        <p>&copy; <?= date('Y'); ?> Agir Partner. Tous droits reserves.</p>
      </div>
    </footer>

    <script src="script.js"></script>
  </body>
</html>

