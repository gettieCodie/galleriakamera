# 🔑 Getting Your Google Gemini API Key

The chat service is running but needs a valid Google Gemini API key to respond to messages.

## Step-by-Step Guide

### 1. Go to Google AI Studio
Visit: **https://aistudio.google.com/app/apikey**

### 2. Create API Key
- Click the blue "Create API Key" button
- Choose "Create API key in new project"
- Google will generate a new API key automatically

### 3. Copy Your API Key
- You'll see a popup with your API key
- Click "Copy" to copy it to your clipboard
- ⚠️ **Important**: This key is sensitive - don't share it publicly

### 4. Add to .env File
1. Open this file in a text editor:
   ```
   C:\xampp\htdocs\galleriakamera\buyandsell\gk-chat-service\.env
   ```

2. Find this line:
   ```
   GEMINI_API_KEY=
   ```

3. Paste your API key after the `=`:
   ```
   GEMINI_API_KEY=AIzaSy_YOUR_KEY_HERE_xxxxxxxxxxxxx
   ```

4. Save the file

### 5. Restart the Chat Service
1. Close the chat service terminal window (Ctrl+C or close button)
2. Double-click `START.bat` to restart with the new API key
3. You should see: `🚀 GK chat service running on http://localhost:3001`

### 6. Test the Chatbot
1. Go to: http://localhost/galleriakamera/buyandsell/marketplace.php
2. Click the chat bubble (bottom right)
3. Type a message
4. The chatbot should now respond!

## How to Know It's Working

When the service starts successfully, you should see:
```
🚀 GK chat service running on http://localhost:3001
📡 Chat endpoint: POST http://localhost:3001/api/chat
```

If you see error messages about "API key not valid", follow the steps above.

## Security Notes

- ✅ Keep your API key in the `.env` file (not in version control)
- ✅ The `.env` file is in `.gitignore` so it won't be pushed to GitHub
- ✅ Never share your API key in chat, email, or public repositories
- ✅ You can regenerate your key anytime from the Google AI Studio

## Free Tier Limits

Google's Gemini API is free to use with these limits:
- 15 requests per minute (RPM)
- 1,000,000 tokens per day (TPM)
- This is more than enough for a small marketplace chatbot

## Need Help?

If the API key still doesn't work:
1. Verify you copied the entire key correctly (no spaces at start/end)
2. Check that the key starts with `AIzaSy`
3. Go back to https://aistudio.google.com/app/apikey and create a new key
4. Make sure the key is active (not disabled)

---

**Once you add the API key and restart, the chatbot will be fully functional!** 🎉
