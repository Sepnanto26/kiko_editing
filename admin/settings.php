<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../includes/db.php';

// Handling password change form submission (example)
$successMessage = '';
$errorMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
        $newPass = $_POST['new_password'];
        $confirmPass = $_POST['confirm_password'];

        if ($newPass === $confirmPass) {
            // Normally you should hash password and update DB here.
            // Example: Update in DB (pseudo)
            // $hashed = password_hash($newPass, PASSWORD_DEFAULT);
            // $stmt = $conn->prepare("UPDATE admin SET password=? WHERE username='admin'");
            // $stmt->bind_param('s', $hashed);
            // $stmt->execute();

            $successMessage = "Password berhasil diubah.";
        } else {
            $errorMessage = "Password dan konfirmasi tidak cocok.";
        }
    } else {
        $errorMessage = "Mohon isi semua kolom.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Settings - Admin Dashboard KIKO EDITING</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #8b5cf6, #b06beb);
            min-height: 100vh;
            margin: 0;
            color: #fff;
        }
        .navbar-custom {
            background: linear-gradient(135deg, #6f42c1, #8b5cf6);
            box-shadow: 0 5px 15px rgba(111, 66, 193, 0.7);
        }
        .sidebar {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            min-height: 100vh;
            position: fixed;
            width: 260px;
            top: 0;
            left: 0;
            padding-top: 70px;
            box-shadow: inset -2px 0 5px rgba(0,0,0,0.3);
            transition: width 0.3s ease;
        }
        .sidebar .nav-link {
            color: #eee;
            padding: 15px 25px;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 10px;
            margin: 0 10px 6px 10px;
            transition: background 0.3s ease, color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar .nav-link i {
            font-size: 1.2rem;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: #8b5cf6;
            color: white;
            box-shadow: 0 0 14px #a984ff;
            text-shadow: 0 0 6px rgba(255,255,255,0.6);
        }
        .main-content {
            margin-left: 260px;
            padding: 40px 60px;
            min-height: 100vh;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px 0 0 20px;
            box-shadow: inset 0 0 50px rgba(255,255,255,0.1);
            color: white;
        }
        h2 {
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 0 12px rgba(139, 92, 246, 0.8);
        }
        p {
            opacity: 0.85;
            margin-bottom: 30px;
            font-size: 1.1rem;
        }
        form {
            max-width: 480px;
        }
        label {
            font-weight: 600;
            font-size: 1rem;
        }
        input[type="password"] {
            background: rgba(255 255 255 / 0.15);
            border: none;
            border-radius: 15px;
            padding: 15px 18px;
            width: 100%;
            color: #eee;
            font-size: 1rem;
            margin-bottom: 25px;
            box-shadow: inset 1px 1px 6px rgba(255,255,255,0.15);
            transition: box-shadow 0.3s ease;
        }
        input[type="password"]:focus {
            outline: none;
            box-shadow: 0 0 10px #b06beb;
            background: rgba(255 255 255 / 0.25);
        }
        button.btn-primary {
            background: linear-gradient(135deg, #a084ff, #6f42c1);
            border: none;
            border-radius: 40px;
            padding: 14px 0;
            font-size: 1.2rem;
            font-weight: 700;
            color: #fff;
            width: 100%;
            cursor: pointer;
            box-shadow: 0 6px 25px rgba(111, 66, 193, 0.7);
            transition: background 0.3s ease, transform 0.3s ease;
        }
        button.btn-primary:hover,
        button.btn-primary:focus {
            background: linear-gradient(135deg, #8b5cf6, #a984ff);
            transform: translateY(-3px);
            box-shadow: 0 10px 35px rgba(139, 92, 246, 0.9);
            outline: none;
        }
        .alert-success, .alert-danger {
            border-radius: 15px;
            font-weight: 600;
            margin-top: 20px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                border-radius: 0;
                padding: 20px 30px;
            }
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                min-height: auto;
                padding-top: 10px;
                box-shadow: none;
                display: flex;
                justify-content: center;
                gap: 15px;
            }
            .sidebar .nav-link {
                margin: 0;
                padding: 10px 15px;
                font-size: 0.9rem;
                border-radius: 10px;
            }
        }
    </style>
</head>
<body>

<!-- Navbar omitted because sidebar used -->

<!-- Sidebar -->
<div class="sidebar" role="navigation" aria-label="Sidebar menu">
    <nav class="nav flex-column">
        <a class="nav-link" href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
        <a class="nav-link" href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a>
        <a class="nav-link active" href="settings.php"><i class="fas fa-cogs"></i> Settings</a>
        <a class="nav-link" href="reports.php"><i class="fas fa-chart-line"></i> Reports</a>
    </nav>
</div>

<!-- Main Content -->
<div class="main-content" role="main" aria-label="Settings Page Content">
    <h2><i class="fas fa-cogs"></i> Settings</h2>
    <p>Halaman ini memungkinkan Anda untuk mengubah pengaturan website, termasuk penggantian password admin.</p>

    <?php if ($successMessage): ?>
        <div class="alert alert-success" role="alert" tabindex="0">
            <?php echo htmlspecialchars($successMessage); ?>
        </div>
    <?php elseif ($errorMessage): ?>
        <div class="alert alert-danger" role="alert" tabindex="0">
            <?php echo htmlspecialchars($errorMessage); ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST" aria-label="Form ubah password admin" novalidate>
        <label for="new_password">Password Baru</label>
        <input type="password" id="new_password" name="new_password" placeholder="Masukkan password baru" required aria-required="true" autocomplete="new-password" />

        <label for="confirm_password">Konfirmasi Password Baru</label>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Ulangi password baru" required aria-required="true" autocomplete="new-password" />

        <button type="submit" class="btn btn-primary" aria-label="Simpan pengaturan baru">Simpan</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>