<?php
defined('ABSPATH') || exit;

function desq_register_testimonial_cpt() {
    register_post_type('desq_testimonial', [
        'labels' => [
            'name'          => 'Témoignages',
            'singular_name' => 'Témoignage',
        ],
        'public'        => false,
        'show_ui'       => true,
        'menu_icon'     => 'dashicons-format-quote',
        'menu_position' => 7,
        'supports'      => ['title', 'editor', 'thumbnail'],
        'show_in_rest'  => false,
    ]);
}
add_action('init', 'desq_register_testimonial_cpt');
