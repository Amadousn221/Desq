<?php
defined('ABSPATH') || exit;

$_logo  = function_exists('desq_option') ? desq_option('desq_logo')  : null;
$_phone = function_exists('desq_option') ? desq_option('desq_phone') : '';

$_solutions = [
    ['label' => 'Résidentiel',     'slug' => 'residentiel'],
    ['label' => 'Commercial',      'slug' => 'commercial'],
    ['label' => 'Industriel',      'slug' => 'industriel'],
    ['label' => 'Pompage solaire', 'slug' => 'pompage-solaire'],
];

$_cat_items = [
    ['label' => 'Onduleurs hors réseau',    'slug' => 'onduleurs-hors-reseau'],
    ['label' => 'Onduleurs hybrides',       'slug' => 'onduleurs-hybrides'],
    ['label' => 'Batteries lithium',        'slug' => 'batteries-lithium'],
    ['label' => 'Panneaux solaires',        'slug' => 'panneaux'],
    ['label' => 'Protection & accessoires', 'slug' => 'protection'],
];

$_services = [
    ['label' => 'Installation certifiée',  'href' => '/services/installation/'],
    ['label' => 'Maintenance & SAV',       'href' => '/services/maintenance/'],
    ['label' => 'Formation installateurs', 'href' => '/services/formation/'],
    ['label' => 'Devenir revendeur',       'href' => '/services/revendeur/'],
];

$_about = [
    ['label' => 'DESQ Energy',               'href' => '/a-propos/'],
    ['label' => 'Partenaire Felicity Solar',  'href' => '/a-propos/felicity-solar/'],
    ['label' => 'Actualités',                'href' => '/actualites/'],
    ['label' => 'Téléchargements',           'href' => '/telechargements/'],
    ['label' => 'Nous contacter',            'href' => '/contact/'],
];

$_preview_q = new WP_Query([
    'post_type'      => 'desq_product',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'orderby'        => 'rand',
    'no_found_rows'  => true,
    'meta_query'     => [['key' => '_thumbnail_id', 'compare' => 'EXISTS']],
]);

function desq_header_chevron() {
    echo '<svg class="site-header__chevron" width="10" height="6" viewBox="0 0 10 6" fill="none" aria-hidden="true">'
       . '<path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>'
       . '</svg>';
}

function desq_header_logo_markup($logo, $height = 36) {
    if ($logo && ! empty($logo['url'])) {
        printf(
            '<img src="%s" alt="%s" height="%d" loading="eager">',
            esc_url($logo['url']),
            esc_attr(get_bloginfo('name')),
            $height
        );
    } elseif (has_custom_logo()) {
        the_custom_logo();
    } else {
        printf(
            '<img src="%s" alt="%s" height="%d" loading="eager" style="width:auto">',
            esc_url(DESQ_URI . '/assets/images/logo-desq-energy.jpg'),
            esc_attr(get_bloginfo('name')),
            $height
        );
    }
}
?>

