<footer class="admin-footer">
    <div class="admin-footer-wrapper">
        <!-- Admin Footer Content -->
        <div class="admin-footer-content">
            <!-- Left Section: Brand -->
            <div class="footer-col admin-footer-brand">
                <div class="footer-brand-logo">
                    <h3 class="admin-footer-brand-name">Galleria Kamera Admin</h3>
                    <p class="brand-tagline">Management Portal</p>
                </div>
                <p class="brand-description">
                    Manage inventory, process orders, and track business analytics in one unified dashboard.
                </p>
            </div>

            <!-- Center-Left Section: Quick Links -->
            <div class="footer-col">
                <h4 class="footer-col-title">Dashboard</h4>
                <ul class="footer-col-list">
                    <li><a href="admin_dashboard.php">Dashboard Home</a></li>
                    <li><a href="admin_products.php">Manage Inventory</a></li>
                    <li><a href="admin_user.php">Manage Users</a></li>
                    <li><a href="admin_dashboard.php#camera-purchases">Pending Reviews</a></li>
                    <li><a href="admin_dashboard.php#customer-orders">Orders</a></li>
                </ul>
            </div>

            <!-- Center Section: Tools -->
            <div class="footer-col">
                <h4 class="footer-col-title">Tools</h4>
                <ul class="footer-col-list">
                    <li><a href="admin_products.php">Add Product</a></li>
                    <li><a href="admin_products.php">Edit Products</a></li>
                    <li><a href="admin_dashboard.php#analytics">View Analytics</a></li>
                    <li><a href="admin_user.php">User Management</a></li>
                    <li><a href="#">Settings</a></li>
                </ul>
            </div>

            <!-- Right Section: Support & Status -->
            <div class="footer-col">
                <h4 class="footer-col-title">Support</h4>
                <ul class="footer-col-list">
                    <li><a href="#">System Status</a></li>
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">Report Issue</a></li>
                    <li><a href="#">Help & Guides</a></li>
                </ul>
                <div class="admin-status">
                    <p><strong>Admin Email:</strong> admin@galleriakamera.com</p>
                    <p><strong>Support:</strong> support@galleriakamera.com</p>
                </div>
            </div>
        </div>

        <!-- Footer Bottom Section -->
        <div class="footer-bottom">
            <div class="footer-bottom-left">
                <p>&copy; 2024 Galleria Kamera Admin Portal. All rights reserved.</p>
                <ul class="footer-links">
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Security</a></li>
                </ul>
            </div>
            <div class="footer-bottom-right">
                <p class="system-info">
                    System Version 1.0 | 
                    <span id="server-time" title="Server Time"><?php echo date('M d, Y H:i'); ?></span>
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
/* Admin Footer Styles */
.admin-footer {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: #e0e0e0;
    padding: 40px 20px 20px;
    margin-top: 60px;
    border-top: 1px solid #404040;
    font-size: 14px;
}

.admin-footer-wrapper {
    max-width: 1400px;
    margin: 0 auto;
}

.admin-footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 40px;
    margin-bottom: 30px;
}

.footer-col {
    display: flex;
    flex-direction: column;
}

.footer-col-title {
    font-size: 15px;
    font-weight: 700;
    margin-bottom: 15px;
    color: #ffffff;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.footer-col-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-col-list li {
    margin-bottom: 10px;
}

.footer-col-list a {
    color: #b0b0b0;
    text-decoration: none;
    transition: color 0.3s ease;
    display: inline-flex;
    align-items: center;
}

.footer-col-list a:hover {
    color: #ffffff;
}

.admin-footer-brand {
    grid-column: 1;
}

.footer-brand-logo {
    margin-bottom: 15px;
}

.brand-name {
    font-size: 18px;
    font-weight: 700;
    margin: 0 0 5px 0;
    color: #ffffff;
}

.brand-tagline {
    font-size: 12px;
    color: #888;
    margin: 0 0 10px 0;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.brand-description {
    color: #999;
    font-size: 13px;
    line-height: 1.6;
    margin: 0 0 15px 0;
}

.admin-status {
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #404040;
}

.admin-status p {
    margin: 8px 0;
    color: #999;
    font-size: 12px;
}

.admin-status strong {
    color: #ffffff;
}

/* Footer Bottom */
.footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 20px;
    border-top: 1px solid #404040;
    flex-wrap: wrap;
    gap: 20px;
}

.footer-bottom-left {
    display: flex;
    align-items: center;
    gap: 30px;
    flex-wrap: wrap;
}

.footer-bottom-left p {
    margin: 0;
    color: #888;
    font-size: 13px;
}

.footer-links {
    list-style: none;
    display: flex;
    gap: 25px;
    padding: 0;
    margin: 0;
}

.footer-links a {
    color: #888;
    text-decoration: none;
    transition: color 0.3s ease;
    font-size: 13px;
}

.footer-links a:hover {
    color: #ffffff;
}

.footer-bottom-right {
    text-align: right;
}

.system-info {
    margin: 0;
    color: #666;
    font-size: 12px;
}

#server-time {
    color: #888;
    cursor: help;
}

/* Responsive Design */
@media (max-width: 768px) {
    .admin-footer {
        padding: 30px 15px 15px;
        margin-top: 40px;
    }

    .admin-footer-content {
        gap: 25px;
    }

    .footer-bottom {
        flex-direction: column;
        align-items: flex-start;
    }

    .footer-bottom-right {
        text-align: left;
        width: 100%;
    }

    .footer-links {
        gap: 15px;
    }
}

@media (max-width: 480px) {
    .admin-footer-content {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .footer-col-title {
        font-size: 13px;
    }

    .footer-bottom-left {
        flex-direction: column;
        gap: 15px;
    }

    .footer-bottom-left p {
        font-size: 12px;
    }
}
</style>
