# pages/_components.md
> Composants globaux — présents sur toutes les pages.
> Source de vérité pour Claude Code.
> Ne jamais coder un composant global sans lire ce fichier.

---

## COMPOSANT : Header principal
> Fichiers produits :
>   /theme-desq/template-parts/header.php
>   /theme-desq/assets/css/header.css
>   /theme-desq/assets/js/header.js

---

### SCÈNE PHYSIQUE
"Directeur PME BTP dakarois, desktop Chrome, 8 secondes
pour confirmer que DESQ a les onduleurs hybrides en stock
avant de décider s'il continue ou rappelle son fournisseur."

"Installateur électricien sur Samsung Galaxy A53, en voiture,
cherche le formulaire devis en moins de 3 secondes sans lire."

### DÉCISION CRÉATIVE UNIQUE
"Un seul univers visuel du header jusqu'au dropdown —
le bleu nuit ne s'interrompt jamais. L'orange ne parle
qu'aux deux éléments qui demandent une action."

---

### LAYOUT DESKTOP (min-width: 1024px)

Conteneur unique. Hauteur fixe : 72px (--header-height).
Fond : #FFFFFF.
Position : sticky, top: 0, z-index: 100.
Border-bottom : 1px solid #E8E8E8.
Scroll > 80px → backdrop-filter: blur(12px)
            + background: rgba(255,255,255,0.95).
Transition fond/blur : 300ms ease-out.

Structure interne (flex, align-center, justify-space-between) :
  [LOGO] ←————————— [NAV] ——————————→ [ACTIONS]
  ~180px             flex-1 centré      auto

**Logo (gauche) :**
  SVG ou image : logo DESQ Energy
  Couleur : #FFFFFF
  Hauteur : 36px, width: auto
  Lien : href="/" aria-label="DESQ Energy — Accueil"

**Navigation centrale :**
  Flex, gap: 8px.
  Chaque item : padding 8px 16px,
                font-family: Inter,
                font-size: 14px,
                font-weight: 400,
                color: #1A1A1A,
                transition: color 150ms ease-out.
  Hover : color #E8722A. Pas de soulignement. Pas de fond.
  Item actif (page courante) : color #E8722A, font-weight: 500.

  Items SANS chevron : Accueil, Contact
  Items AVEC chevron (▾ 10px, opacity: 0.6, margin-left: 4px) :
    Solutions, Produits, Services, À propos

  Item accentué "Installateurs" :
    color: #E8722A, font-weight: 500
    Hover : color #C45E1A
    Position : dernier item avant les actions.
    Pas de fond. Pas de bordure. Pas de pill.

**Actions (droite) :**
  Flex, align-center, gap: 16px.

  CTA "Devis rapide" :
    height: 40px, padding: 0 20px
    background: #E8722A, color: #FFFFFF
    font-family: Inter, font-size: 14px, font-weight: 500
    border-radius: 8px, border: none
    Hover : background #C45E1A, transform: translateY(-1px)
    Active : transform: scale(0.98)
    Transition : 250ms ease-out

  Icône loupe :
    SVG 20×20px, stroke #FFFFFF, opacity: 0.7
    Hover : opacity 1
    aria-label="Rechercher"
    Padding: 8px (zone de clic min 36×36px)

---

### DROPDOWNS — RÈGLE COMMUNE

Déclenchement : hover desktop / click mobile.
Fond : #0F3460 — MÊME fond que le header. Pas de blanc. Jamais.
Position : absolute, top: calc(100% + 0px).
Border-top : 1px solid rgba(255,255,255,0.1).
Box-shadow : 0 16px 32px rgba(0,0,0,0.3).
Animation : opacity 0→1 + translateY(-6px→0), 200ms ease-out.
Fermeture : mouseleave après 120ms délai.

---

### DROPDOWN — SOLUTIONS

Type : méga-dropdown grille visuelle.
Largeur : 480px. Centré sous l'item "Solutions".
Padding : 24px.

Titre interne :
  "Nos solutions"
  Inter 11px / uppercase / weight 500 /
  letter-spacing: 0.08em / color rgba(255,255,255,0.4)
  margin-bottom: 16px.

Grille 2×2, gap: 12px.
Chaque cellule :
  border-radius: 8px, overflow: hidden
  position: relative, cursor: pointer
  Transition: transform 200ms ease-out

  Image :
    width: 100%, height: 96px, object-fit: cover
    filter: brightness(0.75)
    Transition: filter 200ms ease-out, transform 200ms ease-out

  Overlay base :
    position: absolute, inset: 0
    background: linear-gradient(
      to top,
      rgba(15,52,96,0.85) 0%,
      rgba(15,52,96,0.1) 60%
    )

  Label :
    position: absolute, bottom: 10px, left: 12px
    Inter 13px / weight 500 / color #FFFFFF

  Hover cellule :
    Image → filter: brightness(0.9), transform: scale(1.04)
    Overlay → linear-gradient(
      to top,
      rgba(232,114,42,0.7) 0%,
      rgba(232,114,42,0.05) 70%
    )

  Les 4 cellules :
    1. Résidentiel      — image maison avec panneaux solaires
    2. Commercial       — image bâtiment commercial + panneaux
    3. Industriel       — image installation industrielle
    4. Pompage solaire  — image pompe / champ agricole

Lien bas :
  "Voir toutes les solutions →"
  Inter 12px / color #E8722A / margin-top: 16px
  display: block, text-align: right
  Hover : color #C45E1A

---

### DROPDOWN — PRODUITS

Type : méga-dropdown sidebar + aperçu.
Largeur : 640px. Aligné à gauche de l'item "Produits".
Padding : 0.

