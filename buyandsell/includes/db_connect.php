<?php
$host = 'localhost';
$dbname = 'galleriakamera';
$username = 'root';
$password = '';  // Default XAMPP password is empty

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optional: Set charset to avoid encoding issues
mysqli_set_charset($conn, "utf8mb4");
?>