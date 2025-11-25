<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../includes/db.php';

$successMessage = '';
$errorMessage = '';

// Proses tambahkan user jika form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addUser'])) {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $password = $_POST['password'];

    // Validasi sederhana
    if (empty($nama) || empty($email) || empty($role) || empty($password)) {
        $errorMessage = "Semua field harus diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Email tidak valid.";
    } else {
        // Cek email unik
        $stmt_check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $stmt_check->store_result();
        if ($stmt_check->num_rows > 0) {
            $errorMessage = "Email sudah terdaftar, gunakan email lain.";
            $stmt_check->close();
        } else {
            $stmt_check->close();
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (nama, email, role, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nama, $email, $role, $hashed_password);
            if ($stmt->execute()) {
                $successMessage = "User baru berhasil ditambahkan.";
            } else {
                $errorMessage = "Gagal menambahkan user baru: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

// Ambil daftar user terbaru
$query = "SELECT id, nama, email, role FROM users ORDER BY id DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Manage Users - Admin Dashboard KIKO EDITING</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f1419 0%, #1e3a8a 50%, #3b82f6 100%);
            color: white;
            min-height: 100vh;
            margin: 0;
            padding-top: 70px;
            position: relative;
            overflow-x: hidden;
        }

        /* Partikel animasi latar belakang untuk efek futuristic */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 80%, rgba(0, 212, 255, 0.2) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(138, 43, 226, 0.2) 0%, transparent 50%),
                        radial-gradient(circle at 40% 40%, rgba(59, 130, 246, 0.15) 0%, transparent 50%);
            animation: electricDrift 10s ease-in-out infinite alternate;
            z-index: -1;
        }

        @keyframes electricDrift {
            0% { transform: translateY(0px) rotate(0deg); opacity: 0.8; }
            100% { transform: translateY(-40px) rotate(15deg); opacity: 1; }
        }

        .navbar-custom {
            background: rgba(30, 58, 138, 0.9);
            backdrop-filter: blur(25px);
            box-shadow: 0 5px 25px rgba(0, 212, 255, 0.3);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1030;
            border-bottom: 1px solid rgba(0, 212, 255, 0.3);
        }

        .sidebar {
            background: rgba(30, 58, 138, 0.9);
            backdrop-filter: blur(25px);
            min-height: 100vh;
            position: fixed;
            width: 280px;
            top: 70px;
            left: 0;
            padding-top: 2rem;
            box-shadow: inset -2px 0 15px rgba(0, 0, 0, 0.3), 0 0 25px rgba(0, 212, 255, 0.2);
            border-right: 1px solid rgba(0, 212, 255, 0.3);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            padding: 18px 35px;
            font-weight: 600;
            font-size: 1.1rem;
            border-radius: 20px;
            margin: 0 20px 15px 20px;
            transition: all 0.4s ease;
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
            overflow: hidden;
        }

        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 212, 255, 0.4), transparent);
            transition: left 0.5s;
        }

        .sidebar .nav-link:hover::before,
        .sidebar .nav-link.active::before {
            left: 100%;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #00d4ff, #8a2be2);
            color: white;
            box-shadow: 0 0 30px rgba(0, 212, 255, 0.7);
            transform: translateX(10px);
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
        }

        .sidebar .nav-link i {
            font-size: 1.3rem;
        }

        .main-content {
            margin-left: 280px;
            padding: 50px 70px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border-radius: 25px 0 0 25px;
            min-height: calc(100vh - 70px);
            box-shadow: inset 0 0 20px rgba(255, 255, 255, 0.1);
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        h2 {
            font-weight: 700;
            margin-bottom: 30px;
            background: linear-gradient(45deg, #00d4ff, #8a2be2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 20px rgba(0, 212, 255, 0.5);
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { filter: drop-shadow(0 0 5px rgba(0, 212, 255, 0.5)); }
            to { filter: drop-shadow(0 0 15px rgba(0, 212, 255, 0.8)); }
        }

        p.description {
            opacity: 0.9;
            margin-bottom: 40px;
            font-size: 1.1rem;
        }

        .table {
            background: rgba(30, 58, 138, 0.9);
            border-radius: 20px;
            color: white;
            backdrop-filter: blur(15px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3), 0 0 20px rgba(0, 212, 255, 0.2);
            border: 1px solid rgba(0, 212, 255, 0.3);
        }

        .table thead {
            background: linear-gradient(135deg, #00d4ff, #8a2be2);
            color: #0f1419;
        }

        .table tbody tr:hover {
            background: rgba(0, 212, 255, 0.1);
            transform: scale(1.02);
            transition: all 0.3s ease;
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.3);
        }

        .btn-action {
            border-radius: 25px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            border: none;
        }

        .btn-add {
            background: linear-gradient(135deg, #00d4ff, #8a2be2);
            color: #0f1419;
            margin-bottom: 20px;
        }

        .btn-add:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.4);
        }

        .btn-edit {
            background: linear-gradient(135deg, #3b82f6, #00d4ff);
            color: white;
        }

        .btn-edit:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.6);
        }

        .btn-delete {
            background: linear-gradient(135deg, #ef4444, #f87171);
            color: white;
        }

        .btn-delete:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.6);
        }

        .alert-success, .alert-danger {
            border-radius: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            background: rgba(34, 197, 94, 0.9);
            color: white;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.9);
        }

        .modal-content {
            border-radius: 25px;
            backdrop-filter: blur(25px);
            background: rgba(30, 58, 138, 0.9);
            border: 1px solid rgba(0, 212, 255, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            color: white;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding-top: 15px;
                box-shadow: none;
                display: flex;
                justify-content: center;
                gap: 20px;
                flex-wrap: wrap;
            }
            .sidebar .nav-link {
                margin: 0 10px;
                font-size: 1rem;
                border-radius: 15px;
                padding: 12px 20px;
            }
            .main-content {
                margin-left: 0;
                border-radius: 0;
                padding: 30px 40px;
            }
            .table {
                font-size: 0.9rem;
            }
            .btn-action {
                padding: 5px 11px;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fas fa-tachometer-alt"></i> KIKO EDITING Dashboard</a>
        <div class="d-flex">
            <span class="navbar-text me-3">Welcome, Admin!</span>
            <a href="logout.php" class="btn btn-outline-light btn-sm"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar" role="navigation" aria-label="Sidebar menu">
    <nav class="nav flex-column">
        <a href="dashboard.php" class="nav-link"><i class="fas fa-home"></i> Dashboard</a>
        <a href="manage_users.php" class="nav-link active"><i class="fas fa-users"></i> Manage Users</a>
        <a href="settings.php" class="nav-link"><i class="fas fa-cogs"></i> Settings</a>
        <a href="reports.php" class="nav-link"><i class="fas fa-chart-line"></i> Reports</a>
    </nav>
</div>

<!-- Main Content -->
<div class="main-content" role="main" aria-label="Manage Users content">
    <h2><i class="fas fa-users"></i> Manage Users</h2>
    <p class="description">Kelola seluruh user sistem Anda di sini. Tambahkan user baru, edit data, atau hapus user yang tidak diperlukan.</p>

    <?php if(!empty($successMessage)): ?>
        <div class="alert alert-success" role="alert" tabindex="0"><?= htmlspecialchars($successMessage); ?></div>
    <?php endif; ?>
    <?php if(!empty($errorMessage)): ?>
        <div class="alert alert-danger" role="alert" tabindex="0"><?= htmlspecialchars($errorMessage); ?></div>
    <?php endif; ?>

    <!-- Tombol Tambah User -->
    <button type="button" class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="fas fa-user-plus"></i> Tambah User Baru
    </button>

    <!-- Tabel User -->
    <div class="table-responsive">
        <table class="table table-striped align-middle text-white">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th style="width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if($result && $result->num_rows > 0): ?>
                    <?php while($user = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']); ?></td>
                            <td><?= htmlspecialchars($user['nama']); ?></td>
                            <td><?= htmlspecialchars($user['email']); ?></td>
                            <td><?= htmlspecialchars($user['role']); ?></td>
                            <td>
                                <button class="btn btn-edit btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editUserModal" 
                                    data-id="<?= $user['id']; ?>" data-nama="<?= htmlspecialchars($user['nama']); ?>" 
                                    data-email="<?= htmlspecialchars($user['email']); ?>" data-role="<?= htmlspecialchars($user['role']); ?>">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-delete btn-sm" data-bs-toggle="modal" data-bs-target="#deleteUserModal" 
                                    data-id="<?= $user['id']; ?>" data-nama="<?= htmlspecialchars($user['nama']); ?>">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">Belum ada user.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addUserForm" action="" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserModalLabel"><i class="fas fa-user-plus"></i> Tambah User Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
          <input type="hidden" name="addUser" value="1" />
          <div class="mb-3">
              <label for="addName" class="form-label">Nama Lengkap</label>
              <input type="text" class="form-control" id="addName" name="nama" required />
          </div>
          <div class="mb-3">
              <label for="addEmail" class="form-label">Email</label>
              <input type="email"