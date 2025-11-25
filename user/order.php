<?php include '../includes/header.php'; include '../includes/db.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Pesan Jasa Desain - KIKO EDITING</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
  <style>
    /* Background dan font modern */
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
      font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem;
      overflow-x: hidden;
    }

    /* Container Form */
    .order-container {
      max-width: 700px;
      width: 100%;
      background: rgba(24, 24, 34, 0.9);
      border-radius: 25px;
      padding: 3rem 3.5rem;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
      position: relative;
      overflow: hidden;
      color: #e0e0e0;
      animation: fadeInUp 1s ease forwards;
      backdrop-filter: blur(20px);
    }

    /* Judul */
    h2 {
      font-weight: 800;
      font-size: 2.8rem;
      margin-bottom: 0.3rem;
      background: linear-gradient(45deg, #ff6b6b, #feca57, #48cae4);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      user-select: none;
      text-align: center;
    }
    p.lead {
      text-align: center;
      margin-bottom: 2.5rem;
      color: #aaa;
      font-size: 1.2rem;
    }

    /* Label form dengan icon */
    label {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-weight: 600;
      font-size: 1.1rem;
      color: #f0f0f0;
    }

    /* Input dan Select modern */
    .form-control, .form-select {
      border-radius: 15px;
      border: none;
      padding: 1rem 1.5rem;
      background: rgba(255, 255, 255, 0.05);
      color: #ddd;
      font-size: 1.1rem;
      transition: box-shadow 0.4s ease, background-color 0.4s ease;
      backdrop-filter: blur(10px);
      box-shadow: inset 1px 1px 15px rgba(255 255 255 / 0.1);
    }
    .form-control::placeholder {
      color: rgba(255, 255, 255, 0.5);
      font-style: italic;
    }
    .form-control:focus, .form-select:focus {
      outline: none;
      background: rgba(255, 255, 255, 0.12);
      box-shadow: 0 0 15px #ff6b6bcc;
      color: white;
      transform: translateY(-3px);
    }

    textarea.form-control {
      resize: vertical;
      min-height: 120px;
    }

    /* Tombol Submit besar dan vibrant */
    .btn-submit {
      display: block;
      width: 100%;
      padding: 1.2rem;
      font-size: 1.3rem;
      font-weight: 700;
      color: white;
      border: none;
      border-radius: 50px;
      background: linear-gradient(45deg, #ff6b6b, #feca57);
      box-shadow: 0 10px 35px rgba(255, 107, 107, 0.7);
      cursor: pointer;
      transition: all 0.4s ease;
      position: relative;
      overflow: hidden;
      user-select: none;
    }
    .btn-submit::before {
      content: '';
      position: absolute;
      top: 0; left: -100%;
      width: 100%; height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
      transition: left 0.7s;
    }
    .btn-submit:hover::before {
      left: 100%;
    }
    .btn-submit:hover {
      background: linear-gradient(45deg, #feca57, #ff6b6b);
      transform: translateY(-4px) scale(1.05);
      box-shadow: 0 15px 50px rgba(254, 202, 87, 0.9);
    }

    /* Informasi di bawah form */
    .alert-info {
      background: rgba(23, 162, 184, 0.85);
      color: white;
      border-radius: 15px;
      font-weight: 600;
      margin-top: 2rem;
      text-align: center;
      box-shadow: 0 6px 25px rgba(23, 162, 184, 0.6);
      user-select: none;
    }

    /* Animasi Fade In Up */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .fade-in-up {
      animation: fadeInUp 1s ease forwards;
    }

    /* Validasi input error */
    .form-control.is-invalid {
      box-shadow: 0 0 8px #dc3545;
      border-color: #dc3545;
      background: rgba(255, 50, 50, 0.15);
      color: #fff;
    }

    @media (max-width: 576px) {
      .order-container {
        padding: 2rem;
      }
      label {
        font-size: 1rem;
      }
      .btn-submit {
        font-size: 1.1rem;
        padding: 1rem;
      }
    }
  </style>
</head>
<body>

<div class="order-container fade-in-up" role="main" aria-labelledby="formTitle">
  <h2 id="formTitle"><i class="fas fa-shopping-cart"></i> Pesan Jasa Desain</h2>
  <p class="lead">Isi form di bawah untuk memulai proyek desain Anda</p>

  <form action="" method="POST" novalidate>
    <div class="row g-4">
      <div class="col-md-6">
        <label for="name"><i class="fas fa-user"></i> Nama Lengkap</label>
        <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan nama Anda" aria-required="true" required />
      </div>
      <div class="col-md-6">
        <label for="email"><i class="fas fa-envelope"></i> Email</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="contoh@email.com" aria-required="true" required/>
      </div>
    </div>

    <div class="mt-4">
      <label for="service"><i class="fas fa-tools"></i> Jenis Jasa</label>
      <select id="service" name="service" class="form-select" aria-required="true" required>
        <option value="" disabled selected>Pilih jenis jasa</option>
        <option value="Logo Design">🎨 Logo Design</option>
        <option value="Banner Design">📢 Banner Design</option>
        <option value="Website Design">🌐 Website Design</option>
        <option value="Video Editing">🎥 Video Editing</option>
        <option value="Branding Package">📦 Branding Package</option>
      </select>
    </div>

    <div class="mt-4">
      <label for="description"><i class="fas fa-edit"></i> Deskripsi Proyek</label>
      <textarea id="description" name="description" class="form-control" rows="5" placeholder="Jelaskan detail proyek Anda, seperti warna favorit, gaya yang diinginkan, referensi, dll." aria-required="true" required></textarea>
    </div>

    <button type="submit" class="btn-submit mt-5" aria-label="Kirim Pesanan Jasa Desain">
      <i class="fas fa-paper-plane"></i> Kirim Pesanan
    </button>
  </form>

  <div class="alert alert-info" role="alert">
    <i class="fas fa-info-circle"></i> Setelah mengirim, tim kami akan menghubungi Anda dalam 24 jam untuk konfirmasi dan diskusi lebih lanjut.
  </div>

  <?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $name = trim($_POST['name']);
      $email = trim($_POST['email']);
      $service = $_POST['service'];
      $description = trim($_POST['description']);

      $stmt = $conn->prepare("INSERT INTO orders (name, email, service, description) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss", $name, $email, $service, $description);

      if ($stmt->execute()) {
          echo "<div class='alert alert-success mt-4 animate__animated animate__fadeIn' role='alert'><i class='fas fa-check-circle'></i> Pesanan berhasil dikirim! Terima kasih atas kepercayaan Anda. Kami akan segera menghubungi Anda.</div>";
      } else {
          echo "<div class='alert alert-danger mt-4 animate__animated animate__fadeIn' role='alert'><i class='fas fa-exclamation-triangle'></i> Terjadi kesalahan: " . htmlspecialchars($stmt->error) . ". Silakan coba lagi.</div>";
      }
      $stmt->close();
  }
  ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Validasi real-time email dengan efek visual
  const emailInput = document.getElementById('email');
  emailInput.addEventListener('input', function () {
    const emailValue = this.value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(emailValue)) {
      this.classList.add('is-invalid');
    } else {
      this.classList.remove('is-invalid');
    }
  });

  // Fokus naikkan input saat hover
  document.querySelectorAll('.form-control, .form-select').forEach(input => {
    input.addEventListener('mouseenter', () => input.style.transform = 'translateY(-2px)');
    input.addEventListener('mouseleave', () => { if (!input.classList.contains('is-invalid')) input.style.transform = 'translateY(0)'; });
  });

  // Loading spinner di tombol submit
  const form = document.querySelector('form');
  form.addEventListener('submit', () => {
    const btn = document.querySelector('.btn-submit');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
  });
</script>

</body>
</html>