<?php
defined('ABSPATH') || exit;

function desq_register_solution_cpt() {
    register_post_type('desq_solution', [
        'labels' => [
            'name'          => 'Solutions',
            'singular_name' => 'Solution',
        ],
        'public'        => true,
        'has_archive'   => true,
        'menu_icon'     => 'dashicons-lightbulb',
        'menu_position' => 6,
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite'       => ['slug' => 'solution'],
        'show_in_rest'  => false,
    ]);
}
add_action('init', 'desq_register_solution_cpt');
