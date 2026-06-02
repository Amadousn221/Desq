<?php
defined('ABSPATH') || exit;

function desq_register_testimonial() {
    register_post_type('desq_testimonial', [
        'labels' => [
            'name'          => __('Témoignages', 'desq-energy'),
            'singular_name' => __('Témoignage', 'desq-energy'),
            'add_new_item'  => __('Ajouter un témoignage', 'desq-energy'),
            'edit_item'     => __('Modifier le témoignage', 'desq-energy'),
        ],
        'public'        => false,
        'show_ui'       => true,
        'show_in_rest'  => true,
        'supports'      => ['title', 'editor', 'thumbnail'],
        'menu_icon'     => 'dashicons-format-quote',
        'menu_position' => 7,
    ]);
}
add_action('init', 'desq_register_testimonial');
