# 🗺️ ROADMAP — Sessions Claude Code

> Ordre exact des sessions de développement. Chaque session = un prompt à Claude Code. Copier-coller les prompts ci-dessous.

---

## PHASE 1 — FONDATIONS (Semaines 1-3)

### Session 1 — Setup & CLAUDE.md
**Specs à lire** : `00-setup.md`
```
Lis CLAUDE.md et specs/00-setup.md.
Crée la structure complète du theme enfant WordPress :
- Tous les dossiers (assets/css, assets/js, templates, template-parts, post-types, acf-fields)
- style.css avec en-tête theme
- functions.php de base (setup, enqueue, includes)
- index.php fallback
Vérifie qu'il n'y a aucune erreur PHP. Commit : "chore: initial theme setup".
```

### Session 2 — Design System CSS
**Specs** : `01-design-system.md`
```
Lis specs/01-design-system.md.
Code les 4 fichiers CSS :
- assets/css/design-system.css (toutes les variables/tokens)
- assets/css/global.css (reset, typo, base)
- assets/css/components.css (boutons, badges, cards, inputs, grilles, section-header)
- assets/css/animations.css (keyframes + reveal)
Crée une page de démo /demo affichant tous les composants pour validation visuelle.
Commit : "feat: design system + components".
```

### Session 3 — CPT & ACF
**Specs** : `02-cpt-acf.md`
```
Lis specs/02-cpt-acf.md.
Code :
- post-types/register-product.php (CPT + taxonomy product_category)
- post-types/register-solution.php
- post-types/register-testimonial.php
- Les helper functions (desq_get_price, desq_get_stock_status, desq_option)
- Active ACF Local JSON dans functions.php
- Crée la page d'options ACF
Crée 3 produits de test pour valider. Commit : "feat: custom post types + ACF".
```

### Session 4 — Header
**Specs** : `composants-header-footer.md`
```
Lis pages/composants-header-footer.md (section HEADER).
Code header.php : logo, menu WP, sticky glassmorphism, effet scroll,
badge panier devis, bouton CTA, menu mobile hamburger.
Ajoute le JS header dans main.js (scroll effect + mobile menu).
Test responsive 360px. Commit : "feat: header sticky glassmorphism".
```

### Session 5 — Footer
**Specs** : `composants-header-footer.md`
```
Lis pages/composants-header-footer.md (section FOOTER).
Code footer.php : 4 colonnes (about, produits, liens, contact),
infos depuis ACF, réseaux sociaux, copyright, liens légaux.
Ajoute le bouton WhatsApp flottant global.
Test responsive. Commit : "feat: footer + whatsapp float".
```

---

## PHASE 2 — PAGES & E-COMMERCE (Semaines 4-6)

### Session 6 — Page d'accueil
**Specs** : `page-accueil.md`
```
Lis pages/page-accueil.md.
Code page-home.php (Template Name: Accueil Premium) avec les 9 sections.
Crée les template-parts/sections/ : hero, features, featured-products, stats, cta.
Ajoute l'animation counter dans main.js.
Configure cette page comme page d'accueil WP.
Test mobile complet. Commit : "feat: homepage with all sections".
```

### Session 7 — Catalogue + filtres
**Specs** : `page-catalogue.md`
```
Lis pages/page-catalogue.md.
Code archive-desq_product.php : layout sidebar filtres + grille.
Code le composant product-card réutilisable (template-parts/product-card.php).
Code assets/js/catalog-filter.js (objet CatalogFilter complet).
Filtres : catégorie, prix, stock, tri, recherche. URL params synchronisés.
Drawer filtres sur mobile. Commit : "feat: catalog with live filters".
```

### Session 8 — Fiche produit
**Specs** : `page-fiche-produit.md`
```
Lis pages/page-fiche-produit.md.
Code single-desq_product.php : galerie + miniatures + lightbox,
infos + prix + stock + quantité, onglets (description/specs/téléchargements),
produits similaires, Schema.org Product.
Ajoute le JS galerie + quantité dans main.js.
Commit : "feat: single product page".
```

### Session 9 — Système de devis
**Specs** : `03-quote-system.md`
```
Lis specs/03-quote-system.md.
Code :
- assets/js/quote-form.js (objet DesqQuote : panier sessionStorage, toast)
- Boutons "Ajouter au devis" branchés (card + single)
- Badge panier header live
- page-quote.php (Template Name: Devis) : 3 étapes + progress bar
- Validation formulaire étape 2
Configure WPForms "Demande de devis" + champs cachés produits_json.
Commit : "feat: quote cart + multi-step form".
```

