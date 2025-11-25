<!-- includes/customer-details-card.php -->
<div id="customer-details-card" class="details-card">
    <div class="card-header">
        <h3>Customer Details</h3>
        <a href="checkout/checkout_user.php?step=details" class="btn-edit">Edit</a>
    </div>
    <div class="card-content">
        <p><strong>Name:</strong> <?= htmlspecialchars($_SESSION['order_data']['customer']['first_name'] . ' ' . $_SESSION['order_data']['customer']['last_name']) ?></p>
        <p><strong>Address:</strong> 
            <?= htmlspecialchars($_SESSION['order_data']['delivery_address']['address_line_1']) ?>,
            <?= htmlspecialchars($_SESSION['order_data']['delivery_address']['city']) ?>,
            <?= htmlspecialchars($_SESSION['order_data']['delivery_address']['region']) ?>
        </p>
        <p><strong>Contact:</strong> +63<?= htmlspecialchars($_SESSION['order_data']['customer']['mobile']) ?> | <?= htmlspecialchars($_SESSION['order_data']['customer']['email']) ?></p>
    </div>
</div>