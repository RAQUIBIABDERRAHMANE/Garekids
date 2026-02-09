⚠️ SÉCURITÉ - Action Requise

## 🚨 Clé API Groq exposée

Votre clé API Groq a été détectée dans l'historique Git et doit être révoquée immédiatement.

### Étape 1 : Révoquer la clé exposée ✅ URGENT

1. Allez sur https://console.groq.com/keys
2. Trouvez la clé qui commence par `gsk_wWNz4aJ1...`
3. **SUPPRIMEZ-LA** immédiatement
4. Créez une nouvelle clé API

### Étape 2 : Nettoyer l'historique Git

Deux options :

#### Option A : Nouveau repository (Plus simple)

```bash
# 1. Créer un nouveau repo vide sur GitHub
# 2. Dans votre projet local :
cd d:\APPS\Care

# Sauvegarder .git actuel
Move-Item .git .git.old

# Nouveau repo
git init
git add .
git commit -m "Initial commit with secure config"
git branch -M main
git remote add origin https://github.com/RAQUIBIABDERRAHMANE/Garekids-clean.git
git push -u origin main
```

#### Option B : Nettoyer l'historique (Plus complexe)

```bash
# Installer BFG Repo Cleaner
# https://rtyley.github.io/bfg-repo-cleaner/

# Nettoyer les secrets
bfg --replace-text secrets.txt

# Force push
git push origin main --force
```

### Étape 3 : Configurer la nouvelle clé

```bash
# Créer un fichier .env (ignoré par Git)
echo "GROQ_API_KEY=votre_nouvelle_cle_ici" > .env
```

### Étape 4 : Déployer sur Vercel

Dans Vercel Dashboard → Settings → Environment Variables :
- Ajoutez `GROQ_API_KEY` avec votre nouvelle clé

## ✅ Modifications déjà appliquées

- ✅ `config/groq.php` utilise maintenant `getenv('GROQ_API_KEY')`
- ✅ `.env.example` n'a que des placeholders
- ✅ `.gitignore` corrigé pour ignorer `.env` mais pas `.env.example`

## 📝 Pourquoi c'est important ?

Une fois qu'une clé API est dans l'historique Git public :
- Elle peut être exploitée même après suppression
- Les bots scannent GitHub pour ces clés
- Votre quota Groq pourrait être utilisé par des tiers

**→ Révocation immédiate obligatoire !**

## 🔒 Bonnes pratiques pour l'avenir

1. ✅ Jamais de secrets dans le code
2. ✅ Toujours utiliser des variables d'environnement
3. ✅ `.env` dans `.gitignore`
4. ✅ `.env.example` avec des placeholders seulement
5. ✅ Activer GitHub Secret Scanning (déjà fait !)

---

**Action immédiate :** Révoquer la clé sur https://console.groq.com/keys
