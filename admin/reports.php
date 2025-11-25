<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../includes/db.php';

// Query jumlah pesanan per bulan (6 bulan terakhir)
$monthly_orders = [];
$monthly_labels = [];
for ($i = 5; $i >= 0; $i--) {
    $month = date('Y-m', strtotime("-$i month"));
    $label = date('M Y', strtotime("-$i month"));
    $count = $conn->query("SELECT COUNT(*) as count FROM orders WHERE DATE_FORMAT(created_at, '%Y-%m') = '$month'")->fetch_assoc()['count'];
    $monthly_orders[] = (int)$count;
    $monthly_labels[] = $label;
}

// Total pendapatan (placeholder: 100.000 per pesanan completed)
$total_revenue = $conn->query("SELECT SUM(CASE WHEN status='completed' THEN 100000 ELSE 0 END) as revenue FROM orders")->fetch_assoc()['revenue'];
if (!$total_revenue) $total_revenue = 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Reports - Admin Dashboard KIKO EDITING</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
        margin: 0;
        padding-top: 70px;
        color: white;
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
    }

    /* Partikel animasi latar belakang untuk efek modern */
    body::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 20% 80%, rgba(255, 119, 198, 0.2) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(120, 219, 226, 0.2) 0%, transparent 50%),
                    radial-gradient(circle at 40% 40%, rgba(255, 0, 150, 0.15) 0%, transparent 50%);
        animation: drift 8s ease-in-out infinite alternate;
        z-index: -1;
    }

    @keyframes drift {
        0% { transform: translateY(0px) rotate(0deg); opacity: 0.8; }
        100% { transform: translateY(-30px) rotate(10deg); opacity: 1; }
    }

    .navbar-custom {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1030;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .sidebar {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        min-height: 100vh;
        position: fixed;
        width: 280px;
        top: 70px;
        left: 0;
        padding-top: 2rem;
        box-shadow: inset -2px 0 10px rgba(0, 0, 0, 0.2), 0 0 20px rgba(255, 0, 150, 0.1);
        border-right: 1px solid rgba(255, 255, 255, 0.2);
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
        background: linear-gradient(90deg, transparent, rgba(255, 0, 150, 0.3), transparent);
        transition: left 0.5s;
    }

    .sidebar .nav-link:hover::before,
    .sidebar .nav-link.active::before {
        left: 100%;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background: linear-gradient(135deg, #ff0086, #00d4ff);
        color: white;
        box-shadow: 0 0 25px rgba(255, 0, 150, 0.6);
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
        background: linear-gradient(45deg, #ff0086, #00d4ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 0 20px rgba(255, 0, 150, 0.5);
        animation: glow 2s ease-in-out infinite alternate;
    }

    @keyframes glow {
        from { filter: drop-shadow(0 0 5px rgba(255, 0, 150, 0.5)); }
        to { filter: drop-shadow(0 0 15px rgba(255, 0, 150, 0.8)); }
    }

    p {
        opacity: 0.9;
        margin-bottom: 35px;
        user-select: none;
        font-size: 1.1rem;
    }

    .stats-cards {
        display: flex;
        gap: 40px;
        margin-bottom: 50px;
    }

    .card-stat {
        flex: 1;
        background: linear-gradient(135deg, rgba(255, 0, 150, 0.2), rgba(0, 212, 255, 0.2));
        padding: 30px 35px;
        border-radius: 25px;
        color: white;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3), 0 0 20px rgba(255, 0, 150, 0.2);
        text-align: center;
        transition: all 0.4s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
    }

    .card-stat::before {
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

    .card-stat:hover::before {
        transform: rotate(45deg) translate(100%, 100%);
    }

    .card-stat:hover {
        transform: translateY(-15px) scale(1.05);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4), 0 0 30px rgba(255, 0, 150, 0.5);
    }

    .card-stat h5 {
        font-weight: 600;
        font-size: 1.2rem;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: rgba(255, 255, 255, 0.9);
    }

    .card-stat h3 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 10px;
        background: linear-gradient(135deg, #ff0086, #00d4ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: pulse 3s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .chart-container {
        background: rgba(255, 255, 255, 0.1);
        padding: 40px 50px;
        border-radius: 25px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3), 0 0 20px rgba(0, 212, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.2);
        animation: slideIn 1.2s ease-out;
    }

    @keyframes slideIn {
        0% { opacity: 0; transform: translateX(-50px); }
        100% { opacity: 1; transform: translateX(0); }
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
        .stats-cards {
            flex-direction: column;
            gap: 25px;
        }
        .card-stat {
            padding: 25px 30px;
        }
        .chart-container {
            padding: 30px 35px;
        }
    }
</style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top" role="banner">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fas fa-tachometer-alt"></i> KIKO EDITING Dashboard</a>
        <div class="d-flex">
            <span class="navbar-text me-3">Welcome, Admin!</span>
            <a href="logout.php" class="btn btn-outline-light btn-sm"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar" role="navigation" aria-label="Main dashboard navigation">
    <nav class="nav flex-column">
        <a class="nav-link" href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
        <a class="nav-link" href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a>
        <a class="nav-link" href="settings.php"><i class="fas fa-cogs"></i> Settings</a>
        <a class="nav-link active" href="reports.php"><i class="fas fa-chart-line"></i> Reports</a>
    </nav>
</div>

<!-- Main Content -->
<div class="main-content" role="main" aria-label="Reports content">
    <h2><i class="fas fa-chart-line"></i> Reports</h2>
    <p>Halaman laporan dengan grafik dan statistik pesanan terbaru serta pendapatan.</p>

    <!-- Statistik Cards -->
    <section class="stats-cards" aria-label="Summary statistics">
        <article class="card-stat" tabindex="0" aria-describedby="desc-revenue">
            <h5><i class="fas fa-dollar-sign"></i> Total Pendapatan</h5>
            <h3 aria-live="polite" aria-atomic="true">Rp <?php echo number_format($total_revenue, 0, ',', '.'); ?></h3>
            <p id="desc-revenue">Dari pesanan yang completed</p>
        </article>
        <article class="card-stat" tabindex="0" aria-describedby="desc-month-orders">
            <h5><i class="fas fa-calendar-alt"></i> Pesanan Bulan Ini</h5>
            <h3 aria-live="polite" aria-atomic="true"><?php echo end($monthly_orders); ?></h3>
            <p id="desc-month-orders">Pesanan terbaru bulan ini</p>
        </article>
    </section>

    <!-- Grafik Pesanan Bulanan -->
    <section class="chart-container" aria-label="Grafik pesanan bulanan">
        <canvas id="monthlyChart" aria-describedby="desc-chart"></canvas>
        <p id="desc-chart" class="visually-hidden">Grafik garis yang menunjukkan jumlah pesanan selama 6 bulan terakhir</p>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const labels = <?php echo json_encode($monthly_labels); ?>;
    const data = <?php echo json_encode($monthly_orders); ?>;
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(255, 0, 150, 0.5)');
    gradient.addColorStop(1, 'rgba(0, 212, 255, 0.1)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Pesanan',
                data: data,
                borderColor: '#ff0086',
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointHoverRadius: 10,
                pointBackgroundColor: '#00d4ff',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                hoverBorderWidth: 3,
                hoverBackgroundColor: '#ff0086'
            }]
        },
        options: {
            responsive: true,
            interaction: { mode: 'nearest', intersect: false },
            plugins: {
                legend: { labels: { color: 'white', font: { weight: '600', size: 16 } } },
                tooltip: { 
                    mode: 'index', 
                    intersect: false, 
                    backgroundColor: 'rgba(0, 0, 0, 0.8)', 
                    titleColor: '#00d4ff', 
                    bodyColor: 'white' 
                }
            },
            scales: {
                x: {
                    ticks: { color: 'white', font: { weight: '600', size: 14 } },
                    grid: { color: 'rgba(255, 255, 255, 0.1)' }
                },
                y: {
                    beginAtZero: true,
                    ticks: { color: 'white', font: { weight: '600', size: 14 } },
                    grid: { color: 'rgba(255, 255, 255, 0.1)' }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart'
            }
        }
    });
</script>
</body>
</html>