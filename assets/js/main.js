/* =========================
   SCROLL REVEAL ANIMATIONS
========================= */
document.addEventListener("DOMContentLoaded", () => {

  const revealElements = document.querySelectorAll(".reveal");

  if (revealElements.length === 0) return;

  const observer = new IntersectionObserver(
    (entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add("active");
          obs.unobserve(entry.target); // animate once only
        }
      });
    },
    {
      threshold: 0.15,
    }
  );

  revealElements.forEach(el => observer.observe(el));
});


/* =========================
   HERO INTRO ANIMATION
========================= */
window.addEventListener("load", () => {
  const hero = document.querySelector(".hero-content");
  if (hero) {
    hero.classList.add("hero-visible");
  }
});

document.querySelectorAll('.accordion-button').forEach(btn => {
  btn.addEventListener('click', () => {
    setTimeout(() => {
      btn.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 300);
  });
});

document.querySelectorAll('.member-list').forEach(list => {
  const count = list.children.length;
  const header = list.closest('.accordion-item')
                    .querySelector('.accordion-button');
  header.innerHTML += ` <span style="opacity:.6">(${count})</span>`;
});
document.querySelectorAll(".event-slider").forEach(slider => {
  const track = slider.querySelector(".slider-track");
  const slides = track.children;
  const prevBtn = slider.querySelector(".prev");
  const nextBtn = slider.querySelector(".next");

  let index = 0;
  let startX = 0;

  function update() {
    track.style.transform = `translateX(-${index * 100}%)`;
  }

  function next() {
    index = (index + 1) % slides.length;
    update();
  }

  function prev() {
    index = (index - 1 + slides.length) % slides.length;
    update();
  }

  nextBtn.addEventListener("click", next);
  prevBtn.addEventListener("click", prev);

  /* Auto play */
  if (slider.dataset.autoplay) {
    setInterval(next, 4000);
  }

  /* Touch swipe */
  slider.addEventListener("touchstart", e => {
    startX = e.touches[0].clientX;
  });

  slider.addEventListener("touchend", e => {
    const endX = e.changedTouches[0].clientX;
    if (startX - endX > 50) next();
    if (endX - startX > 50) prev();
  });
});
// main.js
document.querySelectorAll('.event-slider').forEach(slider => {
  slider.addEventListener('slid.bs.carousel', () => {
    slider.style.height = slider.querySelector('.carousel-item.active img').offsetHeight + 'px';
  });
});
document.querySelectorAll('.event-slider img').forEach(img => {
  img.addEventListener('load', () => {
    const isPortrait = img.naturalHeight > img.naturalWidth;

    if (isPortrait) {
      img.style.maxWidth = '70%';
      img.style.maxHeight = '80vh';
    } else {
      img.style.maxWidth = '100%';
      img.style.maxHeight = '60vh';
    }
  });
});
/* ===== HOME AUTO SLIDER ===== */
document.addEventListener("DOMContentLoaded", () => {
  const slides = document.querySelectorAll(".home-slider .slide");
  let index = 0;

  if (slides.length > 1) {
    setInterval(() => {
      slides[index].classList.remove("active");
      index = (index + 1) % slides.length;
      slides[index].classList.add("active");
    }, 4000); // 4 seconds
  }
});

