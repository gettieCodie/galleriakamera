<?php
session_start();
include 'includes/header_hero.php';
include 'includes/header_user.php';
// include 'gridsystem.php';
?>

<div class="container">
    <h2>User Login</h2>

    <form action="login_process.php" method="POST">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>

        <button class="btn" type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
</div>


