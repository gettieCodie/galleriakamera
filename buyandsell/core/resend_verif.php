<?php
session_start();
include 'db_connect.php';
require '../phpmailer/PHPMailer.php';
require '../phpmailer/SMTP.php';
require '../phpmailer/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(!isset($_POST['email'])){
    $_SESSION['error'] = "No email provided.";
    header("Location: ../includes/confirm_box.php");
    exit;
}

$email = $_POST['email'];

// Fetch user info
$stmt = $conn->prepare("SELECT * FROM Customers WHERE Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    $_SESSION['error'] = "Email not found.";
    header("Location: ../includes/confirm_box.php");
    exit;
}

$user = $result->fetch_assoc();

$fullname = $user['FullName'];

// Check if already verified
if($user['IsVerified'] == 1){
    $_SESSION['success'] = "Account already verified. Please login.";
    header("Location: ../login.php");
    exit;
}

// Generate a new token and update database
$token = bin2hex(random_bytes(16));
$stmt = $conn->prepare("UPDATE Customers SET VerifyToken = ? WHERE Email = ?");
$stmt->bind_param("ss", $token, $email);
$stmt->execute();

// Send verification email
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "noreplygalleriakamera@gmail.com";
    $mail->Password = "veoa gfsh pjbu wfka"; // Be careful with storing passwords in plain text
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

    $_SESSION['success'] = "Verification email resent! Check your inbox.";
    header("Location: ../includes/confirm_box.php");
    exit;

} catch (Exception $e) {
    $_SESSION['error'] = "Failed to resend email. Try again later.";
    header("Location: ../includes/confirm_box.php");
    exit;
}
