# 🎯 Chat Service Quick Reference Card

## To Start Using the Chatbot:

### 1️⃣ Get API Key (2 min)
```
Go to: https://aistudio.google.com/app/apikey
Click: "Create API Key"
Copy: The key that appears
```

### 2️⃣ Add to Configuration (1 min)
```
File: C:\xampp\htdocs\galleriakamera\buyandsell\gk-chat-service\.env

Change:
GEMINI_API_KEY=

To:
GEMINI_API_KEY=AIzaSy_YOUR_KEY_HERE
```

### 3️⃣ Restart Service (30 sec)
```
Double-click: START.bat
Wait for: "🚀 GK chat service running on http://localhost:3001"
```

### 4️⃣ Test (1 min)
```
Open: http://localhost/galleriakamera/buyandsell/marketplace.php
Click: Chat bubble (bottom right)
Type: "Hello"
Result: Chatbot responds with AI answer ✅
```

---

## Every Day: Just Double-Click This

📁 Location:
```
C:\xampp\htdocs\galleriakamera\buyandsell\gk-chat-service\START.bat
```

That's it! Keep the window open while using the marketplace.

---

## API Key Reference

- **Where to get**: https://aistudio.google.com/app/apikey
- **Format**: Starts with `AIzaSy`
- **Cost**: Free (Google's free tier)
- **Limits**: 15 requests/min, 1M tokens/day
- **Security**: Keep in .env (it's in .gitignore)

---

## Status Indicators

✅ `🚀 GK chat service running on http://localhost:3001`
→ Service is working!

❌ `API key not valid. Please pass a valid API key.`
→ Need to add/fix API key in .env

❌ `Unable to connect to chat service`
→ START.bat window not open

---

## Files Explained

| File | Purpose | Use |
|------|---------|-----|
| `START.bat` | Launch service | Double-click daily |
| `.env` | Configuration | Add API key here |
| `GET_API_KEY.md` | Detailed guide | Follow for API key |
| `RUNNING.md` | Full documentation | Reference guide |
| `enable-auto-start.ps1` | Optional auto-start | Run once if wanted |

---

## Emergency Reset

If something goes wrong:

1. **Close the service window** (Ctrl+C or close button)
2. **Check the .env file** - is API key there?
3. **Double-click START.bat** - restart the service
4. **Refresh marketplace** - browser cache clear (Ctrl+Shift+R)

---

## One-Time Setup Checklist

- [ ] Got API key from https://aistudio.google.com/app/apikey
- [ ] Added API key to `.env` file
- [ ] Restarted service (START.bat)
- [ ] Tested chat in marketplace
- [ ] All working! ✅

---

## Support & Docs

- **Step-by-step API key setup**: `GET_API_KEY.md`
- **Troubleshooting & usage**: `RUNNING.md`
- **Technical details**: `SETUP.md`
- **Full status report**: `CHAT_SERVICE_STATUS.md`

All files are in: `C:\xampp\htdocs\galleriakamera\buyandsell\gk-chat-service\`

---

## 🚀 Ready to Go!

The infrastructure is set. Just add your free API key and the chatbot will be live!

Questions? Check the documentation files or retry from Step 1.
