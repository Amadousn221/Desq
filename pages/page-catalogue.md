# Page — Catalogue (archive-desq_product.php)

> Page de listing des produits avec filtres live. Cœur de la navigation produit.

---

## Objectif
Permettre de trouver rapidement un produit par catégorie, prix, disponibilité. Filtrage instantané sans rechargement.

## Structure

```
1. Header
2. Page header (titre + breadcrumb)
3. Barre de filtres (sticky sous header)
4. Layout : [Sidebar filtres] [Grille produits]
5. Pagination / Load more
6. Footer
```

---

## Section — Page header
- Breadcrumb : Accueil / Catalogue
- H1 : "Catalogue Produits Solaires"
- Sous-titre : nombre de produits + court texte
- Fond léger

---

## Section — Filtres

### Filtres disponibles
1. **Catégorie** (boutons/pills ou checkboxes)
   - Tous · Batteries · Onduleurs · Panneaux · Protection · Accessoires · Pompes
2. **Fourchette de prix** (double slider ou inputs min/max)
3. **Disponibilité** (toggle : En stock uniquement)
4. **Tri** (select : Pertinence / Prix croissant / Prix décroissant / Nouveautés)
5. **Recherche** (input texte, filtre sur titre)

### Comportement
- Filtrage **live en JavaScript** côté client (les produits sont déjà chargés) OU **AJAX** si beaucoup de produits (>50)
- Pour MVP : charger tous les produits, filtrer en JS (plus rapide, pas d'appel serveur)
- URL params synchronisés : `?cat=batteries&prix_max=500000&tri=prix_asc`
- Compteur de résultats live : "12 produits"
- Bouton "Réinitialiser les filtres"

### Layout responsive
- Desktop : sidebar filtres à gauche (260px) + grille à droite
- Mobile : bouton "Filtres" → ouvre un panneau/drawer + grille pleine largeur

---

## Section — Grille produits

- Utilise le composant `product-card` (voir 01-design-system)
- Grille responsive : 3 colonnes desktop, 2 tablette, 1-2 mobile
- Chaque carte : image, catégorie, titre, prix, badge stock, bouton "+ Devis" et lien "Voir"
- Animation : fade-in au filtrage

### Données par carte
```php
$category = get_the_terms(get_the_ID(), 'product_category');
$price = desq_get_price();
$stock = desq_get_stock_status();
```

---

## JavaScript — catalog-filter.js

```js
const CatalogFilter = {
  products: [], // NodeList des cartes
  state: { category: 'all', priceMin: 0, priceMax: Infinity, inStock: false, sort: 'relevance', search: '' },

  init() {
    this.products = [...document.querySelectorAll('.product-card')];
    this.bindEvents();
    this.readURLParams();
    this.apply();
  },

  bindEvents() {
    // Catégories
    document.querySelectorAll('[data-filter-cat]').forEach(btn =>
      btn.addEventListener('click', () => { this.state.category = btn.dataset.filterCat; this.apply(); }));
    // Prix
    document.querySelector('#price-min')?.addEventListener('input', e => { this.state.priceMin = +e.target.value || 0; this.apply(); });
    document.querySelector('#price-max')?.addEventListener('input', e => { this.state.priceMax = +e.target.value || Infinity; this.apply(); });
    // Stock
    document.querySelector('#in-stock')?.addEventListener('change', e => { this.state.inStock = e.target.checked; this.apply(); });
    // Tri
    document.querySelector('#sort')?.addEventListener('change', e => { this.state.sort = e.target.value; this.apply(); });
    // Recherche
    document.querySelector('#catalog-search')?.addEventListener('input', e => { this.state.search = e.target.value.toLowerCase(); this.apply(); });
  },

  apply() {
    let visible = this.products.filter(card => {
      const cat = card.dataset.category;
      const price = +card.dataset.price;
      const stock = +card.dataset.stock;
      const title = card.dataset.title.toLowerCase();

      if (this.state.category !== 'all' && cat !== this.state.category) return false;
      if (price < this.state.priceMin || price > this.state.priceMax) return false;
      if (this.state.inStock && stock <= 0) return false;
      if (this.state.search && !title.includes(this.state.search)) return false;
      return true;
    });

    // Tri
    if (this.state.sort === 'prix_asc') visible.sort((a,b) => a.dataset.price - b.dataset.price);
    if (this.state.sort === 'prix_desc') visible.sort((a,b) => b.dataset.price - a.dataset.price);

    // Affichage
    this.products.forEach(c => c.style.display = 'none');
    const grid = document.querySelector('.catalog__grid');
    visible.forEach(c => { c.style.display = ''; grid.appendChild(c); });

    // Compteur
    document.querySelector('.catalog__count').textContent = `${visible.length} produit${visible.length > 1 ? 's' : ''}`;
    // Empty state
    document.querySelector('.catalog__empty').style.display = visible.length ? 'none' : 'block';

    this.updateURL();
  },

  updateURL() {
    const params = new URLSearchParams();
    if (this.state.category !== 'all') params.set('cat', this.state.category);
    if (this.state.sort !== 'relevance') params.set('tri', this.state.sort);
    history.replaceState(null, '', params.toString() ? `?${params}` : location.pathname);
  },

  readURLParams() {
    const params = new URLSearchParams(location.search);
    if (params.get('cat')) this.state.category = params.get('cat');
    if (params.get('tri')) this.state.sort = params.get('tri');
  },

  reset() {
    this.state = { category: 'all', priceMin: 0, priceMax: Infinity, inStock: false, sort: 'relevance', search: '' };
    document.querySelectorAll('input, select').forEach(el => { if(el.type==='checkbox') el.checked=false; else el.value=''; });
    this.apply();
  }
};

document.addEventListener('DOMContentLoaded', () => {
  if (document.querySelector('.catalog')) CatalogFilter.init();
});
```

### Data attributes requis sur chaque card
```html
<article class="product-card"
         data-category="batteries"
         data-price="1200000"
         data-stock="5"
         data-title="Batterie Lithium FLA48300">
```

---

## Empty state
Si aucun produit ne correspond :
```html
<div class="catalog__empty" style="display:none">
  <p>Aucun produit ne correspond à vos critères.</p>
  <button class="btn btn--outline" onclick="CatalogFilter.reset()">Réinitialiser les filtres</button>
</div>
```

---

## Styles (components.css)
```
.catalog                 → layout grid : sidebar + main
.catalog__filters        → sidebar sticky
.catalog__filter-group   → bloc de filtre, margin-bottom lg
.catalog__grid           → grille produits
.catalog__count          → compteur résultats
.catalog__empty          → état vide
.filter-pill             → bouton catégorie
.filter-pill.is-active   → fond orange
@media mobile            → sidebar devient drawer
```

---

## SEO
- Title : "Catalogue Solaire — Batteries, Onduleurs, Panneaux | DESQ Energy"
- Filtres en JS donc pas d'impact SEO négatif (contenu présent au chargement)
- Pagination SEO-friendly si AJAX (rel next/prev)

---

## Checklist
- [ ] archive-desq_product.php avec layout sidebar + grille
- [ ] Tous les filtres fonctionnels en JS
- [ ] URL params synchronisés
- [ ] Compteur live + empty state
- [ ] Bouton réinitialiser
- [ ] Drawer filtres sur mobile
- [ ] Tri prix croissant/décroissant
- [ ] Data attributes sur les cards
- [ ] Test : filtrer par catégorie + prix simultanément
