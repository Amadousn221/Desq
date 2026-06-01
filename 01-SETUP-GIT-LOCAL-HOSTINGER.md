# 🚀 SETUP LOCAL + GIT + HOSTINGER AUTO-DEPLOY

> Guide complet pour mettre Claude Code en local, versionner sur GitHub, et déployer automatiquement sur Hostinger.

---

## 📋 Prérequis

- [ ] Compte GitHub (https://github.com - gratuit)
- [ ] WordPress installé sur Hostinger (ya?)
- [ ] Accès SSH à Hostinger (à activer dans le panel)
- [ ] Git installé sur ta machine locale : `git --version`
- [ ] Terminal/PowerShell (Linux/Mac/Windows)

---

## ÉTAPE 1 — Créer le repo GitHub

### Sur GitHub.com
1. Va sur https://github.com/new
2. **Repository name** : `desq-energy-theme`
3. **Description** : "DESQ Energy WordPress Theme — Solar E-Commerce"
4. **Visibility** : Private (sécurité)
5. **Initialize with** : README (checké)
6. **Add .gitignore** : WordPress (dropdown)
7. Clique **"Create repository"**

### Copie l'URL HTTPS
Sur la page du repo, bouton vert **"Code"** → copie l'URL HTTPS :
```
hhttps://github.com/Amadousn221/Desq
```

---

## ÉTAPE 2 — Setup local

### Sur ta machine (Linux/Mac)

```bash
# 1. Va dans le dossier wp-content/themes
cd /path/to/wordpress/wp-content/themes

# 2. Clone le repo GitHub
git clone https://github.com/TONUSERNAME/desq-energy-theme.git
cd desq-energy-theme

# 3. Configure Git (une seule fois)
git config user.email "tonemail@gmail.com"
git config user.name "DESQ Development"

# 4. Copie le package de specs qu'on a créé
cp -r /home/claude/desq-specs .

# 5. Premier commit
git add .
git commit -m "chore: initial setup with specs package"
git push origin main

# ✅ Vérifiez sur GitHub que les fichiers sont là
```

### Sur Windows (PowerShell)

```powershell
# 1. Va dans le dossier
cd C:\path\to\wordpress\wp-content\themes

# 2. Clone
git clone https://github.com/TONUSERNAME/desq-energy-theme.git
cd desq-energy-theme

# 3. Configure
git config user.email "tonemail@gmail.com"
git config user.name "DESQ Development"

# 4. Copie les specs
Copy-Item C:\path\to\desq-specs -Recurse

# 5. Commit
git add .
git commit -m "chore: initial setup with specs package"
git push origin main
```

---

## ÉTAPE 3 — Configuration Hostinger Auto-Deploy

Hostinger va **automatiquement** mettre à jour le site quand tu pousses sur GitHub.

### 3a. Accès SSH à Hostinger

1. Va sur **Hostinger → My Account → Security → SSH Keys**
2. Génère une nouvelle clé SSH (ou importe la tienne)
3. Note le **SSH Login** : `user@hostinger-xxx.com` ou `user@ip.xxx.xxx`

### 3b. Vérifie la connexion SSH

Sur ta machine locale :
```bash
# Teste la connexion
ssh user@hostinger-xxx.com "wp version"

# Dois voir : "WordPress X.X.X" (pas d'erreur)
```

Si ça marche pas, contact Hostinger support (SSH pas activé par défaut).

### 3c. Create GitHub Personal Access Token

1. Va sur https://github.com/settings/tokens
2. **Personal Access Tokens** → **Tokens (classic)** → **Generate new token**
3. **Token name** : "Hostinger Deploy"
4. **Expiration** : 90 days (ou "No expiration")
5. **Scopes à cocher** :
   - ✅ `repo` (full control)
   - ✅ `workflow`
6. Clique **"Generate token"**
7. **COPIE LE TOKEN IMMÉDIATEMENT** (tu ne le reverras plus)

Token exemple : `ghp_xyzAbcDefGhijKlmnOpQrStUvWxyz1234`

### 3d. Configure le webhook auto-deploy sur Hostinger

#### Option A : Script de déploiement sur Hostinger (simple)

Connecte-toi via SSH à Hostinger et crée un script :

```bash
ssh user@hostinger-xxx.com

# Crée le script de déploiement
cat > ~/deploy.sh << 'EOF'
#!/bin/bash
set -e

# Chemin vers le theme
THEME_PATH="/home/user/public_html/wp-content/themes/desq-energy-theme"

# Log
echo "[$(date)] Déploiement lancé..." >> ~/deploy.log

cd $THEME_PATH
git fetch origin
git reset --hard origin/main

# Logs WordPress
echo "[$(date)] ✅ Déploiement réussi" >> ~/deploy.log
EOF

chmod +x ~/deploy.sh

# Teste le script
~/deploy.sh

# Dois voir : "✅ Déploiement réussi"
```

#### Option B : Utiliser GitHub Actions (automatique)

Crée un fichier `.github/workflows/deploy.yml` dans ton repo :

```yaml
name: Deploy to Hostinger

on:
  push:
    branches: [ main ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
    - uses: actions/checkout@v3
    
    - name: Deploy via SSH
      uses: appleboy/ssh-action@master
      with:
        host: ${{ secrets.HOSTINGER_HOST }}
        username: ${{ secrets.HOSTINGER_USER }}
        key: ${{ secrets.HOSTINGER_SSH_KEY }}
        script: |
          cd /home/user/public_html/wp-content/themes/desq-energy-theme
          git fetch origin
          git reset --hard origin/main
          echo "✅ Déploié!"
```

Puis configure les **GitHub Secrets** :
1. Va sur https://github.com/TONUSERNAME/desq-energy-theme/settings/secrets/actions
2. **New repository secret** :
   - `HOSTINGER_HOST` = `hostinger-xxx.com`
   - `HOSTINGER_USER` = `user`
   - `HOSTINGER_SSH_KEY` = contenu de `~/.ssh/id_rsa` (ta clé privée)

**Je recommande l'Option A pour commencer** (plus simple).

---

## ÉTAPE 4 — Test du workflow

### Local → GitHub → Hostinger

```bash
# Sur ta machine locale

# 1. Crée un fichier de test
echo "# Test deploy" > TEST.md

# 2. Commit et push
git add TEST.md
git commit -m "test: github actions deployment"
git push origin main

# 3. Attends 10 secondes

# 4. Vérifie sur Hostinger
ssh user@hostinger-xxx.com "ls -la /home/user/public_html/wp-content/themes/desq-energy-theme | grep TEST"

# 5. Dois voir le fichier TEST.md
# Si oui : ✅ Auto-deploy fonctionne!

# 6. Nettoie le test
rm TEST.md
git add -A
git commit -m "test: cleanup"
git push origin main
```

---

## ÉTAPE 5 — Configuration finale (.gitignore)

Assure-toi que `.gitignore` contient :

```
# Dépendances
node_modules/
vendor/

# Fichiers temp
.DS_Store
Thumbs.db
*.log

# Uploads (non-versionned, trop volumineux)
wp-content/uploads/

# Plugins tiers (optionnel, pour lighter repo)
# wp-content/plugins/

# Fichiers sensibles
.env
.env.local
.htaccess (optionnel)
```

---

## ÉTAPE 6 — Workflow quotidien avec Claude Code

### À chaque session Claude Code :

```bash
# 1. Ouvre le terminal, va dans le dossier
cd /path/to/wordpress/wp-content/themes/desq-energy-theme

# 2. Tire les dernières modifs (au cas où)
git pull origin main

# 3. Lance Claude Code
claude

# → Claude Code code, crée les fichiers

# 4. Après validation locale :
git status                           # Voir ce qui a changé
git add .                            # Stage tous les fichiers
git commit -m "feat: session X - [description]"  # Format : feat/fix/refactor
git push origin main                # Pousse vers GitHub
                                    # ↓ Auto-déploie sur Hostinger
                                    # ↓ Attends 30 secondes
                                    # ✅ Vérifiez sur live

# 5. Teste sur live
curl https://desq-energy.sn/wp-content/themes/desq-energy-theme/CLAUDE.md
```

---

## ÉTAPE 7 — Rollback d'urgence (si problème)

Si une version casse le site :

```bash
# Sur ta machine locale

# Voir les commits
git log --oneline -10

# Revenir à une version précédente
git reset --hard abc1234  # Le hash du bon commit
git push origin main --force

# Hostinger se redéploie automatiquement
# Site restauré en 30 secondes
```

---

## 📱 Panel Hostinger — Points de contrôle

Va régulièrement vérifier :

1. **File Manager** → `/public_html/wp-content/themes/desq-energy-theme/`
   - Les fichiers sont là et à jour
   
2. **WordPress** → Thèmes
   - "DESQ Energy" est activé et pas en erreur

3. **SSH** → Teste une commande
   ```bash
   ssh user@hostinger-xxx.com "wp theme list"
   ```
   - "DESQ Energy" doit être visible

---

## 🔒 Sécurité — Checklist

- [ ] `.env` jamais commité (dans `.gitignore`)
- [ ] Pas de credentials dans le code
- [ ] Repo GitHub = Private
- [ ] Token GitHub = à rotation régulière (90j)
- [ ] SSH key = jamais partagée
- [ ] `.gitignore` contient `wp-content/uploads/`

---

## Commandes Git essentielles

```bash
# Voir le statut
git status

# Voir l'historique
git log --oneline

# Voir les différences
git diff

# Annuler un fichier local
git checkout -- filename.php

# Annuler le dernier commit (avant push)
git reset --soft HEAD~1

# Voir quel serveur est configuré
git remote -v
```

---

## ✅ Checklist avant de lancer Claude Code

- [ ] Repo GitHub créé et cloné localement
- [ ] `.gitignore` configuré
- [ ] Package `desq-specs/` dans le repo
- [ ] SSH connecté à Hostinger
- [ ] Auto-deploy script testé (TEST.md déployé)
- [ ] `git status` propre (rien en attente)
- [ ] Terminal ouvert dans le dossier du theme
- [ ] Prêt pour `claude`

---

## Commandes rapides (copier-coller)

### Setup complet (one-liner)

```bash
cd /path/to/wordpress/wp-content/themes && \
git clone https://github.com/TONUSERNAME/desq-energy-theme.git && \
cd desq-energy-theme && \
git config user.email "email@gmail.com" && \
git config user.name "DESQ Dev" && \
cp -r /home/claude/desq-specs . && \
git add . && \
git commit -m "chore: initial setup" && \
git push origin main && \
echo "✅ Setup complet!"
```

### Test auto-deploy

```bash
echo "# Test $(date)" > TEST.md && \
git add TEST.md && \
git commit -m "test: github deploy" && \
git push origin main && \
echo "⏳ Attends 30 secondes..." && \
sleep 30 && \
ssh user@hostinger-xxx.com "ls -la /home/user/public_html/wp-content/themes/desq-energy-theme/TEST.md" && \
rm TEST.md && \
git add -A && \
git commit -m "test: cleanup" && \
git push origin main && \
echo "✅ Auto-deploy OK!"
```

---

## Support rapide

| Problème | Solution |
|----------|----------|
| "Git not found" | Installe Git : https://git-scm.com |
| "SSH permission denied" | Demande SSH keys à Hostinger support |
| "401 authentication failed" | Utilise un GitHub Personal Access Token au lieu du password |
| "Files not on Hostinger" | Vérifie le deploy script, relance-le manuellement |
| "wp-content/uploads énorme" | C'est normal, reste en `.gitignore` |

