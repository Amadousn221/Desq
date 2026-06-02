<?php
$solutions_query = new WP_Query([
    'post_type'      => 'desq_solution',
    'posts_per_page' => 4,
    'post_status'    => 'publish',
]);
$use_static = !$solutions_query->have_posts();

$static_solutions = [
    [
        'icon'  => '<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 22V12h6v10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
        'title' => 'Résidentiel',
        'desc'  => 'Autonomie totale pour votre domicile. Kits complets batteries + panneau + onduleur dimensionnés pour votre consommation.',
        'link'  => home_url('/solutions/residentiel/'),
    ],
    [
        'icon'  => '<rect x="2" y="7" width="20" height="14" rx="2" stroke="currentColor" stroke-width="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="12" x2="12" y2="16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="10" y1="14" x2="14" y2="14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>',
        'title' => 'Commercial',
        'desc'  => 'Continuité d\'activité pour boutiques, bureaux et hôtels. Systèmes hybrides avec bascule automatique sur réseau.',
        'link'  => home_url('/solutions/commercial/'),
    ],
    [
        'icon'  => '<path d="M2 20h20M4 20V10l8-6 8 6v10M10 20v-6h4v6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
        'title' => 'Industriel',
        'desc'  => 'Installations haute puissance pour usines, entrepôts et sites industriels. Onduleurs triphasés jusqu\'à 50kW.',
        'link'  => home_url('/solutions/industriel/'),
    ],
    [
        'icon'  => '<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>',
        'title' => 'Pompage solaire',
        'desc'  => 'Irrigation et distribution d\'eau en zones rurales. Pompes solaires submersibles sans batterie ou avec stockage.',
        'link'  => home_url('/solutions/pompage/'),
    ],
];
?>
<section class="solutions section-pad" aria-labelledby="solutions-title">
  <div class="container">

    <div class="section-header section-header--light reveal">
      <span class="section-label section-label--light">Solutions</span>
      <h2 class="section-title section-title--light" id="solutions-title">Adaptées à vos besoins</h2>
      <p class="section-desc section-desc--light">Du particulier à l'industriel, nous dimensionnons votre installation solaire selon votre consommation réelle.</p>
    </div>

    <div class="solutions__grid" data-stagger="0.08">
      <?php if ($use_static): ?>
        <?php foreach ($static_solutions as $sol): ?>
          <div class="solution-card reveal">
            <div class="solution-card__icon" aria-hidden="true">
              <svg width="26" height="26" viewBox="0 0 24 24" fill="none"><?php echo $sol['icon']; ?></svg>
            </div>
            <h3 class="solution-card__title"><?php echo esc_html($sol['title']); ?></h3>
            <p class="solution-card__desc"><?php echo esc_html($sol['desc']); ?></p>
            <a href="<?php echo esc_url($sol['link']); ?>" class="solution-card__link">
              En savoir plus
              <svg width="14" height="14" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                <path d="M7 10h6M10 7l3 3-3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <?php while ($solutions_query->have_posts()): $solutions_query->the_post(); ?>
          <div class="solution-card reveal">
            <h3 class="solution-card__title"><?php the_title(); ?></h3>
            <p class="solution-card__desc"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
            <a href="<?php the_permalink(); ?>" class="solution-card__link">
              En savoir plus
              <svg width="14" height="14" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                <path d="M7 10h6M10 7l3 3-3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
          </div>
        <?php endwhile; wp_reset_postdata(); ?>
      <?php endif; ?>
    </div>

  </div>
</section>
