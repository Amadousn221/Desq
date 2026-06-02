<?php
defined('ABSPATH') || exit;

function desq_register_product_cpt() {
    register_post_type('desq_product', [
        'labels' => [
            'name'          => 'Produits',
            'singular_name' => 'Produit',
            'add_new_item'  => 'Ajouter un produit',
            'edit_item'     => 'Modifier le produit',
            'search_items'  => 'Rechercher un produit',
        ],
        'public'        => true,
        'has_archive'   => true,
        'menu_icon'     => 'dashicons-store',
        'menu_position' => 5,
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite'       => ['slug' => 'produit'],
        'show_in_rest'  => false,
    ]);
}
add_action('init', 'desq_register_product_cpt');

function desq_register_product_taxonomy() {
    register_taxonomy('product_category', 'desq_product', [
        'labels' => [
            'name'          => 'Catégories',
            'singular_name' => 'Catégorie',
        ],
        'hierarchical'      => true,
        'public'            => true,
        'rewrite'           => ['slug' => 'categorie-produit'],
        'show_admin_column' => true,
    ]);
}
add_action('init', 'desq_register_product_taxonomy');

/* ============================================================
   HELPERS
============================================================ */

function desq_get_price($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $price   = get_field('product_price', $post_id);
    if (!$price) return '';
    return number_format((float) $price, 0, ',', ' ') . ' FCFA';
}

function desq_get_sale_price($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $price   = get_field('product_sale_price', $post_id);
    if (!$price) return '';
    return number_format((float) $price, 0, ',', ' ') . ' FCFA';
}

function desq_get_stock_status($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $stock   = (int) get_field('product_stock', $post_id);
    if ($stock > 10) return ['label' => 'En stock',      'class' => 'badge--in-stock'];
    if ($stock > 0)  return ['label' => 'Stock limité',  'class' => 'badge--low-stock'];
    return              ['label' => 'Sur commande',   'class' => 'badge--out-stock'];
}

function desq_option($key) {
    return get_field($key, 'option');
}
