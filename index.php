<?php
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
    ['name' => 'Eiffage', 'mark' => 'E'],
    ['name' => 'TotalEnergies', 'mark' => 'T'],
    ['name' => 'Banque de France', 'mark' => 'B'],
    ['name' => 'Paris Habitat', 'mark' => 'P'],
    ['name' => 'Sanofi', 'mark' => 'S'],
    ['name' => 'Engie', 'mark' => 'E'],
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
        <nav class="nav reveal">
          <a class="brand" href="#accueil">Agir Partner</a>
          <div class="nav-links">
            <a href="#services">Services</a>
            <a href="#temoignages">Temoignages</a>
            <a href="#contact">Contact</a>
          </div>
          <a class="nav-cta" href="mailto:contact@agirpartner.com">contact@agirpartner.com</a>
        </nav>

        <section class="hero-grid">
          <div class="hero-copy reveal">
            <p class="eyebrow">ESN SIRH et IT Consulting</p>
            <h1>Une signature premium pour les projets RH et IT qui exigent clarte, rythme et execution.</h1>
            <p class="lead">
              Agir Partner accompagne les organisations dans le cadrage, le pilotage et
              l'optimisation de leurs transformations SIRH et IT avec une approche sobre,
              exigeante et directement utile au terrain.
            </p>

            <div class="hero-actions">
              <a class="btn btn-primary" href="#services">Decouvrir nos expertises</a>
              <a class="btn btn-secondary" href="mailto:contact@agirpartner.com">Nous ecrire</a>
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
                <span class="trusted-mark"><?= htmlspecialchars($company['mark']); ?></span>
                <span class="trusted-name"><?= htmlspecialchars($company['name']); ?></span>
              </div>
            <?php endforeach; ?>
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

      <section class="section" id="contact">
        <div class="container">
          <div class="contact-shell reveal">
            <div class="contact-copy">
              <p class="eyebrow">Contact</p>
              <h2>Parlons de votre prochain sujet SIRH ou IT consulting.</h2>
              <p>
                Pour un besoin de cadrage, de pilotage, de renfort conseil ou d'optimisation,
                contactez-nous directement par email.
              </p>
            </div>

            <div class="contact-card">
              <a class="contact-mail" href="mailto:contact@agirpartner.com">contact@agirpartner.com</a>
              <p>
                Reponse rapide pour echanger sur vos enjeux, vos priorites et le format
                d'accompagnement le plus pertinent.
              </p>
            </div>
          </div>
        </div>
      </section>
    </main>

    <script src="script.js"></script>
  </body>
</html>
