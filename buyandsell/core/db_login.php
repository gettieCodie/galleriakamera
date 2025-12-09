<?php 
session_start();
include 'db_connect.php';

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: ../login.php");
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// Validate inputs
if (empty($email) || empty($password)) {
    $_SESSION['error'] = "Email and password are required.";
    header("Location: ../login.php");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Please enter a valid email address.";
    header("Location: ../login.php");
    exit;
}

// Check if email exists
$stmt = $conn->prepare("SELECT * FROM Customers WHERE Email = ?");
if (!$stmt) {
    $_SESSION['error'] = "Database error: " . $conn->error;
    header("Location: ../login.php");
    exit;
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    $_SESSION['error'] = "Email not found. Please sign up.";
    header("Location: ../login.php");
    exit;
}

$user = $result->fetch_assoc();
$stmt->close();

// Verify password
if(!password_verify($password, $user['Password'])){
    $_SESSION['error'] = "Incorrect password. Try again.";
    header("Location: ../login.php");
    exit;
}

// Block Login if not verified
if($user['IsVerified'] == 0){
    $_SESSION['error'] = "Please verify your email before logging in.";
    header("Location: ../login.php");
    exit;
}

// Check if admin
if($user['CustomerID'] == 1 && $user['Role'] === 'admin'){
    $_SESSION['admin_id'] = $user['CustomerID'];
    $_SESSION['admin_name'] = $user['FullName'];
    $_SESSION['admin_role'] = 'admin';

    $_SESSION['success'] = "Welcome, Admin " . htmlspecialchars($user['FullName']) . "!";
    header("Location: ../admin/admin_dashboard.php");
    exit;
}

// Normal customer login
$_SESSION['user_id'] = $user['CustomerID'];
$_SESSION['user_name'] = $user['FullName'];
$_SESSION['user_role'] = $user['Role'];

$_SESSION['success'] = "Welcome, " . htmlspecialchars($user['FullName']) . "!";
header("Location: ../marketplace.php");
exit;

?>