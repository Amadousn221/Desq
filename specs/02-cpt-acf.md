# 02 — Custom Post Types & ACF

> Spec des CPT et champs personnalisés. Claude Code code les fichiers `/post-types/*.php` et configure ACF.

---

## CPT 1 — Produits (desq_product)

### post-types/register-product.php
```php
<?php
if (!defined('ABSPATH')) exit;

function desq_register_product_cpt() {
    register_post_type('desq_product', [
        'labels' => [
            'name'          => 'Produits',
            'singular_name' => 'Produit',
            'add_new_item'  => 'Ajouter un produit',
            'edit_item'     => 'Modifier le produit',
            'search_items'  => 'Rechercher un produit',
        ],
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-store',
        'menu_position'=> 5,
        'supports'     => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite'      => ['slug' => 'produit'],
        'show_in_rest' => false, // ACF, pas Gutenberg
    ]);
}
add_action('init', 'desq_register_product_cpt');

// Taxonomie catégorie produit
function desq_register_product_taxonomy() {
    register_taxonomy('product_category', 'desq_product', [
        'labels' => [
            'name'          => 'Catégories',
            'singular_name' => 'Catégorie',
        ],
        'hierarchical' => true,
        'public'       => true,
        'rewrite'      => ['slug' => 'categorie-produit'],
        'show_admin_column' => true,
    ]);
}
add_action('init', 'desq_register_product_taxonomy');
```

### Champs ACF — Groupe "Détails Produit" (location: desq_product)

| Champ | Nom (name) | Type | Notes |
|-------|-----------|------|-------|
| Prix FCFA | `product_price` | Number | Step 1000, requis |
| Référence SKU | `product_sku` | Text | |
| Prix promo | `product_sale_price` | Number | Optionnel |
| Garantie (années) | `product_warranty` | Number | Défaut 2 |
| Stock | `product_stock` | Number | 0 = sur commande |
| Marque | `product_brand` | Text | Défaut "Felicity Solar" |
| Specs techniques | `product_specs` | Repeater | Sous-champs ↓ |
| → Nom spec | `spec_name` | Text | Ex: "Puissance" |
| → Valeur spec | `spec_value` | Text | Ex: "8kW" |
| Galerie photos | `product_gallery` | Gallery | |
| Fiche technique PDF | `product_datasheet` | File | PDF |
| Produit vedette | `product_featured` | True/False | Affichage homepage |

### Catégories à créer (taxonomy product_category)
- Batteries (slug: batteries)
- Onduleurs (slug: onduleurs)
- Panneaux solaires (slug: panneaux)
- Protection & coffrets (slug: protection)
- Accessoires (slug: accessoires)
- Pompes solaires (slug: pompes)

---

## CPT 2 — Solutions (desq_solution)

### post-types/register-solution.php
```php
<?php
if (!defined('ABSPATH')) exit;

function desq_register_solution_cpt() {
    register_post_type('desq_solution', [
        'labels' => [
            'name'          => 'Solutions',
            'singular_name' => 'Solution',
        ],
        'public'      => true,
        'has_archive' => true,
        'menu_icon'   => 'dashicons-lightbulb',
        'menu_position' => 6,
        'supports'    => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite'     => ['slug' => 'solution'],
        'show_in_rest'=> false,
    ]);
}
add_action('init', 'desq_register_solution_cpt');
```

### Champs ACF — Groupe "Détails Solution"
| Champ | Nom | Type |
|-------|-----|------|
| Icône (SVG) | `solution_icon` | Image (SVG) |
| Segment | `solution_segment` | Select (résidentiel, commercial, industriel, pompage) |
| Puissance type | `solution_power` | Text (ex: "3-5 kW") |
| Produits recommandés | `solution_products` | Relationship (vers desq_product) |
| Avantages | `solution_benefits` | Repeater (benefit_text) |

---

## CPT 3 — Témoignages (desq_testimonial)

### post-types/register-testimonial.php
```php
<?php
if (!defined('ABSPATH')) exit;

function desq_register_testimonial_cpt() {
    register_post_type('desq_testimonial', [
        'labels' => [
            'name'          => 'Témoignages',
            'singular_name' => 'Témoignage',
        ],
        'public'      => false,
        'show_ui'     => true,
        'menu_icon'   => 'dashicons-format-quote',
        'menu_position' => 7,
        'supports'    => ['title', 'editor', 'thumbnail'],
        'show_in_rest'=> false,
    ]);
}
add_action('init', 'desq_register_testimonial_cpt');
```

### Champs ACF — "Détails Témoignage"
| Champ | Nom | Type |
|-------|-----|------|
| Nom client | `testimonial_author` | Text |
| Fonction/Société | `testimonial_role` | Text |
| Note (1-5) | `testimonial_rating` | Number |
| Localisation | `testimonial_location` | Text |

---

## Options globales du site

### Groupe ACF "Options DESQ" (location: Options Page)
Créer la page d'options dans functions.php :
```php
if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => 'Options DESQ',
        'menu_title' => 'Options DESQ',
        'menu_slug'  => 'desq-options',
        'icon_url'   => 'dashicons-admin-generic',
        'position'   => 4,
    ]);
}
```

| Champ | Nom | Type |
|-------|-----|------|
| Logo | `desq_logo` | Image |
| Téléphone | `desq_phone` | Text |
| WhatsApp | `desq_whatsapp` | Text (format intl: 221773480737) |
| Email | `desq_email` | Email |
| Adresse | `desq_address` | Textarea |
| Horaires | `desq_hours` | Textarea |
| Titre Hero accueil | `desq_hero_title` | Text |
| Sous-titre Hero | `desq_hero_subtitle` | Textarea |
| Coords Google Maps | `desq_map_lat` / `desq_map_lng` | Text |
| Liens réseaux | `desq_social` | Repeater (network, url) |

---

## Helper functions à coder (dans functions.php ou /inc/)

```php
/**
 * Récupère le prix formaté d'un produit
 */
function desq_get_price($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $price = get_field('product_price', $post_id);
    return number_format($price, 0, ',', ' ') . ' FCFA';
}

/**
 * Récupère le statut de stock
 */
function desq_get_stock_status($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $stock = (int) get_field('product_stock', $post_id);
    return $stock > 0
        ? ['label' => 'En stock', 'class' => 'badge--success']
        : ['label' => 'Sur commande', 'class' => 'badge'];
}

/**
 * Récupère une option globale
 */
function desq_option($key) {
    return get_field($key, 'option');
}
```

---

## Export ACF en JSON (pour versionner)

Activer ACF Local JSON pour versionner la config :
```php
// functions.php
add_filter('acf/settings/save_json', function() {
    return DESQ_DIR . '/acf-fields';
});
add_filter('acf/settings/load_json', function($paths) {
    $paths[0] = DESQ_DIR . '/acf-fields';
    return $paths;
});
```
Ainsi tous les groupes de champs sont sauvegardés en JSON dans `/acf-fields/` et versionnés avec Git.

---

## Checklist
- [ ] 3 CPT enregistrés et visibles dans l'admin
- [ ] Taxonomie product_category + 6 catégories créées
- [ ] Tous les groupes ACF configurés
- [ ] Page d'options ACF créée
- [ ] ACF Local JSON activé (config versionnée)
- [ ] Helper functions testées
- [ ] 2-3 produits de test créés pour valider
