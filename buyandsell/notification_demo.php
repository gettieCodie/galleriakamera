<?php
// Simple demo page - no authentication required for testing
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toast Notification System - Demo</title>
    <link rel="stylesheet" href="assets/css/notifications.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .demo-card {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .demo-card h1 {
            color: #111;
            margin-bottom: 10px;
            font-size: 32px;
        }

        .demo-card p {
            color: #666;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .demo-section {
            margin-bottom: 40px;
        }

        .demo-section h2 {
            color: #333;
            font-size: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .demo-section h2 i {
            font-size: 24px;
        }

        .button-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
            margin-bottom: 20px;
        }

        .demo-btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            white-space: nowrap;
        }

        .demo-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .demo-btn:active {
            transform: translateY(0);
        }

        /* Button Colors */
        .btn-success {
            background: #10b981;
            color: white;
        }

        .btn-error {
            background: #ef4444;
            color: white;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-info {
            background: #3b82f6;
            color: white;
        }

        .btn-loading {
            background: #6366f1;
            color: white;
        }

        .demo-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 30px 0;
        }

        .code-block {
            background: #f3f4f6;
            border-left: 4px solid #667eea;
            padding: 16px;
            border-radius: 8px;
            margin-top: 15px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: #374151;
            overflow-x: auto;
            line-height: 1.5;
        }

        .feature-list {
            list-style: none;
            padding: 0;
        }

        .feature-list li {
            padding: 10px 0;
            color: #555;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .feature-list li:before {
            content: "✓";
            color: #10b981;
            font-weight: bold;
            font-size: 18px;
        }

        .notification-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .notification-row {
                grid-template-columns: 1fr;
            }

            .button-grid {
                grid-template-columns: 1fr;
            }

            .demo-card {
                padding: 20px;
            }

            .demo-card h1 {
                font-size: 24px;
            }
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            color: white;
            font-size: 14px;
        }

        .status-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .status-success {
            background: #10b981;
        }

        .status-error {
            background: #ef4444;
        }

        .status-warning {
            background: #f59e0b;
        }

        .status-info {
            background: #3b82f6;
        }

        .status-loading {
            background: #6366f1;
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="demo-card">
            <h1>🎉 Toast Notification System</h1>
            <p>A beautiful and responsive notification system for your admin dashboard. Click the buttons below to see different notification types in action.</p>

            <!-- Success Notifications -->
            <div class="demo-section">
                <h2><span class="status-indicator status-success"></span>Success Notifications</h2>
                <div class="button-grid">
                    <button class="demo-btn btn-success" onclick="showSuccessBasic()">
                        <i class="fas fa-check-circle"></i>
                        Basic Success
                    </button>
                    <button class="demo-btn btn-success" onclick="showSuccessOrder()">
                        <i class="fas fa-shopping-cart"></i>
                        Order Updated
                    </button>
                </div>
                <div class="code-block">Toast.success('Title', 'Message text', duration)</div>
            </div>

            <!-- Error Notifications -->
            <div class="demo-section">
                <h2><span class="status-indicator status-error"></span>Error Notifications</h2>
                <div class="button-grid">
                    <button class="demo-btn btn-error" onclick="showErrorBasic()">
                        <i class="fas fa-times-circle"></i>
                        Basic Error
                    </button>
                    <button class="demo-btn btn-error" onclick="showErrorValidation()">
                        <i class="fas fa-exclamation-circle"></i>
                        Validation Error
                    </button>
                </div>
                <div class="code-block">Toast.error('Title', 'Message text', duration)</div>
            </div>

            <!-- Warning Notifications -->
            <div class="demo-section">
                <h2><span class="status-indicator status-warning"></span>Warning Notifications</h2>
                <div class="button-grid">
                    <button class="demo-btn btn-warning" onclick="showWarningBasic()">
                        <i class="fas fa-exclamation-triangle"></i>
                        Basic Warning
                    </button>
                    <button class="demo-btn btn-warning" onclick="showWarningConfirm()">
                        <i class="fas fa-info-circle"></i>
                        Important Notice
                    </button>
                </div>
                <div class="code-block">Toast.warning('Title', 'Message text', duration)</div>
            </div>

            <!-- Info Notifications -->
            <div class="demo-section">
                <h2><span class="status-indicator status-info"></span>Info Notifications</h2>
                <div class="button-grid">
                    <button class="demo-btn btn-info" onclick="showInfoBasic()">
                        <i class="fas fa-info-circle"></i>
                        Basic Info
                    </button>
                    <button class="demo-btn btn-info" onclick="showInfoUpdate()">
                        <i class="fas fa-bell"></i>
                        Update Available
                    </button>
                </div>
                <div class="code-block">Toast.info('Title', 'Message text', duration)</div>
            </div>

            <!-- Loading Notifications -->
            <div class="demo-section">
                <h2><span class="status-indicator status-loading"></span>Loading Notifications</h2>
                <div class="button-grid">
                    <button class="demo-btn btn-loading" onclick="showLoadingDemo()">
                        <i class="fas fa-hourglass-start"></i>
                        Start Loading
                    </button>
                    <button class="demo-btn btn-loading" onclick="showCompleteFlow()">
                        <i class="fas fa-sync"></i>
                        Full Flow Demo
                    </button>
                </div>
                <div class="code-block">const id = Toast.loading('Title', 'Message')<br>Toast.remove(id)</div>
            </div>

            <div class="demo-divider"></div>

            <!-- Features Section -->
            <div class="demo-section">
                <h2><i class="fas fa-star"></i> Features</h2>
                <ul class="feature-list">
                    <li>Automatic dismissal with progress bar</li>
                    <li>Manual close button</li>
                    <li>Smooth slide-in/out animations</li>
                    <li>Responsive design (mobile-friendly)</li>
                    <li>Dark mode support</li>
                    <li>Customizable duration and options</li>
                    <li>Icon indicators</li>
                    <li>Stack multiple notifications</li>
                    <li>No dependencies (vanilla JS)</li>
                    <li>Lightweight (~7KB total)</li>
                </ul>
            </div>

            <!-- Usage Section -->
            <div class="demo-section">
                <h2><i class="fas fa-code"></i> Quick Usage</h2>
                <div class="code-block">
// Success<br>
Toast.success('Title', 'Message');<br>
<br>
// Error<br>
Toast.error('Title', 'Message');<br>
<br>
// Loading<br>
const id = Toast.loading('Title', 'Message');<br>
Toast.remove(id);<br>
<br>
// Custom<br>
Toast.show({\<br>
&nbsp;&nbsp;type: 'success',<br>
&nbsp;&nbsp;title: 'Done!',<br>
&nbsp;&nbsp;message: 'Operation complete',<br>
&nbsp;&nbsp;duration: 5000<br>
});
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🚀 Toast Notification System Demo | Integrated with Admin Dashboard</p>
        </div>
    </div>

    <!-- Load the notification system -->
    <script src="assets/js/notifications.js"></script>

    <script>
        // Success Examples
        function showSuccessBasic() {
            Toast.success('Success!', 'Your action was completed successfully');
        }

        function showSuccessOrder() {
            Toast.success('Order Updated', 'Order #12345 status changed to Shipped', 5000);
        }

        // Error Examples
        function showErrorBasic() {
            Toast.error('Oops!', 'Something went wrong. Please try again.');
        }

        function showErrorValidation() {
            Toast.error('Validation Error', 'Please check the highlighted fields and try again.');
        }

        // Warning Examples
        function showWarningBasic() {
            Toast.warning('Warning', 'Please review this action before continuing.');
        }

        function showWarningConfirm() {
            Toast.warning('Important', 'This action cannot be undone.');
        }

        // Info Examples
        function showInfoBasic() {
            Toast.info('Information', 'Here is some useful information for you.');
        }

        function showInfoUpdate() {
            Toast.info('New Update', 'A new version is available. Please refresh the page.');
        }

        // Loading Example
        function showLoadingDemo() {
            const id = Toast.loading('Processing', 'Please wait while we process your request...');
            
            setTimeout(() => {
                Toast.remove(id);
                Toast.success('Complete', 'Operation finished successfully!');
            }, 3000);
        }

        // Complete Flow Demo
        function showCompleteFlow() {
            // Step 1: Loading
            const loadingId = Toast.loading('Step 1/3', 'Initializing process...');
            
            setTimeout(() => {
                Toast.remove(loadingId);
                Toast.info('Step 2/3', 'Processing your data...');
                
                setTimeout(() => {
                    Toast.success('Step 3/3', 'Finalizing operation...');
                    
                    setTimeout(() => {
                        Toast.success('Complete!', 'All steps completed successfully!', 5000);
                    }, 1000);
                }, 1500);
            }, 1500);
        }
    </script>
</body>
</html>
