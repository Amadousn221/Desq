# 00 — Setup & Installation

> Première session Claude Code. Met en place l'environnement complet avant tout développement.

---

## Objectif
Installer WordPress, les plugins, créer le theme enfant et la structure de base.

---

## Étape 1 — Installation WordPress

```bash
# Sur Hostinger (ou local avec LocalWP / Docker pour dev)
# WordPress 6.5+ avec PHP 8.2

# Structure attendue après install :
wp-content/
├── themes/
│   └── desq-energy-theme/   ← notre theme
├── plugins/
└── uploads/
```

### Config wp-config.php (ajouts)
```php
// Performance & sécurité
define('WP_MEMORY_LIMIT', '256M');
define('DISALLOW_FILE_EDIT', true);      // Pas d'édition de fichiers depuis l'admin
define('WP_POST_REVISIONS', 5);           // Limiter les révisions
define('EMPTY_TRASH_DAYS', 7);

// Debug en dev uniquement
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

---

## Étape 2 — Plugins requis

| Plugin | Rôle | Source |
|--------|------|--------|
| Advanced Custom Fields PRO | Champs personnalisés | Licence à acheter |
| WooCommerce | Catalogue produits | wordpress.org |
| WPForms | Formulaires devis | Lite ou Pro |
| Rank Math SEO | Optimisation SEO | wordpress.org |
| WP Rocket | Cache & perf | Licence |
| Safe SVG | Upload SVG sécurisé | wordpress.org |
| WebP Express | Conversion images WebP | wordpress.org |

```bash
# Via WP-CLI si disponible
wp plugin install woocommerce wpforms-lite seo-by-rank-math safe-svg webp-express --activate
# ACF Pro et WP Rocket : upload manuel (licences)
```

---

## Étape 3 — Création du theme enfant

### style.css (en-tête obligatoire)
```css
/*
Theme Name: DESQ Energy
Theme URI: https://desq-energy.sn
Description: Theme e-commerce solaire premium pour DESQ Energy. WordPress + code custom.
Author: DESQ Energy
Version: 1.0.0
Requires at least: 6.5
Requires PHP: 8.2
Text Domain: desq-energy
*/

/* Les styles réels sont dans /assets/css/ */
@import url('assets/css/design-system.css');
@import url('assets/css/global.css');
@import url('assets/css/components.css');
@import url('assets/css/animations.css');
```

> **Note** : en production, ne PAS utiliser `@import` (lent). Enqueue chaque fichier dans `functions.php`. Le `@import` ici n'est qu'un fallback.

---

## Étape 4 — Structure de dossiers à créer

```bash
mkdir -p desq-energy-theme/{assets/{css,js,images},templates,template-parts/sections,post-types,acf-fields}
touch desq-energy-theme/{functions.php,index.php,header.php,footer.php}
touch desq-energy-theme/assets/css/{design-system.css,global.css,components.css,animations.css}
touch desq-energy-theme/assets/js/{main.js,catalog-filter.js,quote-form.js,simulator.js}
```

---

## Étape 5 — functions.php de base

```php
<?php
/**
 * DESQ Energy Theme — Functions
 */

if (!defined('ABSPATH')) exit; // Sécurité

define('DESQ_VERSION', '1.0.0');
define('DESQ_DIR', get_template_directory());
define('DESQ_URI', get_template_directory_uri());

/**
 * Setup du theme
 */
function desq_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo');
    add_theme_support('woocommerce');

    // Tailles d'images
    add_image_size('product-card', 400, 300, true);
    add_image_size('product-hero', 800, 600, true);

    // Menus
    register_nav_menus([
        'primary' => 'Menu principal',
        'footer'  => 'Menu footer',
    ]);

    // Traduction
    load_theme_textdomain('desq-energy', DESQ_DIR . '/languages');
}
add_action('after_setup_theme', 'desq_theme_setup');

/**
 * Enqueue styles & scripts
 */
function desq_enqueue_assets() {
    // Google Fonts
    wp_enqueue_style('desq-fonts', 'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap', [], null);

    // CSS
    wp_enqueue_style('desq-design-system', DESQ_URI . '/assets/css/design-system.css', [], DESQ_VERSION);
    wp_enqueue_style('desq-global', DESQ_URI . '/assets/css/global.css', ['desq-design-system'], DESQ_VERSION);
    wp_enqueue_style('desq-components', DESQ_URI . '/assets/css/components.css', ['desq-global'], DESQ_VERSION);
    wp_enqueue_style('desq-animations', DESQ_URI . '/assets/css/animations.css', ['desq-components'], DESQ_VERSION);

    // JS
    wp_enqueue_script('desq-main', DESQ_URI . '/assets/js/main.js', [], DESQ_VERSION, true);

    // Localize pour AJAX
    wp_localize_script('desq-main', 'desqData', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('desq_nonce'),
        'homeurl' => home_url(),
    ]);
}
add_action('wp_enqueue_scripts', 'desq_enqueue_assets');

/**
 * Includes — modulariser
 */
require_once DESQ_DIR . '/post-types/register-product.php';
require_once DESQ_DIR . '/post-types/register-solution.php';
require_once DESQ_DIR . '/post-types/register-testimonial.php';

// Désactiver Gutenberg sur les CPT (on utilise ACF)
add_filter('use_block_editor_for_post_type', function($enabled, $post_type) {
    if (in_array($post_type, ['desq_product', 'desq_solution'])) return false;
    return $enabled;
}, 10, 2);
```

---

## Checklist de fin de session

- [ ] WordPress 6.5+ installé et accessible
- [ ] Tous les plugins activés
- [ ] Theme enfant créé et activé
- [ ] Structure de dossiers complète
- [ ] functions.php de base fonctionnel (pas d'erreur PHP)
- [ ] Google Fonts chargées
- [ ] CLAUDE.md + specs copiés à la racine du theme
- [ ] Git initialisé : `git init && git add . && git commit -m "chore: initial theme setup"`
