# 01 — Design System

> Spec détaillée des composants UI. Claude Code code `design-system.css` + `components.css` à partir de ce document.

---

## Fichier : assets/css/design-system.css

Contient UNIQUEMENT les variables (tokens). Aucun style de composant.

```css
:root {
  /* Couleurs primaires */
  --color-primary: #E8722A;
  --color-primary-dark: #C45E1A;
  --color-primary-light: #FFB380;
  --color-primary-bg: #FFF4EE;

  /* Couleurs secondaires */
  --color-secondary: #0F3460;
  --color-secondary-mid: #1A5799;
  --color-secondary-bg: #EBF2FA;

  /* Sémantiques */
  --color-success: #16A34A;
  --color-warning: #EA8C55;
  --color-danger: #DC2626;

  /* Texte */
  --color-text: #1A1A1A;
  --color-text-muted: #444444;
  --color-text-light: #777777;
  --color-text-on-dark: #FFFFFF;

  /* Surfaces */
  --color-bg: #FFFFFF;
  --color-bg-alt: #F7F7F7;
  --color-bg-dark: #0F3460;
  --color-border: #E8E8E8;
  --color-border-light: #F0F0F0;

  /* Typographie */
  --font-display: 'DM Sans', sans-serif;
  --font-body: 'Inter', sans-serif;

  --fs-xs: 0.75rem;
  --fs-sm: 0.875rem;
  --fs-base: 1rem;
  --fs-lg: 1.125rem;
  --fs-xl: 1.375rem;
  --fs-2xl: 1.75rem;
  --fs-3xl: 2.25rem;
  --fs-4xl: 3rem;

  --fw-regular: 400;
  --fw-medium: 500;
  --fw-semibold: 600;
  --fw-bold: 700;

  --lh-tight: 1.2;
  --lh-normal: 1.5;
  --lh-relaxed: 1.75;

  /* Espacements */
  --space-xs: 0.25rem;
  --space-sm: 0.5rem;
  --space-md: 1rem;
  --space-lg: 1.5rem;
  --space-xl: 2rem;
  --space-2xl: 3rem;
  --space-3xl: 4rem;

  /* Bordures & rayons */
  --radius-sm: 4px;
  --radius-md: 8px;
  --radius-lg: 12px;
  --radius-xl: 16px;
  --radius-full: 9999px;

  /* Ombres */
  --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
  --shadow-md: 0 4px 8px rgba(0,0,0,0.08);
  --shadow-lg: 0 8px 16px rgba(0,0,0,0.1);
  --shadow-xl: 0 12px 24px rgba(0,0,0,0.12);

  /* Transitions */
  --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
  --transition: 250ms cubic-bezier(0.4, 0, 0.2, 1);
  --transition-slow: 350ms cubic-bezier(0.4, 0, 0.2, 1);

  /* Layout */
  --container-max: 1280px;
  --container-padding: 1.5rem;
  --header-height: 72px;
}
```

---

## Composants à coder dans components.css

### 1. Boutons

```
.btn                  → base : inline-flex, padding 12px 24px, radius-md, transition
.btn--primary         → fond orange, texte blanc, hover orange-dark
.btn--secondary       → fond bleu, texte blanc
.btn--outline         → bordure orange, fond transparent, hover rempli
.btn--ghost           → transparent, hover bg-alt
.btn--sm              → padding réduit 8px 16px
.btn--lg              → padding 16px 32px, fs-lg
.btn--block           → width 100%
.btn--icon            → carré, pour icône seule, aria-label requis
```

États : `:hover` (translateY -1px + shadow), `:active` (scale 0.98), `:disabled` (opacity 0.5).

### 2. Badges / Pills

```
.badge                → inline-block, padding 4px 12px, radius-full, fs-xs, fw-medium
.badge--primary       → fond orange clair, texte orange-dark
.badge--secondary     → fond bleu clair, texte bleu
.badge--success       → fond vert clair, texte vert
.badge--stock         → vert si en stock, gris si sur commande
```

### 3. Cards

```
.card                 → fond blanc, bordure, radius-lg, padding-lg, transition
.card:hover           → bordure orange, shadow-lg
.card__header         → border-bottom, padding-bottom md
.card__title          → fs-lg, fw-semibold, font-display
.card__body           → fs-base, text-muted
.card__footer         → border-top, flex, gap-sm
```

