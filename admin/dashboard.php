<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../includes/db.php';

// Ambil data statistik untuk dashboard
$total_orders = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
$pending_orders = $conn->query("SELECT COUNT(*) as count FROM orders WHERE status='pending'")->fetch_assoc()['count'];
$completed_orders = $conn->query("SELECT COUNT(*) as count FROM orders WHERE status='completed'")->fetch_assoc()['count'];
$in_progress_orders = $conn->query("SELECT COUNT(*) as count FROM orders WHERE status='in_progress'")->fetch_assoc()['count'];

// Handle update status
if (isset($_GET['update']) && isset($_GET['status'])) {
    $id = (int)$_GET['update'];
    $status = $_GET['status'];
    $valid_statuses = ['pending', 'in_progress', 'completed'];
    if (in_array($status, $valid_statuses)) {
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: dashboard.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - KIKO EDITING</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            color: white;
            position: relative;
            overflow-x: hidden;
        }

        /* Partikel animasi latar belakang untuk efek cyberpunk */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 25% 75%, rgba(0, 255, 128, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 75% 25%, rgba(255, 215, 0, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 50% 50%, rgba(138, 43, 226, 0.1) 0%, transparent 50%);
            animation: cyberDrift 10s ease-in-out infinite alternate;
            z-index: -1;
        }

        @keyframes cyberDrift {
            0% { transform: translateY(0px) rotate(0deg); opacity: 0.7; }
            100% { transform: translateY(-40px) rotate(15deg); opacity: 1; }
        }

        .navbar-custom {
            background: rgba(26, 26, 46, 0.9);
            backdrop-filter: blur(25px);
            box-shadow: 0 5px 25px rgba(0, 255, 128, 0.3);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1030;
            border-bottom: 1px solid rgba(0, 255, 128, 0.3);
        }

        .sidebar {
            background: rgba(26, 26, 46, 0.9);
            backdrop-filter: blur(25px);
            min-height: 100vh;
            position: fixed;
            width: 280px;
            top: 0;
            left: 0;
            z-index: 1000;
            padding-top: 70px;
            box-shadow: inset -2px 0 15px rgba(0, 0, 0, 0.3), 0 0 25px rgba(0, 255, 128, 0.2);
            border-right: 1px solid rgba(0, 255, 128, 0.3);
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
            background: linear-gradient(90deg, transparent, rgba(0, 255, 128, 0.4), transparent);
            transition: left 0.5s;
        }

        .sidebar .nav-link:hover::before,
        .sidebar .nav-link.active::before {
            left: 100%;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #00ff80, #ffd700);
            color: #1a1a2e;
            box-shadow: 0 0 30px rgba(0, 255, 128, 0.7);
            transform: translateX(10px);
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
        }

        .sidebar .nav-link i {
            font-size: 1.3rem;
        }

        .main-content {
            margin-left: 280px;
            padding: 30px;
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        h2 {
            color: white;
            font-weight: 700;
            margin-bottom: 30px;
            margin-top: 20px; /* Tambahan margin-top agar h2 turun sedikit */
            background: linear-gradient(45deg, #00ff80, #ffd700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 20px rgba(0, 255, 128, 0.5);
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { filter: drop-shadow(0 0 5px rgba(0, 255, 128, 0.5)); }
            to { filter: drop-shadow(0 0 15px rgba(0, 255, 128, 0.8)); }
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(0, 255, 128, 0.2), rgba(255, 215, 0, 0.2));
            color: white;
            border-radius: 25px;
            padding: 35px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), 0 0 20px rgba(0, 255, 128, 0.3);
            transition: all 0.4s ease;
            border: 1px solid rgba(0, 255, 128, 0.3);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: transform 0.6s;
            transform: rotate(45deg) translate(-100%, -100%);
        }

        .stat-card:hover::before {
            transform: rotate(45deg) translate(100%, 100%);
        }

        .stat-card:hover {
            transform: translateY(-15px) scale(1.05);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5), 0 0 30px rgba(0, 255, 128, 0.6);
        }

        .stat-card.completed {
            background: linear-gradient(135deg, rgba(0, 255, 128, 0.3), rgba(78, 205, 196, 0.3));
        }

        .stat-card.pending {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.3), rgba(250, 177, 160, 0.3));
        }

        .stat-card.in-progress {
            background: linear-gradient(135deg, rgba(138, 43, 226, 0.3), rgba(108, 92, 231, 0.3));
        }

        .table-responsive {
            margin-top: 50px; /* Tambahan margin-top agar tabel turun lebih ke bawah */
        }

        .table-modern {
            background: rgba(26, 26, 46, 0.9);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), 0 0 20px rgba(255, 215, 0, 0.2);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(0, 255, 128, 0.3);
        }

        .table-modern thead {
            background: linear-gradient(135deg, #00ff80, #ffd700);
            color: #1a1a2e;
        }

        .table-modern tbody tr:hover {
            background: rgba(0, 255, 128, 0.1);
            transform: scale(1.02);
            transition: all 0.3s ease;
            box-shadow: 0 0 15px rgba(0, 255, 128, 0.3);
        }

        .btn-action {
            border-radius: 25px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            border: none;
            background: linear-gradient(135deg, #00ff80, #ffd700);
            color: #1a1a2e;
        }

        .btn-action:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(0, 255, 128, 0.4);
        }

        .modal-content {
            border-radius: 25px;
            backdrop-filter: blur(25px);
            background: rgba(26, 26, 46, 0.9);
            border: 1px solid rgba(0, 255, 128, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            color: white;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                padding-top: 0;
            }
            .main-content {
                margin-left: 0;
            }
            .stat-card {
                margin-bottom: 20px;
            }
            .table-responsive {
                margin-top: 30px; /* Sesuaikan untuk mobile */
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
    <div class="sidebar">
        <nav class="nav flex-column">
            <a class="nav-link active" href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
            <a class="nav-link" href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a>
            <a class="nav-link" href="settings.php"><i class="fas fa-cogs"></i> Settings</a>
            <a class="nav-link" href="reports.php"><i class="fas fa-chart-line"></i> Reports</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-4"><i class="fas fa-list"></i> Daftar Pesanan</h2>

            <!-- Statistik Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <h3><?php echo $total_orders; ?></h3>
                        <p><i class="fas fa-shopping-cart"></i> Total Pesanan</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card pending">
                        <h3><?php echo $pending_orders; ?></h3>
                        <p><i class="fas fa-clock"></i> Pending</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card in-progress">
                        <h3><?php echo $in_progress_orders; ?></h3>
                        <p><i class="fas fa-spinner"></i> In Progress</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card completed">
                        <h3><?php echo $completed_orders; ?></h3>
                        <p><i class="fas fa-check-circle"></i> Completed</p>
                    </div>
                </div>
            </div>

            <!-- Tabel Pesanan -->
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th><i class="fas fa-id-badge"></i> ID</th>
                            <th><i class="fas fa-user"></i> Nama</th>
                            <th><i class="fas fa-envelope"></i> Email</th>
                            <th><i class="fas fa-tools"></i> Jasa</th>
                            <th><i class="fas fa-info-circle"></i> Deskripsi</th>
                            <th><i class="fas fa-tasks"></i> Status</th>
                            <th><i class="fas fa-calendar"></i> Tanggal</th>
                            <th><i class="fas fa-cogs"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $status_class = '';
                                switch ($row['status']) {
                                    case 'pending': $status_class = 'text-warning'; break;
                                    case 'in_progress': $status_class = 'text-info'; break;
                                    case 'completed': $status_class = 'text-success'; break;
                                }
                                echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['service']}</td>
                                    <td>" . (strlen($row['description']) > 50 ? substr($row['description'], 0, 50) . '...' : $row['description']) . "</td>
                                    <td class='$status_class'><strong>" . ucfirst(str_replace('_', ' ', $row['status'])) . "</strong></td>
                                    <td>" . date('d M Y', strtotime($row['created_at'])) . "</td>
                                    <td>
                                        <button class='btn btn-success btn-sm btn-action' onclick='updateStatus({$row['id']}, \"completed\")'><i class='fas fa-check'></i> Selesai</button>
                                        <button class='btn btn-warning btn-sm btn-action' onclick='updateStatus({$row['id']}, \"in_progress\")'><i class='fas fa-play'></i> Proses</button>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center'>Tidak ada pesanan.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Update -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Update Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin mengupdate status pesanan ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a id="confirmLink" href="#" class="btn btn-primary">Ya, Update</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5