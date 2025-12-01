# 🤖 TakeCare Chatbot avec Groq AI

## 📋 Vue d'ensemble

Le chatbot TakeCare utilise l'API Groq pour fournir une assistance intelligente aux visiteurs. Il apparaît en bas à droite de l'écran et peut répondre aux questions sur :
- Les services de garde d'enfants
- Les horaires et disponibilités
- Les informations de contact
- Les conseils généraux sur la garde d'enfants

## 🚀 Installation & Configuration

### 1. Obtenir une clé API Groq

1. Visitez [https://console.groq.com](https://console.groq.com)
2. Créez un compte gratuit
3. Allez dans "API Keys"
4. Cliquez sur "Create API Key"
5. Copiez votre clé (elle commence par `gsk_`)

### 2. Configurer la clé API

Ouvrez le fichier `config/groq.php` et remplacez :

```php
define('GROQ_API_KEY', 'gsk_YOUR_API_KEY_HERE');
```

Par :

```php
define('GROQ_API_KEY', 'gsk_votre_clé_api_ici');
```

### 3. Personnalisation (optionnel)

Dans `config/groq.php`, vous pouvez personnaliser :

```php
// Nom du chatbot
define('CHATBOT_NAME', 'TakeCare Assistant');

// Emoji/avatar du chatbot
define('CHATBOT_AVATAR', '👶');

// Modèle Groq à utiliser
define('GROQ_MODEL', 'llama-3.1-70b-versatile');
// Options: 
// - llama-3.1-70b-versatile (recommandé, très rapide)
// - mixtral-8x7b-32768 (bon pour le français)
// - gemma2-9b-it (léger et rapide)

// Message de bienvenue personnalisé
define('CHATBOT_WELCOME_MESSAGE', 'Hello! How can I help you?');
define('CHATBOT_WELCOME_MESSAGE_FR', 'Bonjour ! Comment puis-je vous aider ?');
```

## 🎨 Personnalisation du design

### Couleurs

Dans `assets/css/chatbot.css`, modifiez les gradients :

```css
/* Bouton du chatbot */
#chatbot-button {
  background: linear-gradient(135deg, #D97706, #B45309);
}

/* Header du chatbot */
#chatbot-header {
  background: linear-gradient(135deg, #D97706, #B45309);
}
```

### Position

Par défaut, le chatbot est en bas à droite. Pour changer :

```css
#chatbot-button {
  bottom: 24px;  /* Distance du bas */
  right: 24px;   /* Distance de droite */
}
```

## 🔧 Fonctionnalités

### ✅ Inclus
- 💬 Chat en temps réel avec Groq AI
- 🌐 Support multi-langue (FR/EN)
- 📱 Design responsive (mobile & desktop)
- 💾 Historique de conversation (session)
- ⌨️ Suggestions de questions rapides
- 🎨 Animations fluides
- 🔒 Gestion d'erreurs robuste

### 🎯 Suggestions rapides

Modifiez les suggestions dans `assets/js/chatbot.js` :

```javascript
<div class="chat-suggestion" onclick="chatbot.quickMessage('Votre question ?')">
  💼 Votre question ?
</div>
```

## 📊 Modèles Groq disponibles

| Modèle | Vitesse | Qualité | Use Case |
|--------|---------|---------|----------|
| **llama-3.1-70b-versatile** | ⚡⚡⚡ | ⭐⭐⭐⭐⭐ | Recommandé (rapide + précis) |
| **mixtral-8x7b-32768** | ⚡⚡ | ⭐⭐⭐⭐ | Excellent pour le français |
| **gemma2-9b-it** | ⚡⚡⚡⚡ | ⭐⭐⭐ | Ultra rapide, bon pour FAQ |

## 🛠️ Dépannage

### Le chatbot ne répond pas

1. **Vérifiez la clé API** : 
   - Ouvrez `config/groq.php`
   - Assurez-vous que la clé commence par `gsk_`

2. **Testez l'API manuellement** :
   ```bash
   curl -X POST /var/www/html/takecare/api/chat.php \
     -H "Content-Type: application/json" \
     -d '{"message":"Hello","language":"en"}'
   ```

3. **Vérifiez les logs PHP** :
   ```bash
   tail -f /var/log/apache2/error.log
   ```

### Erreur "API key not configured"

Le chatbot affichera un message par défaut. Configurez votre clé API dans `config/groq.php`.

### Le chatbot n'apparaît pas

Vérifiez que les fichiers sont bien chargés :
- `assets/css/chatbot.css`
- `assets/js/chatbot.js`

Ouvrez la console du navigateur (F12) pour voir les erreurs.

## 💰 Coûts Groq

Groq offre :
- **Gratuit** : 30 requêtes/minute
- **Très rapide** : ~100-300 tokens/seconde
- **Pas de carte bancaire** requise pour commencer

## 🔐 Sécurité

- ✅ Les clés API sont côté serveur (non exposées au client)
- ✅ Validation des entrées utilisateur
- ✅ Limite de l'historique (10 messages max)
- ✅ Gestion des erreurs sans exposition de détails sensibles

## 📝 Personnalisation du prompt système

Pour adapter le comportement du chatbot, modifiez `CHATBOT_SYSTEM_PROMPT` dans `config/groq.php` :

```php
define('CHATBOT_SYSTEM_PROMPT', 'You are a helpful assistant for TakeCare...
- Add your custom instructions here
- Define the tone and style
- Set boundaries and limitations
');
```

## 🎯 Améliorations futures possibles

- [ ] Bouton pour effacer l'historique
- [ ] Sauvegarde des conversations en base de données
- [ ] Analytics des questions fréquentes
- [ ] Réponses avec liens vers les pages du site
- [ ] Support audio (voice chat)
- [ ] Intégration avec WhatsApp Business API

## 📞 Support

Pour toute question sur le chatbot, consultez :
- [Documentation Groq](https://console.groq.com/docs)
- [Modèles disponibles](https://console.groq.com/docs/models)

---

**Développé pour TakeCare Childcare** 🏠👶
