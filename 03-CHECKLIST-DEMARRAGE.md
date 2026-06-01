# ✅ CHECKLIST DÉMARRAGE RAPIDE

> Suis cette checklist étape par étape. Tu peux cocher au fur et à mesure.

---

## 🟦 AVANT DE COMMENCER (5 minutes)

- [ ] Git installé ? `git --version`
- [ ] Compte GitHub créé ? https://github.com
- [ ] Accès SSH à Hostinger activé ? (Panel → Security → SSH Keys)
- [ ] WordPress local ou sur Hostinger ? (précise où)

---

## 🟦 ÉTAPE 1 — Créer repo GitHub (3 minutes)

```bash
# Sur GitHub.com :
# 1. New Repository
# 2. Name: desq-energy-theme
# 3. Private
# 4. Add README + WordPress .gitignore
# 5. Create

# Copie l'URL HTTPS du repo
```

- [ ] Repo créé
- [ ] URL copiée : `https://github.com/.../desq-energy-theme.git`

---

## 🟦 ÉTAPE 2 — Clone en local (2 minutes)

```bash
# Sur ta machine (terminal) :

cd /path/to/wordpress/wp-content/themes
git clone https://github.com/TONUSERNAME/desq-energy-theme.git
cd desq-energy-theme

# Configure Git
git config user.email "tonemail@gmail.com"
git config user.name "DESQ Development"

# Vérifie
git status
```

- [ ] Clonage réussi
- [ ] `git status` affiche "On branch main, nothing to commit"

---

## 🟦 ÉTAPE 3 — Ajoute les specs (1 minute)

```bash
# Toujours dans le dossier desq-energy-theme :

# Copie le package de specs
cp -r /home/claude/desq-specs .

# Ou si tu l'as en ZIP, décompresse-le ici

# Vérifie
ls -la desq-specs/
```

- [ ] Dossier `desq-specs/` présent
- [ ] Fichiers visibles : `CLAUDE.md`, `README.md`, `ROADMAP-SESSIONS.md`

---

## 🟦 ÉTAPE 4 — Premier commit et push (2 minutes)

```bash
# Ajoute tout
git add .

# Commit
git commit -m "chore: initial setup with specs package"

# Pousse
git push origin main

# Vérifie sur GitHub.com (reload la page)
```

- [ ] Push réussi (sans erreur 403/401)
- [ ] Fichiers visibles sur GitHub

---

## 🟦 ÉTAPE 5 — Teste SSH à Hostinger (2 minutes)

```bash
# Teste la connexion
ssh user@hostinger-xxx.com "wp version"

# Dois voir : "WordPress 6.x.x" (ou erreur = SSH pas activé)
```

- [ ] SSH fonctionne
- [ ] Commande `wp` reconnue

---

## 🟦 ÉTAPE 6 — Configure auto-deploy (5 minutes)

### Option A : Script simple (recommandé pour commencer)

```bash
# Via SSH à Hostinger :
ssh user@hostinger-xxx.com

# Crée et test le script
cat > ~/deploy.sh << 'EOF'
#!/bin/bash
cd /home/user/public_html/wp-content/themes/desq-energy-theme
git fetch origin
git reset --hard origin/main
echo "[$(date)] ✅ Déploiement réussi" >> ~/deploy.log
EOF

chmod +x ~/deploy.sh
~/deploy.sh

# Sort (Ctrl+D)
exit
```

- [ ] Script créé
- [ ] Script exécuté sans erreur
- [ ] Vérification : `ssh user@hostinger-xxx.com "tail ~/deploy.log"`

### Option B : GitHub Actions (automatique)

Je crée le fichier et tu le commits.

- [ ] Fichier `.github/workflows/deploy.yml` créé
- [ ] Secrets GitHub configurés

---

## 🟦 ÉTAPE 7 — Teste auto-deploy (3 minutes)

```bash
# Sur ta machine locale, dans le dossier du theme :

# Crée un fichier test
echo "# Test $(date)" > TEST.md

# Commit et push
git add TEST.md
git commit -m "test: github deploy"
git push origin main

# Attends 30 secondes

# Vérifie sur Hostinger
ssh user@hostinger-xxx.com "ls desq-energy-theme/TEST.md"

# Dois voir le fichier TEST.md
```

- [ ] Test file créé et pushé
- [ ] Auto-deploy fonctionne (fichier visible sur Hostinger)
- [ ] Nettoyage : supprime TEST.md et recommit

---

## 🟦 ÉTAPE 8 — Prêt pour Claude Code (1 minute)

```bash
# Dans le terminal, dossier desq-energy-theme :
git status

# Doit afficher : "On branch main, nothing to commit"

# Vérifie le CLAUDE.md
cat CLAUDE.md | head -20

# Puis lance Claude Code
claude
```

- [ ] Repo propre (`git status` = rien à commiter)
- [ ] `CLAUDE.md` accessible
- [ ] Terminal prêt

---

## ✅ READY FOR LAUNCH

Tu es prêt pour **Session 1 avec Claude Code** ! 🚀

```bash
# Copie-colle ce prompt à Claude Code :

Lis CLAUDE.md et desq-specs/specs/00-setup.md.
Crée la structure complète du theme enfant WordPress :
- Tous les dossiers (assets/css, assets/js, templates, template-parts, post-types, acf-fields)
- style.css avec en-tête theme
- functions.php de base (setup, enqueue, includes)
- index.php fallback
Vérifie qu'il n'y a aucune erreur PHP. Commit : "chore: initial theme setup".
```

---

## 🆘 Si quelque chose casse

```bash
# Revenir à la version précédente
git log --oneline -5        # Vois les commits

# Revert le dernier
git reset --hard HEAD~1

# ou Revert un commit spécifique
git reset --hard abc1234    # Le hash du bon commit

# Pousse la correction
git push origin main --force
```

---

## 📞 Besoin d'aide ?

| Erreur | Commande à tester |
|--------|-------------------|
| "Git not found" | `which git` ou réinstalle https://git-scm.com |
| "SSH connection refused" | `ssh-keyscan hostinger-xxx.com` |
| "Push failed 403" | Utilise un Personal Access Token, pas password |
| "File not on Hostinger" | `ssh user@hostinger "cd /chemin && git status"` |

---

## 🎯 Recap du workflow quotidien

```
1. Terminal → cd chemin/theme
2. Valide les changements localement (localhost)
3. git add . && git commit -m "..." && git push origin main
4. Attends 30 secondes
5. Vérifie sur live : https://tonsite.sn
6. ✅ Done, une session complétée
```

---

**GO ! 🚀**
