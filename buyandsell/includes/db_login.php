<?php 
include 'db_connect.php';

$email = trim($_POST['email']);
$password = trim($_POST['password']);

// Check if email exists
$stmt = $conn->prepare("SELECT * FROM Customers WHERE Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    $_SESSION['error'] = "Email not found. Please sign up.";
    header("Location: ../login.php");
    exit;
}

$user = $result->fetch_assoc();

// Verify password
if(password_verify($password, $user['Password'])){
    $_SESSION['user_id'] = $user['CustomerID'];
    $_SESSION['user_name'] = $user['FullName'];
    $_SESSION['user_role'] = $user['Role'];

    $_SESSION['success'] = "Welcome, " . $user['FullName'] . "!";
    header("Location: ../index.php");
    exit;
} else {
    $_SESSION['error'] = "Incorrect password. Try again.";
    header("Location: ../login.php");
    exit;
}

?>