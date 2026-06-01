# 03 — Système de Devis

> Le cœur fonctionnel du site. Spec complète du panier de devis et du formulaire multi-étapes.

---

## Vue d'ensemble du flux

```
Catalogue/Fiche produit
    │ clic "Ajouter au devis"
    ▼
Panier de devis (sessionStorage)
    │ clic "Demander mon devis"
    ▼
Formulaire multi-étapes (/devis)
    ├── Étape 1 : Produits sélectionnés (récap + quantités)
    ├── Étape 2 : Informations client
    └── Étape 3 : Récapitulatif + soumission
    │
    ▼
WPForms → Webhook Make.com → Email + CRM + WhatsApp
```

---

## Partie 1 — Panier de devis (JS)

### Fichier : assets/js/quote-form.js

Le panier vit dans `sessionStorage` (clé `desq_quote`). Structure :
```js
{
  items: [
    { id: 123, title: "Batterie FLA48300", price: 1200000, qty: 1, category: "batteries" },
    { id: 456, title: "Onduleur IVEM8048", price: 450000, qty: 2, category: "onduleurs" }
  ],
  updated: "2026-06-01T10:00:00Z"
}
```

### Fonctions à coder
```js
const DesqQuote = {
  KEY: 'desq_quote',

  get() {
    try {
      return JSON.parse(sessionStorage.getItem(this.KEY)) || { items: [] };
    } catch { return { items: [] }; }
  },

  save(data) {
    data.updated = new Date().toISOString();
    sessionStorage.setItem(this.KEY, JSON.stringify(data));
    this.updateBadge();
  },

  add(product) {
    const quote = this.get();
    const existing = quote.items.find(i => i.id === product.id);
    if (existing) {
      existing.qty += 1;
    } else {
      quote.items.push({ ...product, qty: 1 });
    }
    this.save(quote);
    this.showToast(`${product.title} ajouté au devis`);
  },

  remove(id) {
    const quote = this.get();
    quote.items = quote.items.filter(i => i.id !== id);
    this.save(quote);
  },

  updateQty(id, qty) {
    const quote = this.get();
    const item = quote.items.find(i => i.id === id);
    if (item) item.qty = Math.max(1, qty);
    this.save(quote);
  },

  total() {
    return this.get().items.reduce((sum, i) => sum + (i.price * i.qty), 0);
  },

  count() {
    return this.get().items.reduce((sum, i) => sum + i.qty, 0);
  },

  clear() {
    sessionStorage.removeItem(this.KEY);
    this.updateBadge();
  },

  updateBadge() {
    const badge = document.querySelector('.quote-badge');
    if (badge) {
      const count = this.count();
      badge.textContent = count;
      badge.style.display = count > 0 ? 'flex' : 'none';
    }
  },

  showToast(msg) {
    // Toast notification temporaire (2s)
    const toast = document.createElement('div');
    toast.className = 'toast toast--success';
    toast.textContent = msg;
    document.body.appendChild(toast);
    setTimeout(() => toast.classList.add('is-visible'), 10);
    setTimeout(() => { toast.classList.remove('is-visible'); setTimeout(() => toast.remove(), 300); }, 2000);
  }
};

// Boutons "Ajouter au devis"
document.addEventListener('click', e => {
  const btn = e.target.closest('[data-add-to-quote]');
  if (!btn) return;
  e.preventDefault();
  DesqQuote.add({
    id: parseInt(btn.dataset.id),
    title: btn.dataset.title,
    price: parseInt(btn.dataset.price),
    category: btn.dataset.category,
  });
});

document.addEventListener('DOMContentLoaded', () => DesqQuote.updateBadge());
```

### Bouton produit (dans product-card et single)
```html
<button class="btn btn--sm btn--primary"
        data-add-to-quote
        data-id="<?php echo get_the_ID(); ?>"
        data-title="<?php echo esc_attr(get_the_title()); ?>"
        data-price="<?php echo esc_attr(get_field('product_price')); ?>"
        data-category="<?php echo esc_attr($category_slug); ?>">
  + Ajouter au devis
</button>
```

### Badge panier (dans header)
```html
<a href="/devis" class="header__quote">
  <i class="icon-quote"></i>
  <span class="quote-badge" style="display:none">0</span>
</a>
```

