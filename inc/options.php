<?php
defined('ABSPATH') || exit;

add_action('acf/init', function() {
    if (!function_exists('acf_add_options_page')) return;

    acf_add_options_page([
        'page_title' => 'Options DESQ',
        'menu_title' => 'Options DESQ',
        'menu_slug'  => 'desq-options',
        'icon_url'   => 'dashicons-admin-generic',
        'position'   => 4,
        'capability' => 'manage_options',
    ]);
});
