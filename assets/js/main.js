'use strict';

/* ============================================================
   DESQ Energy — main.js
   IntersectionObserver scroll reveal + header scroll + stagger
============================================================ */

/* ============================================================
   SCROLL REVEAL
============================================================ */

(function initReveal() {
  const revealEls = document.querySelectorAll('.reveal');
  if (!revealEls.length) return;

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      });
    },
    {
      threshold: 0.1,
      rootMargin: '0px 0px -48px 0px',
    }
  );

  revealEls.forEach(el => observer.observe(el));
})();

/* ============================================================
   STAGGER ENFANTS
   <div data-stagger="0.1"> → les .reveal enfants reçoivent
   un transition-delay progressif
============================================================ */

(function initStagger() {
  document.querySelectorAll('[data-stagger]').forEach(container => {
    const delay = parseFloat(container.dataset.stagger) || 0.1;
    container.querySelectorAll('.reveal').forEach((el, i) => {
      el.style.transitionDelay = `${i * delay}s`;
    });
  });
})();

/* HEADER SCROLL + MOBILE MENU → déplacés dans header.js */

/* ============================================================
   STATS COUNTER
   Déclenché à l'entrée dans le viewport
============================================================ */

(function initCounters() {
  const items = document.querySelectorAll('.stat-item__count');
  if (!items.length) return;

  const countUp = (el) => {
    const target   = parseInt(el.dataset.target, 10);
    const duration = 1800;
    const step     = target / (duration / 16);
    let current    = 0;

    const tick = () => {
      current += step;
      if (current >= target) {
        el.textContent = target;
        return;
      }
      el.textContent = Math.floor(current);
      requestAnimationFrame(tick);
    };
    requestAnimationFrame(tick);
  };

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        countUp(entry.target);
        observer.unobserve(entry.target);
      });
    },
    { threshold: 0.4 }
  );

  items.forEach(el => observer.observe(el));
})();

