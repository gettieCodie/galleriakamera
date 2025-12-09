# Galleria Kamera Chat Service Auto-Starter
# This script starts the chat service automatically

$chatServicePath = "C:\xampp\htdocs\galleriakamera\buyandsell\gk-chat-service"
$logFile = "$chatServicePath\chat-service.log"

# Check if node_modules exists
if (-not (Test-Path "$chatServicePath\node_modules")) {
    Write-Host "Installing dependencies..." -ForegroundColor Yellow
    Set-Location $chatServicePath
    npm install
}

# Start the chat service
Write-Host "Starting Galleria Kamera Chat Service on port 3001..." -ForegroundColor Green
Set-Location $chatServicePath
npm start | Tee-Object -FilePath $logFile

# Keep window open
Write-Host "Chat service is running!" -ForegroundColor Green
Read-Host "Press Enter to exit"
