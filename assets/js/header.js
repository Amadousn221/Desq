'use strict';

(function desqHeader() {

  const SCROLL_THRESHOLD = 80;
  const DROPDOWN_DELAY   = 120;

  const header = document.getElementById('site-header');
  if (!header) return;

  /* ── STICKY SCROLL ───────────────────────────────────── */

  (function initScroll() {
    const update = () => {
      header.classList.toggle('site-header--scrolled', window.scrollY > SCROLL_THRESHOLD);
    };
    window.addEventListener('scroll', update, { passive: true });
    update();
  })();

  /* ── DROPDOWNS DESKTOP (hover + délai 120ms) ─────────── */

  (function initDropdowns() {
    const items = header.querySelectorAll('.menu-item--has-dropdown');

    items.forEach(item => {
      const toggle   = item.querySelector('.site-header__link--toggle');
      const dropdown = item.querySelector('.site-header__dropdown');
      if (!toggle || !dropdown) return;

      let openTimer, closeTimer;

      function open() {
        clearTimeout(closeTimer);
        openTimer = setTimeout(() => {
          dropdown.classList.add('is-open');
          item.classList.add('is-open');
          toggle.setAttribute('aria-expanded', 'true');
        }, DROPDOWN_DELAY);
      }

      function close() {
        clearTimeout(openTimer);
        closeTimer = setTimeout(() => {
          dropdown.classList.remove('is-open');
          item.classList.remove('is-open');
          toggle.setAttribute('aria-expanded', 'false');
        }, DROPDOWN_DELAY);
      }

      item.addEventListener('mouseenter', open);
      item.addEventListener('mouseleave', close);

      toggle.addEventListener('keydown', e => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          const isOpen = dropdown.classList.contains('is-open');
          isOpen ? close() : open();
        }
        if (e.key === 'Escape') close();
      });
    });
  })();

  /* ── DRAWER MOBILE ───────────────────────────────────── */

  (function initDrawer() {
    const toggle  = document.getElementById('nav-drawer-toggle');
    const drawer  = document.getElementById('nav-drawer');
    const overlay = document.getElementById('nav-overlay');
    if (!toggle || !drawer || !overlay) return;

    function openDrawer() {
      drawer.classList.add('is-open');
      overlay.classList.add('is-active');
      drawer.removeAttribute('aria-hidden');
      overlay.removeAttribute('aria-hidden');
      toggle.setAttribute('aria-expanded', 'true');
      toggle.setAttribute('aria-label', 'Fermer le menu');
      document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
      drawer.classList.remove('is-open');
      overlay.classList.remove('is-active');
      drawer.setAttribute('aria-hidden', 'true');
      overlay.setAttribute('aria-hidden', 'true');
      toggle.setAttribute('aria-expanded', 'false');
      toggle.setAttribute('aria-label', 'Ouvrir le menu');
      document.body.style.overflow = '';
    }

    toggle.addEventListener('click', () => {
      drawer.classList.contains('is-open') ? closeDrawer() : openDrawer();
    });

    overlay.addEventListener('click', closeDrawer);

    document.addEventListener('keydown', e => {
      if (e.key === 'Escape' && drawer.classList.contains('is-open')) {
        closeDrawer();
        toggle.focus();
      }
    });
  })();

  /* ── ACCORDÉONS DRAWER (délégué) ─────────────────────── */

  (function initAccordions() {
    const drawer = document.getElementById('nav-drawer');
    if (!drawer) return;

    drawer.addEventListener('click', e => {
      const btn = e.target.closest('.nav-drawer__item--toggle');
      if (!btn) return;

      const sub    = btn.nextElementSibling;
      const isOpen = btn.getAttribute('aria-expanded') === 'true';

      btn.setAttribute('aria-expanded', String(!isOpen));
      sub ? (isOpen ? sub.setAttribute('hidden', '') : sub.removeAttribute('hidden')) : null;
    });
  })();

})();
