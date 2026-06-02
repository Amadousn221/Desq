<?php
$title    = desq_option('desq_hero_title')    ?: 'Solutions Solaires Complètes pour l\'Afrique de l\'Ouest';
$subtitle = desq_option('desq_hero_subtitle') ?: 'Batteries lithium, onduleurs hybrides et panneaux premium. Devis gratuit en 2h, livraison sur Dakar.';
$hero_img = desq_option('desq_hero_image');

if (!$hero_img) {
    $q = new WP_Query([
        'post_type'      => 'desq_product',
        'posts_per_page' => 1,
        'meta_key'       => '_thumbnail_id',
        'tax_query'      => [['taxonomy' => 'product_category', 'field' => 'slug', 'terms' => 'onduleurs-hors-reseau']],
    ]);
    if ($q->have_posts()) {
        $q->the_post();
        $hero_img = get_the_post_thumbnail_url(null, 'product-hero');
        wp_reset_postdata();
    }
}
?>
<section class="hero" aria-label="Présentation DESQ Energy">
  <div class="hero__glow" aria-hidden="true"></div>
  <div class="hero__dots" aria-hidden="true"></div>

  <div class="container hero__inner">

    <div class="hero__content">
      <span class="badge badge--glow animate-fade-in">
        <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path d="M10 2l2.4 5.6 5.6.8-4.2 4.4 1.2 6-5.0-2.8-5.0 2.8 1.2-6L2 8.4l5.6-.8L10 2z"/>
        </svg>
        Partenaire officiel Felicity Solar au Sénégal
      </span>

      <h1 class="hero__title animate-slide-up animate--delay-200">
        <?php echo esc_html($title); ?>
      </h1>

      <p class="hero__subtitle animate-slide-up animate--delay-300">
        <?php echo esc_html($subtitle); ?>
      </p>

      <div class="hero__actions animate-slide-up animate--delay-400">
        <a href="<?php echo esc_url(get_post_type_archive_link('desq_product') ?: home_url('/catalogue/')); ?>"
           class="btn btn--primary btn--lg">
          Explorer le catalogue
          <svg width="18" height="18" viewBox="0 0 20 20" fill="none" aria-hidden="true">
            <path d="M7 10h6M10 7l3 3-3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
        <a href="<?php echo esc_url(home_url('/devis/')); ?>" class="btn btn--hero-outline btn--lg">
          Demander un devis
        </a>
      </div>

      <div class="hero__proof animate-fade-in animate--delay-600">
        <div class="hero__proof-item">
          <svg width="15" height="15" viewBox="0 0 20 20" fill="none" aria-hidden="true">
            <path d="M10 2L12 7.5H18L13.5 11L15.5 17L10 13.5L4.5 17L6.5 11L2 7.5H8L10 2Z" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linejoin="round"/>
          </svg>
          Garantie 5 ans
        </div>
        <span class="hero__proof-dot" aria-hidden="true"></span>
        <div class="hero__proof-item">
          <svg width="15" height="15" viewBox="0 0 20 20" fill="none" aria-hidden="true">
            <path d="M3 10h14M5 6l-2 4 2 4M3 14h14l1-4-1-4H3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Livraison Dakar & régions
        </div>
        <span class="hero__proof-dot" aria-hidden="true"></span>
        <div class="hero__proof-item">
          <svg width="15" height="15" viewBox="0 0 20 20" fill="none" aria-hidden="true">
            <path d="M10 2L4 5v5c0 4 6 8 6 8s6-4 6-8V5L10 2Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
          </svg>
          Installation certifiée
        </div>
      </div>
    </div>

    <div class="hero__visual animate-scale-in animate--delay-300" aria-hidden="true">
      <div class="hero__visual-ring hero__visual-ring--1"></div>
      <div class="hero__visual-ring hero__visual-ring--2"></div>
      <?php if ($hero_img): ?>
        <div class="hero__visual-frame">
          <img src="<?php echo esc_url($hero_img); ?>"
               alt=""
               class="hero__visual-img"
               width="560" height="440"
               loading="eager" decoding="async">
        </div>
      <?php else: ?>
        <div class="hero__visual-frame hero__visual-frame--svg">
          <svg viewBox="0 0 480 380" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Installation solaire">
            <rect x="30" y="140" width="130" height="90" rx="5" fill="rgba(232,114,42,.18)" stroke="rgba(232,114,42,.55)" stroke-width="2"/>
            <line x1="30" y1="170" x2="160" y2="170" stroke="rgba(232,114,42,.3)" stroke-width="1"/>
            <line x1="30" y1="200" x2="160" y2="200" stroke="rgba(232,114,42,.3)" stroke-width="1"/>
            <line x1="60" y1="140" x2="60" y2="230" stroke="rgba(232,114,42,.3)" stroke-width="1"/>
            <line x1="95" y1="140" x2="95" y2="230" stroke="rgba(232,114,42,.3)" stroke-width="1"/>
            <line x1="130" y1="140" x2="130" y2="230" stroke="rgba(232,114,42,.3)" stroke-width="1"/>
            <rect x="175" y="115" width="130" height="90" rx="5" fill="rgba(232,114,42,.26)" stroke="rgba(232,114,42,.7)" stroke-width="2.5"/>
            <line x1="175" y1="145" x2="305" y2="145" stroke="rgba(232,114,42,.35)" stroke-width="1"/>
            <line x1="175" y1="175" x2="305" y2="175" stroke="rgba(232,114,42,.35)" stroke-width="1"/>
            <line x1="205" y1="115" x2="205" y2="205" stroke="rgba(232,114,42,.35)" stroke-width="1"/>
            <line x1="240" y1="115" x2="240" y2="205" stroke="rgba(232,114,42,.35)" stroke-width="1"/>
            <line x1="275" y1="115" x2="275" y2="205" stroke="rgba(232,114,42,.35)" stroke-width="1"/>
            <rect x="320" y="155" width="130" height="90" rx="5" fill="rgba(232,114,42,.14)" stroke="rgba(232,114,42,.45)" stroke-width="2"/>
            <line x1="320" y1="185" x2="450" y2="185" stroke="rgba(232,114,42,.25)" stroke-width="1"/>
            <line x1="320" y1="215" x2="450" y2="215" stroke="rgba(232,114,42,.25)" stroke-width="1"/>
            <line x1="350" y1="155" x2="350" y2="245" stroke="rgba(232,114,42,.25)" stroke-width="1"/>
            <line x1="385" y1="155" x2="385" y2="245" stroke="rgba(232,114,42,.25)" stroke-width="1"/>
            <line x1="420" y1="155" x2="420" y2="245" stroke="rgba(232,114,42,.25)" stroke-width="1"/>
            <rect x="150" y="265" width="90" height="65" rx="8" fill="rgba(15,52,96,.9)" stroke="rgba(232,114,42,.8)" stroke-width="2"/>
            <rect x="175" y="258" width="40" height="8" rx="3" fill="rgba(232,114,42,.7)"/>
            <line x1="170" y1="282" x2="170" y2="310" stroke="rgba(232,114,42,.45)" stroke-width="1.5"/>
            <line x1="185" y1="282" x2="185" y2="310" stroke="rgba(232,114,42,.45)" stroke-width="1.5"/>
            <line x1="200" y1="282" x2="200" y2="310" stroke="rgba(232,114,42,.45)" stroke-width="1.5"/>
            <line x1="215" y1="282" x2="215" y2="310" stroke="rgba(232,114,42,.45)" stroke-width="1.5"/>
            <rect x="260" y="258" width="80" height="68" rx="8" fill="rgba(15,52,96,.9)" stroke="rgba(26,87,153,.7)" stroke-width="2"/>
            <circle cx="300" cy="290" r="18" fill="none" stroke="rgba(232,114,42,.6)" stroke-width="2.5"/>
            <path d="M292 290 L300 282 L308 290 L300 298 Z" fill="rgba(232,114,42,.6)"/>
            <circle cx="410" cy="65" r="36" fill="rgba(232,114,42,.12)"/>
            <circle cx="410" cy="65" r="23" fill="rgba(232,114,42,.28)"/>
            <circle cx="410" cy="65" r="13" fill="rgba(232,114,42,.85)"/>
            <line x1="410" y1="18" x2="410" y2="10" stroke="rgba(232,114,42,.55)" stroke-width="2.5" stroke-linecap="round"/>
            <line x1="440" y1="35" x2="447" y2="28" stroke="rgba(232,114,42,.55)" stroke-width="2.5" stroke-linecap="round"/>
            <line x1="457" y1="65" x2="465" y2="65" stroke="rgba(232,114,42,.55)" stroke-width="2.5" stroke-linecap="round"/>
            <line x1="440" y1="95" x2="447" y2="102" stroke="rgba(232,114,42,.55)" stroke-width="2.5" stroke-linecap="round"/>
            <line x1="380" y1="35" x2="373" y2="28" stroke="rgba(232,114,42,.55)" stroke-width="2.5" stroke-linecap="round"/>
            <line x1="363" y1="65" x2="355" y2="65" stroke="rgba(232,114,42,.55)" stroke-width="2.5" stroke-linecap="round"/>
            <path d="M95 230 L95 252 L150 252 L150 295" stroke="rgba(232,114,42,.4)" stroke-width="2" stroke-dasharray="5 3" stroke-linecap="round"/>
            <path d="M240 205 L240 265" stroke="rgba(232,114,42,.4)" stroke-width="2" stroke-dasharray="5 3" stroke-linecap="round"/>
            <path d="M385 245 L385 260 L340 260 L340 288" stroke="rgba(26,87,153,.45)" stroke-width="2" stroke-dasharray="5 3" stroke-linecap="round"/>
          </svg>
        </div>
      <?php endif; ?>
    </div>

  </div>
</section>
