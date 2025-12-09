<?php
session_start();
include 'includes/header_user.php';
// include 'gridsystem.php';
?>

<div class="container">
    <h2>User Login</h2>
    <p class="container-subtitle">Sign in to access your account</p>

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

    <form action="core/db_login.php" method="POST" id="loginForm">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>

        <button class="btn" type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();

        if (!email || !password) {
            e.preventDefault();
            alert('Please fill in all fields.');
            return false;
        }

        if (!email.includes('@')) {
            e.preventDefault();
            alert('Please enter a valid email address.');
            return false;
        }
    });
</script>


