@echo off
REM Galleria Kamera Chat Service Launcher
REM This script starts the chat service and minimizes the window

title Galleria Kamera Chat Service
color 0A

echo ========================================
echo Galleria Kamera Chat Service
echo ========================================
echo.
echo Starting chat service on port 3001...
echo.
echo Once you see "running on http://localhost:3001"
echo the service is ready to use.
echo.
echo Do NOT close this window while using the marketplace.
echo.
echo ========================================
echo.

cd /d "C:\xampp\htdocs\galleriakamera\buyandsell\gk-chat-service"

REM Check if node_modules exists, if not install dependencies
if not exist "node_modules" (
    echo Installing dependencies...
    call npm install
    echo.
)

REM Start the service
call npm start

pause
