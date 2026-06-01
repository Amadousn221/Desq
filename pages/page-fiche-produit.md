# Page — Fiche Produit (single-desq_product.php)

> Page détaillée d'un produit. Doit donner toutes les infos techniques et pousser au devis.

---

## Objectif
Présenter le produit en détail (specs, photos, garantie) et convertir via "Ajouter au devis".

## Structure

```
1. Header
2. Breadcrumb
3. Layout produit : [Galerie] [Infos + actions]
4. Onglets : Description / Spécifications / Téléchargements
5. Produits similaires
6. CTA devis
7. Footer
```

---

## Section — Layout produit (2 colonnes)

### Colonne gauche — Galerie
- Image principale (grande)
- Miniatures sous l'image (galerie ACF `product_gallery`)
- Clic miniature → change l'image principale
- Lightbox au clic sur l'image principale (zoom)
- Si pas de galerie : featured image seule
- Badge catégorie en overlay

### Colonne droite — Infos & actions
```
- Badge catégorie
- H1 : Titre du produit
- Marque : "Felicity Solar"
- Prix : grand, orange (desq_get_price)
- Si prix promo : prix barré + prix promo
- Badge stock (En stock / Sur commande)
- Excerpt (résumé court)
- Sélecteur quantité (-, input, +)
- Bouton "Ajouter au devis" (primary, lg, block)
- Bouton "Demander conseil" (WhatsApp, outline)
- Bloc garantie : "✓ Garantie X ans constructeur"
- Bloc réassurance : livraison, support
```

### Code de référence
```php
<?php
$price = get_field('product_price');
$sale = get_field('product_sale_price');
$warranty = get_field('product_warranty');
$gallery = get_field('product_gallery');
$specs = get_field('product_specs');
$datasheet = get_field('product_datasheet');
$stock = desq_get_stock_status();
$cat = get_the_terms(get_the_ID(), 'product_category');
?>

<div class="product-single container">
  <div class="product-single__gallery">
    <?php if ($gallery): ?>
      <img src="<?php echo esc_url($gallery[0]['sizes']['large']); ?>" class="product-single__main-img" id="mainImg" alt="<?php the_title_attribute(); ?>">
      <div class="product-single__thumbs">
        <?php foreach ($gallery as $img): ?>
          <img src="<?php echo esc_url($img['sizes']['thumbnail']); ?>"
               data-large="<?php echo esc_url($img['sizes']['large']); ?>"
               class="product-single__thumb" alt="">
        <?php endforeach; ?>
      </div>
    <?php else: the_post_thumbnail('product-hero'); endif; ?>
  </div>

  <div class="product-single__info">
    <?php if ($cat): ?><span class="badge badge--primary"><?php echo esc_html($cat[0]->name); ?></span><?php endif; ?>
    <h1><?php the_title(); ?></h1>
    <p class="product-single__brand"><?php echo esc_html(get_field('product_brand') ?: 'Felicity Solar'); ?></p>

    <div class="product-single__price">
      <?php if ($sale): ?>
        <span class="product-single__price-old"><?php echo number_format($price,0,',',' '); ?> FCFA</span>
        <span class="product-single__price-now"><?php echo number_format($sale,0,',',' '); ?> FCFA</span>
      <?php else: ?>
        <span class="product-single__price-now"><?php echo number_format($price,0,',',' '); ?> FCFA</span>
      <?php endif; ?>
    </div>

    <span class="badge <?php echo $stock['class']; ?>"><?php echo $stock['label']; ?></span>

    <div class="product-single__excerpt"><?php the_excerpt(); ?></div>

    <div class="product-single__qty">
      <button class="qty-btn" data-action="minus">−</button>
      <input type="number" value="1" min="1" id="productQty">
      <button class="qty-btn" data-action="plus">+</button>
    </div>

    <button class="btn btn--primary btn--lg btn--block"
            data-add-to-quote
            data-id="<?php echo get_the_ID(); ?>"
            data-title="<?php the_title_attribute(); ?>"
            data-price="<?php echo esc_attr($sale ?: $price); ?>"
            data-category="<?php echo esc_attr($cat[0]->slug ?? ''); ?>">
      Ajouter au devis
    </button>

    <a href="https://wa.me/<?php echo desq_option('desq_whatsapp'); ?>?text=Bonjour, je souhaite des infos sur <?php the_title_attribute(); ?>"
       class="btn btn--outline btn--block" target="_blank">
      Demander conseil (WhatsApp)
    </a>

    <div class="product-single__warranty">
      ✓ Garantie <?php echo esc_html($warranty ?: 2); ?> ans constructeur
    </div>
  </div>
</div>
```

---

## Section — Onglets

3 onglets : Description / Spécifications / Téléchargements

### Description
- `the_content()` — description riche

### Spécifications
- Tableau depuis le repeater `product_specs`
```php
<table class="specs-table">
  <?php foreach ($specs as $spec): ?>
    <tr>
      <td class="specs-table__name"><?php echo esc_html($spec['spec_name']); ?></td>
      <td class="specs-table__value"><?php echo esc_html($spec['spec_value']); ?></td>
    </tr>
  <?php endforeach; ?>
</table>
```

### Téléchargements
- Lien PDF fiche technique (`product_datasheet`)
- Icône + nom + taille fichier

---

## Section — Produits similaires
- 3-4 produits de la même catégorie (WP_Query, exclure le produit actuel)
- Composant product-card

```php
$similar = new WP_Query([
  'post_type' => 'desq_product',
  'posts_per_page' => 4,
  'post__not_in' => [get_the_ID()],
  'tax_query' => [[
    'taxonomy' => 'product_category',
    'terms' => wp_get_post_terms(get_the_ID(), 'product_category', ['fields' => 'ids']),
  ]],
]);
```

---

## JS — Galerie + quantité (dans main.js)
```js
// Galerie : clic miniature
document.querySelectorAll('.product-single__thumb').forEach(thumb => {
  thumb.addEventListener('click', () => {
    document.querySelector('#mainImg').src = thumb.dataset.large;
  });
});

// Quantité
document.querySelectorAll('.qty-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const input = document.querySelector('#productQty');
    let val = parseInt(input.value);
    input.value = btn.dataset.action === 'plus' ? val + 1 : Math.max(1, val - 1);
  });
});
```

---

## SEO + Schema
- Title : "{Titre produit} — {Catégorie} | DESQ Energy"
- Schema.org Product : name, image, description, brand, offers (price, currency XOF, availability)
```php
// Schema JSON-LD dans le footer de la page
```

---

## Checklist
- [ ] Layout 2 colonnes galerie + infos
- [ ] Galerie avec miniatures cliquables + lightbox
- [ ] Prix + prix promo si applicable
- [ ] Badge stock dynamique
- [ ] Sélecteur quantité
- [ ] Bouton "Ajouter au devis" avec data-attributes
- [ ] Bouton WhatsApp pré-rempli
- [ ] Onglets Description/Specs/Téléchargements
- [ ] Tableau specs depuis repeater ACF
- [ ] Produits similaires même catégorie
- [ ] Schema.org Product
- [ ] Test mobile
