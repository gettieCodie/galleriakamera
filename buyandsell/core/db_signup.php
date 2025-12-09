<?php
session_start(); // Start session
include 'db_connect.php';
require '../phpmailer/PHPMailer.php';
require '../phpmailer/SMTP.php';
require '../phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$secretKey = "6LdcWw8sAAAAAGupVBCFI1oFHD0ZoPJgva14a_mt";
$recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

if (empty($recaptchaResponse)) {
    $_SESSION['error'] = "Please complete the CAPTCHA.";
    header("Location: ../signup.php");
    exit;
}

$verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$recaptchaResponse");
$responseData = json_decode($verifyResponse, true);

if(!$responseData['success']){
    $_SESSION['error'] = "CAPTCHA verification failed. Please try again.";
    header("Location: ../signup.php");
    exit;
}

// Get form data
$fullname = trim($_POST['fullname'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
$role = $_POST['role'] ?? '';

// Validate inputs
if (empty($fullname) || empty($email) || empty($password) || empty($role)) {
    $_SESSION['error'] = "All fields are required.";
    header("Location: ../signup.php");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Please enter a valid email address.";
    header("Location: ../signup.php");
    exit;
}

if (strlen($password) < 6) {
    $_SESSION['error'] = "Password must be at least 6 characters long.";
    header("Location: ../signup.php");
    exit;
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$_SESSION['signup_email'] = $email;
$_SESSION['signup_name'] = $fullname;

// Check if email exists
$stmt = $conn->prepare("SELECT * FROM Customers WHERE Email = ?");
if (!$stmt) {
    $_SESSION['error'] = "Database error: " . $conn->error;
    header("Location: ../signup.php");
    exit;
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $_SESSION['error'] = "Email already registered. Please login.";
    header("Location: ../signup.php");
    exit;
}
$stmt->close();

$token = bin2hex(random_bytes(16));

$stmt = $conn->prepare("INSERT INTO Customers (FullName, Email, Password, Role, VerifyToken, IsVerified) VALUES (?, ?, ?, ?, ?, 0)");
if (!$stmt) {
    $_SESSION['error'] = "Database error: " . $conn->error;
    header("Location: ../signup.php");
    exit;
}

$stmt->bind_param("sssss", $fullname, $email, $hashed_password, $role, $token);

if($stmt->execute()){
    $stmt->close();
    // Send verification email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "noreplygalleriakamera@gmail.com";
        $mail->Password = "veoa gfsh pjbu wfka";
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        $mail->setFrom("noreplygalleriakamera@gmail.com", "Galleria Kamera");
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "Verify your Galleria Kamera account";

        $verify_link = "http://localhost/galleriakamera/buyandsell/core/verify.php?token=$token";

        $mail->Body = '
        <!DOCTYPE html>
        <html>
        <head>
        <meta charset="UTF-8">
        </head>
        <body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:20px;">

        <div style="max-width:600px; margin:auto; background:white; border-radius:10px; padding:30px; box-shadow:0 4px 10px rgba(0,0,0,0.1);">

            <h2 style="text-align:center; color:#333; margin-bottom:20px;">Welcome to Galleria Kamera 📸</h2>

            <p style="font-size:16px; color:#555;">
            Hello <strong>' . $fullname . '</strong>,
            </p>

            <p style="font-size:16px; color:#555;">
            Thank you for registering! Please verify your account by clicking the button below.
            </p>

            <div style="text-align:center; margin:30px 0;">
            <a href="' . $verify_link . '" 
                style="
                    background:#372200;
                    color:white;
                    padding:12px 20px;
                    border-radius:5px;
                    text-decoration:none;
                    font-size:16px;
                    display:inline-block;
                    font-weight:bold;
                ">
                Verify My Account
            </a>
            </div>

            <p style="font-size:14px; color:#777;">
            If the button doesn’t work, copy and paste this link into your browser:
            </p>

            <p style="font-size:14px; word-break:break-all; color:#0d6efd;">
            ' . $verify_link . '
            </p>

            <hr style="margin-top:30px; border:0; border-top:1px solid #eee;">

            <p style="font-size:12px; text-align:center; color:#aaa;">
            © ' . date("Y") . ' Galleria Kamera. All rights reserved.
            </p>

        </div>

        </body>
        </html>
        ';


        $mail->send();
        $_SESSION['success'] = "Account created! Check your email to verify.";
        header("Location: ../includes/confirm_box.php"); 
        exit;

    } catch (Exception $e) {
        $_SESSION['error'] = "Error sending email: " . $mail->ErrorInfo . " Please try again later.";
        header("Location: ../signup.php");
        exit;
    }

} else {
    $_SESSION['error'] = "Account creation failed: " . $stmt->error;
    header("Location: ../signup.php");
    exit;
}
$stmt->close();
?>