<?php
$q = new WP_Query([
    'post_type'      => 'desq_testimonial',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'orderby'        => 'rand',
]);

$static = [
    ['note' => 5, 'texte' => 'Équipement de qualité exceptionnelle. L\'onduleur Felicity tient parfaitement la charge pendant les coupures, et l\'équipe DESQ a assuré une installation propre.', 'nom' => 'Moussa Diallo', 'role' => 'Directeur, Hôtel Téranga', 'ville' => 'Dakar'],
    ['note' => 5, 'texte' => 'Enfin une entreprise qui comprend nos contraintes locales. Le système de pompage solaire a changé la donne pour nos cultures. ROI en moins d\'un an.', 'nom' => 'Fatou Ndiaye', 'role' => 'Agricultrice', 'ville' => 'Thiès'],
    ['note' => 5, 'texte' => 'Service réactif, matériel livré en 48h et techniciens compétents. La garantie 5 ans nous a convaincus. Nos trois succursales sont maintenant autonomes.', 'nom' => 'Ibrahima Sarr', 'role' => 'Gérant, Pharmacie Centrale', 'ville' => 'Saint-Louis'],
];
$use_static = !$q->have_posts();
?>
<section class="testimonials section-pad section-pad--alt" aria-labelledby="testimonials-title">
  <div class="container">

    <div class="section-header reveal">
      <span class="section-label">Témoignages</span>
      <h2 class="section-title" id="testimonials-title">Ils nous font confiance</h2>
    </div>

    <div class="testimonials__grid" data-stagger="0.1">
      <?php if ($use_static): ?>
        <?php foreach ($static as $t): ?>
          <article class="testimonial-card reveal">
            <div class="testimonial-card__stars" aria-label="Note <?php echo intval($t['note']); ?>/5">
              <?php for ($i = 0; $i < $t['note']; $i++): ?>
                <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path d="M10 2l2 5.5h5.5l-4.5 3.3 1.7 5.5L10 13.3l-4.7 2.9 1.7-5.5L2.5 7.5H8L10 2z"/>
                </svg>
              <?php endfor; ?>
            </div>
            <blockquote class="testimonial-card__quote">
              <p><?php echo esc_html($t['texte']); ?></p>
            </blockquote>
            <footer class="testimonial-card__author">
              <div class="testimonial-card__avatar" aria-hidden="true">
                <?php echo esc_html(mb_substr($t['nom'], 0, 1)); ?>
              </div>
              <div class="testimonial-card__meta">
                <span class="testimonial-card__name"><?php echo esc_html($t['nom']); ?></span>
                <span class="testimonial-card__role"><?php echo esc_html($t['role']); ?> · <?php echo esc_html($t['ville']); ?></span>
              </div>
            </footer>
          </article>
        <?php endforeach; ?>
      <?php else: ?>
        <?php while ($q->have_posts()): $q->the_post(); ?>
          <?php
          $note  = (int) get_field('testimonial_note')  ?: 5;
          $nom   = get_field('testimonial_name')  ?: get_the_title();
          $role  = get_field('testimonial_role')  ?: '';
          $ville = get_field('testimonial_city')  ?: '';
          ?>
          <article class="testimonial-card reveal">
            <div class="testimonial-card__stars" aria-label="Note <?php echo $note; ?>/5">
              <?php for ($i = 0; $i < $note; $i++): ?>
                <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path d="M10 2l2 5.5h5.5l-4.5 3.3 1.7 5.5L10 13.3l-4.7 2.9 1.7-5.5L2.5 7.5H8L10 2z"/>
                </svg>
              <?php endfor; ?>
            </div>
            <blockquote class="testimonial-card__quote">
              <p><?php echo esc_html(get_the_content()); ?></p>
            </blockquote>
            <footer class="testimonial-card__author">
              <div class="testimonial-card__avatar" aria-hidden="true">
                <?php echo esc_html(mb_substr($nom, 0, 1)); ?>
              </div>
              <div class="testimonial-card__meta">
                <span class="testimonial-card__name"><?php echo esc_html($nom); ?></span>
                <span class="testimonial-card__role"><?php echo esc_html("{$role} · {$ville}"); ?></span>
              </div>
            </footer>
          </article>
        <?php endwhile; wp_reset_postdata(); ?>
      <?php endif; ?>
    </div>

  </div>
</section>
