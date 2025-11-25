<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);

    if ($id <= 0) {
        $_SESSION['delete_user_error'] = "ID user tidak valid.";
        header("Location: manage_users.php");
        exit();
    }

    // Hapus user berdasarkan id
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['delete_user_success'] = "User berhasil dihapus.";
    } else {
        $_SESSION['delete_user_error'] = "Gagal menghapus user: " . $stmt->error;
    }
    $stmt->close();

    header("Location: manage_users.php");
    exit();
}

// Jika akses langsung, kembali ke Manage Users
header("Location: manage_users.php");
exit();