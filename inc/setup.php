<?php
defined('ABSPATH') || exit;

function desq_setup() {
    load_theme_textdomain('desq-energy', DESQ_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('woocommerce');

    register_nav_menus([
        'primary' => __('Menu principal', 'desq-energy'),
        'footer'  => __('Menu footer', 'desq-energy'),
    ]);
}
add_action('after_setup_theme', 'desq_setup');
