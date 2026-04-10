<?php
$contactEmail = 'contact@agirpartner.com';
$formStatus = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $website = trim($_POST['website'] ?? '');

    if ($website !== '') {
        $formStatus = ['type' => 'success', 'message' => "Merci, votre demande a bien ete envoyee."];
    } elseif ($name === '' || $email === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $formStatus = ['type' => 'error', 'message' => "Merci de verifier vos informations avant l'envoi."];
    } else {
        $subject = 'Nouveau message depuis agirpartner.com';
        $body = "Nom : {$name}\n";
        $body .= "Email : {$email}\n";
        $body .= "Societe : {$company}\n\n";
        $body .= "Message :\n{$message}\n";

        $headers = [
            'From: Agir Partner <no-reply@agirpartner.com>',
            'Reply-To: ' . $email,
            'Content-Type: text/plain; charset=UTF-8',
        ];

        $sent = @mail($contactEmail, $subject, $body, implode("\r\n", $headers));

        if ($sent) {
            $formStatus = ['type' => 'success', 'message' => "Merci, votre demande a bien ete envoyee."];
        } else {
            $formStatus = ['type' => 'error', 'message' => "L'envoi n'a pas abouti pour le moment. Merci de reessayer dans quelques instants."];
        }
    }
}

$services = [
    [
        'title' => 'Conseil SIRH',
        'description' => "Cadrage des besoins, aide au choix de solution, roadmap et gouvernance pour faire converger les enjeux RH, IT et metier.",
    ],
    [
        'title' => 'IT Consulting',
        'description' => "Pilotage de projets, AMOA, coordination des editeurs et accompagnement des equipes pour fluidifier l'execution et tenir les jalons.",
    ],
    [
        'title' => 'Run et optimisation',
        'description' => "Stabilisation post go-live, accompagnement des usages, mesure de la valeur et optimisation continue des dispositifs SIRH.",
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
        'text' => "Agir Partner a remis de la clarte dans un programme SIRH qui patinait. En quelques semaines, nous avions une gouvernance lisible, des priorites tranchees et des decisions plus rapides.",
        'name' => 'Directrice Transformation RH',
        'role' => 'Groupe energie',
    ],
    [
        'text' => "Leur force a ete de relier les besoins metier, les contraintes IT et les attentes des utilisateurs sans complexifier le projet. L'accompagnement a ete tres rassurant pour les equipes.",
        'name' => 'Responsable SIRH',
        'role' => 'Acteur immobilier public',
    ],
    [
        'text' => "Nous cherchions un partenaire capable de cadrer, challenger et accelerer. La mission a apporte un vrai cap et un niveau d'exigence utile pour toutes les parties prenantes.",
        'name' => 'DRH adjointe',
        'role' => 'Industrie sante',
    ],
    [
        'text' => "Le pilotage a gagne en fluidite et les points d'arbitrage sont devenus beaucoup plus simples. Nous avons enfin eu des livrables actionnables et un rythme de travail solide.",
        'name' => 'Directeur de programme',
        'role' => 'Grande infrastructure',
    ],
    [
        'text' => "L'approche est a la fois premium et tres concrete. On sent une vraie maitrise des sujets SIRH, mais aussi une excellente lecture des enjeux de delivery et d'adoption.",
        'name' => 'DSI RH',
        'role' => 'Services financiers',
    ],
    [
        'text' => "Agir Partner a su remettre de la confiance dans un contexte tendu. Les equipes se sont rapidement re-alignees autour d'une trajectoire compréhensible et realiste.",
        'name' => 'Cheffe de projet transformation',
        'role' => 'Grand compte industrie',
    ],
    [
        'text' => "Nous avions besoin d'un regard externe solide, sans jargon inutile. L'accompagnement a ete exigeant, elegant et surtout tres efficace pour faire avancer le programme.",
        'name' => 'Directeur PMO',
        'role' => 'Habitat et services publics',
    ],
    [
        'text' => "La mission a permis de reconnecter les decisions strategiques avec le terrain. Les utilisateurs ont ete mieux embarques et les sponsors ont retrouve de la visibilite.",
        'name' => 'Responsable conduite du changement',
        'role' => 'Groupe multi-sites',
    ],
    [
        'text' => "Sur des sujets sensibles entre RH, IT et editeur, l'intervention d'Agir Partner a clairement fait la difference. Le niveau de structuration et de tact relationnel a ete remarquable.",
        'name' => 'Manager transformation digitale',
        'role' => 'Groupe CAC 40',
    ],
];

