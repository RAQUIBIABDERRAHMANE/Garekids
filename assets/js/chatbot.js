/**
 * TakeCare Chatbot with Groq AI
 */

class Chatbot {
  constructor() {
    this.isOpen = false;
    this.messages = [];
    this.isTyping = false;
    
    this.init();
  }

  init() {
    this.createChatbotHTML();
    this.attachEventListeners();
    this.showWelcomeMessage();
  }

  createChatbotHTML() {
    const chatbotHTML = `
      <!-- Chatbot Button -->
      <button id="chatbot-button" aria-label="Open chat">
        <i class="fas fa-comment-dots"></i>
      </button>

      <!-- Chatbot Window -->
      <div id="chatbot-window">
        <!-- Header -->
        <div id="chatbot-header">
          <div id="chatbot-header-info">
            <div id="chatbot-avatar">👶</div>
            <div>
              <div id="chatbot-title">TakeCare Assistant</div>
              <div id="chatbot-status">Online</div>
            </div>
          </div>
          <button id="chatbot-close" aria-label="Close chat">
            <i class="fas fa-times"></i>
          </button>
        </div>

        <!-- Messages -->
        <div id="chatbot-messages"></div>

        <!-- Input Area -->
        <div id="chatbot-input-area">
          <input 
            type="text" 
            id="chatbot-input" 
            placeholder="${this.getLanguage() === 'fr' ? 'Tapez votre message...' : 'Type your message...'}"
            autocomplete="off"
          />
          <button id="chatbot-send" aria-label="Send message">
            <i class="fas fa-paper-plane"></i>
          </button>
        </div>
      </div>
    `;

    document.body.insertAdjacentHTML('beforeend', chatbotHTML);
  }

