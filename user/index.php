<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="KIKO EDITING - Jasa Desain Grafis Terbaik untuk Bisnis Anda. Kreatif, Cepat, dan Berkualitas Tinggi. Pesan logo, banner, dan UI/UX sekarang!">
    <meta name="keywords" content="desain grafis, logo design, banner, UI/UX, KIKO EDITING, jasa desain">
    <title>KIKO EDITING - Jasa Desain Grafis Terbaik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://via.placeholder.com/1920x1080/667eea/ffffff?text=Creative+Background') no-repeat center center;
            background-size: cover;
            opacity: 0.1;
            z-index: 1;
        }
        .hero .container {
            position: relative;
            z-index: 2;
        }
        .text-gradient {
            background: linear-gradient(45deg, #ff6b6b, #feca57, #48cae4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .btn-primary {
            background: linear-gradient(45deg, #ff6b6b, #feca57);
            border: none;
            border-radius: 50px;
            padding: 1rem 2rem;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4);
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 107, 107, 0.6);
        }
        .shadow-modern {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            transition: all 0.3s ease;
        }
        .shadow-modern:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
        .transition-smooth {
            transition: all 0.3s ease;
        }
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-img-top {
            border-radius: 15px 15px 0 0;
            height: 200px;
            object-fit: cover;
        }
        .testimonial-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
        }
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.6s ease;
        }
        .animate-on-scroll.animate {
            opacity: 1;
            transform: translateY(0);
        }
        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }
        .floating-elements div {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        .floating-elements div:nth-child(1) { width: 80px; height: 80px; top: 10%; left: 10%; animation-delay: 0s; }
        .floating-elements div:nth-child(2) { width: 60px; height: 60px; top: 20%; right: 15%; animation-delay: 2s; }
        .floating-elements div:nth-child(3) { width: 100px; height: 100px; bottom: 20%; left: 20%; animation-delay: 4s; }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .stats-section {
            background: #f8f9fa;
            padding: 3rem 0;
        }
        .stat-item {
            text-align: center;
            margin-bottom: 2rem;
        }
        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            color: #667eea;
        }
        .stat-label {
            font-size: 1.2rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <div class="hero">
        <div class="floating-elements">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="container text-center">
            <h1 class="display-4 text-gradient animate-on-scroll">Selamat Datang di KIKO EDITING</h1>
            <p class="lead animate-on-scroll">Jasa Desain Grafis Terbaik untuk Bisnis Anda – Kreatif, Cepat, dan Berkualitas Tinggi. Kami siap membantu mewujudkan ide-ide brilian Anda menjadi karya visual yang memukau.</p>
            <a href="order.php" class="btn btn-primary btn-lg animate-on-scroll">Pesan Sekarang</a>
            <div class="mt-4 animate-on-scroll">
                <small class="text-white-50">Bergabunglah dengan ribuan klien puas kami. Dari startup hingga korporasi besar, kami telah membantu mereka bersinar!</small>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 stat-item animate-on-scroll">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Proyek Selesai</div>
                </div>
                <div class="col-md-3 stat-item animate-on-scroll">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Kepuasan Klien</div>
                </div>
                <div class="col-md-3 stat-item animate-on-scroll">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Klien Aktif</div>
                </div>
                <div class="col-md-3 stat-item animate-on-scroll">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Dukungan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Fitur Layanan -->
    <section class="py-5 bg-white">
        <div class="container">
            <h2 class="text-center mb-5 text-gradient animate-on-scroll">Mengapa Memilih KIKO EDITING?</h2>
            <div class="row g-4">
                <div class="col-md-4 animate-on-scroll">
                    <div class="card h-100 shadow-modern transition-smooth">
                        <div class="card-body text-center">
                            <i class="fas fa-palette fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Desain Kreatif & Inovatif</h5>
                            <p class="card-text">Tim desainer berpengalaman kami menciptakan desain unik yang tidak hanya estetis, tetapi juga efektif dalam menyampaikan pesan brand Anda. Kami menggunakan tren terkini dan teknologi terdepan untuk hasil yang luar biasa.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 animate-on-scroll">
                    <div class="card h-100 shadow-modern transition-smooth">
                        <div class="card-body text-center">
                            <i class="fas fa-clock fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Cepat & Tepat Waktu</h5>
                            <p class="card-text">Kami memahami pentingnya deadline. Dengan proses kerja yang efisien dan terstruktur, kami selalu menyelesaikan proyek tepat waktu tanpa mengorbankan kualitas. Revisi gratis hingga Anda puas!</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 animate-on-scroll">
                    <div class="card h-100 shadow-modern transition-smooth">
                        <div class="card-body text-center">
                            <i class="fas fa-star fa-3x text-warning mb-3"></i>
                            <h5 class="card-title">Kualitas Terjamin & Harga Terjangkau</h5>
                            <p class="card-text">Setiap desain kami melalui proses quality control ketat. Kami menawarkan harga kompetitif dengan hasil premium. Mulai dari logo sederhana hingga kampanye pemasaran lengkap, kami siap membantu.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Portfolio Preview -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 text-gradient animate-on-scroll">Portfolio Terbaru Kami</h2>
            <div class="row g-4">
                <div class="col-md-4 animate-on-scroll">
                    <div class="card shadow-modern transition-smooth">
                        <img src="https://via.placeholder.com/400x300/667eea/ffffff?text=Logo+Design" class="card-img-top" alt="Desain Logo Modern untuk Startup Teknologi">
                        <div class="card-body">
                            <h5 class="card-title">Desain Logo Modern</h5>
                            <p class="card-text">Logo kreatif dan profesional untuk startup teknologi. Menggabungkan elemen futuristik dengan kesederhanaan yang elegan.</p>
                            <a href="portfolio.php" class="btn btn-primary">Lihat Lebih Banyak</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 animate-on-scroll">
                    <div class="card shadow-modern transition-smooth">
                        <img src="https://via.placeholder.com/400x300/764ba2/ffffff?text=Banner+Design" class="card-img-top" alt="Banner Promosi untuk Kampanye Marketing">
                        <div class="card-body">
                            <h5 class="card-title">Banner Promosi</h5>
                            <p class="card-text">Banner eye-catching untuk kampanye marketing digital. Dirancang untuk meningkatkan engagement dan konversi penjualan.</p>
                            <a href="portfolio.php" class="btn btn-primary">Lihat Lebih Banyak</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 animate-on-scroll">
                    <div class="card shadow-modern transition-smooth">
                        <img src="https://via.placeholder.com/400x300/ff6b6b/ffffff?text=Website+Design" class="card-img-top" alt="UI/UX Website Responsif dan User-Friendly">
                        <div class="card-body">
                            <h5 class="card-title">UI/UX Website</h5>
                            <p class="card-text">Interface yang user-friendly dan responsif. Mengoptimalkan pengalaman pengguna untuk konversi yang lebih tinggi.</p>
                            <a href="portfolio.php" class="btn btn-primary">Lihat Lebih Banyak</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4 animate-on-scroll">
                <a href="portfolio.php" class="btn btn-outline-primary btn-lg">Jelajahi Semua Portfolio</a>
            </div>
        </div>
    </section>

    <!-- Section Testimonial -->
    <section class="py-5 bg-white">
        <div class="container">
            <h2 class="text-center mb-5 text-gradient animate-on-scroll">Apa Kata Klien Kami?</h2>
            <div class="row g-4">
                <div class="col-md-6 animate-on-scroll">
                    <div class="card testimonial-card shadow-modern transition-smooth">
                        <div class="card-body">
                            <p class="card-text">"KIKO EDITING sangat membantu bisnis saya. Desain logo mereka luar biasa dan benar-benar mencerminkan brand kami. Prosesnya cepat dan komunikasi sangat baik!"</p>
                            <footer class="blockquote-footer">Ahmad Rahman, CEO Startup TechInnovate</footer>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 animate-on-scroll">
                    <div class="card testimonial-card shadow-modern transition-smooth">
                        <div class="card-body">
                            <p class="card-text">"Saya sangat puas dengan hasil banner promosi mereka. Trafik website saya meningkat drastis setelah menggunakan desain KIKO. Recommended banget!"</p>
                            <footer class="blockquote-footer">Sari Lestari, Marketing Manager PT. Maju Jaya</footer>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Call to Action -->
    <section class="py-5 text-center bg-gradient-primary text-white">
        <div class="container">
            <h2 class="mb-3 animate-on-scroll">Siap Tingkatkan Brand Anda?</h2>
            <p class="lead mb-4 animate-on-scroll">Hubungi kami sekarang dan dapatkan konsultasi gratis! Kami siap mendengarkan kebutuhan Anda dan memberikan solusi terbaik.</p>
            <a href="order.php" class="btn btn-light btn-lg me-3 animate-on-scroll">Pesan Jasa</a>
            <a href="mailto:info@kikoediting.com" class="btn btn-outline-light btn-lg animate-on-scroll">Kontak Kami</a>
            <div class="mt-4 animate-on-scroll">
                <small>WhatsApp: +62 812-3456-7890 | Email: info@kikoediting.com</small>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animasi scroll untuk elemen
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate');
                }
            });
        });

        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });

        // Efek parallax sederhana untuk hero
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const hero = document.querySelector('.hero');
            hero.style.backgroundPositionY = -(scrolled * 0.5) + 'px';
        });
    </script>
</body>
</html>