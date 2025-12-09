<!-- Galleriakamera Chat Widget -->
<div id="gk-chat-widget">
  <!-- Chat Toggle Button -->
  <button id="gk-chat-toggle" class="gk-chat-toggle" aria-label="Open chat">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
    </svg>
  </button>

  <!-- Chat Window -->
  <div id="gk-chat-window" class="gk-chat-window" style="display: none;">
    <div class="gk-chat-header">
      <div>
        <h3>🎥 Galleria Kamera Assistant</h3>
        <p>Ask me about cameras!</p>
      </div>
      <button id="gk-chat-close" class="gk-chat-close" aria-label="Close chat">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
    </div>

    <div id="gk-chat-messages" class="gk-chat-messages">
      <div class="gk-chat-message gk-bot">
        Hello! I'm your Galleria Kamera assistant. How can I help you today?
      </div>
    </div>

    <div class="gk-chat-input-area">
      <input 
        type="text" 
        id="gk-chat-input" 
        class="gk-chat-input" 
        placeholder="Type your message..."
        autocomplete="off"
      >
      <button id="gk-chat-send" class="gk-chat-send" aria-label="Send message">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="22" y1="2" x2="11" y2="13"></line>
          <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
        </svg>
      </button>
    </div>
  </div>
</div>

<style>
/* Chat Widget Styles */
#gk-chat-widget {
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 9999;
  font-family: -apple-system, DMSans, sans-serif;
}

.gk-chat-toggle {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border: none;
  color: white;
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: transform 0.3s, box-shadow 0.3s;
}

.gk-chat-toggle:hover {
  transform: scale(1.1);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
}

