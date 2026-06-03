<?php
defined('ABSPATH') || exit;

define('DESQ_VERSION', '1.1.0');
define('DESQ_DIR', get_template_directory());
define('DESQ_URI', get_template_directory_uri());

function desq_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo');
    add_theme_support('woocommerce');

    add_image_size('product-card', 400, 300, true);
    add_image_size('product-hero', 800, 600, true);

    register_nav_menus([
        'primary' => 'Menu principal',
        'footer'  => 'Menu footer',
    ]);

    load_theme_textdomain('desq-energy', DESQ_DIR . '/languages');
}
add_action('after_setup_theme', 'desq_theme_setup');

function desq_enqueue_assets() {
    wp_enqueue_style(
        'desq-fonts',
        'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap',
        [],
        null
    );

    wp_enqueue_style('desq-design-system', DESQ_URI . '/assets/css/design-system.css', [], DESQ_VERSION);
    wp_enqueue_style('desq-global',        DESQ_URI . '/assets/css/global.css',        ['desq-design-system'], DESQ_VERSION);
    wp_enqueue_style('desq-components',    DESQ_URI . '/assets/css/components.css',    ['desq-global'],        DESQ_VERSION);
    wp_enqueue_style('desq-animations',    DESQ_URI . '/assets/css/animations.css',    ['desq-components'],    DESQ_VERSION);
    wp_enqueue_style('desq-header',        DESQ_URI . '/assets/css/header.css',        ['desq-animations'],     DESQ_VERSION);

    if (is_front_page()) {
        wp_enqueue_style('desq-home', DESQ_URI . '/assets/css/home.css', ['desq-header'], DESQ_VERSION);
    }

    wp_enqueue_script('desq-header', DESQ_URI . '/assets/js/header.js', [], DESQ_VERSION, true);
    wp_enqueue_script('desq-main',   DESQ_URI . '/assets/js/main.js',   ['desq-header'], DESQ_VERSION, true);

    wp_localize_script('desq-main', 'desqData', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('desq_nonce'),
        'homeurl' => home_url(),
    ]);
}
add_action('wp_enqueue_scripts', 'desq_enqueue_assets');

require_once DESQ_DIR . '/post-types/register-product.php';
require_once DESQ_DIR . '/post-types/register-solution.php';
require_once DESQ_DIR . '/post-types/register-testimonial.php';
require_once DESQ_DIR . '/inc/acf.php';
require_once DESQ_DIR . '/inc/options.php';

// Désactiver les CSS de compatibilité thème WooCommerce (interfèrent avec le footer)
add_action('wp_enqueue_scripts', function() {
    foreach (['woocommerce-twenty-twenty-one', 'woocommerce-twenty-twenty',
              'woocommerce-twenty-nineteen', 'woocommerce-twenty-seventeen',
              'wc-twenty-twenty-one', 'wc-twenty-twenty', 'wc-twenty-nineteen'] as $handle) {
        wp_dequeue_style($handle);
        wp_deregister_style($handle);
    }
}, 100);

add_filter('use_block_editor_for_post_type', function($enabled, $post_type) {
    if (in_array($post_type, ['desq_product', 'desq_solution'])) return false;
    return $enabled;
}, 10, 2);
