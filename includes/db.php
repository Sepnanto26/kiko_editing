<?php
$host = 'localhost';
$user = 'root';  // Default XAMPP
$pass = '';      // Default XAMPP
$db = 'kiko_editing_db';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>