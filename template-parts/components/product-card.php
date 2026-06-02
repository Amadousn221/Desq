<?php
/**
 * Product card component — desq_product
 * Expects: WP loop context (have_posts / the_post)
 */
$terms    = get_the_terms(get_the_ID(), 'product_category');
$cat_name = '';
if ($terms && !is_wp_error($terms)) {
    $leaf = array_filter($terms, fn($t) => !in_array($t->slug, ['batteries', 'onduleurs', 'panneaux', 'protection', 'accessoires']));
    $term = $leaf ? reset($leaf) : reset($terms);
    $cat_name = $term->name;
}
$brand = get_post_meta(get_the_ID(), 'product_brand', true);
?>
<article class="product-card">
  <a href="<?php the_permalink(); ?>" class="product-card__link" aria-label="<?php echo esc_attr(get_the_title()); ?>">

    <div class="product-card__thumb">
      <?php if (has_post_thumbnail()): ?>
        <?php the_post_thumbnail('product-card', ['loading' => 'lazy', 'decoding' => 'async', 'class' => 'product-card__img']); ?>
      <?php else: ?>
        <div class="product-card__no-img" aria-hidden="true">
          <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
            <rect width="48" height="48" rx="8" fill="rgba(232,114,42,.08)"/>
            <path d="M14 34l8-10 6 7 4-5 6 8H14z" fill="rgba(232,114,42,.3)"/>
            <circle cx="18" cy="20" r="4" fill="rgba(232,114,42,.25)"/>
          </svg>
        </div>
      <?php endif; ?>
      <?php if ($cat_name): ?>
        <span class="product-card__badge"><?php echo esc_html($cat_name); ?></span>
      <?php endif; ?>
    </div>

    <div class="product-card__body">
      <?php if ($brand): ?>
        <span class="product-card__brand"><?php echo esc_html($brand); ?></span>
      <?php endif; ?>
      <h3 class="product-card__title"><?php the_title(); ?></h3>
      <?php
      $excerpt = get_the_excerpt();
      if ($excerpt):
      ?>
        <p class="product-card__excerpt"><?php echo esc_html(wp_trim_words($excerpt, 14)); ?></p>
      <?php endif; ?>
    </div>

    <div class="product-card__footer">
      <span class="product-card__cta">Voir le produit</span>
      <svg class="product-card__arrow" width="16" height="16" viewBox="0 0 20 20" fill="none" aria-hidden="true">
        <path d="M7 10h6M10 7l3 3-3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>

  </a>
</article>
