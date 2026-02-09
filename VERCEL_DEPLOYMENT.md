# Déploiement sur Vercel

## ✨ Bonne nouvelle : C'est maintenant BEAUCOUP plus simple !

Avec **SQLite**, plus besoin de :
- ❌ Base de données externe (PlanetScale, Railway, etc.)
- ❌ Configuration de credentials
- ❌ Import de schéma
- ❌ Variables d'environnement DB_HOST, DB_USER, etc.

**La base de données est automatiquement initialisée sur Vercel ! 🎉**

## 🚀 Déploiement en 3 étapes

### 1. Poussez sur GitHub

```bash
git init
git add .
git commit -m "Ready for Vercel"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/takecare.git
git push -u origin main
```

### 2. Déployez sur Vercel

#### Option A : Via le Dashboard (Recommandé)
1. Allez sur [vercel.com](https://vercel.com)
2. Cliquez "New Project"
3. Importez votre repository GitHub
4. Cliquez "Deploy"

#### Option B : Via CLI
```bash
npm install -g vercel
vercel login
vercel
```

### 3. Configurez l'API Groq  (Optionnel)

Pour activer le chatbot IA :
1. Dashboard Vercel → Settings → Environment Variables
2. Ajoutez : `GROQ_API_KEY` avec votre clé de [console.groq.com](https://console.groq.com)
3. Redéployez : `vercel --prod`

## 🎯 C'est tout !

Votre application est déployée à : `https://votre-projet.vercel.app`

## ⚠️ Important : À propos de SQLite sur Vercel

### Système de fichiers éphémère

Vercel utilise `/tmp` pour le stockage temporaire :

**Implications :**
- ✅ Base de données auto-initialisée au démarrage
- ✅ Parfait pour demos, prototypes, et MVPs
- ✅ Déploiement ultra-simple
- ⚠️ Les données se réinitialisent après ~15 minutes d'inactivité
- ⚠️ Les données ne persistent pas entre les déploiements
- ⚠️ Chaque région serverless a sa propre base

**Cas d'usage idéaux :**
- Sites de démonstration
- Prototypes et POCs
- Applications avec données peu critiques
- Sites avec < 1000 utilisateurs actifs
- Environnements de développement/test

### Solutions pour la persistance des données

Si vous avez besoin de données persistantes :

#### Option A : Vercel Postgres (Recommandé)
```bash
# Ajoutez Postgres à votre projet Vercel
vercel postgres create
```
- Persistant et fiable
- Intégration native avec Vercel
- [Documentation](https://vercel.com/docs/storage/vercel-postgres)

#### Option B : Turso (SQLite distribué)
- SQLite dans le cloud
- Compatible avec votre code actuel
- Gratuit jusqu'à 9 GB
- [turso.tech](https://turso.tech)

#### Option C : Railway
- Support PHP + base de données natif
- Meilleure alternative à Vercel pour PHP
- MySQL/PostgreSQL/SQLite persistant
```bash
npm install -g @railway/cli
railway login
railway init
railway up
```

## 📁 Configuration des fichiers

### Uploads et stockage

Vercel n'a pas de système de fichiers persistant pour les uploads.

**Solution : Cloudinary (Recommandé)**

1. Créez un compte : [cloudinary.com](https://cloudinary.com)
2. Obtenez vos credentials (cloud_name, api_key, api_secret)
3. Modifiez les fichiers d'upload pour utiliser l'API Cloudinary

Alternative : **AWS S3**, **Vercel Blob Storage**

### Logs

Les logs sur fichiers ne fonctionnent pas. Utilisez :
- **Vercel Dashboard** : Logs en temps réel
- **Sentry** : Suivi des erreurs ([sentry.io](https://sentry.io))
- Console navigateur pour debugging JavaScript

## 📋 Post-Déploiement

### Checklist de sécurité

1. ✅ Changez le mot de passe admin (admin123)
2. ✅ Supprimez ou protégez les fichiers de test :
   - `test_*.php`
   - `create_test_user.php`
   - `add_sample_data.php`
3. ✅ Configurez les variables d'environnement sensibles
4. ✅ Activez HTTPS (automatique sur Vercel)

### Monitoring

Dans Vercel Dashboard :
- **Analytics** : Trafic et performance
- **Speed Insights** : Métriques de vitesse
- **Logs** : Erreurs et debugging

### Nom de domaine personnalisé

1. Dashboard → Settings → Domains
2. Ajoutez votre domaine
3. Configurez les DNS selon les instructions

## 🛠️ Commandes utiles

```bash
# Voir les logs en temps réel
vercel logs --follow

# Lister les déploiements
vercel list

# Redéployer
vercel --prod

# Variables d'environnement
vercel env ls
vercel env add
vercel env rm

# Tester localement
vercel dev
```

## 🔍 Dépannage

### Erreur : "Database connection failed"
- Normal au premier cold start (2-3 secondes d'initialisation)
- Vérifiez les logs Vercel

### Le site est lent au premier chargement
- Cold start normal pour serverless (~2-5 secondes)
- Les requêtes suivantes sont rapides

### Les données disparaissent
- Normal ! SQLite utilise `/tmp` (éphémère)
- Voir [SQLITE_GUIDE.md](SQLITE_GUIDE.md) pour les solutions de persistance

### Les uploads ne fonctionnent pas
- Vercel n'a pas de système de fichiers persistant
- Configurez Cloudinary (voir section Uploads)

## 🚀 Alternatives à Vercel

Si vous avez besoin de :
- Données persistantes
- Système de fichiers en écriture
- Support PHP optimisé

### Railway (Recommandé)
```bash
npm install -g @railway/cli
railway login
railway init
railway up
```

**Avantages :**
- ✅ Base de données persistante incluse
- ✅ Système de fichiers persistant
- ✅ Support PHP natif
- ✅ Prix compétitifs

### Render
- Interface simple
- Support PHP excellent
- Base de données PostgreSQL incluse
- [render.com](https://render.com)

## 📚 Documentation

- [Guide SQLite complet](SQLITE_GUIDE.md)
- [Démarrage rapide](QUICKSTART_VERCEL.md)
- [README principal](README.md)
- [Gestion admin](ADMIN_CREDENTIALS.md)

## Support

Pour des problèmes spécifiques :
- **Vercel** : [Documentation](https://vercel.com/docs) | [Community](https://github.com/vercel/community)
- **SQLite** : [SQLITE_GUIDE.md](SQLITE_GUIDE.md)
- **PHP sur Vercel** : [Runtime Docs](https://vercel.com/docs/runtimes#official-runtimes/php)

---

**Profitez de votre déploiement simplifié avec SQLite ! 🎉**
