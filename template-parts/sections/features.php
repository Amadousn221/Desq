<section class="features section-pad" aria-labelledby="features-title">
  <div class="container">

    <div class="section-header reveal">
      <span class="section-label">Pourquoi DESQ</span>
      <h2 class="section-title" id="features-title">Votre partenaire énergie solaire de confiance</h2>
      <p class="section-desc">Représentant officiel Felicity Solar au Sénégal, nous combinons des équipements de niveau industriel avec un service local ancré dans vos réalités terrain.</p>
    </div>

    <div class="features__layout">

      <div class="features__main reveal reveal--from-left">
        <div class="features__main-inner">
          <span class="features__main-label">Ce qui nous distingue</span>
          <h3 class="features__main-title">Équipements certifiés.<br>Installation maîtrisée.<br>Suivi garanti.</h3>
          <p class="features__main-text">
            Chaque produit Felicity Solar est sélectionné pour les conditions climatiques et les contraintes réseau de l'Afrique de l'Ouest. Nos techniciens certifiés assurent l'installation et le SAV.
          </p>
          <a href="<?php echo esc_url(home_url('/devis/')); ?>" class="btn btn--primary">
            Obtenir un devis
            <svg width="16" height="16" viewBox="0 0 20 20" fill="none" aria-hidden="true">
              <path d="M7 10h6M10 7l3 3-3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
        </div>
      </div>

      <div class="features__grid" data-stagger="0.08">

        <?php
        $items = [
            [
                'icon'  => '<path d="M13 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9l-7-7zm0 0v7h7M9 15h6M9 11h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
                'title' => 'Batteries Premium',
                'desc'  => 'Lithium LiFePO4 et gel dernière génération, garantie 5 ans, conçues pour les cycles de charge en zone tropicale.',
            ],
            [
                'icon'  => '<path d="M13 10V3L4 14h7v7l9-11h-7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
                'title' => 'Onduleurs Hybrides',
                'desc'  => 'Convertisseurs haute efficacité 24/48V avec MPPT intégré, compatibles réseau et générateur.',
            ],
            [
                'icon'  => '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
                'title' => 'Partenaire Local',
                'desc'  => 'Représentant officiel Felicity Solar Sénégal. Stock disponible à Dakar, pas de délais d\'importation.',
            ],
            [
                'icon'  => '<path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
                'title' => 'Support Technique',
                'desc'  => 'Dimensionnement sur mesure, installation par techniciens certifiés, maintenance préventive.',
            ],
            [
                'icon'  => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2"/>',
                'title' => 'Livraison Rapide',
                'desc'  => 'Dakar et toutes les régions. Logistique maîtrisée de A à Z, suivi en temps réel.',
            ],
            [
                'icon'  => '<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>',
                'title' => 'Paiement Flexible',
                'desc'  => 'Conditions adaptées aux professionnels, PME et collectivités. Devis personnalisé sans engagement.',
            ],
        ];
        foreach ($items as $item): ?>
          <div class="feature-item reveal">
            <div class="feature-item__icon" aria-hidden="true">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><?php echo $item['icon']; ?></svg>
            </div>
            <div class="feature-item__body">
              <h3 class="feature-item__title"><?php echo esc_html($item['title']); ?></h3>
              <p class="feature-item__desc"><?php echo esc_html($item['desc']); ?></p>
            </div>
          </div>
        <?php endforeach; ?>

      </div>
    </div>

  </div>
</section>
