# CHECKLIST DEMARRAGE RAPIDE

> Derniere mise à jour : Session 1 — 01/06/2026

---

## AVANT DE COMMENCER

- [x] Git installé — `git version 2.47.3` (local) + `git version 2.47.3` (Hostinger)
- [x] Compte GitHub — https://github.com/Amadousn221
- [x] Accès SSH Hostinger activé — port 65002, IP 145.79.20.84
- [x] WordPress sur Hostinger — version 6.9.4

---

## ETAPE 1 — Repo GitHub

- [x] Repo créé — https://github.com/Amadousn221/Desq
- [x] Branch principale : `main`

---

## ETAPE 2 — Git local

- [x] Git initialisé dans `C:\Users\LENOVO\Documents\Projets\Desq`
- [x] Remote origin configuré
- [x] `git config user.email "contact@atta-africa.com"`
- [x] `git config user.name "DESQ Development"`
- [x] `git status` = branch propre

---

## ETAPE 3 — Specs dans le repo

- [x] `CLAUDE.md` présent
- [x] `README.md` présent
- [x] `ROADMAP-SESSIONS.md` présent
- [x] `specs/` — 5 fichiers (00 à 04)
- [x] `pages/` — 5 fichiers (accueil, catalogue, fiche-produit, solutions, composants)

---

## ETAPE 4 — Premier commit et push

- [x] Push réussi — commit `9afce64`
- [x] Fichiers visibles sur GitHub

---

## ETAPE 5 — SSH Hostinger

- [x] Connexion SSH fonctionnelle (port 65002)
- [x] WP-CLI fonctionnel — `wp core version` = 6.9.4
- [x] PHP 8.3.30

---

## ETAPE 6 — Auto-deploy GitHub Actions

- [x] `.github/workflows/deploy.yml` créé (Option B — GitHub Actions)
- [x] Secret `HOSTINGER_SSH_KEY` configuré
- [x] Workflow vert au run #4
- [x] Destination : `/home/u415053603/domains/desqenergy.com/public_html/wp-content/themes/desq-energy-theme/`

---

## ETAPE 7 — Test auto-deploy

- [x] Fichier test pushé et déployé automatiquement
- [x] Fichiers confirmés sur Hostinger (style.css, functions.php, inc/, assets/)
- [x] Fichier test supprimé (`deploy-test.txt`)

---

## ETAPE 8 — Pret pour le dev

- [x] Theme `desq-energy-theme` = ACTIF sur WordPress (version 1.0.0)
- [x] Repo propre — `git status` = rien à commiter
- [x] `CLAUDE.md` accessible et à jour
- [x] Terminal prêt dans `C:\Users\LENOVO\Documents\Projets\Desq`

---

## READY FOR LAUNCH

Pipeline operationnel. Workflow quotidien :

```bash
# Dev → push → deploy automatique
git add .
git commit -m "feat: description"
git push origin main
# Site mis a jour sur https://desqenergy.com en ~30 secondes
```

---

## Themes sur Hostinger

| Theme | Statut | Version |
|-------|--------|---------|
| `desq-energy-theme` | **ACTIF** | 1.0.0 |
| `blonwe` | Inactif | 1.3.6 |
| `blonwe-child` | Inactif | 1.3.6 |
| `hostinger-ai-theme` | Inactif | 2.0.14 |

---

## Recap workflow quotidien

```
1. Ouvre terminal → cd C:\Users\LENOVO\Documents\Projets\Desq
2. Code avec Claude Code
3. git add . && git commit -m "..." && git push origin main
4. Attends ~30 secondes
5. Verifie sur https://desqenergy.com
```

---

## Si quelque chose casse

```bash
git log --oneline -5           # Voir les commits
git reset --hard <hash>        # Revenir a un commit
git push origin main --force   # Force push → re-deploy
```
