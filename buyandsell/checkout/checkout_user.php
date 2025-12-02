<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../assets/css/checkout.css">
</head>
<body>
    <div class="checkout-container">
        <h1>Checkout</h1>
        
        <div class="checkout-layout">
            <!-- Left Column - Forms -->
            <div class="checkout-left">
                <!-- Customer Details Section -->
                <?php include '../includes/checkout_customer_deets.php'; ?>
                
                <!-- Payment Method Section -->
                <?php include '../includes/checkout_payment.php'; ?>
            </div>
            
            <!-- Right Column - Order Summary -->
            <div class="checkout-right">
                <?php include '../includes/checkout_order_summary.php'; ?>
            </div>
        </div>
    </div>
    
    <!-- Success Notification (Hidden by default) -->
    <?php include '../includes/checkout_success_notif.php'; ?>
    
    <script src="../assets/js/checkout.js"></script>
</body>
</html>