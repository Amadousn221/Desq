<section class="cta-final reveal" aria-label="Appel à l'action">
  <div class="cta-final__bg" aria-hidden="true"></div>
  <div class="container cta-final__inner">
    <div class="cta-final__content">
      <span class="cta-final__tag">Démarrez votre projet</span>
      <h2 class="cta-final__title">Besoin d'une solution<br>sur mesure ?</h2>
      <p class="cta-final__text">Nos experts dimensionnent votre installation solaire et vous remettent un devis détaillé sous 2h, sans engagement.</p>
      <div class="cta-final__actions">
        <a href="<?php echo esc_url(home_url('/devis/')); ?>" class="btn btn--primary btn--lg">
          Demander une consultation
        </a>
        <a href="<?php echo esc_url(get_post_type_archive_link('desq_product') ?: home_url('/catalogue/')); ?>"
           class="btn btn--outline btn--lg cta-final__btn-secondary">
          Explorer le catalogue
        </a>
      </div>
    </div>
    <div class="cta-final__deco" aria-hidden="true">
      <svg viewBox="0 0 320 280" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="160" cy="140" r="120" stroke="rgba(232,114,42,.12)" stroke-width="40"/>
        <circle cx="160" cy="140" r="75" stroke="rgba(232,114,42,.15)" stroke-width="2"/>
        <circle cx="160" cy="140" r="35" fill="rgba(232,114,42,.18)"/>
        <path d="M160 90 L170 115 L198 115 L175 130 L183 157 L160 142 L137 157 L145 130 L122 115 L150 115 Z" fill="rgba(232,114,42,.7)"/>
      </svg>
    </div>
  </div>
</section>
