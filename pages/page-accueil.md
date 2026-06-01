# Page — Accueil (page-home.php)

> Template Name: Accueil Premium. Page d'entrée du site, doit convertir en 5 secondes.

---

## Objectif
Convaincre B2B et B2C en un coup d'œil : DESQ = solaire premium, fiable, local. Conduire vers le catalogue et le devis.

## Structure (sections dans l'ordre)

```
1. Header (sticky)
2. Hero
3. Trust bar (logos / chiffres clés)
4. Features (pourquoi nous)
5. Produits vedettes
6. Solutions par segment
7. Simulateur (teaser)
8. Stats animées
9. Témoignages
10. CTA final
11. Footer
```

---

## Section 1 — Hero

```
template-parts/sections/hero.php
```

### Contenu
- Badge : "Partenaire officiel Felicity Solar au Sénégal"
- H1 : `desq_hero_title` (ACF) — défaut : "Solutions Solaires Complètes pour l'Afrique de l'Ouest"
- Sous-titre : `desq_hero_subtitle` — défaut : "Batteries lithium, onduleurs hybrides et équipements solaires premium. Devis en 2h."
- 2 boutons : "Explorer le catalogue" (primary) + "Demander un devis" (outline)
- Visuel : image produit/installation ou illustration (à droite desktop, dessous mobile)

### Design
- Fond : dégradé léger orange→bleu très subtil (5% opacity) ou image avec overlay
- H1 avec dégradé de texte orange→bleu (`background-clip: text`)
- Animations : slideDown sur H1, slideUp sur sous-titre + boutons (stagger 0.1s)
- Hauteur : min 80vh desktop, auto mobile
- Mobile : texte centré, image dessous

### Code de référence
```php
<section class="hero">
  <div class="container hero__inner">
    <div class="hero__content">
      <span class="badge badge--primary">Partenaire officiel Felicity Solar</span>
      <h1 class="hero__title"><?php echo esc_html(desq_option('desq_hero_title') ?: 'Solutions Solaires Complètes'); ?></h1>
      <p class="hero__subtitle"><?php echo esc_html(desq_option('desq_hero_subtitle')); ?></p>
      <div class="hero__actions">
        <a href="<?php echo get_post_type_archive_link('desq_product'); ?>" class="btn btn--primary btn--lg">Explorer le catalogue</a>
        <a href="/devis" class="btn btn--outline btn--lg">Demander un devis</a>
      </div>
    </div>
    <div class="hero__visual">
      <!-- Image ou illustration -->
    </div>
  </div>
</section>
```

---

## Section 2 — Trust bar

Bande de réassurance juste sous le hero.
- 4 éléments : "Garantie 5 ans" · "Livraison Dakar" · "Support technique" · "Paiement flexible"
- Icônes SVG + label court
- Fond gris clair, séparateurs verticaux

---

## Section 3 — Features (Pourquoi nous)

```
template-parts/sections/features.php
```
- Section header : label "POURQUOI DESQ" + titre "Votre partenaire énergie solaire"
- Grille 3 colonnes (1 sur mobile) — 6 cartes :
  1. ⚡ Batteries Premium — "Lithium FLA dernière génération, garantie 5 ans"
  2. 🔄 Onduleurs Hybrides — "Convertisseurs haute efficacité 24/48V"
  3. 🌍 Partenaire Local — "Représentant officiel Felicity Solar Sénégal"
  4. 🛠️ Support Technique — "Installation et maintenance par experts"
  5. 📦 Livraison Rapide — "Dakar et régions, installation sur site"
  6. 💳 Paiement Flexible — "Solutions adaptées aux professionnels"
- Cartes : icône (cercle dégradé) + titre + description
- Hover : translateY(-8px) + shadow + bordure orange
- Scroll reveal (stagger)

---

## Section 4 — Produits vedettes

```
template-parts/sections/featured-products.php
```
- Section header : "NOS PRODUITS" + "Sélection premium Felicity Solar"
- WP_Query : `desq_product` où `product_featured = true`, limit 6
- Grille de product-card (composant réutilisable)
- Bouton "Voir tout le catalogue" en bas
- Si pas de featured : afficher les 6 plus récents

```php
$featured = new WP_Query([
    'post_type' => 'desq_product',
    'posts_per_page' => 6,
    'meta_query' => [['key' => 'product_featured', 'value' => '1']],
]);
```

---

## Section 5 — Solutions par segment

- Section header : "SOLUTIONS" + "Adaptées à vos besoins"
- 4 cartes : Résidentiel / Commercial / Industriel / Pompage
- Chaque carte : icône, titre, description courte, lien "En savoir plus"
- Issues du CPT desq_solution OU statiques si CPT vide

---

## Section 6 — Simulateur (teaser)

- Bloc CTA : "Quelle puissance pour votre projet ?"
- Mini-aperçu du simulateur ou juste bouton "Lancer le simulateur"
- Fond bleu, texte blanc, bouton orange

---

## Section 7 — Stats animées

```
template-parts/sections/stats.php
```
- Fond bleu profond (`--color-secondary`)
- 4 compteurs : 500+ Clients · 5 ans Garantie · 24/7 Support · 10+ Ans d'expérience
- Animation : compteur de 0 à la valeur au scroll (IntersectionObserver)

```js
// Dans main.js
function animateCounter(el, target, duration = 2000) {
  let start = 0;
  const step = target / (duration / 16);
  const timer = setInterval(() => {
    start += step;
    if (start >= target) { el.textContent = target; clearInterval(timer); }
    else el.textContent = Math.floor(start);
  }, 16);
}
```

---

## Section 8 — Témoignages

- Section header : "ILS NOUS FONT CONFIANCE"
- Slider/grille de 3 témoignages (CPT desq_testimonial)
- Chaque : note étoiles, citation, nom, fonction, localisation
- Mobile : 1 carte, swipe

---

## Section 9 — CTA final

```
template-parts/sections/cta.php
```
- Centré, fond dégradé léger
- H2 : "Besoin d'une solution sur mesure ?"
- Texte : "Contactez nos experts pour un dimensionnement gratuit"
- Bouton "Demander une consultation" (primary, lg)

---

## SEO
- Title : "DESQ Energy — Solutions Solaires Premium au Sénégal | Felicity Solar"
- Meta description : "Catalogue solaire premium à Dakar : batteries lithium, onduleurs hybrides, panneaux. Devis gratuit en 2h. Partenaire officiel Felicity Solar."
- H1 unique (hero)
- Schema.org : Organization + LocalBusiness

---

## Performance
- Hero image : WebP, preload, dimensions explicites
- Lazy-load toutes les images sous le fold
- Animations : `will-change` sur les éléments animés uniquement

---

## Checklist
- [ ] 9 sections codées et responsive
- [ ] Hero avec animations
- [ ] Produits vedettes via WP_Query
- [ ] Stats counter animé au scroll
- [ ] Témoignages depuis CPT
- [ ] Tous les CTA pointent vers /devis ou catalogue
- [ ] SEO + Schema configurés
- [ ] Test mobile 360px
