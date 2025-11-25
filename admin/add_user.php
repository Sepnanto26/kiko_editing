<?php
// Aktifkan tampilan error (debug hanya saat development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

if (!$conn) {
    die("Koneksi database gagal");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $password = $_POST['password'];

    if (empty($nama) || empty($email) || empty($role) || empty($password)) {
        $_SESSION['add_user_error'] = "Semua field harus diisi.";
        header("Location: manage_users.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['add_user_error'] = "Email tidak valid.";
        header("Location: manage_users.php");
        exit();
    }

    $stmt_check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    if ($stmt_check === false) {
        die("Prepare failed: " . $conn->error);
    }
    
    $stmt_check->bind_param("s", $email);
    if (!$stmt_check->execute()) {
        die("Execute failed: " . $stmt_check->error);
    }
    
    $stmt_check->store_result();
    if ($stmt_check->num_rows > 0) {
        $stmt_check->close();
        $_SESSION['add_user_error'] = "Email sudah terdaftar, gunakan email lain.";
        header("Location: manage_users.php");
        exit();
    }
    $stmt_check->close();

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (nama, email, role, password) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("ssss", $nama, $email, $role, $hashed_password);
    if ($stmt->execute()) {
        $_SESSION['add_user_success'] = "User baru berhasil ditambahkan.";
    } else {
        $_SESSION['add_user_error'] = "Gagal menambahkan user baru. Error: " . $stmt->error;
    }
    $stmt->close();

    header("Location: manage_users.php");
    exit();
}

header("Location: manage_users.php");
exit();
