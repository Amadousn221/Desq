# Pages — Solutions, Contact, Simulateur

> Specs des 3 pages restantes.

---

# PAGE SOLUTIONS (page-solutions.php)

## Objectif
Présenter les solutions par segment et orienter vers les produits adaptés.

## Structure
```
1. Header
2. Hero solutions (titre + intro)
3. 4 blocs segments (alternance gauche/droite)
4. Comparatif (optionnel)
5. CTA devis
6. Footer
```

## Les 4 segments
1. **Résidentiel** — Maisons, villas. Système 3-5 kW. Autonomie foyer.
2. **Commercial** — Bureaux, commerces. Système 5-15 kW. Réduction facture.
3. **Industriel** — Usines, ateliers. Système 15kW+. Production continue.
4. **Pompage solaire** — Agriculture, forages. Pompes immergées.

## Bloc segment (répété 4×, alternance)
```php
<section class="solution-block <?php echo $i % 2 ? 'solution-block--reverse' : ''; ?>">
  <div class="solution-block__visual">
    <!-- Icône SVG ou image -->
  </div>
  <div class="solution-block__content">
    <span class="badge badge--primary"><?php echo $segment; ?></span>
    <h2><?php echo $title; ?></h2>
    <p><?php echo $description; ?></p>
    <ul class="solution-block__benefits">
      <!-- avantages -->
    </ul>
    <p class="solution-block__power">Puissance type : <strong><?php echo $power; ?></strong></p>
    <a href="/devis?projet=<?php echo $segment; ?>" class="btn btn--primary">Devis pour ce projet</a>
  </div>
</section>
```

Données depuis CPT `desq_solution` (champ `solution_segment`) ou statiques.

## SEO
- Title : "Solutions Solaires — Résidentiel, Commercial, Industriel | DESQ Energy"

---

# PAGE CONTACT (page-contact.php)

## Objectif
Faciliter la prise de contact par tous les canaux.

## Structure
```
1. Header
2. Page header
3. Layout : [Formulaire] [Infos + Carte]
4. Footer
```

## Colonne formulaire (WPForms)
- Nom *, Email *, Téléphone *, Sujet, Message *
- Bouton "Envoyer"
- Confirmation après envoi

## Colonne infos
- **Adresse** : 15 Rue Escarfait X Lamine Guèye, Dakar (depuis ACF `desq_address`)
- **Téléphone** : +221 77 348 07 37 (cliquable `tel:`)
- **WhatsApp** : bouton direct
- **Email** : desq93@gmail.com (cliquable `mailto:`)
- **Horaires** : depuis ACF `desq_hours`
- **Carte Google Maps** : embed iframe ou API avec marqueur

## Google Maps
```html
<div class="contact__map">
  <iframe src="https://www.google.com/maps/embed?pb=..." loading="lazy" allowfullscreen></iframe>
</div>
```
Coordonnées depuis ACF `desq_map_lat` / `desq_map_lng`.

## Bouton WhatsApp flottant (global, toutes pages)
```html
<a href="https://wa.me/<?php echo desq_option('desq_whatsapp'); ?>"
   class="whatsapp-float" target="_blank" aria-label="Contacter sur WhatsApp">
  <svg><!-- icône WhatsApp --></svg>
</a>
```
```css
.whatsapp-float {
  position: fixed; bottom: 24px; right: 24px; z-index: 99;
  width: 56px; height: 56px; border-radius: 50%;
  background: #25D366; box-shadow: var(--shadow-lg);
  display: flex; align-items: center; justify-content: center;
}
```

## SEO + Schema
- Schema.org LocalBusiness (adresse, téléphone, horaires, geo)

---

# PAGE SIMULATEUR (page-simulator.php ou section)

## Objectif
Outil interactif : aider à dimensionner un système solaire et capturer un lead.

## Fonctionnement
```
Étape 1 : Type de besoin (sliders/inputs)
  - Puissance souhaitée (kW) OU nombre d'appareils
  - Budget approximatif (FCFA)
  - Type : Résidentiel / Commercial / Industriel
  - Autonomie souhaitée (heures)

Étape 2 : Calcul (algorithme JS)
  → Recommandation : X batteries + Y onduleur + Z panneaux

Étape 3 : Résultat
  - Affichage du système recommandé
  - Prix estimatif total
  - Formulaire capture email "Recevoir le détail"
  - Bouton "Ajouter au devis"
```

## Algorithme simplifié (simulator.js)
```js
const Simulator = {
  // Bases de calcul (à ajuster avec données réelles Felicity)
  calc(params) {
    const { power, autonomy, type } = params;

    // Capacité batterie nécessaire (kWh) = puissance × autonomie × facteur
    const batteryKwh = power * autonomy * 1.2;

    // Nombre de batteries (15kWh par batterie FLA48300)
    const batteries = Math.ceil(batteryKwh / 15);

    // Onduleur : puissance × 1.25 (marge)
    const inverterKw = Math.ceil(power * 1.25);

    // Panneaux (400W chacun, production ~5h/jour à Dakar)
    const panels = Math.ceil((batteryKwh * 1000) / (400 * 5));

    return {
      batteries,
      inverter: `${inverterKw}kW`,
      panels,
      estimatedPrice: (batteries * 1200000) + 450000 + (panels * 180000),
    };
  },

  render(result) {
    // Afficher la recommandation
  }
};
```

> **Note** : les coefficients doivent être validés avec DESQ/Felicity Solar. Le résultat est indicatif.

## Capture lead
- Email obligatoire pour voir le détail complet
- Envoie vers HubSpot (même flow que devis)
- Mention : "Estimation indicative, devis précis sur demande"

## SEO
- Title : "Simulateur Solaire — Dimensionnez votre installation | DESQ Energy"

---

## Checklist globale
### Solutions
- [ ] 4 blocs segments alternés
- [ ] Liens devis pré-remplis par segment
- [ ] Responsive (blocs empilés mobile)

### Contact
- [ ] Formulaire WPForms
- [ ] Toutes les infos depuis ACF
- [ ] Google Maps embed
- [ ] Bouton WhatsApp flottant global
- [ ] Schema LocalBusiness

### Simulateur
- [ ] 3 étapes interactives
- [ ] Algorithme de calcul
- [ ] Affichage recommandation
- [ ] Capture email → HubSpot
- [ ] Bouton ajouter au devis
- [ ] Mentions légales estimation
