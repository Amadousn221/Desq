<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e('Aller au contenu', 'desq-energy'); ?></a>

<header id="site-header" class="site-header" role="banner">
    <div class="container site-header__inner">

        <a href="<?php echo esc_url(home_url('/')); ?>"
           class="site-header__logo"
           aria-label="<?php echo esc_attr(get_bloginfo('name')); ?> — <?php esc_attr_e('Accueil', 'desq-energy'); ?>">
            <?php
            $logo = function_exists('desq_option') ? desq_option('desq_logo') : null;
            if ($logo && ! empty($logo['url'])) :
            ?>
                <img src="<?php echo esc_url($logo['url']); ?>"
                     alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                     width="<?php echo esc_attr($logo['width'] ?? 140); ?>"
                     height="<?php echo esc_attr($logo['height'] ?? 38); ?>"
                     loading="eager">
            <?php else : ?>
                <span class="site-header__logo-text" aria-hidden="true">
                    DESQ <em>Energy</em>
                </span>
            <?php endif; ?>
        </a>

        <nav class="site-header__nav"
             id="site-nav"
             data-menu
             aria-label="<?php esc_attr_e('Navigation principale', 'desq-energy'); ?>">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'site-header__menu',
                'link_before'    => '',
                'link_after'     => '',
                'fallback_cb'    => function () {
                    $links = [
                        home_url('/')           => 'Accueil',
                        home_url('/produit/')   => 'Produits',
                        home_url('/solution/')  => 'Solutions',
                        home_url('/simulateur/')=> 'Simulateur',
                        home_url('/contact/')   => 'Contact',
                    ];
                    echo '<ul class="site-header__menu">';
                    foreach ($links as $url => $label) {
                        echo '<li><a href="' . esc_url($url) . '">' . esc_html($label) . '</a></li>';
                    }
                    echo '</ul>';
                },
            ]);
            ?>
        </nav>

        <div class="site-header__actions">
            <a href="<?php echo esc_url(home_url('/devis/')); ?>"
               class="btn btn--primary btn--sm site-header__cta">
                <?php esc_html_e('Devis rapide', 'desq-energy'); ?>
            </a>

            <button class="site-header__burger"
                    data-menu-toggle
                    aria-label="<?php esc_attr_e('Ouvrir le menu', 'desq-energy'); ?>"
                    aria-expanded="false"
                    aria-controls="site-nav">
                <span class="site-header__burger-line"></span>
                <span class="site-header__burger-line"></span>
                <span class="site-header__burger-line"></span>
            </button>
        </div>

    </div>
</header>
