# 🚀 Guide de démarrage rapide - Chatbot TakeCare

## ⚡ Installation en 3 étapes

### 1️⃣ Obtenir votre clé API Groq (GRATUIT)

1. Allez sur **https://console.groq.com**
2. Créez un compte (email + mot de passe)
3. Cliquez sur "**API Keys**" dans le menu
4. Cliquez sur "**Create API Key**"
5. Donnez un nom à votre clé (ex: "TakeCare Chatbot")
6. **Copiez la clé** (elle commence par `gsk_`)

### 2️⃣ Configurer la clé dans le site

Ouvrez le fichier : **`config/groq.php`**

Ligne 6, remplacez :
```php
define('GROQ_API_KEY', 'gsk_YOUR_API_KEY_HERE');
```

Par :
```php
define('GROQ_API_KEY', 'gsk_VotreCléIci');
```

**💾 Sauvegardez le fichier !**

### 3️⃣ Tester le chatbot

Option A - **Test rapide** :
- Ouvrez : `http://votre-site.com/test_chatbot.php`
- Cliquez sur "Tester le chatbot"
- Vous devriez voir ✅ "Chatbot opérationnel !"

Option B - **Test sur le site** :
- Ouvrez n'importe quelle page du site
- Regardez en bas à droite → bouton orange avec icône 💬
- Cliquez dessus pour ouvrir le chat
- Tapez "Hello" et appuyez sur Entrée

## ✅ C'est tout ! Le chatbot est prêt

---

## 🎨 Personnalisation rapide

### Changer le nom du chatbot

Dans `config/groq.php` :
```php
define('CHATBOT_NAME', 'Votre Nom Ici');
define('CHATBOT_AVATAR', '🤖'); // Changez l'emoji
```

### Changer les couleurs

Dans `assets/css/chatbot.css` (ligne 12-13) :
```css
#chatbot-button {
  background: linear-gradient(135deg, #D97706, #B45309);
}
```
Remplacez par vos couleurs préférées !

### Modifier les suggestions rapides

Dans `assets/js/chatbot.js` (ligne 110-120), modifiez :
```javascript
<div class="chat-suggestion" onclick="chatbot.quickMessage('Votre question ?')">
  💼 Votre question ?
</div>
```

---

## 🔧 Dépannage ultra-rapide

### Le chatbot n'apparaît pas ?
1. Vérifiez que vous êtes sur une page du site (pas test_chatbot.php)
2. Ouvrez la console (F12) → vérifiez les erreurs
3. Vérifiez que `chatbot.css` et `chatbot.js` sont chargés

### Le chatbot ne répond pas ?
1. Vérifiez votre clé API dans `config/groq.php`
2. Testez avec : `http://votre-site.com/test_chatbot.php`
3. Si erreur "API key not configured" → clé incorrecte

### Message d'erreur ?
- **"Invalid API response"** → Clé API invalide ou expirée
- **"No database connection"** → Rien à voir avec le chatbot, c'est normal
- **"Sorry, something went wrong"** → Problème réseau ou quota Groq dépassé

---

## 📊 Modèles Groq disponibles

Dans `config/groq.php`, changez le modèle si besoin :

```php
define('GROQ_MODEL', 'llama-3.1-70b-versatile'); // Par défaut - RECOMMANDÉ
```

**Autres options :**
- `mixtral-8x7b-32768` - Excellent pour le français
- `gemma2-9b-it` - Ultra rapide, bon pour FAQ simples
- `llama-3.1-8b-instant` - Très rapide, qualité moyenne

---

## 💰 Limites Groq (compte gratuit)

- ✅ **Gratuit à vie** pour usage modéré
- ✅ **30 requêtes/minute** (largement suffisant)
- ✅ **Pas de carte bancaire** requise
- ✅ **Ultra rapide** (1-3 secondes par réponse)

Si vous dépassez les limites → message d'erreur temporaire

---

## 📞 Besoin d'aide ?

1. **Documentation complète** : `CHATBOT_README.md`
2. **Fonctionnalités détaillées** : `CHATBOT_FEATURES.md`
3. **Doc Groq** : https://console.groq.com/docs
4. **Support Groq** : https://console.groq.com/support

---

## 🎯 Checklist finale

- [x] Fichiers créés (css, js, api, config)
- [ ] Clé API Groq configurée dans `config/groq.php`
- [ ] Test réussi sur `test_chatbot.php`
- [ ] Chatbot visible en bas à droite du site
- [ ] Première conversation testée

**✨ Profitez de votre chatbot intelligent ! ✨**