### Session 10 — Page Solutions
**Specs** : `pages-solutions-contact-simulateur.md` (section SOLUTIONS)
```
Lis pages/pages-solutions-contact-simulateur.md (section SOLUTIONS).
Code page-solutions.php : hero + 4 blocs segments alternés
(résidentiel, commercial, industriel, pompage).
Liens devis pré-remplis par segment (/devis?projet=X).
Données depuis CPT desq_solution ou statiques.
Commit : "feat: solutions page".
```

### Session 11 — Page Contact
**Specs** : `pages-solutions-contact-simulateur.md` (section CONTACT)
```
Lis pages/pages-solutions-contact-simulateur.md (section CONTACT).
Code page-contact.php : formulaire WPForms + colonne infos (depuis ACF)
+ Google Maps embed + Schema.org LocalBusiness.
Commit : "feat: contact page + map".
```

### Session 12 — Simulateur solaire
**Specs** : `pages-solutions-contact-simulateur.md` (section SIMULATEUR)
```
Lis pages/pages-solutions-contact-simulateur.md (section SIMULATEUR).
Code page-simulator.php : 3 étapes interactives.
Code assets/js/simulator.js (algorithme de dimensionnement).
Capture email → branche le lead vers le même flow que le devis.
Mentions légales "estimation indicative".
Commit : "feat: solar simulator".
```

---

## PHASE 3 — AUTOMATION (Semaines 7)

### Session 13 — Webhook & intégration Make
**Specs** : `04-crm-automation.md`
```
Lis specs/04-crm-automation.md.
Code la fonction desq_send_quote_to_make() (hook wpforms_process_complete).
Envoie le payload JSON vers le webhook Make.com.
Teste l'envoi du payload (logger la réponse).
Commit : "feat: make.com webhook integration".
```

### Session 14 — Config Make.com (no-code, accompagné)
**Specs** : `04-crm-automation.md`
```
NON-CODE : configuration dans Make.com directement.
- Créer scénario "Nouveau Devis" : webhook → router 4 branches
- Email client (Gmail), HubSpot (contact+deal), WhatsApp, Google Sheets
- Tester end-to-end avec un vrai devis
Claude Code aide à débugger le payload si besoin.
```

### Session 15 — Relances & pipeline
**Specs** : `04-crm-automation.md`
```
NON-CODE : Make.com + HubSpot.
- Scénario "Relance Leads" planifié (toutes les 6h)
- Pipeline HubSpot "Ventes DESQ" (6 étapes)
- Propriétés contact custom
- Test relance automatique
```

---

## PHASE 4 — FINITION & LAUNCH (Semaines 8-9)

### Session 16 — SEO & Schema
```
Configure Rank Math sur toutes les pages.
Vérifie : title, meta description, H1 unique, Schema.org.
Génère sitemap.xml. Soumets à Google Search Console.
Commit : "feat: SEO optimization".
```

### Session 17 — Performance
```
Optimise les performances :
- Conversion images WebP (WebP Express)
- Lazy-load vérifié partout
- Minification CSS/JS
- WP Rocket configuré (cache, defer JS)
- Cloudflare CDN activé
Cible : chargement < 3s sur 3G, score PageSpeed > 85.
Commit : "perf: optimization + cache".
```

### Session 18 — Tests & corrections
```
Tests complets :
- Cross-browser : Chrome, Firefox, Safari, Samsung Internet
- Mobile réel : Samsung Galaxy, iPhone, Tecno
- Parcours complet : catalogue → fiche → devis → confirmation
- Formulaires + automation end-to-end
- Accessibilité (contraste, navigation clavier)
Corrige les bugs. Commit : "fix: cross-browser + mobile fixes".
GO-LIVE.
```

---

## 📊 Récapitulatif

| Phase | Sessions | Durée | Livrable |
|-------|----------|-------|----------|
| Fondations | S1-S5 | Sem 1-3 | Theme + design system + header/footer |
| Pages | S6-S12 | Sem 4-6 | Toutes les pages + devis |
| Automation | S13-S15 | Sem 7 | CRM + Make.com opérationnel |
| Finition | S16-S18 | Sem 8-9 | Site optimisé + live |

**Total : 18 sessions sur 9 semaines.**

---

## 💡 Conseils pour piloter Claude Code

1. **Commence chaque session** par "Lis CLAUDE.md et [la spec]"
2. **Valide visuellement** avant de passer à la suite
3. **Commit après chaque session** réussie
4. **Si bug** : donne le message d'erreur exact à Claude Code
5. **Garde le contrôle** : Claude Code propose, tu valides, il ajuste
6. **Mets à jour CLAUDE.md** si une décision technique change
