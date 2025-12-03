includes/confirmation.php
<?php
$order_id = $_GET['order_id'] ?? 'ORD' . date('YmdHis');

// Fetch order
$stmt = $conn->prepare("SELECT * FROM orders WHERE OrderID = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

// Fetch order items
$stmt_items = $conn->prepare("SELECT * FROM orderitems WHERE OrderID = ?");
$stmt_items->bind_param("i", $order_id);
$stmt_items->execute();
$order_items = $stmt_items->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<section id="confirmation" class="form-section">
    <div class="confirmation-header">
        <i class="fas fa-check-circle"></i>
        <h2>Order Confirmed!</h2>
    </div>
    
    <div class="confirmation-details">
        <div class="order-info">
            <p><strong>Order ID:</strong> <?= htmlspecialchars($order_id) ?></p>
            <p><strong>Order Date:</strong> <?= date('F j, Y g:i A') ?></p>
            <p><strong>Total Amount:</strong> P<?= number_format($_SESSION['order_data']['total'], 2) ?></p>
            <p><strong>Payment Method:</strong> 
                <?= match($_SESSION['order_data']['payment_method']) {
                    'cod' => 'Cash on Delivery',
                    'gcash' => 'GCash',
                    'paymaya' => 'PayMaya',
                    'maribank' => 'Maribank',
                    default => 'Not specified'
                } ?>
            </p>
        </div>
        
        <div class="delivery-info">
            <h3>Delivery Information</h3>
            <p><strong>Name:</strong> <?= htmlspecialchars($_SESSION['order_data']['customer']['first_name'] . ' ' . $_SESSION['order_data']['customer']['last_name']) ?></p>
            <p><strong>Address:</strong> 
                <?= htmlspecialchars($_SESSION['order_data']['delivery_address']['address_line_1']) ?>,
                <?= if (!empty($_SESSION['order_data']['delivery_address']['address_line_2'])): ?>
                    <?= htmlspecialchars($_SESSION['order_data']['delivery_address']['address_line_2']) ?>,
                <?php endif; ?>
                <?= htmlspecialchars($_SESSION['order_data']['delivery_address']['barangay']) ?>,
                <?= htmlspecialchars($_SESSION['order_data']['delivery_address']['city']) ?>,
                <?= htmlspecialchars($_SESSION['order_data']['delivery_address']['region']) ?>,
                <?= htmlspecialchars($_SESSION['order_data']['delivery_address']['postal_code']) ?>
            </p>
            <p><strong>Contact:</strong> +63<?= htmlspecialchars($_SESSION['order_data']['customer']['mobile']) ?></p>
            <?php if (!empty($_SESSION['order_data']['customer']['alternate_mobile'])): ?>
                <p><strong>Alternate Contact:</strong> +63<?= htmlspecialchars($_SESSION['order_data']['customer']['alternate_mobile']) ?></p>
            <?php endif; ?>
        </div>
        
        <div class="order-items">
            <h3>Order Items</h3>
            <?php foreach ($_SESSION['order_data']['items'] as $item): ?>
            <div class="order-item">
                <span class="item-name"><?= htmlspecialchars($item['name']) ?> (<?= htmlspecialchars($item['variant']) ?>)</span>
                <span class="item-price">P<?= number_format($item['price'], 2) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="confirmation-actions">
        <p>You will receive a confirmation email at <strong><?= htmlspecialchars($_SESSION['order_data']['customer']['email']) ?></strong> shortly.</p>
        
        <div class="navigation-buttons">
            <a href="my-purchases.php" class="btn-primary">View My Purchases</a>
            <a href="../../marketplace.php" class="btn-secondary">Continue Shopping</a>
        </div>
    </div>
</section>