# Create a Windows Task to Auto-Start Chat Service
# Run this script as Administrator to enable auto-start on system boot

# Elevate to Admin if not already
if (-not ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)) {
    Write-Host "This script requires Administrator privileges. Please run as Administrator." -ForegroundColor Red
    exit
}

$taskName = "Galleria-Kamera-Chat-Service"
$scriptPath = "C:\xampp\htdocs\galleriakamera\buyandsell\gk-chat-service\start-chat-service.ps1"
$logPath = "C:\xampp\htdocs\galleriakamera\buyandsell\gk-chat-service\startup-log.txt"

# Check if task already exists
$existingTask = Get-ScheduledTask -TaskName $taskName -ErrorAction SilentlyContinue

if ($existingTask) {
    Write-Host "Task already exists. Removing old task..." -ForegroundColor Yellow
    Unregister-ScheduledTask -TaskName $taskName -Confirm:$false
}

# Create the task action
$action = New-ScheduledTaskAction `
    -Execute "powershell.exe" `
    -Argument "-NoProfile -ExecutionPolicy Bypass -File `"$scriptPath`"" `
    -WorkingDirectory "C:\xampp\htdocs\galleriakamera\buyandsell\gk-chat-service"

# Create the task trigger (at system startup)
$trigger = New-ScheduledTaskTrigger -AtStartup

# Create task settings
$settings = New-ScheduledTaskSettingsSet `
    -AllowStartIfOnBatteries `
    -DontStopIfGoingOnBatteries `
    -StartWhenAvailable `
    -RunOnlyIfNetworkAvailable `
    -MultipleInstances IgnoreNew

# Register the task
Register-ScheduledTask `
    -TaskName $taskName `
    -Action $action `
    -Trigger $trigger `
    -Settings $settings `
    -User "SYSTEM" `
    -RunLevel Highest `
    -Force | Out-Null

Write-Host "✓ Chat service auto-start task created successfully!" -ForegroundColor Green
Write-Host "The chat service will now start automatically when Windows boots." -ForegroundColor Green
Write-Host ""
Write-Host "To disable auto-start, run:" -ForegroundColor Yellow
Write-Host "Unregister-ScheduledTask -TaskName 'Galleria-Kamera-Chat-Service' -Confirm:`$false" -ForegroundColor Yellow
