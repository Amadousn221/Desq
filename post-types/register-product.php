<?php
defined('ABSPATH') || exit;

function desq_register_product() {
    register_post_type('desq_product', [
        'labels' => [
            'name'               => __('Produits', 'desq-energy'),
            'singular_name'      => __('Produit', 'desq-energy'),
            'add_new_item'       => __('Ajouter un produit', 'desq-energy'),
            'edit_item'          => __('Modifier le produit', 'desq-energy'),
            'view_item'          => __('Voir le produit', 'desq-energy'),
            'search_items'       => __('Rechercher un produit', 'desq-energy'),
            'not_found'          => __('Aucun produit trouvé', 'desq-energy'),
        ],
        'public'             => true,
        'show_in_rest'       => true,
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt'],
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'produits'],
        'menu_icon'          => 'dashicons-portfolio',
        'menu_position'      => 5,
    ]);

    register_taxonomy('product_category', ['desq_product'], [
        'labels' => [
            'name'          => __('Catégories produit', 'desq-energy'),
            'singular_name' => __('Catégorie', 'desq-energy'),
            'all_items'     => __('Toutes les catégories', 'desq-energy'),
            'edit_item'     => __('Modifier la catégorie', 'desq-energy'),
            'add_new_item'  => __('Ajouter une catégorie', 'desq-energy'),
        ],
        'public'            => true,
        'show_in_rest'      => true,
        'hierarchical'      => true,
        'rewrite'           => ['slug' => 'categorie-produit'],
    ]);
}
add_action('init', 'desq_register_product');

function desq_get_price($post_id = null) {
    $post_id = $post_id ?? get_the_ID();
    $price = get_field('product_price', $post_id);
    if (!$price) return '';
    return number_format((float) $price, 0, ',', ' ') . ' FCFA';
}

function desq_get_stock_status($post_id = null) {
    $post_id = $post_id ?? get_the_ID();
    $stock = (int) get_field('product_stock', $post_id);
    if ($stock > 10) return ['label' => 'En stock', 'class' => 'in-stock'];
    if ($stock > 0)  return ['label' => 'Stock limité', 'class' => 'low-stock'];
    return ['label' => 'Rupture', 'class' => 'out-of-stock'];
}