### 4. Product Card (composant clé)

```
.product-card                  → card cliquable, overflow hidden
.product-card__image           → ratio 4:3, object-fit cover, bg dégradé léger
.product-card__badge           → position absolute top-right (catégorie ou promo)
.product-card__content         → padding-md
.product-card__category        → fs-xs, uppercase, orange, letter-spacing
.product-card__title           → fs-lg, fw-semibold, 2 lignes max (line-clamp)
.product-card__desc            → fs-sm, text-light, 2 lignes max
.product-card__footer          → flex between, align center, margin-top md
.product-card__price           → fs-lg, fw-semibold, orange
.product-card__action          → btn--sm--ghost "Voir" ou "+ Devis"
```

Hover : `translateY(-8px)` + `shadow-xl` + image légèrement zoomée.

### 5. Inputs / Forms

```
.field                → wrapper, margin-bottom md
.field__label         → fs-sm, fw-medium, margin-bottom xs, block
.field__input         → width 100%, padding 12px 16px, bordure, radius-md
.field__input:focus   → bordure orange, ring orange léger (box-shadow)
.field__error         → fs-xs, rouge, margin-top xs
.field--error .field__input → bordure rouge
```

### 6. Grilles utilitaires

```
.grid                 → display grid, gap-lg
.grid--2              → auto-fit minmax(300px, 1fr)
.grid--3              → auto-fit minmax(250px, 1fr)
.grid--4              → auto-fit minmax(200px, 1fr)
.container            → max-width container-max, margin auto, padding container-padding
.section              → padding-block 3xl (réduit à 2xl sur mobile)
```

### 7. Section headers

```
.section-header             → text-center, margin-bottom 2xl
.section-header__label      → fs-xs, uppercase, orange, letter-spacing, fw-semibold
.section-header__title      → fs-3xl, fw-semibold, font-display (réduit fs-2xl mobile)
.section-header__subtitle   → fs-lg, text-light, max-width 600px, margin auto
```

---

## Règles de style globales (global.css)

```css
* { margin: 0; padding: 0; box-sizing: border-box; }
html { scroll-behavior: smooth; }
body {
  font-family: var(--font-body);
  font-size: var(--fs-base);
  line-height: var(--lh-normal);
  color: var(--color-text);
  background: var(--color-bg);
}
h1,h2,h3,h4,h5,h6 { font-family: var(--font-display); line-height: var(--lh-tight); }
h1 { font-size: var(--fs-4xl); font-weight: var(--fw-bold); }
h2 { font-size: var(--fs-3xl); font-weight: var(--fw-semibold); }
h3 { font-size: var(--fs-2xl); font-weight: var(--fw-semibold); }
a { color: var(--color-primary); text-decoration: none; transition: color var(--transition-fast); }
a:hover { color: var(--color-primary-dark); }
img { max-width: 100%; height: auto; display: block; }

/* Responsive titres mobile */
@media (max-width: 768px) {
  h1 { font-size: var(--fs-2xl); }
  h2 { font-size: var(--fs-xl); }
  h3 { font-size: var(--fs-lg); }
}
```

---

## Animations (animations.css)

```css
@keyframes fadeIn { from {opacity:0} to {opacity:1} }
@keyframes slideUp { from {opacity:0; transform:translateY(24px)} to {opacity:1; transform:translateY(0)} }
@keyframes slideDown { from {opacity:0; transform:translateY(-24px)} to {opacity:1; transform:translateY(0)} }

/* Scroll reveal — déclenché par IntersectionObserver dans main.js */
.reveal { opacity: 0; transform: translateY(30px); transition: all var(--transition); }
.reveal.is-visible { opacity: 1; transform: translateY(0); }

/* Respecter prefers-reduced-motion */
@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
}
```

---

## Checklist
- [ ] design-system.css : toutes les variables
- [ ] global.css : reset, typo, base
- [ ] components.css : tous les composants ci-dessus
- [ ] animations.css : keyframes + reveal
- [ ] Test : créer une page démo affichant tous les composants