<header id="site-header" class="site-header" role="banner">
    <div class="container site-header__inner">

        <!-- ── LOGO ── -->
        <a href="<?php echo esc_url(home_url('/')); ?>"
           class="site-header__logo"
           aria-label="<?php esc_attr_e('DESQ Energy — Accueil', 'desq-energy'); ?>">
            <?php desq_header_logo_markup($_logo, 36); ?>
        </a>

        <!-- ── NAV DESKTOP ── -->
        <nav class="site-header__nav"
             id="primary-nav"
             aria-label="<?php esc_attr_e('Navigation principale', 'desq-energy'); ?>">
            <ul class="site-header__menu" role="menubar">

                <li class="menu-item" role="none">
                    <a href="<?php echo esc_url(home_url('/')); ?>"
                       class="site-header__link<?php echo is_front_page() ? ' is-active' : ''; ?>"
                       role="menuitem">
                        <?php esc_html_e('Accueil', 'desq-energy'); ?>
                    </a>
                </li>

                <!-- Solutions ▾ -->
                <li class="menu-item menu-item--has-dropdown" role="none">
                    <button class="site-header__link site-header__link--toggle"
                            aria-haspopup="true" aria-expanded="false" role="menuitem">
                        <?php esc_html_e('Solutions', 'desq-energy'); ?>
                        <?php desq_header_chevron(); ?>
                    </button>
                    <div class="site-header__dropdown site-header__dropdown--solutions"
                         role="menu" aria-label="<?php esc_attr_e('Solutions', 'desq-energy'); ?>">
                        <p class="site-header__dropdown-title">
                            <?php esc_html_e('Nos solutions', 'desq-energy'); ?>
                        </p>
                        <div class="solutions-grid">
                            <?php foreach ($_solutions as $_sol) : ?>
                            <a href="<?php echo esc_url(home_url('/solution/' . $_sol['slug'] . '/')); ?>"
                               class="solutions-grid__cell" role="menuitem">
                                <div class="solutions-grid__overlay"></div>
                                <span class="solutions-grid__label">
                                    <?php echo esc_html($_sol['label']); ?>
                                </span>
                            </a>
                            <?php endforeach; ?>
                        </div>
                        <a href="<?php echo esc_url(home_url('/solution/')); ?>"
                           class="site-header__dropdown-link-all" role="menuitem">
                            <?php esc_html_e('Voir toutes les solutions', 'desq-energy'); ?> →
                        </a>
                    </div>
                </li>

                <!-- Produits ▾ -->
                <li class="menu-item menu-item--has-dropdown" role="none">
                    <button class="site-header__link site-header__link--toggle"
                            aria-haspopup="true" aria-expanded="false" role="menuitem">
                        <?php esc_html_e('Produits', 'desq-energy'); ?>
                        <?php desq_header_chevron(); ?>
                    </button>
                    <div class="site-header__dropdown site-header__dropdown--products"
                         role="menu" aria-label="<?php esc_attr_e('Produits', 'desq-energy'); ?>">

                        <div class="products-dropdown__sidebar">
                            <p class="site-header__dropdown-title">
                                <?php esc_html_e('Catalogue', 'desq-energy'); ?>
                            </p>
                            <?php foreach ($_cat_items as $_cat) : ?>
                            <a href="<?php echo esc_url(home_url('/categorie-produit/' . $_cat['slug'] . '/')); ?>"
                               class="products-dropdown__cat"
                               data-cat="<?php echo esc_attr($_cat['slug']); ?>"
                               role="menuitem">
                                <?php echo esc_html($_cat['label']); ?>
                            </a>
                            <?php endforeach; ?>
                            <a href="<?php echo esc_url(get_post_type_archive_link('desq_product') ?: home_url('/catalogue/')); ?>"
                               class="products-dropdown__cat products-dropdown__cat--all"
                               role="menuitem">
                                <?php esc_html_e('→ Voir tout le catalogue', 'desq-energy'); ?>
                            </a>
                        </div>

                        <div class="products-dropdown__preview">
                            <?php
                            if ($_preview_q->have_posts()) :
                                while ($_preview_q->have_posts()) : $_preview_q->the_post();
                                    $thumb = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                            ?>
                            <a href="<?php echo esc_url(get_permalink()); ?>"
                               class="products-preview__card" role="menuitem">
                                <?php if ($thumb) : ?>
                                <img src="<?php echo esc_url($thumb); ?>"
                                     alt="<?php echo esc_attr(get_the_title()); ?>"
                                     loading="lazy">
                                <?php endif; ?>
                                <span class="products-preview__name"><?php the_title(); ?></span>
                                <span class="products-preview__link">
                                    <?php esc_html_e('Voir →', 'desq-energy'); ?>
                                </span>
                            </a>
                            <?php
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                    </div>
                </li>

                <!-- Services ▾ -->
                <li class="menu-item menu-item--has-dropdown" role="none">
                    <button class="site-header__link site-header__link--toggle"
                            aria-haspopup="true" aria-expanded="false" role="menuitem">
                        <?php esc_html_e('Services', 'desq-energy'); ?>
                        <?php desq_header_chevron(); ?>
                    </button>
                    <div class="site-header__dropdown site-header__dropdown--list"
                         role="menu" aria-label="<?php esc_attr_e('Services', 'desq-energy'); ?>">
                        <?php foreach ($_services as $_svc) : ?>
                        <a href="<?php echo esc_url(home_url($_svc['href'])); ?>"
                           class="list-dropdown__item" role="menuitem">
                            <?php echo esc_html($_svc['label']); ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </li>

                <!-- À propos ▾ -->
                <li class="menu-item menu-item--has-dropdown" role="none">
                    <button class="site-header__link site-header__link--toggle"
                            aria-haspopup="true" aria-expanded="false" role="menuitem">
                        <?php esc_html_e('À propos', 'desq-energy'); ?>
                        <?php desq_header_chevron(); ?>
                    </button>
                    <div class="site-header__dropdown site-header__dropdown--list"
                         role="menu" aria-label="<?php esc_attr_e('À propos', 'desq-energy'); ?>">
                        <?php foreach ($_about as $_item) : ?>
                        <a href="<?php echo esc_url(home_url($_item['href'])); ?>"
                           class="list-dropdown__item" role="menuitem">
                            <?php echo esc_html($_item['label']); ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </li>

                <li class="menu-item" role="none">
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>"
                       class="site-header__link<?php echo is_page('contact') ? ' is-active' : ''; ?>"
                       role="menuitem">
                        <?php esc_html_e('Contact', 'desq-energy'); ?>
                    </a>
                </li>

                <li class="menu-item" role="none">
                    <a href="<?php echo esc_url(home_url('/installateurs/')); ?>"
                       class="site-header__link site-header__link--accent"
                       role="menuitem">
                        <?php esc_html_e('Installateurs', 'desq-energy'); ?>
                    </a>
                </li>

            </ul>
        </nav>

        <!-- ── ACTIONS ── -->
        <div class="site-header__actions">

            <button class="site-header__search-btn" type="button"
                    aria-label="<?php esc_attr_e('Rechercher', 'desq-energy'); ?>">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                     stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <circle cx="8.5" cy="8.5" r="5.5"/>
                    <path d="M17 17l-3.5-3.5" stroke-linecap="round"/>
                </svg>
            </button>

            <a href="<?php echo esc_url(home_url('/devis/')); ?>"
               class="site-header__cta btn btn--primary btn--sm">
                <?php esc_html_e('Devis rapide', 'desq-energy'); ?>
            </a>

            <button class="site-header__burger" type="button"
                    id="nav-drawer-toggle"
                    aria-label="<?php esc_attr_e('Ouvrir le menu', 'desq-energy'); ?>"
                    aria-expanded="false"
                    aria-controls="nav-drawer">
                <svg width="20" height="16" viewBox="0 0 20 16" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     aria-hidden="true">
                    <line x1="0" y1="2"  x2="20" y2="2"/>
                    <line x1="0" y1="8"  x2="20" y2="8"/>
                    <line x1="0" y1="14" x2="20" y2="14"/>
                </svg>
            </button>
        </div>

    </div>
