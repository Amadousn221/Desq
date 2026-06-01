# 📦 DESQ Energy — Package de Spécifications Claude Code

> Tout ce dont Claude Code a besoin pour coder le site de A à Z. À copier à la racine du theme WordPress.

---

## 🗂️ Contenu du package

```
desq-specs/
├── CLAUDE.md                          ← LIRE EN PREMIER (contexte global)
├── README.md                          ← Ce fichier
├── ROADMAP-SESSIONS.md                ← Ordre des sessions Claude Code
│
├── specs/
│   ├── 00-setup.md                    ← Installation & config
│   ├── 01-design-system.md            ← Variables CSS + composants
│   ├── 02-cpt-acf.md                  ← Custom Post Types + champs
│   ├── 03-quote-system.md             ← Système de devis complet
│   └── 04-crm-automation.md           ← Make.com + HubSpot
│
└── pages/
    ├── composants-header-footer.md    ← Header & Footer
    ├── page-accueil.md                ← Homepage (9 sections)
    ├── page-catalogue.md              ← Catalogue + filtres
    ├── page-fiche-produit.md          ← Fiche produit détaillée
    └── pages-solutions-contact-simulateur.md
```

---

## 🚀 Comment utiliser ce package avec Claude Code

### 1. Installation
```bash
# Copier le dossier desq-specs à la racine du theme
cp -r desq-specs/ wp-content/themes/desq-energy-theme/
# CLAUDE.md doit être à la racine pour lecture auto
cp desq-specs/CLAUDE.md wp-content/themes/desq-energy-theme/CLAUDE.md
```

### 2. Démarrer une session Claude Code
```bash
cd wp-content/themes/desq-energy-theme/
claude
```

### 3. Prompt de démarrage type
```
Lis CLAUDE.md et desq-specs/specs/00-setup.md.
Puis exécute la Session 1 : setup du theme.
Code uniquement ce qui est demandé dans la spec, respecte les conventions.
```

### 4. Règle d'or
**Une session = une tâche.** Ne jamais demander "code tout le site".
Toujours : "Code [composant X] selon la spec [fichier Y]".

---

## 📋 Ordre de développement (voir ROADMAP-SESSIONS.md)

| Phase | Sessions | Specs à lire |
|-------|----------|--------------|
| **Fondations** | S1-S5 | 00, 01, 02, header-footer |
| **Pages** | S6-S12 | accueil, catalogue, fiche, solutions, contact, simulateur, 03 |
| **Automation** | S13-S15 | 04 |
| **Finition** | S16-S18 | toutes (tests, SEO, perf) |

---

## ✅ Definition of Done (chaque session)

Une session est terminée quand :
- [ ] Le code respecte les conventions de CLAUDE.md
- [ ] Mobile-first vérifié (test 360px)
- [ ] Pas d'erreur PHP/JS dans la console
- [ ] Validation visuelle navigateur OK
- [ ] Commit Git avec message clair
- [ ] La checklist de la spec est cochée

---

## 🎨 Rappel design tokens (détail dans CLAUDE.md)

```
Orange : #E8722A   |   Bleu : #0F3460
Fonts  : DM Sans (titres) + Inter (corps)
Radius : cards 12px, buttons 8px
Spacing: base 8px
```

---

## 📞 Infos client (DESQ Energy)

- **Adresse** : 15 Rue Escarfait X Lamine Guèye, Dakar
- **Tél** : +221 77 348 07 37
- **Email** : desq93@gmail.com
- **NINEA** : 006855483-1A1
- **Fournisseur** : Felicity Solar (représentant Sénégal : Yoff, Dakar)
