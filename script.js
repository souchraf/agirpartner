const revealItems = document.querySelectorAll(".reveal");

const revealObserver = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) {
        return;
      }

      entry.target.classList.add("is-visible");
      revealObserver.unobserve(entry.target);
    });
  },
  { threshold: 0.2 }
);

revealItems.forEach((item, index) => {
  item.style.transitionDelay = `${Math.min(index * 90, 360)}ms`;
  revealObserver.observe(item);
});

const demoButton = document.querySelector("[data-demo-submit]");
const feedback = document.querySelector("[data-form-feedback]");

if (demoButton && feedback) {
  demoButton.addEventListener("click", () => {
    feedback.textContent =
      "Demande enregistree en mode demonstration. Je peux relier ce formulaire a un envoi email ou a un backend ensuite.";
    feedback.classList.add("is-success");
  });
}