</header>

<!-- ── DRAWER MOBILE ── -->
<aside class="nav-drawer" id="nav-drawer"
       aria-hidden="true"
       aria-label="<?php esc_attr_e('Menu mobile', 'desq-energy'); ?>">

    <div class="nav-drawer__header">
        <a href="<?php echo esc_url(home_url('/')); ?>"
           class="nav-drawer__logo"
           aria-label="<?php esc_attr_e('DESQ Energy — Accueil', 'desq-energy'); ?>">
            <?php desq_header_logo_markup($_logo, 28); ?>
        </a>
    </div>

    <nav class="nav-drawer__body"
         aria-label="<?php esc_attr_e('Navigation mobile', 'desq-energy'); ?>">

        <a href="<?php echo esc_url(home_url('/installateurs/')); ?>"
           class="nav-drawer__item nav-drawer__item--accent">
            <?php esc_html_e('Installateurs', 'desq-energy'); ?>
            <span class="nav-drawer__pill">B2B</span>
        </a>

        <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-drawer__item">
            <?php esc_html_e('Accueil', 'desq-energy'); ?>
        </a>

        <?php
        $drawer_groups = [
            [
                'label' => 'Solutions',
                'items' => array_merge(
                    array_map(fn($s) => ['label' => $s['label'], 'href' => '/solution/' . $s['slug'] . '/'], $_solutions),
                    [['label' => 'Toutes les solutions', 'href' => '/solution/', 'class' => 'all']]
                ),
            ],
            [
                'label' => 'Produits',
                'items' => array_merge(
                    array_map(fn($c) => ['label' => $c['label'], 'href' => '/categorie-produit/' . $c['slug'] . '/'], $_cat_items),
                    [['label' => 'Voir tout le catalogue', 'href' => get_post_type_archive_link('desq_product') ?: '/catalogue/', 'class' => 'all']]
                ),
            ],
            [
                'label' => 'Services',
                'items' => array_map(fn($s) => ['label' => $s['label'], 'href' => $s['href']], $_services),
            ],
            [
                'label' => 'À propos',
                'items' => array_map(fn($i) => ['label' => $i['label'], 'href' => $i['href']], $_about),
            ],
        ];
        foreach ($drawer_groups as $_group) :
        ?>
        <div class="nav-drawer__group">
            <button class="nav-drawer__item nav-drawer__item--toggle" aria-expanded="false">
                <?php echo esc_html($_group['label']); ?>
                <svg class="nav-drawer__chevron" width="10" height="6" viewBox="0 0 10 6"
                     fill="none" aria-hidden="true">
                    <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <div class="nav-drawer__sub" hidden>
                <?php foreach ($_group['items'] as $_sub) :
                    $extra_class = isset($_sub['class']) ? ' nav-drawer__sub-item--' . esc_attr($_sub['class']) : '';
                    $href = is_array($_sub['href']) ? $_sub['href'] : home_url($_sub['href']);
                ?>
                <a href="<?php echo esc_url($href); ?>"
                   class="nav-drawer__sub-item<?php echo $extra_class; ?>">
                    <?php echo esc_html($_sub['label']); ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>

        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="nav-drawer__item">
            <?php esc_html_e('Contact', 'desq-energy'); ?>
        </a>

    </nav>

    <div class="nav-drawer__footer">
        <a href="<?php echo esc_url(home_url('/devis/')); ?>"
           class="btn btn--primary nav-drawer__cta">
            <?php esc_html_e('Devis rapide', 'desq-energy'); ?>
        </a>
        <?php if ($_phone) : ?>
        <p class="nav-drawer__phone">
            <?php esc_html_e('ou appeler le', 'desq-energy'); ?>
            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $_phone)); ?>">
                <?php echo esc_html($_phone); ?>
            </a>
        </p>
        <?php endif; ?>
    </div>

</aside>

<div class="nav-overlay" id="nav-overlay" aria-hidden="true"></div>
