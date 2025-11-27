<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat - Galleria Kamera</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    
    body {
      font-family: -apple-system, DMSans, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .chat-container {
      background: white;
      border-radius: 16px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.3);
      max-width: 800px;
      width: 100%;
      height: 600px;
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .chat-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 24px;
      text-align: center;
    }

    .chat-header h1 {
      font-size: 24px;
      margin-bottom: 8px;
    }

    .chat-header p {
      font-size: 14px;
      opacity: 0.9;
    }

    .chat-messages {
      flex: 1;
      overflow-y: auto;
      padding: 24px;
      background: #f8f9fa;
    }

    .message {
      margin-bottom: 16px;
      padding: 12px 16px;
      border-radius: 12px;
      max-width: 70%;
      word-wrap: break-word;
      animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .message.user {
      background: #667eea;
      color: white;
      margin-left: auto;
      text-align: right;
    }

    .message.bot {
      background: white;
      border: 2px solid #e0e0e0;
      color: #333;
    }

    .loading {
      display: inline-block;
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: #667eea;
      margin: 0 2px;
      animation: bounce 1.4s infinite ease-in-out both;
    }

    .loading:nth-child(1) { animation-delay: -0.32s; }
    .loading:nth-child(2) { animation-delay: -0.16s; }

    @keyframes bounce {
      0%, 80%, 100% { transform: scale(0); }
      40% { transform: scale(1); }
    }

    .chat-input-area {
      padding: 20px;
      background: white;
      border-top: 2px solid #e0e0e0;
      display: flex;
      gap: 12px;
    }

    .chat-input {
      flex: 1;
      padding: 14px 20px;
      border: 2px solid #e0e0e0;
      border-radius: 24px;
      font-size: 15px;
      outline: none;
      transition: border-color 0.2s;
    }

    .chat-input:focus {
      border-color: #667eea;
    }

    .send-button {
      padding: 14px 28px;
      background: #667eea;
      color: white;
      border: none;
      border-radius: 24px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s;
    }

    .send-button:hover {
      background: #5568d3;
    }

    .send-button:disabled {
      background: #ccc;
      cursor: not-allowed;
    }

    .back-link {
      position: absolute;
      top: 20px;
      left: 20px;
      color: white;
      text-decoration: none;
      padding: 10px 20px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 8px;
      transition: background 0.2s;
    }

    .back-link:hover {
      background: rgba(255, 255, 255, 0.3);
    }

    @media (max-width: 768px) {
      .chat-container {
        height: calc(100vh - 40px);
      }
      
      .message {
        max-width: 85%;
      }
    }
  </style>
</head>
<body>
  <a href="../marketplace.php" class="back-link">← Back to Home</a>

  <div class="chat-container">
    <div class="chat-header">
      <h1>🎥 Galleria Kamera Chat</h1>
      <p>Ask me anything about cameras and photography!</p>
    </div>

    <div id="chatMessages" class="chat-messages">
      <div class="message bot">
        Hello! I'm your Galleria Kamera assistant. I can help you with:
        <br>• Camera recommendations
        <br>• Product information
        <br>• Photography tips
        <br>• General inquiries
        <br><br>How can I help you today?
      </div>
    </div>

    <div class="chat-input-area">
      <input 
        type="text" 
        id="messageInput" 
        class="chat-input" 
        placeholder="Type your message here..."
        autocomplete="off"
      >
      <button id="sendButton" class="send-button">Send</button>
    </div>
  </div>

  <script>
    const API_URL = 'http://localhost:3001/api/chat';
    let conversationHistory = [];
    
    const messagesContainer = document.getElementById('chatMessages');
    const messageInput = document.getElementById('messageInput');
    const sendButton = document.getElementById('sendButton');

    // Send on Enter key
    messageInput.addEventListener('keypress', (e) => {
      if (e.key === 'Enter') {
        sendMessage();
      }
    });

    sendButton.addEventListener('click', sendMessage);

    async function sendMessage() {
      const message = messageInput.value.trim();
      if (!message) return;

      // Disable input
      messageInput.disabled = true;
      sendButton.disabled = true;

      // Add user message
      addMessage(message, 'user');
      messageInput.value = '';

      // Show loading
      const loadingDiv = document.createElement('div');
      loadingDiv.className = 'message bot';
      loadingDiv.innerHTML = '<span class="loading"></span><span class="loading"></span><span class="loading"></span>';
      messagesContainer.appendChild(loadingDiv);
      scrollToBottom();

      try {
        // Add to history
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

        if (data.ok) {
          addMessage(data.text, 'bot');
          conversationHistory.push({
            role: 'model',
            parts: [{ text: data.text }]
          });
        } else {
          addMessage('Sorry, I encountered an error: ' + data.error, 'bot');
        }
      } catch (error) {
        messagesContainer.removeChild(loadingDiv);
        addMessage('Unable to connect. Please make sure the chat service is running.', 'bot');
        console.error('Chat error:', error);
      }

      // Re-enable
      messageInput.disabled = false;
      sendButton.disabled = false;
      messageInput.focus();
    }

    function addMessage(text, type) {
      const messageDiv = document.createElement('div');
      messageDiv.className = `message ${type}`;
      messageDiv.textContent = text;
      messagesContainer.appendChild(messageDiv);
      scrollToBottom();
    }

    function scrollToBottom() {
      messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Focus input on load
    messageInput.focus();
  </script>
</body>
</html>