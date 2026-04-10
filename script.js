const revealItems = document.querySelectorAll(".reveal");

const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) {
        return;
      }

      entry.target.classList.add("is-visible");
      observer.unobserve(entry.target);
    });
  },
  {
    threshold: 0.18,
  }
);

revealItems.forEach((item, index) => {
  item.style.transitionDelay = `${Math.min(index * 70, 280)}ms`;
  observer.observe(item);
});

const menuToggle = document.querySelector("[data-menu-toggle]");
const menuClose = document.querySelector("[data-menu-close]");
const mobileMenu = document.querySelector("[data-mobile-menu]");
const mobileLinks = document.querySelectorAll("[data-mobile-link]");

const closeMenu = () => {
  if (!mobileMenu || !menuToggle) return;
  mobileMenu.setAttribute("hidden", "");
  menuToggle.setAttribute("aria-expanded", "false");
  document.body.style.overflow = "";
};

const openMenu = () => {
  if (!mobileMenu || !menuToggle) return;
  mobileMenu.removeAttribute("hidden");
  menuToggle.setAttribute("aria-expanded", "true");
  document.body.style.overflow = "hidden";
};

if (menuToggle) {
  menuToggle.addEventListener("click", () => {
    const expanded = menuToggle.getAttribute("aria-expanded") === "true";
    if (expanded) {
      closeMenu();
    } else {
      openMenu();
    }
  });
}

if (menuClose) {
  menuClose.addEventListener("click", closeMenu);
}

mobileLinks.forEach((link) => {
  link.addEventListener("click", closeMenu);
});

if (mobileMenu) {
  mobileMenu.addEventListener("click", (event) => {
    if (event.target === mobileMenu) {
      closeMenu();
    }
  });
}

document.addEventListener("keydown", (event) => {
  if (event.key === "Escape") {
    closeMenu();
  }
});
