<?php
session_start(); // Start session
include 'includes/header_user.php';
// include 'gridsystem.php';
?>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<div class="container">
    <h2>Create an Account</h2>

    <!-- Error/Success Messages -->
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo htmlspecialchars($_SESSION['error']); ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php echo htmlspecialchars($_SESSION['success']); ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <form action="core/db_signup.php" method="POST">
        <label for="fullname">Full Name</label>
        <input type="text" id="fullname" name="fullname" placeholder="Enter your name" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Create a password" required>

        <label for="role">I am a:</label>
        <select id="role" name="role" required>
            <option value="buyer">Buyer</option>
            <option value="seller">Seller</option>
            <option value="both">Both</option>
        </select>
        <div class="g-recaptcha" data-sitekey="6LdcWw8sAAAAACDSJC7L4GtnWH9E30qzxzFA5pLy"></div>
        <button class="btn" type="submit">Sign Up</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>


