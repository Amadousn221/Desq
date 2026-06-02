<?php
$stats = [
    ['value' => 500,  'suffix' => '+', 'label' => 'Clients équipés',       'sub' => 'particuliers & entreprises'],
    ['value' => 5,    'suffix' => '',  'label' => 'Ans de garantie',       'sub' => 'sur tous les équipements'],
    ['value' => 74,   'suffix' => '+', 'label' => 'Références en stock',   'sub' => 'disponibles à Dakar'],
    ['value' => 10,   'suffix' => '+', 'label' => 'Ans d\'expertise',      'sub' => 'en énergie solaire'],
];
?>
<section class="stats" aria-label="Chiffres clés DESQ Energy">
  <div class="container stats__inner" data-stagger="0.12">
    <?php foreach ($stats as $s): ?>
      <div class="stat-item reveal">
        <div class="stat-item__number">
          <span class="stat-item__count" data-target="<?php echo intval($s['value']); ?>"><?php echo intval($s['value']); ?></span><?php echo esc_html($s['suffix']); ?>
        </div>
        <div class="stat-item__label"><?php echo esc_html($s['label']); ?></div>
        <div class="stat-item__sub"><?php echo esc_html($s['sub']); ?></div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
