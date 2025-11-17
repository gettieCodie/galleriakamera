<?php
session_start(); // Start session
include 'db_connect.php';

// Get form data
$fullname = trim($_POST['fullname']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$role = $_POST['role'];

$errors = [];

// For security 
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if email exists
$stmt = $conn->prepare("SELECT * FROM Customers WHERE Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $_SESSION['error'] = "Email already registered. Please login.";
    header("Location: ../signup.php");
    exit;
}

$stmt = $conn->prepare("INSERT INTO Customers (FullName, Email, Password, Role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $fullname, $email, $hashed_password, $role);

if($stmt->execute()){
    $_SESSION['success'] = "Account created successfully!";
    header("Location: ../login.php");
    exit;
}else{
    $_SESSION['error'] = "Failed to create account. Try again.";
    header("Location: ../signup.php");
    exit;
}
?>