**Zone gauche — catégories (200px, flex-shrink: 0) :**
  background: rgba(0,0,0,0.2)
  padding: 20px 0
  border-right: 1px solid rgba(255,255,255,0.08)

  Titre :
    "Catalogue"
    Inter 11px / uppercase / weight 500 /
    letter-spacing: 0.08em / color rgba(255,255,255,0.4)
    padding: 0 20px, margin-bottom: 8px.

  Items :
    Padding: 10px 20px
    Inter 13px / weight 400 / color rgba(255,255,255,0.75)
    Transition: color 150ms, background 150ms

    Hover / actif :
      color #FFFFFF
      background: rgba(255,255,255,0.06)
      border-left: 2px solid #E8722A
      padding-left: 18px

    Les 6 items :
      1. Onduleurs hors réseau
      2. Onduleurs hybrides
      3. Batteries lithium
      4. Panneaux solaires
      5. Protection & accessoires
      6. → Voir tout le catalogue
         (color #E8722A / weight 500 / pas de border-left hover)

**Zone droite — aperçu produits (flex-1) :**
  padding: 20px

  3 mini cards produit de la catégorie survolée.
  Grille 3 colonnes, gap: 12px.

  Chaque card :
    border-radius: 6px
    background: rgba(255,255,255,0.05)
    padding: 12px
    Hover : background rgba(255,255,255,0.1),
            transform: translateY(-2px)
    Transition: 150ms ease-out

    Image :
      width: 100%, height: 72px
      object-fit: contain
      margin-bottom: 8px

    Nom :
      Inter 12px / weight 500 / color rgba(255,255,255,0.9)
      line-clamp: 2

    Lien "Voir →" :
      Inter 11px / color #E8722A
      margin-top: 6px, display: block

---

### DROPDOWN — SERVICES

Type : liste simple.
Largeur : 240px. Aligné sous "Services". Padding : 8px 0.

Items (dans l'ordre) :
  1. Installation certifiée
  2. Maintenance & SAV
  3. Formation installateurs
  4. Devenir revendeur

Chaque item :
  Padding: 12px 20px
  Inter 14px / weight 400 / color rgba(255,255,255,0.8)
  Hover : color #FFFFFF, background rgba(255,255,255,0.06)
  Transition: 150ms ease-out
  Pas de séparateurs. Pas d'icônes.

---

### DROPDOWN — À PROPOS

Type : liste simple.
Largeur : 240px. Aligné sous "À propos". Padding : 8px 0.

Items (dans l'ordre) :
  1. DESQ Energy
  2. Partenaire Felicity Solar
  3. Actualités
  4. Téléchargements
  5. Nous contacter

Même style que dropdown Services.

---

### LAYOUT MOBILE (max-width: 1023px)

Hauteur header : 60px.
Fond : #0F3460. Sticky, z-index: 100.
Pas de blur par défaut (performance 3G).

Structure :
  [LOGO 28px hauteur] ←—————————→ [HAMBURGER]

Hamburger :
  3 traits SVG : 20×16px, stroke #FFFFFF, stroke-width: 2px.
  Zone de clic : 44×44px.
  aria-label="Ouvrir le menu" / "Fermer le menu".
  Bascule simple hamburger ↔ ✕. Pas de morphing animé.

**Drawer latéral :**
  Largeur : 280px.
  Position : fixed, top: 0, left: -280px → translateX(0) ouvert.
  Fond : #0F3460. Hauteur : 100vh. z-index: 200.
  Box-shadow : 8px 0 32px rgba(0,0,0,0.4).
  Transition : 300ms cubic-bezier(0.4,0,0.2,1).
  Overlay : rgba(0,0,0,0.5), fade-in 300ms. Click → fermer.
  Escape → fermer.

  Header drawer :
    Logo DESQ blanc, height: 28px
    Padding: 20px 24px
    Border-bottom: 1px solid rgba(255,255,255,0.1)

  Items (flex column, padding: 8px 0) :
    Ordre :
      1. "Installateurs" + pill "B2B"
         background: rgba(232,114,42,0.15)
         color: #E8722A, padding: 2px 8px
         border-radius: 9999px, font-size: 11px
      2. Accueil
      3. Solutions   (accordéon ▾)
      4. Produits    (accordéon ▾)
      5. Services    (accordéon ▾)
      6. À propos    (accordéon ▾)
      7. Contact

    Chaque item principal :
      Padding: 14px 24px
      Inter 15px / weight 400 / color rgba(255,255,255,0.85)
      Border-bottom: 1px solid rgba(255,255,255,0.06)
      Tap : background rgba(255,255,255,0.05)

    Sous-items accordéon :
      Padding: 10px 24px 10px 40px
      Inter 14px / weight 400 / color rgba(255,255,255,0.65)
      Reprendre le contenu des dropdowns desktop dans l'ordre.

  Footer drawer :
    margin-top: auto, padding: 24px
    CTA "Devis rapide" : btn--primary, width 100%, height 48px
    Dessous : Inter 12px / opacity: 0.5 / centré
              "ou appeler le [desq_phone]"

---

### ACCESSIBILITÉ
- Logo : aria-label="DESQ Energy — Accueil"
- Hamburger : aria-expanded (toggle), aria-controls="nav-drawer"
- Dropdowns : aria-haspopup="true", aria-expanded, role="menu"
- Items dropdown : role="menuitem"
- Focus visible : outline 2px solid #E8722A, outline-offset: 2px
- Loupe : aria-label="Rechercher"
- Drawer : fermeture au Escape

---

### CE QU'ON RETIENT
"Le bleu nuit ne s'interrompt jamais —
du header jusqu'au fond du dropdown.
L'orange ne parle qu'aux deux éléments
qui demandent une action."

---
---

## COMPOSANT : Footer
> À compléter — spec non encore rédigée.

## COMPOSANT : Barre de recherche
> À compléter — spec non encore rédigée.
