# CLAUDE.md — DESQ Energy WordPress Theme

> **À LIRE EN PREMIER À CHAQUE SESSION.** Ce fichier est la source de vérité pour le développement. Il contient le stack, les conventions, les design tokens et les règles absolues. Ne jamais coder sans l'avoir lu.

---

## 🎯 Projet

**DESQ Energy** — Site e-commerce solaire premium pour le marché sénégalais.

- **Client** : DESQ Energy (Diouf Equipement Solaire & Quincaillerie), Dakar
- **Fournisseur produits** : Felicity Solar (batteries, onduleurs, panneaux)
- **Cibles** : B2B (entreprises, installateurs) + B2C (particuliers)
- **Objectif** : Catalogue filtrable + devis automatisé + CRM intégré
- **Contrainte clé** : Mobile-first (85% du trafic), chargement < 3s sur 3G

---

## 🛠️ Stack technique exact

| Couche | Technologie | Version |
|--------|-------------|---------|
| CMS | WordPress | 6.5+ |
| Champs custom | ACF Pro | 6.x |
| E-commerce | WooCommerce (mode catalogue) | 8.x |
| Formulaires | WPForms | 1.8+ |
| SEO | Rank Math | latest |
| Cache | WP Rocket | latest |
| CDN | Cloudflare | — |
| Hébergement | Hostinger Business | PHP 8.2 |
| Automation | Make.com | — |
| CRM | HubSpot Free | — |

