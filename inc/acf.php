<?php
defined('ABSPATH') || exit;

/* ============================================================
   ACF LOCAL JSON — versionner la config dans /acf-fields/
============================================================ */

add_filter('acf/settings/save_json', function() {
    return DESQ_DIR . '/acf-fields';
});

add_filter('acf/settings/load_json', function($paths) {
    $paths[] = DESQ_DIR . '/acf-fields';
    return $paths;
});

/* ============================================================
   ENREGISTREMENT DES GROUPES DE CHAMPS EN PHP
   Chargés localement — pas besoin de les recréer dans l'UI
============================================================ */

add_action('acf/init', 'desq_register_acf_fields');

function desq_register_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) return;

    /* ----------------------------------------------------------
       GROUPE 1 : Détails Produit → desq_product
    ---------------------------------------------------------- */
    acf_add_local_field_group([
        'key'    => 'group_desq_product',
        'title'  => 'Détails Produit',
        'fields' => [
            [
                'key'           => 'field_product_price',
                'label'         => 'Prix FCFA',
                'name'          => 'product_price',
                'type'          => 'number',
                'required'      => 1,
                'min'           => 0,
                'step'          => 1000,
                'instructions'  => 'Prix en FCFA (ex: 450000)',
            ],
            [
                'key'          => 'field_product_sale_price',
                'label'        => 'Prix promo FCFA',
                'name'         => 'product_sale_price',
                'type'         => 'number',
                'required'     => 0,
                'min'          => 0,
                'step'         => 1000,
                'instructions' => 'Laisser vide si pas de promo',
            ],
            [
                'key'   => 'field_product_sku',
                'label' => 'Référence SKU',
                'name'  => 'product_sku',
                'type'  => 'text',
            ],
            [
                'key'           => 'field_product_brand',
                'label'         => 'Marque',
                'name'          => 'product_brand',
                'type'          => 'text',
                'default_value' => 'Felicity Solar',
            ],
            [
                'key'           => 'field_product_warranty',
                'label'         => 'Garantie (années)',
                'name'          => 'product_warranty',
                'type'          => 'number',
                'default_value' => 2,
                'min'           => 0,
                'max'           => 25,
            ],
            [
                'key'           => 'field_product_stock',
                'label'         => 'Stock',
                'name'          => 'product_stock',
                'type'          => 'number',
                'default_value' => 0,
                'min'           => 0,
                'instructions'  => '0 = Sur commande',
            ],
            [
                'key'          => 'field_product_featured',
                'label'        => 'Produit vedette',
                'name'         => 'product_featured',
                'type'         => 'true_false',
                'ui'           => 1,
                'instructions' => 'Afficher sur la page d\'accueil',
            ],
            [
                'key'          => 'field_product_specs',
                'label'        => 'Spécifications techniques',
                'name'         => 'product_specs',
                'type'         => 'repeater',
                'layout'       => 'table',
                'button_label' => 'Ajouter une spec',
                'sub_fields'   => [
                    [
                        'key'   => 'field_spec_name',
                        'label' => 'Nom',
                        'name'  => 'spec_name',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_spec_value',
                        'label' => 'Valeur',
                        'name'  => 'spec_value',
                        'type'  => 'text',
                    ],
                ],
            ],
            [
                'key'          => 'field_product_gallery',
                'label'        => 'Galerie photos',
                'name'         => 'product_gallery',
                'type'         => 'gallery',
                'mime_types'   => 'jpg,jpeg,png,webp',
                'return_format'=> 'array',
            ],
            [
                'key'          => 'field_product_datasheet',
                'label'        => 'Fiche technique (PDF)',
                'name'         => 'product_datasheet',
                'type'         => 'file',
                'mime_types'   => 'pdf',
                'return_format'=> 'array',
            ],
        ],
        'location' => [[
            ['param' => 'post_type', 'operator' => '==', 'value' => 'desq_product'],
        ]],
        'menu_order'  => 0,
        'style'       => 'seamless',
        'active'      => true,
    ]);

    /* ----------------------------------------------------------
       GROUPE 2 : Détails Solution → desq_solution
    ---------------------------------------------------------- */
    acf_add_local_field_group([
        'key'    => 'group_desq_solution',
        'title'  => 'Détails Solution',
        'fields' => [
            [
                'key'     => 'field_solution_segment',
                'label'   => 'Segment',
                'name'    => 'solution_segment',
                'type'    => 'select',
                'choices' => [
                    'residentiel' => 'Résidentiel',
                    'commercial'  => 'Commercial',
                    'industriel'  => 'Industriel',
                    'pompage'     => 'Pompage',
                ],
                'allow_null' => 0,
            ],
            [
                'key'          => 'field_solution_power',
                'label'        => 'Puissance type',
                'name'         => 'solution_power',
                'type'         => 'text',
                'instructions' => 'Ex: 3-5 kW',
            ],
            [
                'key'           => 'field_solution_icon',
                'label'         => 'Icône',
                'name'          => 'solution_icon',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'thumbnail',
            ],
            [
                'key'           => 'field_solution_products',
                'label'         => 'Produits recommandés',
                'name'          => 'solution_products',
                'type'          => 'relationship',
                'post_type'     => ['desq_product'],
                'filters'       => ['search', 'taxonomy'],
                'return_format' => 'post_object',
                'max'           => 6,
            ],
            [
                'key'          => 'field_solution_benefits',
                'label'        => 'Avantages',
                'name'         => 'solution_benefits',
                'type'         => 'repeater',
                'layout'       => 'table',
                'button_label' => 'Ajouter un avantage',
                'sub_fields'   => [
                    [
                        'key'   => 'field_benefit_text',
                        'label' => 'Avantage',
                        'name'  => 'benefit_text',
                        'type'  => 'text',
                    ],
                ],
            ],
        ],
        'location' => [[
            ['param' => 'post_type', 'operator' => '==', 'value' => 'desq_solution'],
        ]],
        'menu_order' => 0,
        'active'     => true,
    ]);

    /* ----------------------------------------------------------
       GROUPE 3 : Détails Témoignage → desq_testimonial
    ---------------------------------------------------------- */
    acf_add_local_field_group([
        'key'    => 'group_desq_testimonial',
        'title'  => 'Détails Témoignage',
        'fields' => [
            [
                'key'      => 'field_testimonial_author',
                'label'    => 'Nom du client',
                'name'     => 'testimonial_author',
                'type'     => 'text',
                'required' => 1,
            ],
            [
                'key'   => 'field_testimonial_role',
                'label' => 'Fonction / Société',
                'name'  => 'testimonial_role',
                'type'  => 'text',
            ],
            [
                'key'          => 'field_testimonial_rating',
                'label'        => 'Note (1-5)',
                'name'         => 'testimonial_rating',
                'type'         => 'number',
                'min'          => 1,
                'max'          => 5,
                'default_value'=> 5,
            ],
            [
                'key'   => 'field_testimonial_location',
                'label' => 'Localisation',
                'name'  => 'testimonial_location',
                'type'  => 'text',
            ],
        ],
        'location' => [[
            ['param' => 'post_type', 'operator' => '==', 'value' => 'desq_testimonial'],
        ]],
        'menu_order' => 0,
        'active'     => true,
    ]);

    /* ----------------------------------------------------------
       GROUPE 4 : Options globales → Options Page
    ---------------------------------------------------------- */
    acf_add_local_field_group([
        'key'    => 'group_desq_options',
        'title'  => 'Options globales DESQ',
        'fields' => [
            [
                'key'           => 'field_desq_logo',
                'label'         => 'Logo',
                'name'          => 'desq_logo',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'thumbnail',
            ],
            [
                'key'   => 'field_desq_phone',
                'label' => 'Téléphone',
                'name'  => 'desq_phone',
                'type'  => 'text',
            ],
            [
                'key'          => 'field_desq_whatsapp',
                'label'        => 'WhatsApp',
                'name'         => 'desq_whatsapp',
                'type'         => 'text',
                'instructions' => 'Format international sans + : 221773480737',
            ],
            [
                'key'   => 'field_desq_email',
                'label' => 'Email',
                'name'  => 'desq_email',
                'type'  => 'email',
            ],
            [
                'key'  => 'field_desq_address',
                'label'=> 'Adresse',
                'name' => 'desq_address',
                'type' => 'textarea',
                'rows' => 3,
            ],
            [
                'key'  => 'field_desq_hours',
                'label'=> 'Horaires',
                'name' => 'desq_hours',
                'type' => 'textarea',
                'rows' => 3,
            ],
            [
                'key'   => 'field_desq_hero_title',
                'label' => 'Titre Hero accueil',
                'name'  => 'desq_hero_title',
                'type'  => 'text',
            ],
            [
                'key'  => 'field_desq_hero_subtitle',
                'label'=> 'Sous-titre Hero',
                'name' => 'desq_hero_subtitle',
                'type' => 'textarea',
                'rows' => 2,
            ],
            [
                'key'   => 'field_desq_map_lat',
                'label' => 'Latitude Google Maps',
                'name'  => 'desq_map_lat',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_desq_map_lng',
                'label' => 'Longitude Google Maps',
                'name'  => 'desq_map_lng',
                'type'  => 'text',
            ],
            [
                'key'          => 'field_desq_social',
                'label'        => 'Réseaux sociaux',
                'name'         => 'desq_social',
                'type'         => 'repeater',
                'layout'       => 'table',
                'button_label' => 'Ajouter un réseau',
                'sub_fields'   => [
                    [
                        'key'     => 'field_social_network',
                        'label'   => 'Réseau',
                        'name'    => 'network',
                        'type'    => 'select',
                        'choices' => [
                            'facebook'  => 'Facebook',
                            'instagram' => 'Instagram',
                            'linkedin'  => 'LinkedIn',
                            'youtube'   => 'YouTube',
                        ],
                    ],
                    [
                        'key'   => 'field_social_url',
                        'label' => 'URL',
                        'name'  => 'url',
                        'type'  => 'url',
                    ],
                ],
            ],
        ],
        'location' => [[
            ['param' => 'options_page', 'operator' => '==', 'value' => 'desq-options'],
        ]],
        'menu_order' => 0,
        'active'     => true,
    ]);
}