  attachEventListeners() {
    const button = document.getElementById('chatbot-button');
    const closeBtn = document.getElementById('chatbot-close');
    const sendBtn = document.getElementById('chatbot-send');
    const input = document.getElementById('chatbot-input');

    button.addEventListener('click', () => this.toggleChat());
    closeBtn.addEventListener('click', () => this.closeChat());
    sendBtn.addEventListener('click', () => this.sendMessage());
    
    input.addEventListener('keypress', (e) => {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        this.sendMessage();
      }
    });
  }

  toggleChat() {
    this.isOpen = !this.isOpen;
    const window = document.getElementById('chatbot-window');
    const button = document.getElementById('chatbot-button');
    
    if (this.isOpen) {
      window.classList.add('active');
      button.classList.add('active');
      button.innerHTML = '<i class="fas fa-times"></i>';
      document.getElementById('chatbot-input').focus();
    } else {
      window.classList.remove('active');
      button.classList.remove('active');
      button.innerHTML = '<i class="fas fa-comment-dots"></i>';
    }
  }

  closeChat() {
    this.isOpen = false;
    document.getElementById('chatbot-window').classList.remove('active');
    const button = document.getElementById('chatbot-button');
    button.classList.remove('active');
    button.innerHTML = '<i class="fas fa-comment-dots"></i>';
  }

  showWelcomeMessage() {
    const messagesContainer = document.getElementById('chatbot-messages');
    const lang = this.getLanguage();
    
    const welcomeHTML = `
      <div class="chat-welcome">
        <div class="chat-welcome-icon">👋</div>
        <h3>${lang === 'fr' ? 'Bienvenue !' : 'Welcome!'}</h3>
        <p>${lang === 'fr' 
          ? 'Je suis votre assistant TakeCare. Comment puis-je vous aider ?' 
          : 'I\'m your TakeCare assistant. How can I help you?'}</p>
        
        <div class="chat-suggestions">
          <div class="chat-suggestion" onclick="chatbot.quickMessage('${lang === 'fr' ? 'Quels sont vos services ?' : 'What are your services?'}')">
            💼 ${lang === 'fr' ? 'Quels sont vos services ?' : 'What are your services?'}
          </div>
          <div class="chat-suggestion" onclick="chatbot.quickMessage('${lang === 'fr' ? 'Quels sont vos horaires ?' : 'What are your hours?'}')">
            🕐 ${lang === 'fr' ? 'Quels sont vos horaires ?' : 'What are your hours?'}
          </div>
          <div class="chat-suggestion" onclick="chatbot.quickMessage('${lang === 'fr' ? 'Comment vous contacter ?' : 'How to contact you?'}')">
            📞 ${lang === 'fr' ? 'Comment vous contacter ?' : 'How to contact you?'}
          </div>
        </div>
      </div>
    `;
    
    messagesContainer.innerHTML = welcomeHTML;
  }

  quickMessage(message) {
    document.getElementById('chatbot-input').value = message;
    this.sendMessage();
  }

  async sendMessage() {
    const input = document.getElementById('chatbot-input');
    const message = input.value.trim();
    
    if (!message || this.isTyping) return;
    
    // Clear input
    input.value = '';
    
    // Add user message
    this.addMessage('user', message);
    
    // Show typing indicator
    this.showTyping();
    
    // Send to API
    try {
      // Simple relative path from current page
      const apiPath = 'api/chat.php';
      
      const response = await fetch(apiPath, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          message: message,
          language: this.getLanguage()
        })
      });
      
      const data = await response.json();
      
      // Hide typing indicator
      this.hideTyping();
      
      if (data.error) {
        this.addMessage('bot', data.response || 'Sorry, something went wrong. Please try again.');
      } else {
        this.addMessage('bot', data.response);
      }
      
    } catch (error) {
      console.error('Chat error:', error);
      this.hideTyping();
      this.addMessage('bot', this.getLanguage() === 'fr' 
        ? 'Désolé, une erreur est survenue. Veuillez réessayer.'
        : 'Sorry, an error occurred. Please try again.');
    }
  }

  addMessage(type, content) {
    const messagesContainer = document.getElementById('chatbot-messages');
    
    // Remove welcome message if exists
    const welcome = messagesContainer.querySelector('.chat-welcome');
    if (welcome) welcome.remove();
    
    // Format content for bot messages
    const formattedContent = type === 'bot' ? this.formatBotMessage(content) : this.escapeHtml(content);
    
    const messageHTML = `
      <div class="chat-message ${type}">
        <div class="chat-message-avatar">
          ${type === 'bot' ? '👶' : '<i class="fas fa-user"></i>'}
        </div>
        <div>
          <div class="chat-message-content">${formattedContent}</div>
          <div class="chat-message-time">${this.getTime()}</div>
        </div>
      </div>
    `;
    
    messagesContainer.insertAdjacentHTML('beforeend', messageHTML);
    this.scrollToBottom();
  }

  formatBotMessage(text) {
    // Don't escape HTML - we need to process formatting first
    let formatted = text;
    
    // Format bold text **text** (before escaping)
    formatted = formatted.replace(/\*\*([^*]+)\*\*/g, '<strong class="chat-bold">$1</strong>');
    
    // Now escape remaining HTML but preserve our tags
    const div = document.createElement('div');
    const parts = formatted.split(/(<strong class="chat-bold">.*?<\/strong>)/g);
    formatted = parts.map(part => {
      if (part.startsWith('<strong')) {
        return part;
      }
      div.textContent = part;
      return div.innerHTML;
    }).join('');
    
    // Format line breaks first
    formatted = formatted.replace(/\n/g, '<br>');
    
    // Format numbered lists (after line breaks)
    formatted = formatted.replace(/(\d+)\.\s+\*\*([^*]+)\*\*/g, '<div class="chat-list-item"><span class="chat-list-number">$1</span><strong class="chat-bold">$2</strong></div>');
    formatted = formatted.replace(/(\d+)\.\s+([^<\n]+)/g, '<div class="chat-list-item"><span class="chat-list-number">$1</span>$2</div>');
    
    // Format bullet points (- at start of line)
    formatted = formatted.replace(/<br>\s*-\s+([^<\n]+)/g, '<br><div class="chat-list-item"><span class="chat-bullet">•</span>$1</div>');
    
    // Format phone numbers as clickable links (avoid already linked)
    formatted = formatted.replace(/(\+\d{1,3}\s?\d{3}\s?\d{3}\s?\d{3,4})(?![^<]*<\/a>)/g, '<a href="tel:$1" class="chat-link">$1</a>');
    
    // Format email addresses (avoid already linked)
    formatted = formatted.replace(/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9_-]+)(?![^<]*<\/a>)/g, '<a href="mailto:$1" class="chat-link">$1</a>');
    
    return formatted;
  }

  showTyping() {
    this.isTyping = true;
    const messagesContainer = document.getElementById('chatbot-messages');
    
    const typingHTML = `
      <div class="chat-message bot typing-message">
        <div class="chat-message-avatar">👶</div>
        <div class="typing-indicator">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    `;
    
    messagesContainer.insertAdjacentHTML('beforeend', typingHTML);
    this.scrollToBottom();
    
    // Disable send button
    document.getElementById('chatbot-send').disabled = true;
  }

  hideTyping() {
    this.isTyping = false;
    const typingMessage = document.querySelector('.typing-message');
    if (typingMessage) typingMessage.remove();
    
    // Enable send button
    document.getElementById('chatbot-send').disabled = false;
  }

  scrollToBottom() {
    const messagesContainer = document.getElementById('chatbot-messages');
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
  }

  getTime() {
    const now = new Date();
    return now.toLocaleTimeString(this.getLanguage() === 'fr' ? 'fr-FR' : 'en-US', {
      hour: '2-digit',
      minute: '2-digit'
    });
  }

  getLanguage() {
    // Get language from PHP session or default to 'en'
    const html = document.documentElement;
    return html.lang || 'en';
  }

  escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }
}

// Initialize chatbot when DOM is ready
let chatbot;
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    chatbot = new Chatbot();
  });
} else {
  chatbot = new Chatbot();
}
