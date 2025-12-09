# Chat Service Status & Usage Guide

## ✅ Chat Service is Now Running!

The Galleria Kamera Chat Service is actively running on `http://localhost:3001`

### Current Status
- **Status**: 🟢 Active
- **Port**: 3001
- **Endpoint**: http://localhost:3001/api/chat
- **API Key**: Configured in .env file

## How to Keep It Running

### Option 1: Batch File (Recommended for Daily Use)
1. Go to: `C:\xampp\htdocs\galleriakamera\buyandsell\gk-chat-service`
2. Double-click: `start-chat-service.bat`
3. A window will open - keep it running while using the marketplace
4. Close the window when done

### Option 2: Auto-Start on System Boot (Recommended for Always-On)
1. Right-click on `enable-auto-start.ps1`
2. Select "Run with PowerShell"
3. Click "Run" if prompted
4. The service will now start automatically when Windows boots

### Option 3: Manual Terminal
```powershell
cd C:\xampp\htdocs\galleriakamera\buyandsell\gk-chat-service
npm start
```

## Quick Test

Try the chat in the marketplace:
1. Go to: http://localhost/galleriakamera/buyandsell/marketplace.php
2. Click the chat bubble (bottom right)
3. Type a message like "Hey" or "Hello"
4. The chatbot should respond with AI-generated answers

## API Endpoints Available

- **POST** `/api/chat` - Send messages to the chatbot
- **GET** `/health` - Check if service is running
- **GET** `/test` - Test the API

## Troubleshooting

| Problem | Solution |
|---------|----------|
| "Unable to connect to chat service" | Make sure the service is running (check terminal) |
| "GEMINI_API_KEY is not set" | Add your API key to `.env` and restart |
| Port 3001 already in use | Kill process: `Get-Process node \| Stop-Process` |
| npm not found | Install Node.js from https://nodejs.org/ |

## Getting Your Google Gemini API Key

1. Visit: https://aistudio.google.com/app/apikey
2. Click "Create API Key"
3. Copy the key
4. Edit `.env` file and replace the placeholder key
5. Restart the service

## Files Created

- `.env` - Configuration file (API key, port)
- `start-chat-service.bat` - Easy Windows batch launcher
- `start-chat-service.ps1` - PowerShell launcher
- `enable-auto-start.ps1` - Set up Windows Task Scheduler
- `SETUP.md` - Detailed setup guide
- This file

## Support

For more details, see `SETUP.md` in the chat service directory.
