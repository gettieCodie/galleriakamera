<?php 
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$order_id = $_GET['order_id'] ?? null;
if (!$order_id) {
    header("Location: dashboard_user.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt #<?php echo htmlspecialchars($order_id); ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 20px;
            line-height: 1.6;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-decoration: none;
            color: #333;
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background: #f8f9fa;
            border-color: #aaa;
        }

        .receipt-container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .receipt-header h1 {
            font-size: 2em;
            margin-bottom: 5px;
        }

        .receipt-header .order-id {
            color: #666;
            font-size: 1.1em;
        }

        .receipt-date {
            text-align: center;
            color: #888;
            margin-bottom: 30px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.2em;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 0.85em;
            color: #666;
            margin-bottom: 4px;
        }

        .info-value {
            font-weight: 500;
            color: #333;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .items-table th {
            background: #f8f9fa;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        .items-table tr:last-child td {
            border-bottom: none;
        }

        .text-right {
            text-align: right;
        }

        .summary {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 1.1em;
        }

        .summary-row.total {
            font-size: 1.4em;
            font-weight: bold;
            border-top: 2px solid #000;
            padding-top: 15px;
            margin-top: 10px;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 500;
        }

        .status-processing {
            background: #fff3cd;
            color: #856404;
        }

        .status-shipped {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-delivered {
            background: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .actions {
            margin-top: 40px;
            display: flex;
            gap: 15px;
        }

        .btn {
            flex: 1;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-print {
            background: #000;
            color: #fff;
        }

        .btn-print:hover {
            background: #333;
        }

        .btn-download {
            background: #007bff;
            color: #fff;
        }

        .btn-download:hover {
            background: #0056b3;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .error {
            text-align: center;
            padding: 40px;
            color: #721c24;
            background: #f8d7da;
            border-radius: 8px;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .back-btn,
            .actions {
                display: none;
            }

            .receipt-container {
                box-shadow: none;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

<a href="dashboard_user.php" class="back-btn">
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
                        <th>Variant</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    ${order.items.map(item => `
                        <tr>
                            <td>${item.name}</td>
                            <td>${item.variant || 'N/A'}</td>
                            <td class="text-right">₱${item.price.toLocaleString('en-PH', {minimumFractionDigits: 2})}</td>
                            <td class="text-right">${item.qty}</td>
                            <td class="text-right">₱${(item.price * item.qty).toLocaleString('en-PH', {minimumFractionDigits: 2})}</td>
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
    // Simple download using print
    // For a proper PDF, you'd need a library like jsPDF
    window.print();
}
</script>

</body>
</html>