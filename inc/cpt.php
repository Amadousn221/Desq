<?php
defined('ABSPATH') || exit;

function desq_register_cpts() {
    register_post_type('desq_product', [
        'labels' => [
            'name'          => __('Produits', 'desq-energy'),
            'singular_name' => __('Produit', 'desq-energy'),
            'add_new_item'  => __('Ajouter un produit', 'desq-energy'),
        ],
        'public'       => true,
        'show_in_rest' => true,
        'supports'     => ['title', 'editor', 'thumbnail', 'excerpt'],
        'has_archive'  => true,
        'rewrite'      => ['slug' => 'produits'],
        'menu_icon'    => 'dashicons-portfolio',
    ]);

    register_post_type('desq_solution', [
        'labels' => [
            'name'          => __('Solutions', 'desq-energy'),
            'singular_name' => __('Solution', 'desq-energy'),
        ],
        'public'       => true,
        'show_in_rest' => true,
        'supports'     => ['title', 'editor', 'thumbnail'],
        'has_archive'  => false,
        'rewrite'      => ['slug' => 'solutions'],
        'menu_icon'    => 'dashicons-lightbulb',
    ]);

    register_post_type('desq_testimonial', [
        'labels' => [
            'name'          => __('Témoignages', 'desq-energy'),
            'singular_name' => __('Témoignage', 'desq-energy'),
        ],
        'public'       => false,
        'show_in_rest' => true,
        'show_ui'      => true,
        'supports'     => ['title', 'editor', 'thumbnail'],
        'menu_icon'    => 'dashicons-format-quote',
    ]);

    register_taxonomy('product_category', ['desq_product'], [
        'labels' => [
            'name'          => __('Catégories produit', 'desq-energy'),
            'singular_name' => __('Catégorie', 'desq-energy'),
        ],
        'public'       => true,
        'show_in_rest' => true,
        'hierarchical' => true,
        'rewrite'      => ['slug' => 'categorie-produit'],
    ]);
}
add_action('init', 'desq_register_cpts');
