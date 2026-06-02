<footer id="site-footer" class="site-footer" role="contentinfo">
    <div class="site-footer__main">
        <div class="container site-footer__grid">

            <!-- Colonne 1 : À propos -->
            <div class="site-footer__col site-footer__col--about">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-footer__logo" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
                    <?php
                    $logo = function_exists('desq_option') ? desq_option('desq_logo') : null;
                    if ($logo && ! empty($logo['url'])) :
                    ?>
                        <img src="<?php echo esc_url($logo['url']); ?>"
                             alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                             width="120" height="34" loading="lazy">
                    <?php else : ?>
                        <span class="site-footer__logo-text">DESQ <em>Energy</em></span>
                    <?php endif; ?>
                </a>
                <p class="site-footer__about">
                    <?php esc_html_e('Distributeur de matériels solaires premium au Sénégal. Partenaire officiel Felicity Solar.', 'desq-energy'); ?>
                </p>

                <?php
                $socials = function_exists('desq_option') ? (desq_option('desq_social') ?: []) : [];
                $icons = [
                    'facebook'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>',
                    'instagram' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>',
                    'linkedin'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>',
                    'youtube'   => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="#fff"/></svg>',
                ];
                if ($socials) :
                ?>
                <div class="site-footer__social">
                    <?php foreach ($socials as $item) :
                        $network = $item['network'] ?? '';
                        $url     = $item['url'] ?? '';
                        if (! $url) continue;
                        $icon = $icons[$network] ?? '';
                    ?>
                        <a href="<?php echo esc_url($url); ?>"
                           class="site-footer__social-link"
                           target="_blank"
                           rel="noopener noreferrer"
                           aria-label="<?php echo esc_attr(ucfirst($network)); ?>">
                            <?php echo $icon; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Colonne 2 : Produits -->
            <div class="site-footer__col">
                <h3 class="site-footer__heading"><?php esc_html_e('Produits', 'desq-energy'); ?></h3>
                <ul class="site-footer__links">
                    <?php
                    $cats = [
                        'batteries'   => 'Batteries',
                        'onduleurs'   => 'Onduleurs',
                        'panneaux'    => 'Panneaux solaires',
                        'protection'  => 'Protection',
                        'accessoires' => 'Accessoires',
                    ];
                    foreach ($cats as $slug => $label) :
                    ?>
                        <li><a href="<?php echo esc_url(home_url('/categorie-produit/' . $slug . '/')); ?>"><?php echo esc_html($label); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Colonne 3 : Liens rapides -->
            <div class="site-footer__col">
                <h3 class="site-footer__heading"><?php esc_html_e('Navigation', 'desq-energy'); ?></h3>
                <ul class="site-footer__links">
                    <li><a href="<?php echo esc_url(home_url('/solution/')); ?>"><?php esc_html_e('Solutions', 'desq-energy'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/simulateur/')); ?>"><?php esc_html_e('Simulateur', 'desq-energy'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/devis/')); ?>"><?php esc_html_e('Demander un devis', 'desq-energy'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact', 'desq-energy'); ?></a></li>
                </ul>
            </div>

            <!-- Colonne 4 : Contact -->
            <div class="site-footer__col site-footer__col--contact">
                <h3 class="site-footer__heading"><?php esc_html_e('Contact', 'desq-energy'); ?></h3>
                <ul class="site-footer__contact-list">
                    <?php if ($phone = (function_exists('desq_option') ? desq_option('desq_phone') : '')) : ?>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.8 19.79 19.79 0 01.01 1.17 2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z"/></svg>
                            <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if ($email = (function_exists('desq_option') ? desq_option('desq_email') : '')) : ?>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if ($address = (function_exists('desq_option') ? desq_option('desq_address') : '')) : ?>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <address><?php echo nl2br(esc_html($address)); ?></address>
                        </li>
                    <?php endif; ?>
                    <?php if ($hours = (function_exists('desq_option') ? desq_option('desq_hours') : '')) : ?>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span><?php echo nl2br(esc_html($hours)); ?></span>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </div>

    <!-- Barre du bas -->
    <div class="site-footer__bottom">
        <div class="container site-footer__bottom-inner">
            <p class="site-footer__copy">
                &copy; <?php echo esc_html(date('Y')); ?>
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html(get_bloginfo('name')); ?></a>.
                <?php esc_html_e('Tous droits réservés.', 'desq-energy'); ?>
            </p>
            <nav class="site-footer__legal" aria-label="<?php esc_attr_e('Liens légaux', 'desq-energy'); ?>">
                <a href="<?php echo esc_url(home_url('/mentions-legales/')); ?>"><?php esc_html_e('Mentions légales', 'desq-energy'); ?></a>
                <a href="<?php echo esc_url(home_url('/confidentialite/')); ?>"><?php esc_html_e('Confidentialité', 'desq-energy'); ?></a>
            </nav>
        </div>
    </div>
</footer>

<?php
/* WhatsApp float — visible uniquement si le numéro est défini dans les options */
$wa = function_exists('desq_option') ? desq_option('desq_whatsapp') : '';
if ($wa) :
    $wa_clean  = preg_replace('/[^0-9]/', '', $wa);
    $wa_msg    = rawurlencode('Bonjour DESQ Energy, j\'aimerais obtenir un devis.');
    $wa_url    = 'https://wa.me/' . $wa_clean . '?text=' . $wa_msg;
?>
<a href="<?php echo esc_url($wa_url); ?>"
   class="whatsapp-float"
   target="_blank"
   rel="noopener noreferrer"
   aria-label="<?php esc_attr_e('Contacter sur WhatsApp', 'desq-energy'); ?>">
    <svg class="whatsapp-float__icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
    </svg>
    <span class="whatsapp-float__label"><?php esc_html_e('WhatsApp', 'desq-energy'); ?></span>
</a>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
