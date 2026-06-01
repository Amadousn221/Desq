<?php
defined('ABSPATH') || exit;

function desq_enqueue_assets() {
    wp_enqueue_style(
        'desq-fonts',
        'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'desq-main',
        DESQ_URI . '/style.css',
        ['desq-fonts'],
        DESQ_VERSION
    );

    wp_enqueue_script(
        'desq-main',
        DESQ_URI . '/assets/js/main.js',
        [],
        DESQ_VERSION,
        true
    );
}
add_action('wp_enqueue_scripts', 'desq_enqueue_assets');
