# Composants — Header & Footer

> Composants globaux présents sur toutes les pages.

---

# HEADER (template-parts/header.php ou header.php)

## Objectif
Navigation principale, sticky, premium avec effet glassmorphism.

## Structure
```
[Logo]    [Nav: Accueil · Produits · Solutions · Simulateur · Contact]    [Panier devis] [CTA]
```

## Comportement
- **Sticky** : reste en haut au scroll
- **Glassmorphism** : fond semi-transparent + backdrop-blur
- **Au scroll** : ajout d'une classe `.is-scrolled` (fond plus opaque + shadow légère)
- **Mobile** : logo + hamburger → menu plein écran ou drawer

## HTML
```php
<header class="header" id="siteHeader">
  <div class="container header__inner">
    <a href="<?php echo home_url(); ?>" class="header__logo">
      <?php if (desq_option('desq_logo')): ?>
        <img src="<?php echo esc_url(desq_option('desq_logo')['url']); ?>" alt="DESQ Energy">
      <?php else: ?>
        <span class="header__logo-text">DESQ <span>Energy</span></span>
      <?php endif; ?>
    </a>

    <nav class="header__nav" id="mainNav">
      <?php wp_nav_menu(['theme_location' => 'primary', 'container' => false, 'menu_class' => 'header__menu']); ?>
    </nav>

    <div class="header__actions">
      <a href="/devis" class="header__quote" aria-label="Mon devis">
        <svg class="icon-quote"><!-- icône --></svg>
        <span class="quote-badge" style="display:none">0</span>
      </a>
      <a href="/devis" class="btn btn--primary btn--sm header__cta">Demander un devis</a>
      <button class="header__burger" id="menuToggle" aria-label="Menu" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>
```

## CSS
```css
.header {
  position: sticky; top: 0; z-index: 100;
  background: rgba(255,255,255,0.85);
  backdrop-filter: blur(12px);
  border-bottom: 1px solid var(--color-border-light);
  transition: var(--transition);
}
.header.is-scrolled {
  background: rgba(255,255,255,0.95);
  box-shadow: var(--shadow-sm);
}
.header__inner { display: flex; align-items: center; justify-content: space-between; height: var(--header-height); }
.header__logo-text { font-family: var(--font-display); font-size: var(--fs-xl); font-weight: var(--fw-bold); color: var(--color-secondary); }
.header__logo-text span { color: var(--color-primary); }
.header__menu { display: flex; gap: var(--space-xl); list-style: none; }
.header__menu a { color: var(--color-text-muted); font-weight: var(--fw-medium); font-size: var(--fs-sm); }
.header__menu a:hover { color: var(--color-primary); }
.header__actions { display: flex; align-items: center; gap: var(--space-md); }
.header__quote { position: relative; }
.quote-badge {
  position: absolute; top: -8px; right: -8px;
  width: 18px; height: 18px; border-radius: 50%;
  background: var(--color-primary); color: white;
  font-size: 11px; display: flex; align-items: center; justify-content: center;
}
.header__burger { display: none; flex-direction: column; gap: 4px; background: none; border: none; cursor: pointer; }
.header__burger span { width: 24px; height: 2px; background: var(--color-text); transition: var(--transition); }

@media (max-width: 1024px) {
  .header__nav { 
    position: fixed; top: var(--header-height); left: 0; right: 0;
    background: white; flex-direction: column; padding: var(--space-lg);
    transform: translateX(-100%); transition: var(--transition);
    height: calc(100vh - var(--header-height)); box-shadow: var(--shadow-lg);
  }
  .header__nav.is-open { transform: translateX(0); }
  .header__menu { flex-direction: column; gap: var(--space-md); }
  .header__burger { display: flex; }
  .header__cta { display: none; }
}
```

## JS (main.js)
```js
// Scroll effect
const header = document.querySelector('#siteHeader');
window.addEventListener('scroll', () => {
  header.classList.toggle('is-scrolled', window.scrollY > 20);
});

// Mobile menu
const toggle = document.querySelector('#menuToggle');
const nav = document.querySelector('#mainNav');
toggle?.addEventListener('click', () => {
  const isOpen = nav.classList.toggle('is-open');
  toggle.classList.toggle('is-active', isOpen);
  toggle.setAttribute('aria-expanded', isOpen);
  document.body.style.overflow = isOpen ? 'hidden' : '';
});
```

