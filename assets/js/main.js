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

/* ============================================================
   HEADER SCROLL
   Placeholder — complété en Session 4 (header.php)
   Ajoute .is-scrolled sur #site-header après 60px de scroll
============================================================ */

(function initHeaderScroll() {
  const header = document.getElementById('site-header');
  if (!header) return;

  const SCROLL_THRESHOLD = 60;

  const update = () => {
    const scrolled = window.scrollY > SCROLL_THRESHOLD;
    header.classList.toggle('is-scrolled', scrolled);
  };

  window.addEventListener('scroll', update, { passive: true });
  update();
})();

/* ============================================================
   MOBILE MENU TOGGLE
   Placeholder — complété en Session 4
============================================================ */

(function initMobileMenu() {
  const toggle = document.querySelector('[data-menu-toggle]');
  const menu   = document.querySelector('[data-menu]');
  if (!toggle || !menu) return;

  toggle.addEventListener('click', () => {
    const isOpen = toggle.getAttribute('aria-expanded') === 'true';
    toggle.setAttribute('aria-expanded', String(!isOpen));
    menu.classList.toggle('is-open', !isOpen);
    document.body.classList.toggle('menu-open', !isOpen);
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && menu.classList.contains('is-open')) {
      toggle.setAttribute('aria-expanded', 'false');
      menu.classList.remove('is-open');
      document.body.classList.remove('menu-open');
      toggle.focus();
    }
  });
})();
