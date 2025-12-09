import express from "express";
import cors from "cors";
import dotenv from "dotenv";
import { GoogleGenerativeAI } from "@google/generative-ai";

dotenv.config();
const app = express();
app.use(cors());
app.use(express.json());

const port = process.env.PORT || 3001;

// Validate API key
if (!process.env.GEMINI_API_KEY) {
  console.error("❌ GEMINI_API_KEY is not set in .env file");
  process.exit(1);
}

const genAI = new GoogleGenerativeAI(process.env.GEMINI_API_KEY);

/**
 * Simple chat endpoint.
 * Expects JSON: { "messages": [{"role":"user","parts":[{"text":"..."}]}] }
 */
app.post("/api/chat", async (req, res) => {
  try {
    const { messages } = req.body;
    console.log('📨 Received chat request with', messages?.length || 0, 'messages');

    if (!messages || !Array.isArray(messages) || messages.length === 0) {
      console.error('❌ Invalid messages format');
      return res.status(400).json({ 
        ok: false, 
        error: "Messages array is required" 
      });
    }

    // Use gemini-2.5-flash (available in free tier)
    const model = genAI.getGenerativeModel({ 
      model: "gemini-2.5-flash"
    });

    // Extract conversation history (all except last message)
    const history = messages.slice(0, -1).map(msg => ({
      role: msg.role === "model" ? "model" : "user",
      parts: msg.parts || [{ text: msg.content || "" }]
    }));

    // Start a chat session with history
    const chat = model.startChat({
      history: history,
      generationConfig: {
        maxOutputTokens: 500,
        temperature: 0.7,
      },
    });

    // Get the last user message
    const lastMessage = messages[messages.length - 1];
    const userText = lastMessage.parts?.[0]?.text || lastMessage.content || "";
    console.log('💬 User message:', userText.substring(0, 50) + '...');

    // Add system context to first message
    const contextualMessage = history.length === 0 
      ? `You are a helpful assistant for Galleria Kamera, an online camera marketplace. Answer questions about cameras, recommendations, and orders. Keep responses conversational and friendly. ${userText}`
      : userText;

    // Send the message and get response
    console.log('🤖 Calling Gemini API...');
    const result = await chat.sendMessage(contextualMessage);
    
    // Make sure we have a valid response
    if (!result || !result.response) {
      throw new Error('No response from Gemini API');
    }
    
    const responseText = result.response.text();
    
    if (!responseText) {
      throw new Error('Empty response text from Gemini API');
    }
    
    console.log('✅ Got response:', responseText.substring(0, 100) + '...');

    res.json({ 
      ok: true, 
      text: responseText,
      role: "model"
    });

  } catch (err) {
    console.error("❌ Chat error:", err.message);
    console.error("Full error:", err);
    
    // Provide more specific error messages
    let errorMessage = err.message || err.toString();
    
    if (errorMessage.includes("API_KEY_INVALID")) {
      errorMessage = "Invalid API key. Please check your GEMINI_API_KEY in .env file.";
    } else if (errorMessage.includes("404")) {
      errorMessage = "Model not available. Please verify your API key has access to Gemini models.";
    } else if (errorMessage.includes("quota")) {
      errorMessage = "API quota exceeded. Please try again later.";
    }
    
    res.status(500).json({ 
      ok: false, 
      error: errorMessage
    });
  }
});

// Health check endpoint
app.get("/health", (req, res) => {
  res.json({ ok: true, message: "GK chat service is running" });
});

// Test endpoint to verify API key
app.get("/test", async (req, res) => {
  try {
    const model = genAI.getGenerativeModel({ model: "gemini-2.5-flash" });
    const result = await model.generateContent("Say hello in one sentence");
    const response = await result.response;
    res.json({ 
      ok: true, 
      message: "API key is valid",
      test_response: response.text()
    });
  } catch (err) {
    res.status(500).json({ 
      ok: false, 
      error: err.message 
    });
  }
});

app.listen(port, () => {
  console.log(`🚀 GK chat service running on http://localhost:${port}`);
  console.log(`📡 Chat endpoint: POST http://localhost:${port}/api/chat`);
  console.log(`🏥 Health check: GET http://localhost:${port}/health`);
  console.log(`🧪 Test API: GET http://localhost:${port}/test`);
});