**JavaScript** : Vanilla ES6+ uniquement. **PAS de jQuery** (sauf si WP core l'impose).
**CSS** : Custom properties natives. Pas de framework (pas de Bootstrap/Tailwind).
**Animations** : GSAP pour le complexe, CSS transitions pour le simple.

---

## 🎨 Design Tokens

### Couleurs
```css
--color-primary: #E8722A;        /* Orange solaire — CTA, accents */
--color-primary-dark: #C45E1A;   /* Hover states */
--color-primary-light: #FFB380;  /* Accents doux */
--color-primary-bg: #FFF4EE;     /* Arrière-plans orange */

--color-secondary: #0F3460;      /* Bleu profond — header, footer */
--color-secondary-mid: #1A5799;  /* Bleu liens, badges */
--color-secondary-bg: #EBF2FA;   /* Arrière-plans bleus */

--color-success: #16A34A;
--color-text: #1A1A1A;
--color-text-muted: #444444;
--color-text-light: #777777;
--color-bg: #FFFFFF;
--color-bg-alt: #F7F7F7;
--color-border: #E8E8E8;
```

### Typographie
```css
--font-display: 'DM Sans', sans-serif;   /* Titres */
--font-body: 'Inter', sans-serif;        /* Corps */
--font-mono: 'JetBrains Mono', monospace; /* Code, specs */
```
Chargées via Google Fonts. Précharger les poids 400, 500, 600, 700.

### Échelle typographique
```css
--fs-xs: 0.75rem;    /* 12px */
--fs-sm: 0.875rem;   /* 14px */
--fs-base: 1rem;     /* 16px */
--fs-lg: 1.125rem;   /* 18px */
--fs-xl: 1.375rem;   /* 22px */
--fs-2xl: 1.75rem;   /* 28px */
--fs-3xl: 2.25rem;   /* 36px */
--fs-4xl: 3rem;      /* 48px */
```

### Espacements (base 8px)
```css
--space-xs: 0.25rem;  /* 4px */
--space-sm: 0.5rem;   /* 8px */
--space-md: 1rem;     /* 16px */
--space-lg: 1.5rem;   /* 24px */
--space-xl: 2rem;     /* 32px */
--space-2xl: 3rem;    /* 48px */
--space-3xl: 4rem;    /* 64px */
```

### Bordures & ombres
```css
--radius-sm: 4px;
--radius-md: 8px;     /* Boutons */
--radius-lg: 12px;    /* Cards */
--radius-full: 9999px; /* Badges, pills */

--shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
--shadow-md: 0 4px 8px rgba(0,0,0,0.08);
--shadow-lg: 0 8px 16px rgba(0,0,0,0.1);

--transition: 250ms cubic-bezier(0.4, 0, 0.2, 1);
```

### Breakpoints (mobile-first)
```css
/* Base = mobile. Puis : */
--bp-sm: 480px;
--bp-md: 768px;
--bp-lg: 1024px;
--bp-xl: 1280px;
```
Container max-width : `1280px`.

---

## 📐 Conventions de code

### PHP
- Toutes les fonctions custom préfixées `desq_` : `desq_product_card()`, `desq_get_price()`
- Échapper toutes les sorties : `esc_html()`, `esc_attr()`, `esc_url()`
- Nonces sur tous les formulaires et appels AJAX : `wp_create_nonce()`, `check_ajax_referer()`
- Hooks regroupés en bas du fichier, jamais inline
- Indentation : 4 espaces (standard WordPress)

### CSS — méthodologie BEM
```css
.product-card { }                      /* Block */
.product-card__title { }               /* Element */
.product-card__title--featured { }     /* Modifier */
```
- Une classe = une responsabilité
- Pas de `!important` sauf override plugin documenté
- Mobile-first : styles de base = mobile, `@media (min-width: ...)` pour agrandir

### JavaScript
- ES6+ : `const`/`let`, arrow functions, template literals, async/await
- Modules séparés par fonctionnalité (un fichier = une feature)
- Événements délégués quand possible
- Pas de variable globale (encapsuler dans IIFE ou module)

### Nommage des fichiers
- Templates : `page-{slug}.php`, `single-{cpt}.php`, `archive-{cpt}.php`
- Parts : kebab-case (`featured-products.php`)
- Assets : kebab-case (`catalog-filter.js`)

---

## 🗂️ Custom Post Types

| CPT | Slug | Usage |
|-----|------|-------|
| Produits | `desq_product` | Catalogue Felicity Solar |
| Solutions | `desq_solution` | Use cases (résidentiel, etc.) |
| Témoignages | `desq_testimonial` | Avis clients |

### Taxonomies
- `product_category` (rattachée à `desq_product`) : batteries, onduleurs, panneaux, protection, accessoires

### Champs ACF — desq_product
- `product_price` (number) — Prix en FCFA
- `product_sku` (text) — Référence
- `product_category_meta` (select) — Catégorie
- `product_specs` (repeater : spec_name, spec_value) — Specs techniques
- `product_warranty` (number) — Garantie années
- `product_stock` (number) — Stock
- `product_gallery` (gallery) — Photos
- `product_datasheet` (file) — PDF fiche technique

### Options globales (préfixe desq_)
`desq_phone`, `desq_whatsapp`, `desq_email`, `desq_address`, `desq_hours`, `desq_hero_title`, `desq_hero_subtitle`

Accès : `get_field('desq_phone', 'option')`

---

## ⚡ Règles absolues (non négociables)

1. **Mobile-first toujours** — Coder le mobile en premier, agrandir avec `min-width`. Tester sur 360px de large minimum.
2. **Performance < 3s sur 3G** — Toutes les images en WebP, lazy-load natif (`loading="lazy"`), CSS/JS minifiés en prod.
3. **Accessibilité** — `alt` sur toutes les images, `aria-label` sur les boutons icônes, focus visible, contraste AA minimum.
4. **Sécurité** — Nonces WP sur AJAX, échappement des sorties, sanitization des entrées, jamais de SQL brut (utiliser `$wpdb->prepare()`).
5. **SEO** — Balises sémantiques HTML5, un seul `<h1>` par page, microdata Schema.org sur les produits, meta via Rank Math.
6. **Pas de hardcoding** — Couleurs/textes via variables CSS et champs ACF. Le client doit pouvoir modifier le contenu sans toucher au code.

---

## 🔄 Workflow de session

1. Claude Code lit ce fichier + la spec de la page concernée (`/specs/`)
2. Code le composant/page demandé
3. Test local + validation visuelle navigateur
4. Corrections selon feedback
5. `git commit` avec message clair : `feat: header sticky glassmorphism`
6. Jamais de `push` sans validation explicite

### Format des commits
```
feat:     nouvelle fonctionnalité
fix:      correction de bug
style:    CSS/design uniquement
refactor: réorganisation sans changement fonctionnel
docs:     documentation
perf:     optimisation performance
```

---

## 📁 Fichiers de spécification

| Fichier | Contenu |
|---------|---------|
| `/specs/00-setup.md` | Installation, plugins, config initiale |
| `/specs/01-design-system.md` | Détail composants UI |
| `/specs/02-cpt-acf.md` | Custom post types + champs ACF |
| `/specs/03-quote-system.md` | Système de devis complet |
| `/specs/04-crm-automation.md` | Config Make.com + HubSpot |
| `/pages/*.md` | Spec détaillée de chaque page |

Consulter le fichier pertinent avant de coder une fonctionnalité.
