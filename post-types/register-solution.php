<?php
defined('ABSPATH') || exit;

function desq_register_solution() {
    register_post_type('desq_solution', [
        'labels' => [
            'name'          => __('Solutions', 'desq-energy'),
            'singular_name' => __('Solution', 'desq-energy'),
            'add_new_item'  => __('Ajouter une solution', 'desq-energy'),
            'edit_item'     => __('Modifier la solution', 'desq-energy'),
        ],
        'public'        => true,
        'show_in_rest'  => true,
        'supports'      => ['title', 'editor', 'thumbnail'],
        'has_archive'   => false,
        'rewrite'       => ['slug' => 'solutions'],
        'menu_icon'     => 'dashicons-lightbulb',
        'menu_position' => 6,
    ]);
}
add_action('init', 'desq_register_solution');
