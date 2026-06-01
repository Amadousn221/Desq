<?php
defined('ABSPATH') || exit;

if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => 'Options DESQ',
        'menu_title' => 'Options DESQ',
        'menu_slug'  => 'desq-options',
        'capability' => 'manage_options',
        'icon_url'   => 'dashicons-admin-settings',
    ]);
}