---

## Partie 2 — Formulaire multi-étapes (/devis)

### Template : templates/page-quote.php

3 étapes affichées avec une progress bar. Navigation JS (pas de rechargement).

### Étape 1 — Produits sélectionnés
- Affiche les items du `sessionStorage`
- Permet de modifier les quantités (+/-)
- Permet de supprimer un item
- Affiche le total estimatif
- Si panier vide : message + lien vers catalogue
- Bouton "Suivant →"

### Étape 2 — Informations client
Champs (avec validation) :
```
Type de client *     → radio : Particulier / Entreprise
Nom complet *        → text
Société              → text (si Entreprise)
Téléphone *          → tel (format sénégalais : +221 ou 77/78/76/70/75...)
Email *              → email
Localisation *       → text (ville/quartier)
Type de projet       → select : Résidentiel / Commercial / Industriel / Pompage
Message              → textarea (optionnel)
```
- Validation en temps réel
- Bouton "← Retour" et "Suivant →"

### Étape 3 — Récapitulatif
- Résumé produits + quantités + total
- Résumé infos client
- Case à cocher RGPD/consentement
- Bouton "Envoyer ma demande de devis"
- À la soumission : injecte les données dans WPForms (champ caché JSON) + submit

### Progress bar
```html
<div class="quote-progress">
  <div class="quote-progress__step is-active" data-step="1">
    <span class="quote-progress__num">1</span>
    <span class="quote-progress__label">Produits</span>
  </div>
  <div class="quote-progress__step" data-step="2">
    <span class="quote-progress__num">2</span>
    <span class="quote-progress__label">Vos infos</span>
  </div>
  <div class="quote-progress__step" data-step="3">
    <span class="quote-progress__num">3</span>
    <span class="quote-progress__label">Validation</span>
  </div>
</div>
```

---

## Partie 3 — WPForms + Webhook

### Configuration WPForms
1. Créer un formulaire "Demande de devis"
2. Champs : nom, société, téléphone, email, localisation, type_projet, message, **produits_json** (champ caché), **total_estime** (champ caché)
3. Notification email à l'équipe DESQ
4. Confirmation à l'utilisateur
5. **Webhook** (WPForms Pro Webhooks ou via Make.com) → URL Make.com

### Champ caché produits_json
Le JS remplit ce champ avant submit :
```js
document.querySelector('#wpforms-field_produits').value = JSON.stringify(DesqQuote.get().items);
document.querySelector('#wpforms-field_total').value = DesqQuote.total();
```

### Après soumission réussie
```js
// Hook WPForms success
DesqQuote.clear(); // Vider le panier
// Redirection vers page de remerciement
```

---

## Styles à coder (components.css)

```
.quote-progress              → flex, justify between, margin-bottom xl
.quote-progress__step        → flex column, align center, opacity 0.5
.quote-progress__step.is-active → opacity 1, num en orange
.quote-progress__num         → cercle 32px, fond gris → orange si actif
.quote-cart                  → liste des items
.quote-cart__item            → flex between, padding md, border-bottom
.quote-cart__qty             → flex, boutons +/- et input
.quote-cart__total           → fs-xl, fw-semibold, orange, text-right
.quote-step                  → display none, .is-active → block
.toast                       → position fixed bottom, translateY hidden
.toast.is-visible            → translateY 0
```

---

## Calcul estimatif — Note importante

Le total affiché est **estimatif**. Mention obligatoire :
> "Ce montant est une estimation. Un devis officiel vous sera envoyé sous 2h après étude de votre demande."

Cela protège DESQ sur les variations de prix.

---

## Checklist
- [ ] quote-form.js : objet DesqQuote complet
- [ ] Boutons "Ajouter au devis" sur card + single
- [ ] Badge panier dans header (compteur live)
- [ ] Toast notification fonctionnel
- [ ] page-quote.php : 3 étapes + progress bar
- [ ] Validation formulaire étape 2
- [ ] WPForms configuré + champs cachés
- [ ] Webhook vers Make.com testé
- [ ] Panier vidé après soumission
- [ ] Mention "estimation" affichée
