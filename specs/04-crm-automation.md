# 04 — CRM & Automation (Make.com)

> Configuration de l'automatisation. Cette spec est principalement no-code (Make.com + HubSpot), mais inclut les points d'intégration côté WordPress.

---

## Vue d'ensemble

```
WPForms (devis soumis)
    │ Webhook POST (JSON)
    ▼
Make.com — Scénario "Nouveau Devis DESQ"
    │
    ├─[Router]─→ Branche A : Email confirmation client (Gmail)
    │
    ├──────────→ Branche B : Créer/MAJ contact HubSpot + Deal
    │
    ├──────────→ Branche C : Notification WhatsApp équipe
    │
    └──────────→ Branche D : Ligne dans Google Sheets (backup)

[Scénario séparé, planifié]
Make.com — "Relance Leads"
    │ Toutes les 6h
    ▼
Cherche deals HubSpot statut "Nouveau" > 48h
    │
    ▼
Email de relance automatique
```

---

## Étape 1 — Payload Webhook (depuis WPForms)

Le webhook envoie ce JSON à Make.com :
```json
{
  "client_type": "Entreprise",
  "name": "Amadou Diallo",
  "company": "Diallo BTP SARL",
  "phone": "+221771234567",
  "email": "amadou@diallobtp.sn",
  "location": "Dakar, Almadies",
  "project_type": "Commercial",
  "message": "Besoin système 10kW pour bureau",
  "products": [
    {"id": 123, "title": "Batterie FLA48300", "price": 1200000, "qty": 1},
    {"id": 456, "title": "Onduleur IVEM8048", "price": 450000, "qty": 2}
  ],
  "total_estime": 2100000,
  "submitted_at": "2026-06-01T10:30:00Z"
}
```

---

## Étape 2 — Scénario Make.com "Nouveau Devis"

### Module 1 : Webhook (trigger)
- Type : Custom webhook
- Copier l'URL générée → la coller dans WPForms Webhooks
- Structure : déterminée par le premier payload reçu

### Module 2 : Router (3-4 branches parallèles)

#### Branche A — Email confirmation client (Gmail)
- Module : Gmail > Send an email
- To : `{{email}}`
- Subject : `Votre demande de devis DESQ Energy — Réf {{submitted_at}}`
- Body (HTML) :
```
Bonjour {{name}},

Merci pour votre demande de devis chez DESQ Energy.

Récapitulatif de votre demande :
{{#products}}
- {{title}} × {{qty}} : {{price}} FCFA
{{/products}}

Total estimatif : {{total_estime}} FCFA
(Ce montant est une estimation. Un devis officiel vous sera envoyé sous 2h.)

Notre équipe vous contactera très rapidement.

DESQ Energy
+221 77 348 07 37 | desq93@gmail.com
15 Rue Escarfait, Dakar
```

#### Branche B — HubSpot CRM
- Module 1 : HubSpot > Search/Create Contact (par email)
  - Email, Nom, Téléphone, Société, Type de client
- Module 2 : HubSpot > Create Deal
  - Nom du deal : `Devis {{name}} - {{total_estime}} FCFA`
  - Pipeline : "Ventes DESQ"
  - Étape : "Nouveau lead"
  - Montant : `{{total_estime}}`
  - Associer au contact créé
- Module 3 : HubSpot > Add Note au deal (liste produits + message)

#### Branche C — WhatsApp équipe
Option 1 (simple) : Make.com > WhatsApp Business Cloud
Option 2 : via API (Twilio/360dialog)
- Destinataire : numéro équipe DESQ
- Message :
```
🔔 NOUVEAU DEVIS

Client : {{name}} ({{client_type}})
{{company}}
📞 {{phone}}
📍 {{location}}
💰 Estimé : {{total_estime}} FCFA

Produits :
{{#products}}• {{title}} ×{{qty}}{{/products}}

→ Voir dans HubSpot
```

