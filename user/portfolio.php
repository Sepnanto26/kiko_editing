<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Portfolio - KIKO EDITING</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding-top: 60px;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding-bottom: 40px;
    }
    nav.navbar-custom {
      background: linear-gradient(135deg, #7c69f3, #9164e4);
      position: fixed;
      top: 0;
      width: 100%;
      height: 60px;
      z-index: 1050;
      box-shadow: 0 5px 15px rgba(67, 56, 152, 0.7);
      padding: 0 2rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    nav.navbar-custom .navbar-brand {
      color: white;
      font-weight: 700;
      font-size: 1.4rem;
      display: flex;
      align-items: center;
      gap: 10px;
      user-select: none;
      text-decoration: none;
    }
    nav.navbar-custom .navbar-brand i {
      font-size: 1.7rem;
    }
    nav.navbar-custom .nav-links {
      display: flex;
      align-items: center;
      gap: 1.8rem;
    }
    nav.navbar-custom .nav-link {
      color: white;
      font-weight: 600;
      font-size: 1.05rem;
      display: flex;
      align-items: center;
      gap: 6px;
      cursor: pointer;
      user-select: none;
      text-decoration: none;
      padding: 0.3rem 0.7rem;
      border-radius: 8px;
      transition: background 0.25s ease, color 0.25s ease;
    }
    nav.navbar-custom .nav-link:hover {
      background: rgba(255,255,255,0.15);
      color: #feca57;
      text-shadow: 0 0 6px #feca57;
    }
    .portfolio-container {
      max-width: 900px;
      width: 100%;
      background: rgba(255 255 255 / 0.15);
      border-radius: 25px;
      box-shadow:
        0 10px 30px rgba(0,0,0,0.3);
      backdrop-filter: blur(15px);
      padding: 3rem 2.5rem;
      text-align: center;
      user-select: none;
      color: white;
    }
    .portfolio-title {
      font-size: 3rem;
      font-weight: 800;
      margin-bottom: 1rem;
      background: linear-gradient(45deg, #ff6b6b, #feca57, #48cae4);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-shadow: 2px 2px 5px rgba(0,0,0,0.4);
    }
    .portfolio-description {
      font-size: 1.2rem;
      line-height: 1.6;
      margin-bottom: 2rem;
      text-shadow: 0 0 5px rgba(0,0,0,0.2);
      max-width: 750px;
      margin-left: auto;
      margin-right: auto;
    }
    .btn-custom {
      background: linear-gradient(45deg, #ff6b6b, #feca57, #48cae4);
      font-weight: 700;
      font-size: 1.3rem;
      border-radius: 30px;
      padding: 1.1rem 4rem;
      border: none;
      box-shadow: 0 12px 35px rgba(255, 107, 107, 0.9);
      color: white;
      cursor: pointer;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
      user-select: none;
    }
    .btn-custom i {
      font-size: 1.8rem;
      filter: drop-shadow(0 0 7px rgba(255, 255, 255, 0.75));
    }
    .btn-custom:hover {
      background: linear-gradient(45deg, #48cae4, #feca57, #ff6b6b);
      box-shadow: 0 15px 50px rgba(255,197,87,0.9);
      transform: scale(1.1);
      text-decoration: none;
    }
    @media (max-width: 576px) {
      .portfolio-container {
        padding: 2.5rem 1.5rem;
      }
      .portfolio-title {
        font-size: 2.2rem;
      }
      .portfolio-description {
        font-size: 1rem;
        max-width: 100%;
      }
      .btn-custom {
        font-size: 1.1rem;
        padding: 0.9rem 3rem;
      }
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-custom" role="navigation" aria-label="Main navigation">
    <a href="index.php" class="navbar-brand"><i class="fas fa-palette"></i> KIKO EDITING</a>
    <div class="nav-links">
      <a href="index.php" class="nav-link"><i class="fas fa-home"></i> Home</a>
      <a href="portfolio.php" class="nav-link active"><i class="fas fa-image"></i> Portfolio</a>
      <a href="order.php" class="nav-link"><i class="fas fa-shopping-cart"></i> Pesan Jasa</a>
    </div>
  </nav>

  <main class="portfolio-container" role="main" aria-label="Portfolio section">
    <h1 class="portfolio-title">Portfolio Kami</h1>
    <div class="portfolio-description">
      <h2>Selamat Datang di Portfolio Kiko Editing</h2>
      <p>
        Kami adalah tim kreatif yang berspesialisasi dalam desain grafis, editing video, dan pengembangan web.
        Dengan pengalaman bertahun-tahun, kami berkomitmen menghadirkan solusi visual inovatif dan berkualitas tinggi
        untuk kebutuhan bisnis dan pribadi Anda.
      </p>
      <p>
        Dari desain logo yang eye-catching sampai video promosi yang memukau, kami siap membantu mewujudkan visi Anda.
        Silakan klik tombol di bawah untuk melihat portfolio lengkap kami dalam format PDF.
      </p>
    </div>
    <a href="../assets/pdf/portfolio.pdf" target="_blank" rel="noopener" class="btn-custom" aria-label="Buka portfolio lengkap dalam format PDF">
      <i class="fas fa-file-pdf"></i> Lihat Portfolio Lengkap (PDF)
    </a>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>