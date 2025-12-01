<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test Chatbot - TakeCare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/chatbot.css">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .test-container {
      background: white;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 20px 60px rgba(0,0,0,0.3);
      max-width: 600px;
      width: 90%;
    }
    .status-badge {
      display: inline-block;
      padding: 0.25rem 0.75rem;
      border-radius: 9999px;
      font-size: 0.875rem;
      font-weight: 600;
    }
    .status-success {
      background: #10B981;
      color: white;
    }
    .status-error {
      background: #EF4444;
      color: white;
    }
    .test-button {
      background: linear-gradient(135deg, #D97706, #B45309);
      color: white;
      padding: 0.75rem 1.5rem;
      border-radius: 0.5rem;
      border: none;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s;
    }
    .test-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(217, 119, 6, 0.3);
    }
  </style>
</head>
<body>
  <div class="test-container">
    <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 1rem; color: #1F2937;">
      🤖 Test du Chatbot TakeCare
    </h1>
    
    <div style="margin-bottom: 2rem;">
      <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; color: #374151;">
        📋 Checklist
      </h2>
      
      <div style="space-y: 0.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; padding: 0.75rem; background: #F3F4F6; border-radius: 0.5rem; margin-bottom: 0.5rem;">
          <i class="fas fa-check-circle" style="color: #10B981;"></i>
          <span>Fichiers CSS/JS créés</span>
        </div>
        
        <div style="display: flex; align-items: center; gap: 0.5rem; padding: 0.75rem; background: #F3F4F6; border-radius: 0.5rem; margin-bottom: 0.5rem;">
          <i class="fas fa-check-circle" style="color: #10B981;"></i>
          <span>API endpoint configuré</span>
        </div>
        
        <div style="display: flex; align-items: center; gap: 0.5rem; padding: 0.75rem; background: #FEF3C7; border-radius: 0.5rem; margin-bottom: 0.5rem;">
          <i class="fas fa-exclamation-circle" style="color: #F59E0B;"></i>
          <span>Clé API Groq à configurer</span>
        </div>
      </div>
    </div>
    
    <div style="margin-bottom: 2rem;">
      <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; color: #374151;">
        🔧 Configuration
      </h2>
      
      <div style="background: #1F2937; color: white; padding: 1rem; border-radius: 0.5rem; font-family: monospace; font-size: 0.875rem;">
        <div>1. Ouvrez: <span style="color: #FCD34D;">config/groq.php</span></div>
        <div style="margin-top: 0.5rem;">2. Remplacez: <span style="color: #FCD34D;">gsk_YOUR_API_KEY_HERE</span></div>
        <div style="margin-top: 0.5rem;">3. Par votre clé de: <a href="https://console.groq.com" target="_blank" style="color: #60A5FA;">https://console.groq.com</a></div>
      </div>
    </div>
    
    <div style="margin-bottom: 2rem;">
      <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; color: #374151;">
        🧪 Test rapide
      </h2>
      
      <button class="test-button" onclick="testChatbot()">
        <i class="fas fa-play mr-2"></i>
        Tester le chatbot
      </button>
      
      <div id="test-result" style="margin-top: 1rem;"></div>
    </div>
    
    <div style="padding: 1rem; background: #EFF6FF; border-left: 4px solid #3B82F6; border-radius: 0.5rem;">
      <p style="font-size: 0.875rem; color: #1E40AF;">
        <strong>💡 Astuce :</strong> Le chatbot apparaîtra en bas à droite de l'écran. Cliquez sur le bouton pour l'ouvrir !
      </p>
    </div>
  </div>

  <script src="assets/js/chatbot.js"></script>
  
  <script>
    async function testChatbot() {
      const resultDiv = document.getElementById('test-result');
      resultDiv.innerHTML = '<div style="color: #6B7280;"><i class="fas fa-spinner fa-spin"></i> Test en cours...</div>';
      
      try {
        const response = await fetch('api/chat.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            message: 'Hello, can you help me?',
            language: 'en'
          })
        });
        
        const data = await response.json();
        
        if (data.error && data.error === 'API key not configured') {
          resultDiv.innerHTML = `
            <div style="padding: 1rem; background: #FEF3C7; border-left: 4px solid #F59E0B; border-radius: 0.5rem; margin-top: 1rem;">
              <p style="color: #92400E; font-weight: 600;">⚠️ Clé API non configurée</p>
              <p style="color: #92400E; font-size: 0.875rem; margin-top: 0.5rem;">
                Le chatbot fonctionne mais vous devez configurer votre clé API Groq dans <code>config/groq.php</code>
              </p>
            </div>
          `;
        } else if (data.response) {
          resultDiv.innerHTML = `
            <div style="padding: 1rem; background: #D1FAE5; border-left: 4px solid #10B981; border-radius: 0.5rem; margin-top: 1rem;">
              <p style="color: #065F46; font-weight: 600;">✅ Chatbot opérationnel !</p>
              <p style="color: #065F46; font-size: 0.875rem; margin-top: 0.5rem;">
                Réponse: "${data.response}"
              </p>
            </div>
          `;
        } else {
          throw new Error('Invalid response');
        }
      } catch (error) {
        resultDiv.innerHTML = `
          <div style="padding: 1rem; background: #FEE2E2; border-left: 4px solid #EF4444; border-radius: 0.5rem; margin-top: 1rem;">
            <p style="color: #991B1B; font-weight: 600;">❌ Erreur de test</p>
            <p style="color: #991B1B; font-size: 0.875rem; margin-top: 0.5rem;">
              ${error.message}
            </p>
          </div>
        `;
      }
    }
  </script>
</body>
</html>
