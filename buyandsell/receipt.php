<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 40px;
        }

        .receipt-container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        .order-info, .items, .summary {
            margin-top: 20px;
        }

        .label {
            font-weight: bold;
        }

        .item-row, .summary-row {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
        }

        hr {
            margin: 20px 0;
        }

        .total {
            font-size: 1.2em;
            font-weight: bold;
        }

        .btn-print {
            width: 100%;
            padding: 12px;
            background: black;
            color: #fff;
            border: none;
            font-size: 1em;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-print:hover {
            background: #444;
        }
    </style>
</head>
<body>

<div class="receipt-container">
    <h2>Order Receipt</h2>
    <p style="text-align:center;" id="date"></p>

    <div class="order-info">
        <p><span class="label">Order ID:</span> <span id="orderID"></span></p>
        <p><span class="label">Customer:</span> <span id="customerName"></span></p>
        <p><span class="label">Email:</span> <span id="customerEmail"></span></p>
    </div>

    <hr>

    <div class="items">
        <h3>Items</h3>
        <div id="itemList"></div>
    </div>

    <hr>

    <div class="summary">
        <div class="summary-row">
            <span>Subtotal:</span>
            <span id="subtotal"></span>
        </div>

        <div class="summary-row">
            <span>Delivery:</span>
            <span>FREE</span>
        </div>

        <div class="summary-row total">
            <span>Total:</span>
            <span id="total"></span>
        </div>
    </div>

    <hr>

    <button class="btn-print" onclick="window.print()">Print Receipt</button>
</div>

<script>
    // ================================
    // SAMPLE ORDER DATA (Replace later)
    // ================================
    const order = {
        orderID: "A09312",
        customerName: "Trisha Nicole Sañosa",
        email: "trish@gmail.com",
        items: [
            { name: "Canon B", variant: "Black", price: 18000, qty: 1 },
            { name: "Sony 143", variant: "Black", price: 26500, qty: 1 },
            { name: "Wow Dada", variant: "Full", price: 123, qty: 1 }
        ]
    };

    // ================================
    // DISPLAY DATE
    // ================================
    document.getElementById("date").innerText =
        new Date().toLocaleString("en-US", { 
            dateStyle: "medium", 
            timeStyle: "short" 
        });

    // Display basic info
    document.getElementById("orderID").innerText = order.orderID;
    document.getElementById("customerName").innerText = order.customerName;
    document.getElementById("customerEmail").innerText = order.email;

    // Display items
    let itemList = document.getElementById("itemList");
    let subtotal = 0;

    order.items.forEach(item => {
        let row = document.createElement("div");
        row.className = "item-row";
        row.innerHTML = `
            <span>${item.name} (${item.variant}) x${item.qty}</span>
            <span>₱${(item.price * item.qty).toLocaleString()}</span>
        `;
        itemList.appendChild(row);
        subtotal += item.price * item.qty;
    });

    document.getElementById("subtotal").innerText = "₱" + subtotal.toLocaleString();
    document.getElementById("total").innerText = "₱" + subtotal.toLocaleString();

</script>

</body>
</html>
