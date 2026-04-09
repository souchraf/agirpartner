import { motion } from "framer-motion";
import {
  ArrowRight,
  BriefcaseBusiness,
  CloudCog,
  Mail,
  ShieldCheck,
  Users
} from "lucide-react";
import { AuroraBackground } from "@/components/ui/aurora-background";

const services = [
  {
    icon: BriefcaseBusiness,
    title: "Conseil SIRH",
    description:
      "Cadrage, roadmap, aide au choix d'outils et pilotage de transformation RH pour structurer les decisions et accelerer les projets."
  },
  {
    icon: CloudCog,
    title: "IT Consulting",
    description:
      "Renfort en organisation, delivery, AMOA et coordination entre metier, IT et editeurs pour garder le bon rythme d'execution."
  },
  {
    icon: ShieldCheck,
    title: "Run et optimisation",
    description:
      "Stabilisation, amelioration continue, accompagnement des usages et gouvernance de service pour faire durer la valeur dans le temps."
  }
];

const highlights = [
  "Expertise conseil SIRH et IT consulting",
  "Approche premium, humaine et orientee resultats",
  "Interventions de cadrage, delivery et optimisation"
];

function App() {
  return (
    <div className="relative">
      <AuroraBackground className="justify-start">
        <div className="relative z-10 w-full">
          <header className="mx-auto w-full max-w-7xl px-6 pb-10 pt-6 md:px-8 lg:px-10">
            <nav className="flex items-center justify-between rounded-full border border-white/60 bg-white/70 px-5 py-3 shadow-glow backdrop-blur-xl">
              <a href="#home" className="font-['Sora'] text-xl font-semibold tracking-tight text-brand-900">
                Agir Partner
              </a>
              <div className="hidden items-center gap-8 text-sm font-semibold text-slate-600 md:flex">
                <a href="#services" className="transition hover:text-brand-700">
                  Services
                </a>
                <a href="mailto:contact@agirpartner.com" className="transition hover:text-brand-700">
                  Contact
                </a>
              </div>
              <a
                href="mailto:contact@agirpartner.com"
                className="inline-flex items-center gap-2 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700"
              >
                <Mail className="h-4 w-4" />
                contact@agirpartner.com
              </a>
            </nav>

            <section
              id="home"
              className="grid gap-10 pb-12 pt-14 lg:grid-cols-[minmax(0,1.1fr)_minmax(360px,0.9fr)] lg:items-center"
            >
              <motion.div
                initial={{ opacity: 0, y: 24 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.8, ease: "easeOut" }}
              >
                <span className="inline-flex rounded-full border border-brand-200 bg-white/75 px-4 py-2 text-xs font-bold uppercase tracking-[0.3em] text-brand-700">
                  ESN SIRH et IT Consulting
                </span>
                <h1 className="mt-6 max-w-4xl text-balance font-['Sora'] text-5xl font-semibold leading-[0.95] text-slate-950 md:text-6xl lg:text-7xl">
                  Le conseil qui aligne vos projets RH, vos enjeux IT et votre execution terrain.
                </h1>
                <p className="mt-6 max-w-2xl text-lg leading-8 text-slate-600">
                  Agir Partner accompagne les entreprises dans leurs transformations SIRH et IT
                  avec une approche premium, claire et pragmatique. Nous intervenons la ou il faut
                  remettre de la lisibilite, de la coordination et de la confiance.
                </p>

                <div className="mt-8 flex flex-col gap-4 sm:flex-row">
                  <a
                    href="#services"
                    className="inline-flex items-center justify-center gap-2 rounded-full bg-slate-950 px-6 py-3.5 font-semibold text-white transition hover:bg-brand-800"
                  >
                    Explorer nos expertises
                    <ArrowRight className="h-4 w-4" />
                  </a>
                  <a
                    href="mailto:contact@agirpartner.com"
                    className="inline-flex items-center justify-center gap-2 rounded-full border border-brand-200 bg-white/80 px-6 py-3.5 font-semibold text-brand-800 transition hover:border-brand-300 hover:bg-white"
                  >
                    Nous ecrire
                    <Mail className="h-4 w-4" />
                  </a>
                </div>

                <div className="mt-10 grid gap-4 sm:grid-cols-3">
                  {highlights.map((item) => (
                    <div
                      key={item}
                      className="rounded-[28px] border border-white/70 bg-white/65 p-5 shadow-glow backdrop-blur-xl"
                    >
                      <p className="text-sm font-semibold leading-6 text-slate-700">{item}</p>
                    </div>
                  ))}
                </div>
              </motion.div>

              <motion.aside
                initial={{ opacity: 0, scale: 0.96, y: 24 }}
                animate={{ opacity: 1, scale: 1, y: 0 }}
                transition={{ duration: 0.9, ease: "easeOut", delay: 0.15 }}
                className="relative overflow-hidden rounded-[36px] border border-white/70 bg-white/60 p-6 shadow-glow backdrop-blur-xl"
              >
                <img
                  src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1200&q=80"
                  alt="Equipe en reunion autour d'un projet de transformation"
                  className="h-72 w-full rounded-[28px] object-cover"
                />
                <div className="mt-6 rounded-[28px] bg-gradient-to-br from-brand-50 via-white to-violet-100 p-6">
                  <p className="text-xs font-bold uppercase tracking-[0.28em] text-brand-700">
                    ADN du cabinet
                  </p>
                  <h2 className="mt-3 font-['Sora'] text-3xl font-semibold leading-tight text-slate-950">
                    Une signature premium, sobre et engagee pour les programmes qui demandent plus
                    qu'un simple renfort.
                  </h2>
                  <div className="mt-6 space-y-4">
                    <div className="flex items-start gap-3">
                      <Users className="mt-1 h-5 w-5 text-brand-700" />
                      <p className="text-sm leading-7 text-slate-600">
                        Animation des parties prenantes, gouvernance et intelligence de terrain.
                      </p>
                    </div>
                    <div className="flex items-start gap-3">
                      <ShieldCheck className="mt-1 h-5 w-5 text-brand-700" />
                      <p className="text-sm leading-7 text-slate-600">
                        Decisions plus sereines grace a un pilotage clair, des livrables utiles et
                        un cadre de travail stable.
                      </p>
                    </div>
                  </div>
                </div>
              </motion.aside>
            </section>
          </header>

          <main className="mx-auto w-full max-w-7xl px-6 pb-16 md:px-8 lg:px-10">
            <section id="services" className="py-10">
              <div className="max-w-3xl">
                <p className="text-sm font-bold uppercase tracking-[0.28em] text-brand-700">
                  Services
                </p>
                <h2 className="mt-4 text-balance font-['Sora'] text-4xl font-semibold tracking-tight text-slate-950 md:text-5xl">
                  Des interventions conseil pensees pour la transformation SIRH et la performance
                  IT.
                </h2>
                <p className="mt-5 max-w-2xl text-base leading-8 text-slate-600">
                  Nous aidons les organisations a cadrer leurs priorites, fluidifier l'execution et
                  faire converger les equipes RH, IT et metier autour d'une meme trajectoire.
                </p>
              </div>

              <div className="mt-10 grid gap-6 lg:grid-cols-3">
                {services.map(({ icon: Icon, title, description }, index) => (
                  <motion.article
                    key={title}
                    initial={{ opacity: 0, y: 24 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    viewport={{ once: true, amount: 0.3 }}
                    transition={{ duration: 0.6, delay: index * 0.08 }}
                    className="group relative overflow-hidden rounded-[32px] border border-white/70 bg-white/70 p-7 shadow-glow backdrop-blur-xl"
                  >
                    <div className="absolute right-0 top-0 h-32 w-32 rounded-full bg-brand-200/40 blur-3xl transition group-hover:scale-125" />
                    <div className="relative">
                      <span className="inline-flex rounded-2xl bg-brand-100 p-3 text-brand-700">
                        <Icon className="h-6 w-6" />
                      </span>
                      <p className="mt-6 text-xs font-bold uppercase tracking-[0.28em] text-brand-600">
                        0{index + 1}
                      </p>
                      <h3 className="mt-3 font-['Sora'] text-2xl font-semibold text-slate-950">
                        {title}
                      </h3>
                      <p className="mt-4 text-base leading-8 text-slate-600">{description}</p>
                    </div>
                  </motion.article>
                ))}
              </div>
            </section>

            <section className="py-10">
              <div className="grid gap-8 rounded-[40px] border border-white/70 bg-slate-950 px-8 py-10 text-white shadow-glow lg:grid-cols-[minmax(0,0.95fr)_minmax(360px,1.05fr)]">
                <div>
                  <p className="text-sm font-bold uppercase tracking-[0.28em] text-brand-300">
                    Contact
                  </p>
                  <h2 className="mt-4 text-balance font-['Sora'] text-4xl font-semibold tracking-tight md:text-5xl">
                    Contactez Agir Partner pour vos besoins en conseil SIRH et IT consulting.
                  </h2>
                  <p className="mt-5 max-w-xl text-base leading-8 text-slate-300">
                    Pour un cadrage, un accompagnement projet ou une mission de conseil, ecrivez
                    directement a notre adresse de contact. Le lien du menu et les boutons du site
                    ouvrent votre messagerie avec l'adresse pre-remplie.
                  </p>
                </div>

                <div className="rounded-[32px] border border-white/10 bg-white/5 p-6">
                  <img
                    src="https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=1200&q=80"
                    alt="Espace de travail premium pour le conseil"
                    className="h-52 w-full rounded-[24px] object-cover"
                  />
                  <div className="mt-6 space-y-4">
                    <a
                      href="mailto:contact@agirpartner.com"
                      className="inline-flex w-full items-center justify-between rounded-[24px] bg-brand-600 px-5 py-4 text-left font-semibold text-white transition hover:bg-brand-700"
                    >
                      <span>contact@agirpartner.com</span>
                      <Mail className="h-5 w-5" />
                    </a>
                    <p className="text-sm leading-7 text-slate-300">
                      Reponse rapide pour echanger sur vos enjeux SIRH, votre organisation projet
                      ou vos besoins de conseil IT.
                    </p>
                  </div>
                </div>
              </div>
            </section>
          </main>
        </div>
      </AuroraBackground>
    </div>
  );
}

export default App;
