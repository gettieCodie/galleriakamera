# Galleria Kamera Chat Service Setup

## Quick Start

The chat service needs to be running for the chatbot to work on the marketplace.

### Option 1: Run with Batch File (Easiest)
1. Double-click `start-chat-service.bat` in this directory
2. A command window will open showing the service is running
3. Keep this window open while using the marketplace

### Option 2: Run with PowerShell
1. Right-click `start-chat-service.ps1`
2. Select "Run with PowerShell"
3. If you get an execution policy error, run PowerShell as Admin and execute:
   ```powershell
   Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
   ```

### Option 3: Manual Start
1. Open Command Prompt or PowerShell
2. Navigate to this directory
3. Run: `npm start`

## Configuration

The `.env` file contains:
- `PORT=3001` - The port the chat service runs on
- `GEMINI_API_KEY` - Your Google Gemini API key

**Important:** Add your actual Google Gemini API key to the `.env` file before starting the service.

## Getting a Google Gemini API Key

1. Go to [Google AI Studio](https://aistudio.google.com/app/apikey)
2. Click "Create API Key"
3. Copy the API key
4. Paste it in the `.env` file as `GEMINI_API_KEY=your_key_here`

## Troubleshooting

**"Unable to connect to chat service"**
- Make sure the chat service is running
- Check that port 3001 is not in use: `netstat -ano | findstr :3001`
- Verify your Gemini API key is correct

**"GEMINI_API_KEY is not set"**
- Add your API key to the `.env` file
- Restart the service

**"npm: command not found"**
- Node.js is not installed or not in PATH
- Download and install Node.js from https://nodejs.org/

## Port Information

The chat service runs on `localhost:3001`

The marketplace looks for it at: `http://localhost:3001/api/chat`
