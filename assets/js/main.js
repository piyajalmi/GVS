/* =========================
   SCROLL REVEAL
========================= */
document.addEventListener("DOMContentLoaded", () => {
  const revealElements = document.querySelectorAll(".reveal");
  if (!revealElements.length) return;

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("active");
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15 });

  revealElements.forEach(el => observer.observe(el));
});

/* =========================
   HERO INTRO
========================= */
window.addEventListener("load", () => {
  const hero = document.querySelector(".hero-content");
  if (hero) hero.classList.add("hero-visible");
});

/* =========================
   ACCORDION SAFE HANDLING
========================= */
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll('.accordion-button').forEach(btn => {
    btn.addEventListener('click', () => {
      setTimeout(() => {
        btn.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }, 250);
    });
  });

  document.querySelectorAll('.member-list').forEach(list => {
    const accordion = list.closest('.accordion-item');
    if (!accordion) return;

    const header = accordion.querySelector('.accordion-button');
    if (!header) return;

    header.insertAdjacentHTML(
      'beforeend',
      ` <span style="opacity:.6">(${list.children.length})</span>`
    );
  });
});

/* =========================
   HOME AUTO SLIDER
========================= */
document.addEventListener("DOMContentLoaded", () => {
  const slides = document.querySelectorAll(".home-slider .slide");
  let index = 0;

  if (slides.length > 1) {
    setInterval(() => {
      slides[index].classList.remove("active");
      index = (index + 1) % slides.length;
      slides[index].classList.add("active");
    }, 4000);
  }
});

/* =========================
   HEADER FIX ON SCROLL
========================= */
document.addEventListener("DOMContentLoaded", () => {
  const header = document.querySelector('.main-header');
  if (!header) return;

  window.addEventListener('scroll', () => {
    header.classList.toggle('is-fixed', window.scrollY > 80);
  });
});
