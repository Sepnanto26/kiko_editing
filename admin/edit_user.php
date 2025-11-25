<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $password = $_POST['password'];

    // Validasi sederhana
    if (empty($nama) || empty($email) || empty($role)) {
        $_SESSION['edit_user_error'] = "Nama, Email, dan Role wajib diisi.";
        header("Location: manage_users.php");
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['edit_user_error'] = "Email tidak valid.";
        header("Location: manage_users.php");
        exit();
    }

    // Cek apakah email sudah digunakan oleh user lain
    $stmt_check = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmt_check->bind_param("si", $email, $id);
    $stmt_check->execute();
    $stmt_check->store_result();
    if ($stmt_check->num_rows > 0) {
        $_SESSION['edit_user_error'] = "Email sudah terpakai oleh user lain.";
        $stmt_check->close();
        header("Location: manage_users.php");
        exit();
    }
    $stmt_check->close();

    if (!empty($password)) {
        // Jika password diisi, update termasuk password (hashing)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET nama=?, email=?, role=?, password=? WHERE id=?");
        $stmt->bind_param("ssssi", $nama, $email, $role, $hashed_password, $id);
    } else {
        // Update tanpa ubah password
        $stmt = $conn->prepare("UPDATE users SET nama=?, email=?, role=? WHERE id=?");
        $stmt->bind_param("sssi", $nama, $email, $role, $id);
    }

    if ($stmt->execute()) {
        $_SESSION['edit_user_success'] = "Data user berhasil diperbarui.";
    } else {
        $_SESSION['edit_user_error'] = "Gagal memperbarui data user: " . $stmt->error;
    }
    $stmt->close();

    header("Location: manage_users.php");
    exit();
}

// Jika akses langsung, kembali ke Manage Users
header("Location: manage_users.php");
exit();