.gk-chat-window {
  position: absolute;
  bottom: 80px;
  right: 0;
  width: 380px;
  height: 550px;
  background: white;
  border-radius: 16px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.gk-chat-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.gk-chat-header h3 {
  margin: 0;
  font-size: 18px;
  font-weight: 600;
}

.gk-chat-header p {
  margin: 4px 0 0 0;
  font-size: 13px;
  opacity: 0.9;
}

.gk-chat-close {
  background: rgba(255, 255, 255, 0.2);
  border: none;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  color: white;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.2s;
}

.gk-chat-close:hover {
  background: rgba(255, 255, 255, 0.3);
}

.gk-chat-messages {
  flex: 1;
  overflow-y: auto;
  padding: 20px;
  background: #f8f9fa;
}

.gk-chat-message {
  margin-bottom: 16px;
  padding: 12px 16px;
  border-radius: 12px;
  max-width: 85%;
  word-wrap: break-word;
  white-space: normal;
  word-break: break-word;
  animation: slideIn 0.3s ease;
  line-height: 1.5;
  overflow-wrap: break-word;
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.gk-chat-message.gk-user {
  background: #667eea;
  color: white;
  margin-left: auto;
  text-align: right;
  max-width: 85%;
}

.gk-chat-message.gk-bot {
  background: white;
  border: 2px solid #e0e0e0;
  color: #333;
  max-width: 95%;
}

.gk-chat-message strong {
  font-weight: 600;
}

.gk-chat-message em {
  font-style: italic;
}

.gk-chat-message br {
  content: "";
  display: block;
  margin: 8px 0;
}

.gk-chat-loading {
  display: inline-block;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #667eea;
  margin: 0 2px;
  animation: bounce 1.4s infinite ease-in-out both;
}

.gk-chat-loading:nth-child(1) { animation-delay: -0.32s; }
.gk-chat-loading:nth-child(2) { animation-delay: -0.16s; }

@keyframes bounce {
  0%, 80%, 100% { transform: scale(0); }
  40% { transform: scale(1); }
}

.gk-chat-input-area {
  display: flex;
  padding: 16px;
  background: white;
  border-top: 1px solid #e0e0e0;
}

.gk-chat-input {
  flex: 1;
  padding: 12px 16px;
  border: 2px solid #e0e0e0;
  border-radius: 24px;
  outline: none;
  font-size: 14px;
  transition: border-color 0.2s;
}

.gk-chat-input:focus {
  border-color: #667eea;
}

.gk-chat-send {
  margin-left: 8px;
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: #667eea;
  border: none;
  color: white;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.2s;
}

.gk-chat-send:hover {
  background: #5568d3;
}

.gk-chat-send:disabled {
  background: #ccc;
  cursor: not-allowed;
}

/* Mobile Responsive */
@media (max-width: 480px) {
  .gk-chat-window {
    width: calc(100vw - 40px);
    height: calc(100vh - 100px);
    bottom: 80px;
  }
}
</style>

<script>
(function() {
  const API_URL = 'http://localhost:3001/api/chat';
  let conversationHistory = [];
  
  const toggle = document.getElementById('gk-chat-toggle');
  const chatWindow = document.getElementById('gk-chat-window');
  const closeBtn = document.getElementById('gk-chat-close');
  const messagesContainer = document.getElementById('gk-chat-messages');
  const input = document.getElementById('gk-chat-input');
  const sendBtn = document.getElementById('gk-chat-send');

  // Toggle chat window
  toggle.addEventListener('click', () => {
    chatWindow.style.display = chatWindow.style.display === 'none' ? 'flex' : 'none';
    if (chatWindow.style.display === 'flex') {
      input.focus();
    }
  });

  closeBtn.addEventListener('click', () => {
    chatWindow.style.display = 'none';
  });

  // Send message on Enter key
  input.addEventListener('keypress', (e) => {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      sendMessage();
    }
  });

  sendBtn.addEventListener('click', sendMessage);

  async function sendMessage() {
    const message = input.value.trim();
    if (!message) return;

    // Disable input
    input.disabled = true;
    sendBtn.disabled = true;

    // Add user message
    addMessage(message, 'user');
    input.value = '';

    // Show loading indicator
    const loadingDiv = document.createElement('div');
    loadingDiv.className = 'gk-chat-message gk-bot';
    loadingDiv.innerHTML = '<span class="gk-chat-loading"></span><span class="gk-chat-loading"></span><span class="gk-chat-loading"></span>';
    messagesContainer.appendChild(loadingDiv);
    scrollToBottom();

    try {
      // Add to conversation history
      conversationHistory.push({
        role: 'user',
        parts: [{ text: message }]
      });

      // Call API
      const response = await fetch(API_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ messages: conversationHistory })
      });

      const data = await response.json();

      // Remove loading
      messagesContainer.removeChild(loadingDiv);

      if (data.ok && data.text) {
        console.log('Bot response received:', data.text);
        addMessage(data.text, 'bot');
        conversationHistory.push({
          role: 'model',
          parts: [{ text: data.text }]
        });
      } else {
        console.error('API Error:', data.error || 'Unknown error');
        addMessage('Sorry, I encountered an error: ' + (data.error || 'No response text') + '. Please try again.', 'bot');
      }
    } catch (error) {
      messagesContainer.removeChild(loadingDiv);
      addMessage('Unable to connect to chat service. Please check if the server is running.', 'bot');
      console.error('Chat error:', error);
    }

    // Re-enable input
    input.disabled = false;
    sendBtn.disabled = false;
    input.focus();
  }

  function addMessage(text, type) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `gk-chat-message gk-${type}`;
    
    if (type === 'bot') {
      // Format markdown-style text for bot messages
      let formattedText = text
        // Convert **bold** to <strong>
        .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
        // Convert *italic* to <em> (but not **bold**)
        .replace(/(?<!\*)\*(?!\*)(.+?)(?<!\*)\*(?!\*)/g, '<em>$1</em>')
        // Replace newlines with line breaks
        .replace(/\n/g, '<br>');
      
      messageDiv.innerHTML = formattedText;
    } else {
      // User messages are plain text
      messageDiv.textContent = text;
    }
    
    messagesContainer.appendChild(messageDiv);
    scrollToBottom();
  }

  function scrollToBottom() {
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
  }
})();
</script>