#### Branche D — Google Sheets (backup)
- Module : Google Sheets > Add a Row
- Colonnes : Date, Nom, Société, Tel, Email, Localisation, Type, Total, Produits, Statut

---

## Étape 3 — Scénario "Relance Leads"

### Trigger : Schedule (toutes les 6h)

### Module 1 : HubSpot > Search Deals
- Filtre : étape = "Nouveau lead" ET date création < il y a 48h

### Module 2 : Iterator (pour chaque deal)

### Module 3 : Gmail > Send relance
```
Bonjour {{name}},

Nous revenons vers vous concernant votre demande de devis solaire.

Avez-vous des questions ? Notre équipe est disponible :
📞 +221 77 348 07 37
💬 WhatsApp : wa.me/221773480737

Nous serions ravis de finaliser votre projet énergétique.

DESQ Energy
```

### Module 4 : HubSpot > Update Deal
- Étape → "Relancé"

---

## Étape 4 — Configuration HubSpot

### Pipeline "Ventes DESQ"
```
1. Nouveau lead         (auto via Make)
2. Relancé              (auto si +48h)
3. Devis envoyé         (manuel commercial)
4. En négociation       (manuel)
5. Gagné                (manuel)
6. Perdu                (manuel)
```

### Propriétés contact custom
- Type client (Particulier/Entreprise)
- Source (toujours "Site web - Devis")
- Localisation

---

## Étape 5 — Intégration WordPress (côté code)

Si on ne passe pas par WPForms Webhooks (Pro), alternative : envoyer le webhook manuellement via `wp_remote_post`.

```php
/**
 * Envoie le devis vers Make.com après soumission WPForms
 * Hook sur wpforms_process_complete
 */
function desq_send_quote_to_make($fields, $entry, $form_data, $entry_id) {
    // Vérifier que c'est le bon formulaire (ID à ajuster)
    if ($form_data['id'] != 5) return;

    $webhook_url = 'https://hook.eu1.make.com/XXXXX'; // URL Make.com

    $payload = [
        'name'        => $fields[1]['value'] ?? '',
        'company'     => $fields[2]['value'] ?? '',
        'phone'       => $fields[3]['value'] ?? '',
        'email'       => $fields[4]['value'] ?? '',
        'location'    => $fields[5]['value'] ?? '',
        'project_type'=> $fields[6]['value'] ?? '',
        'message'     => $fields[7]['value'] ?? '',
        'products'    => json_decode($fields[8]['value'] ?? '[]', true),
        'total_estime'=> (int)($fields[9]['value'] ?? 0),
        'submitted_at'=> current_time('c'),
    ];

    wp_remote_post($webhook_url, [
        'method'  => 'POST',
        'headers' => ['Content-Type' => 'application/json'],
        'body'    => wp_json_encode($payload),
        'timeout' => 15,
    ]);
}
add_action('wpforms_process_complete', 'desq_send_quote_to_make', 10, 4);
```

---

## Coûts (plan gratuit)

| Service | Plan | Limite gratuite |
|---------|------|-----------------|
| Make.com | Free | 1 000 opérations/mois |
| HubSpot | Free CRM | Illimité contacts |
| WhatsApp Business | Cloud API | 1 000 conversations/mois |
| Google Sheets | Gratuit | — |

> 1 devis = ~4 opérations Make. Donc ~250 devis/mois en gratuit. Largement suffisant pour démarrer.

---

## Checklist
- [ ] Webhook WPForms ou wp_remote_post configuré
- [ ] Scénario Make "Nouveau Devis" : 4 branches
- [ ] Email confirmation client testé
- [ ] HubSpot : contact + deal créés automatiquement
- [ ] Notification WhatsApp reçue par l'équipe
- [ ] Backup Google Sheets fonctionnel
- [ ] Scénario "Relance Leads" planifié
- [ ] Pipeline HubSpot configuré
- [ ] Test end-to-end : soumettre un devis → vérifier les 4 sorties
