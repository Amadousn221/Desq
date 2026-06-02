# ⚙️ MA CONFIGURATION PERSONNALISÉE

> Fichier de référence — NE PAS COMMITER (contient des chemins sensibles)

---

## Mes infos GitHub

```
Username GitHub          : Amadousn221
Repo URL (HTTPS)         : https://github.com/Amadousn221/Desq.git
GitHub Email             : contact@atta-africa.com
Nom (pour Git config)    : DESQ Development
Token Personal Access    : ⚠️ Ne pas stocker ici — utiliser GitHub Secrets
```

### Variables d'environnement
```bash
export GH_USERNAME="Amadousn221"
export GH_REPO_URL="https://github.com/Amadousn221/Desq.git"
export GH_EMAIL="contact@atta-africa.com"
export GH_NAME="DESQ Development"
```

---

## Mes infos Hostinger

```
Domain                   : desqenergy.com
IP SSH                   : 145.79.20.84
Port SSH                 : 65002
SSH Username             : u415053603
Chemin WordPress         : /home/u415053603/domains/desqenergy.com/public_html
Chemin Theme             : /home/u415053603/domains/desqenergy.com/public_html/wp-content/themes/desq-energy-theme
Chemin Themes            : /home/u415053603/domains/desqenergy.com/public_html/wp-content/themes
```

### Variables d'environnement
```bash
export HOSTINGER_IP="145.79.20.84"
export HOSTINGER_PORT="65002"
export HOSTINGER_USER="u415053603"
export HOSTINGER_DOMAIN="https://desqenergy.com"
export HOSTINGER_WP_PATH="/home/u415053603/domains/desqenergy.com/public_html"
export HOSTINGER_THEME_PATH="/home/u415053603/domains/desqenergy.com/public_html/wp-content/themes/desq-energy-theme"
```

### Test SSH
```bash
ssh -p 65002 u415053603@145.79.20.84 "echo 'SSH OK' && wp --path=$HOSTINGER_WP_PATH theme list"
```

---

## Chemin local (Windows)

```
Dossier projet local     : C:\Users\LENOVO\Documents\Projets\Desq
WordPress                : sur Hostinger uniquement (pas de WP local)
Theme local              : C:\Users\LENOVO\Documents\Projets\Desq  (= racine du theme)
```

---

## GitHub Actions — Secrets configurés

| Secret | Valeur | Usage |
|--------|--------|-------|
| `HOSTINGER_SSH_KEY` | Clé privée RSA | Auth SSH pour rsync |

Clé publique ajoutée dans : `~/.ssh/authorized_keys` sur Hostinger

---

## Auto-deploy — Comment ca marche

```
Push sur main
    ↓
GitHub Actions (ubuntu-latest)
    ↓
rsync via SSH (port 65002)
    ↓ exclut : .git .github *.md *.pdf specs/ pages/
    ↓ synchro vers :
/home/u415053603/domains/desqenergy.com/public_html/wp-content/themes/desq-energy-theme/
```

Durée moyenne : ~30 secondes

---

## Themes disponibles sur Hostinger

| Theme | Statut |
|-------|--------|
| `blonwe` | Theme parent actif |
| `blonwe-child` | Child theme (3 fichiers) |
| `desq-energy-theme` | **Notre theme custom — en développement** |
| `hostinger-ai-theme` | Inactif |
| `twentytwentyfive` | Inactif |

---

## Commands rapides

### Push après une session de dev
```bash
cd "C:\Users\LENOVO\Documents\Projets\Desq"
git add .
git commit -m "feat: description"
git push origin main
# → deploy automatique en ~30 secondes
```

### Vérifier ce qui est sur Hostinger
```bash
ssh -p 65002 u415053603@145.79.20.84 "ls -la /home/u415053603/domains/desqenergy.com/public_html/wp-content/themes/desq-energy-theme/"
```

### Rollback d'urgence
```bash
git log --oneline -10           # Voir les commits
git reset --hard <hash>         # Revenir à un commit
git push origin main --force    # Force push → re-deploy automatique
```

---

## Securite — Checklist

- [x] Clé SSH privée = dans GitHub Secret uniquement, jamais dans le repo
- [x] `.gitignore` contient `*.pem`, `*.pub`, `github-actions-key*`
- [x] Repo GitHub = Public (pas de credentials dans le code)
- [x] SSH authorized_keys = configuré sur Hostinger
- [ ] Activer le theme DESQ Energy dans WordPress admin

---

## Notes de session

```
Session 1 (01/06/2026) : Setup git, GitHub, SSH, auto-deploy. Pipeline operationnel.
Session 2 : ________________
Issues rencontrées : Mauvaise cle SSH collée dans GitHub Secret → corrigé
```

---

## Contacts & support

- **Hostinger Support** : https://support.hostinger.com
- **GitHub Actions** : https://github.com/Amadousn221/Desq/actions
- **WP Admin** : https://desqenergy.com/wp-admin
- **Site live** : https://desqenergy.com