---

# FOOTER (template-parts/footer.php ou footer.php)

## Objectif
Liens utiles, contact, réassurance. Premium et complet.

## Structure (4 colonnes)
```
[À propos + logo]  [Produits]  [Liens rapides]  [Contact]
─────────────────────────────────────────────────────
[Copyright]                            [Liens légaux]
```

## HTML
```php
<footer class="footer">
  <div class="container">
    <div class="footer__grid">
      <div class="footer__col footer__col--about">
        <span class="footer__logo">DESQ <span>Energy</span></span>
        <p>Distributeur de matériels solaires premium au Sénégal. Partenaire officiel Felicity Solar.</p>
        <div class="footer__social">
          <?php foreach (desq_option('desq_social') ?: [] as $social): ?>
            <a href="<?php echo esc_url($social['url']); ?>" target="_blank"><?php echo esc_html($social['network']); ?></a>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="footer__col">
        <h4>Produits</h4>
        <a href="/categorie-produit/batteries">Batteries</a>
        <a href="/categorie-produit/onduleurs">Onduleurs</a>
        <a href="/categorie-produit/panneaux">Panneaux solaires</a>
        <a href="/categorie-produit/protection">Protection</a>
      </div>

      <div class="footer__col">
        <h4>Liens rapides</h4>
        <a href="/solutions">Solutions</a>
        <a href="/simulateur">Simulateur</a>
        <a href="/devis">Demander un devis</a>
        <a href="/contact">Contact</a>
      </div>

      <div class="footer__col">
        <h4>Contact</h4>
        <a href="tel:<?php echo desq_option('desq_phone'); ?>"><?php echo desq_option('desq_phone'); ?></a>
        <a href="mailto:<?php echo desq_option('desq_email'); ?>"><?php echo desq_option('desq_email'); ?></a>
        <p><?php echo nl2br(esc_html(desq_option('desq_address'))); ?></p>
      </div>
    </div>

    <div class="footer__bottom">
      <p>&copy; <?php echo date('Y'); ?> DESQ Energy. Tous droits réservés.</p>
      <nav class="footer__legal">
        <a href="/mentions-legales">Mentions légales</a>
        <a href="/confidentialite">Confidentialité</a>
      </nav>
    </div>
  </div>
</footer>
```

## CSS
```css
.footer { background: var(--color-bg-alt); border-top: 1px solid var(--color-border); padding: var(--space-3xl) 0 var(--space-lg); }
.footer__grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: var(--space-xl); margin-bottom: var(--space-2xl); }
.footer__logo { font-family: var(--font-display); font-size: var(--fs-xl); font-weight: var(--fw-bold); color: var(--color-secondary); }
.footer__logo span { color: var(--color-primary); }
.footer__col h4 { font-size: var(--fs-base); margin-bottom: var(--space-md); }
.footer__col a { display: block; color: var(--color-text-light); font-size: var(--fs-sm); margin-bottom: var(--space-sm); }
.footer__col a:hover { color: var(--color-primary); }
.footer__bottom { border-top: 1px solid var(--color-border); padding-top: var(--space-lg); display: flex; justify-content: space-between; align-items: center; }
.footer__legal { display: flex; gap: var(--space-lg); }

@media (max-width: 768px) {
  .footer__grid { grid-template-columns: 1fr; gap: var(--space-lg); }
  .footer__bottom { flex-direction: column; gap: var(--space-md); text-align: center; }
}
```

---

## Checklist
### Header
- [ ] Logo (image ACF ou texte fallback)
- [ ] Menu WordPress (location primary)
- [ ] Sticky + glassmorphism + effet scroll
- [ ] Badge panier devis (compteur live)
- [ ] Bouton CTA
- [ ] Menu mobile (hamburger + drawer)
- [ ] Accessibilité (aria-expanded, aria-label)

### Footer
- [ ] 4 colonnes responsive
- [ ] Toutes les infos depuis ACF
- [ ] Liens produits par catégorie
- [ ] Réseaux sociaux dynamiques
- [ ] Copyright + liens légaux
- [ ] 1 colonne sur mobile
