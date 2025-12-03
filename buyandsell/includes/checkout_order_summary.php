<?php
// Get database connection
include "../core/db_connect.php";

// Get user ID from session
$user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

// Initialize variables
$cart_items = [];
$subtotal = 0.00;
$item_count = 0;
$user_email = '';
$user_name = '';

// Fetch data only if user is logged in
if($user_id > 0) {
    // Fetch user details
    $user_sql = "SELECT Email, FullName FROM Customers WHERE CustomerID = ?";
    $user_stmt = $conn->prepare($user_sql);
    $user_stmt->bind_param("i", $user_id);
    $user_stmt->execute();
    $user_result = $user_stmt->get_result();
    
    if($user_row = $user_result->fetch_assoc()) {
        $user_email = $user_row['Email'];
        $user_name = $user_row['FullName'];
    }
    $user_stmt->close();
    
    // Fetch cart items
    $cart_sql = "SELECT 
        l.listing_id,
        l.brand,
        l.model,
        l.selling_price,
        l.original_price,
        c.quantity,
        (SELECT image_path FROM listing_images WHERE listing_id = l.listing_id LIMIT 1) as image_path
    FROM cart c
    JOIN listings l ON c.listingid = l.listing_id
    WHERE c.customerid = ?
    ORDER BY c.dateadded DESC";
    
    $cart_stmt = $conn->prepare($cart_sql);
    $cart_stmt->bind_param("i", $user_id);
    $cart_stmt->execute();
    $cart_result = $cart_stmt->get_result();
    
    while($item = $cart_result->fetch_assoc()) {
        $item_total = (float)$item['selling_price'] * (int)$item['quantity'];
        $subtotal += $item_total;
        $item_count += (int)$item['quantity'];
        $item['item_total'] = $item_total;
        $cart_items[] = $item;
    }
    $cart_stmt->close();
}

// Calculate totals
$vat = $subtotal * 0.12;
$delivery = 0.00;
$total = $subtotal + $vat + $delivery;
?>

<div class="order-summary">
    <h2>Order Summary</h2>
    
    <div class="cart-info">
<<<<<<< HEAD
        <p>You have <?php echo $item_count; ?> item<?php echo $item_count !== 1 ? 's' : ''; ?> in your cart</p>
        <a href="../cart.php" class="edit-link">Edit Cart</a>
=======
        <p>You have 1 item in your cart</p>
        <a href="../cart.php" class="edit-link">Edit</a>
>>>>>>> f179fb805ef04ef2752c9737b3c0cac69facaba8
    </div>
    
    <?php if(!empty($cart_items)): ?>
        <?php foreach($cart_items as $item): ?>
            <div class="cart-item">
                <div class="item-image">
                    <img src="../<?php echo htmlspecialchars($item['image_path'] ?? 'assets/images/empty.png'); ?>" alt="<?php echo htmlspecialchars($item['brand'] . ' ' . $item['model']); ?>" onerror="this.src='../assets/images/empty.png'">
                </div>
                <div class="item-details">
                    <h3><?php echo htmlspecialchars($item['brand']); ?> <?php echo htmlspecialchars($item['model']); ?></h3>
                    <p>Qty: <?php echo (int)$item['quantity']; ?></p>
                </div>
                <div class="item-price">
                    <span class="unit-price">₱<?php echo number_format((float)$item['selling_price'], 2); ?></span>
                    <span class="total-price">₱<?php echo number_format($item['item_total'], 2); ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="cart-item" style="text-align: center; padding: 20px;">
            <p>Your cart is empty</p>
        </div>
    <?php endif; ?>
    
    <div class="summary-section">
        <h3>Summary</h3>
        <div class="summary-row">
            <span>Subtotal</span>
            <span>₱<?php echo number_format($subtotal, 2); ?></span>
        </div>
        <div class="summary-row">
            <span>Delivery</span>
            <span class="free">Free</span>
        </div>
        <div class="summary-row total">
            <span>Total</span>
            <span>₱<?php echo number_format($total, 2); ?></span>
        </div>
        <div class="vat-info">
            <span>12% VAT (inclusive)</span>
            <span>₱<?php echo number_format($vat, 2); ?></span>
        </div>
    </div>

    <?php if(!empty($user_name)): ?>
    <div class="customer-info" style="margin-top: 15px; padding: 15px; background: #f9f9f9; border-radius: 8px;">
        <h3 style="margin: 0 0 10px 0; font-size: 14px;">Customer Details</h3>
        <p style="margin: 5px 0;"><strong><?php echo htmlspecialchars($user_name); ?></strong></p>
        <p style="margin: 5px 0; color: #666;"><?php echo htmlspecialchars($user_email); ?></p>
    </div>
    <?php endif; ?>
   
    <div class="shipping-assurance">
        <div class="shipping-badge">
            <span class="badge-icon">📦</span>
            <span class="badge-text">Premium Handling</span>
        </div>
        <p>Your order will be carefully packaged and handled with extra care during shipping to ensure it arrives in perfect condition.</p>
        <div class="shipping-features">
            <div class="feature">
                <span class="feature-icon">🛡️</span>
                <span>Secure Packaging</span>
            </div>
            <div class="feature">
                <span class="feature-icon">👐</span>
                <span>Careful Handling</span>
            </div>
            <div class="feature">
                <span class="feature-icon">🚚</span>
                <span>Reliable Delivery</span>
            </div>
        </div>
    </div>
</div>