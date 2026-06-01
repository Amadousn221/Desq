# ⚙️ MA CONFIGURATION PERSONNALISÉE

> Remplisse ce fichier avec TES infos, puis utilise-le comme référence.

---

## 📋 Mes infos GitHub

```
Username GitHub          : ________________
Repo URL (HTTPS)         : https://github.com/________________/desq-energy-theme.git
GitHub Email             : ________________
Nom (pour Git config)    : ________________
Token Personal Access    : ghp_________________  ⚠️ GARDE SECRET
```

### Copie-colle tes infos ici :
```bash
export GH_USERNAME="TonUsername"
export GH_REPO_URL="https://github.com/TonUsername/desq-energy-theme.git"
export GH_EMAIL="tonemail@gmail.com"
export GH_NAME="DESQ Development"
```

---

## 🖥️ Mes infos Hostinger

```
Domain / Subdomain       : ________________
SSH Host                 : ________________ (user@hostinger-xxx.com)
SSH Username             : ________________
Chemin WordPress         : /home/________________/public_html
Chemin Theme             : /home/________________/public_html/wp-content/themes/desq-energy-theme
```

### Copie-colle tes infos ici :
```bash
export HOSTINGER_HOST="user@hostinger-xxx.com"
export HOSTINGER_USER="user"
export HOSTINGER_DOMAIN="https://desqenergy.com/"
export HOSTINGER_THEME_PATH="/home/user/public_html/wp-content/themes/desq-energy-theme"
```

### Test SSH (vérifie la connexion)
```bash
ssh $HOSTINGER_HOST "echo 'SSH OK!' && wp version"
```

---

## 📂 Chemin local (ta machine)

```
Chemin WordPress local   : ________________
Chemin Theme local       : ________________/wp-content/themes/desq-energy-theme
```

### Copie-colle tes infos ici :
```bash
export LOCAL_WP_PATH="/path/to/wordpress"
export LOCAL_THEME_PATH="$LOCAL_WP_PATH/wp-content/themes/desq-energy-theme"
```

### Test local
```bash
cd $LOCAL_THEME_PATH
git status  # Doit voir le repo
wp theme list  # Doit lister les thèmes
```

---

## 🔐 Sécurité — Checklist

- [ ] Token GitHub = **JAMAIS** partagé, **JAMAIS** commité
- [ ] Passwords = jamais en texte clair dans les fichiers
- [ ] `.gitignore` contient les fichiers sensibles
- [ ] Repo GitHub = **Private**
- [ ] SSH keys = permissions `600` (`chmod 600 ~/.ssh/id_rsa`)

---

## 🚀 Commands rapides (à adapter)

### Clone et setup initial
```bash
cd $LOCAL_WP_PATH/wp-content/themes
git clone $GH_REPO_URL
cd desq-energy-theme
git config user.email "$GH_EMAIL"
git config user.name "$GH_NAME"
git pull origin main
```

### Push après une session Claude Code
```bash
cd $LOCAL_THEME_PATH
git add .
git commit -m "feat: session X - description"
git push origin main
```

### Vérifie le déploiement
```bash
# Attends 30 secondes après le push, puis :
ssh $HOSTINGER_HOST "cd $HOSTINGER_THEME_PATH && git log -1 --oneline"
```

### Vérifiez sur le site live
```bash
curl "$HOSTINGER_DOMAIN/wp-content/themes/desq-energy-theme/CLAUDE.md" | head -5
```

---

## 📝 Notes

Ajoute tes notes ici au fur et à mesure :

```
Session 1 : ________________
Session 2 : ________________
Issues rencontrées : ________________
```

---

## 📞 Contacts & support

- **Hostinger Support** : https://support.hostinger.com
- **GitHub Docs** : https://docs.github.com
- **WP-CLI** : https://developer.wordpress.org/cli

---

**⚠️ Une fois rempli : SAVE THIS FILE → NE PARTAGE PAS (contient tes infos privées)**
