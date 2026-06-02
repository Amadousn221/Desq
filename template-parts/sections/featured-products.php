<?php
// Produits featured d'abord, sinon les plus récents avec image
$q = new WP_Query([
    'post_type'      => 'desq_product',
    'posts_per_page' => 6,
    'post_status'    => 'publish',
    'meta_query'     => [
        'relation' => 'AND',
        ['key' => 'product_featured', 'value' => '1'],
        ['key' => '_thumbnail_id',    'compare' => 'EXISTS'],
    ],
]);

if (!$q->have_posts()) {
    $q = new WP_Query([
        'post_type'      => 'desq_product',
        'posts_per_page' => 6,
        'post_status'    => 'publish',
        'orderby'        => 'rand',
        'meta_query'     => [['key' => '_thumbnail_id', 'compare' => 'EXISTS']],
    ]);
}
?>
<section class="featured-products section-pad section-pad--alt" aria-labelledby="featured-title">
  <div class="container">

    <div class="section-header reveal">
      <span class="section-label">Nos produits</span>
      <h2 class="section-title" id="featured-title">Sélection premium Felicity Solar</h2>
      <p class="section-desc">Des équipements testés et certifiés pour les conditions d'usage en Afrique de l'Ouest.</p>
    </div>

    <?php if ($q->have_posts()): ?>
      <div class="products-grid" data-stagger="0.07">
        <?php while ($q->have_posts()): $q->the_post(); ?>
          <?php get_template_part('template-parts/components/product-card'); ?>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>

      <div class="featured-products__footer reveal">
        <a href="<?php echo esc_url(get_post_type_archive_link('desq_product') ?: home_url('/catalogue/')); ?>"
           class="btn btn--outline btn--lg">
          Voir tout le catalogue
          <svg width="16" height="16" viewBox="0 0 20 20" fill="none" aria-hidden="true">
            <path d="M7 10h6M10 7l3 3-3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
      </div>
    <?php endif; ?>

  </div>
</section>