$columns = array_chunk($testimonials, 3);
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
              <a class="nav-link current" href="#accueil">Accueil</a>
              <a class="nav-link" href="#services">Services</a>
              <a class="nav-link" href="#temoignages">Temoignages</a>
            </div>

            <a class="nav-cta" href="#contact">Parler nous</a>
          </nav>
        </div>

        <div class="mobile-menu" id="mobile-menu" data-mobile-menu hidden>
          <div class="mobile-menu-panel">
            <button class="mobile-close" type="button" aria-label="Fermer le menu" data-menu-close>×</button>
            <a href="#accueil" data-mobile-link>Accueil</a>
            <a href="#services" data-mobile-link>Services</a>
            <a href="#temoignages" data-mobile-link>Temoignages</a>
            <a href="#contact" data-mobile-link>Parler nous</a>
          </div>
        </div>

        <section class="hero-grid">
          <div class="hero-copy reveal">
            <p class="eyebrow">ESN SIRH et IT Consulting</p>
            <h1>Agir Partner vous aide a agir.</h1>
            <p class="lead">
              Agir Partner accompagne les organisations dans le cadrage, le pilotage et
              l'optimisation de leurs transformations SIRH et IT avec une approche sobre,
              exigeante et directement utile au terrain.
            </p>

            <div class="hero-actions">
              <a class="btn btn-primary" href="#services">Decouvrir nos expertises</a>
              <a class="btn btn-secondary" href="#contact">Parler de votre projet</a>
            </div>

            <div class="hero-highlights">
              <div class="highlight-card">
                <strong>Cadrage</strong>
                <span>Un cap clair des les premieres semaines.</span>
              </div>
              <div class="highlight-card">
                <strong>Delivery</strong>
                <span>Un pilotage plus simple et plus fluide.</span>
              </div>
              <div class="highlight-card">
                <strong>Adoption</strong>
                <span>Accompagnement des equipes et ancrage durable des usages.</span>
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
            <div class="panel-content">
              <p class="eyebrow subtle">ADN du cabinet</p>
              <h2>Relier vision, gouvernance et terrain sans sur-complexifier les projets.</h2>
              <ul class="panel-list">
                <li>Conseil SIRH de cadrage a l'optimisation continue</li>
                <li>Interventions IT consulting avec une forte culture delivery</li>
                <li>Accompagnement premium, humain et oriente resultats</li>
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
            <h2>Des interventions de conseil pensees pour aligner RH, IT et metier.</h2>
            <p>
              Nous intervenons sur les moments cles d'un programme: cadrer, arbitrer, remettre de
              la lisibilite, accelerer l'execution et stabiliser dans la duree.
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
            <h2>Des organisations exigeantes nous ont confie des enjeux de transformation et de pilotage.</h2>
          </div>

          <div class="trusted-line reveal">
            <?php foreach ($trustedCompanies as $company): ?>
              <div class="trusted-logo" aria-label="<?= htmlspecialchars($company['name']); ?>">
                <img
                  src="<?= htmlspecialchars($company['logo']); ?>"
                  alt="Logo <?= htmlspecialchars($company['name']); ?>"
                  loading="lazy"
                  referrerpolicy="no-referrer"
                />
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section class="section" id="contact">
        <div class="container">
          <div class="contact-shell reveal">
            <div class="contact-copy">
              <p class="eyebrow">Contact</p>
              <h2>Parlons de votre prochain sujet SIRH ou IT consulting.</h2>
              <p>
                Pour un besoin de cadrage, de pilotage, de renfort conseil ou d'optimisation,
                laissez-nous un message et nous revenons vers vous rapidement.
              </p>
            </div>

            <div class="contact-card">
              <form class="contact-form" method="post" action="#contact">
                <input type="hidden" name="website" value="" />
                <label>
                  Nom
                  <input type="text" name="name" placeholder="Votre nom" required />
                </label>
                <label>
                  Email
                  <input type="email" name="email" placeholder="vous@entreprise.fr" required />
                </label>
                <label>
                  Societe
                  <input type="text" name="company" placeholder="Votre societe" />
                </label>
                <label>
                  Votre besoin
                  <textarea name="message" rows="5" placeholder="Parlez-nous de votre contexte, de votre projet ou de votre besoin." required></textarea>
                </label>
                <button class="contact-mail" type="submit">Envoyer la demande</button>
                <?php if ($formStatus): ?>
                  <p class="form-feedback <?= htmlspecialchars($formStatus['type']); ?>">
                    <?= htmlspecialchars($formStatus['message']); ?>
                  </p>
                <?php else: ?>
                  <p class="form-feedback">Une reponse rapide pour cadrer le besoin et definir le bon format d'accompagnement.</p>
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
                <div class="testimonials-column <?= $columnIndex > 0 ? 'desktop-only' : ''; ?> <?= $columnIndex > 1 ? 'wide-only' : ''; ?>">
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

    <script src="script.js"></script>
  </body>
</html>
