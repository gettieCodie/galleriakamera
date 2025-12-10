<?php 
session_start();

// Allow access from both user and admin sessions
$source = $_GET['source'] ?? 'user';
if ($source === 'admin') {
    // Admin access - check for admin_id or user_id with admin privileges
    if (!isset($_SESSION['admin_id']) && !isset($_SESSION['user_id'])) {
        header("Location: admin/admin_login.php");
        exit;
    }
} else {
    // User access - check for user_id
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
}

$order_id = $_GET['order_id'] ?? null;
if (!$order_id) {
    $redirect = ($source === 'admin') ? 'admin/admin_dashboard.php' : 'dashboard_user.php';
    header("Location: $redirect");
    exit;
}

// Determine redirect URL based on source parameter
if ($source === 'admin') {
    $dashboard_url = 'admin/admin_dashboard.php';
} else {
    $dashboard_url = 'dashboard_user.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt #<?php echo htmlspecialchars($order_id); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/receipt.css">
</head>
<body>

<a href="<?php echo htmlspecialchars($dashboard_url); ?>" class="back-btn">
    <i class="fas fa-arrow-left"></i>
    Back to Dashboard
</a>

<div class="receipt-container" id="receiptContainer">
    <div class="loading">
        <i class="fas fa-spinner fa-spin fa-2x"></i>
        <p>Loading receipt...</p>
    </div>
</div>

<script>
const orderID = <?php echo json_encode($order_id); ?>;

document.addEventListener('DOMContentLoaded', function() {
    loadReceipt();
});

function loadReceipt() {
    fetch(`core/get_order_details.php?order_id=${orderID}`)
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                displayReceipt(data.order);
            } else {
                showError(data.message);
            }
        })
        .catch(error => {
            showError('Failed to load receipt: ' + error.message);
        });
}

function displayReceipt(order) {
    const container = document.getElementById('receiptContainer');
    
    const subtotal = order.items.reduce((sum, item) => sum + (item.price * item.qty), 0);
    
    container.innerHTML = `
        <div class="receipt-header">
            <h1>Order Receipt</h1>
            <p class="order-id">Order #${order.orderID}</p>
        </div>

        <div class="receipt-date">
            ${new Date(order.date).toLocaleString('en-US', { 
                dateStyle: 'full', 
                timeStyle: 'short' 
            })}
        </div>

        <div class="section">
            <h2 class="section-title">Customer Information</h2>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Name</span>
                    <span class="info-value">${order.customerName}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value">${order.email}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Mobile</span>
                    <span class="info-value">+63 ${order.mobile}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Payment Method</span>
                    <span class="info-value">${order.paymentMethod}</span>
                </div>
            </div>
        </div>

        <div class="section">
            <h2 class="section-title">Delivery Address</h2>
            <p class="info-value">
                ${order.address}<br>
                ${order.city}, ${order.region} ${order.postalCode}
            </p>
        </div>

        <div class="section">
            <h2 class="section-title">Order Status</h2>
            <span class="status-badge status-${order.status.toLowerCase()}">${order.status}</span>
        </div>

        <div class="section">
            <h2 class="section-title">Order Items</h2>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    ${order.items.filter(item => item.name && item.price && item.qty).map(item => `
                        <tr>
                            <td>${item.name || 'N/A'}</td>
                            <td class="text-right">₱${(item.price || 0).toLocaleString('en-PH', {minimumFractionDigits: 2})}</td>
                            <td class="text-right">${item.qty || 0}</td>
                            <td class="text-right">₱${((item.price || 0) * (item.qty || 0)).toLocaleString('en-PH', {minimumFractionDigits: 2})}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>

        <div class="summary">
            <div class="summary-row">
                <span>Subtotal:</span>
                <span>₱${subtotal.toLocaleString('en-PH', {minimumFractionDigits: 2})}</span>
            </div>
            <div class="summary-row">
                <span>VAT (12%):</span>
                <span>₱${(subtotal * 0.12).toLocaleString('en-PH', {minimumFractionDigits: 2})}</span>
            </div>
            <div class="summary-row">
                <span>Delivery:</span>
                <span>FREE</span>
            </div>
            <div class="summary-row total">
                <span>Total:</span>
                <span>₱${order.total.toLocaleString('en-PH', {minimumFractionDigits: 2})}</span>
            </div>
        </div>

        <div class="actions">
            <button class="btn btn-print" onclick="window.print()">
                <i class="fas fa-print"></i>
                Print Receipt
            </button>
            <button class="btn btn-download" onclick="downloadPDF()">
                <i class="fas fa-download"></i>
                Download PDF
            </button>
        </div>
    `;
}

function showError(message) {
    const container = document.getElementById('receiptContainer');
    container.innerHTML = `
        <div class="error">
            <i class="fas fa-exclamation-circle fa-2x"></i>
            <h3>Error Loading Receipt</h3>
            <p>${message}</p>
        </div>
    `;
}

function downloadPDF() {
    window.print();
}
</script>

</body>
</html>