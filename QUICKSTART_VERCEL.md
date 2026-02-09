# Guide Rapide de Déploiement Vercel

## ⚡ Déploiement en 2 Minutes

**Bonne nouvelle !** Avec SQLite, le déploiement est ultra-simple. **Aucune base de données externe nécessaire !**

## 🚀 Étapes de déploiement

### Étape 1 : Déployez sur Vercel

#### Via GitHub (Recommandé)
```bash
# 1. Poussez votre code sur GitHub
git init
git add .
git commit -m "Initial commit"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/takecare.git
git push -u origin main
```

2. Allez sur [vercel.com](https://vercel.com)
3. Cliquez sur "New Project"
4. Importez votre repository
5. Cliquez sur "Deploy"

#### Via CLI
```bash
# 1. Installez Vercel CLI
npm install -g vercel

# 2. Connectez-vous
vercel login

# 3. Déployez
vercel

# 4. Pour la production
vercel --prod
```

### Étape 2 : Configurez l'API Groq (Optionnel)

Si vous voulez le chatbot IA :

1. Dans Vercel Dashboard → Settings → Environment Variables
2. Ajoutez :
   ```
   GROQ_API_KEY=votre-groq-api-key
   ```
3. Obtenez une clé sur [console.groq.com](https://console.groq.com)

### Étape 3 : Changez le mot de passe admin

**Important !** Changez le mot de passe par défaut :

```
Email: admin@gardekids.com
Password: admin123
```

Voir [ADMIN_CREDENTIALS.md](ADMIN_CREDENTIALS.md) pour les instructions.

Pour les uploads (galerie, images), utilisez Cloudinary :

1. Créez un compte sur [cloudinary.com](https://cloudinary.com)
2. Installez le SDK PHP :
```bash
composer require cloudinary/cloudinary_php
```
3. Mettez à jour `submit_testimonial.php` et `admin/gallery.php`

### Étape 5 : Testez votre déploiement

Visitez l'URL fournie par Vercel et vérifiez :
- ✅ La page d'accueil se charge
- ✅ La connexion à la base de données fonctionne
- ✅ Le chatbot répond (si GROQ_API_KEY est configuré)
- ✅ Les formulaires fonctionnent

## 🚨 Dépannage

### La page ne se charge pas
- Consultez les logs : `vercel logs --follow`
- Vérifiez le Dashboard Vercel → Deployments → Logs

### Le chatbot ne fonctionne pas
- Vérifiez que GROQ_API_KEY est configuré
- Testez votre clé API sur console.groq.com

### Les uploads ne fonctionnent pas
- Normal ! Vercel n'a pas de système de fichiers persistant
- Utilisez Cloudinary (voir ci-dessus)

## 📱 Commandes Utiles

```bash
# Voir les logs en temps réel
vercel logs --follow

# Lister les déploiements
vercel list

# Supprimer un déploiement
vercel remove [deployment-url]

# Réinitialiser les variables d'environnement
vercel env rm DB_PASS
vercel env add DB_PASS

# Tester localement
vercel dev
```

## 🎯 Prochaines Étapes

1. ✅ Configurez un nom de domaine personnalisé
2. ✅ Activez les analyses Vercel
3. ✅ Configurez les alertes d'erreur
4. ✅ Mettez en place un backup automatique de la base de données
5. ✅ Ajoutez un CDN pour les assets statiques

## 💡 Conseil Pro

Si vous rencontrez trop de limitations avec Vercel pour PHP, considérez **Railway** :

```bash
npm install -g @railway/cli
railway login
railway init
railway add --database mysql
railway up
```

Railway offre :
- ✅ Support PHP natif
- ✅ Base de données MySQL intégrée
- ✅ Système de fichiers persistant
- ✅ Logs en temps réel
- ✅ Environnements de staging

---

**Besoin d'aide ?** Consultez [VERCEL_DEPLOYMENT.md](VERCEL_DEPLOYMENT.md) pour des instructions détaillées.
