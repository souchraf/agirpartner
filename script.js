const topbar = document.querySelector(".topbar");

const syncTopbarState = () => {
  if (!topbar) return;
  topbar.classList.toggle("is-scrolled", window.scrollY > 18);
};

syncTopbarState();
window.addEventListener("scroll", syncTopbarState, { passive: true });
