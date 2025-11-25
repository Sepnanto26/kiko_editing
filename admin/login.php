<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($username === 'admin' && $password === 'password123') {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Login gagal! Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Login - KIKO EDITING</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      position: relative;
    }

    /* Partikel animasi latar belakang untuk efek modern */
    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                  radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                  radial-gradient(circle at 40% 40%, rgba(120, 219, 226, 0.3) 0%, transparent 50%);
      animation: float 6s ease-in-out infinite alternate;
      z-index: -1;
    }

    @keyframes float {
      0% { transform: translateY(0px) rotate(0deg); }
      100% { transform: translateY(-20px) rotate(5deg); }
    }

    .login-container {
      position: relative;
      width: 400px;
      padding: 2.5rem 3rem;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 25px;
      box-shadow: 
        0 15px 35px rgba(0, 0, 0, 0.3),
        0 0 0 1px rgba(255, 255, 255, 0.2),
        inset 0 0 20px rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      animation: slideIn 1s ease-out;
      z-index: 1;
    }

    @keyframes slideIn {
      0% { opacity: 0; transform: translateY(50px) scale(0.9); }
      100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    .login-header {
      text-align: center;
      margin-bottom: 2rem;
      color: white;
    }

    .login-header i {
      font-size: 4.5rem;
      margin-bottom: 0.5rem;
      background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      filter: drop-shadow(0 0 10px rgba(255, 107, 107, 0.8));
      animation: pulse 2s infinite;
      user-select: none;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }

    .login-header h2 {
      font-weight: 700;
      font-size: 2.5rem;
      margin-bottom: 0.3rem;
      background: linear-gradient(45deg, #fff, #feca57);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      user-select: none;
    }

    .login-header p {
      font-weight: 500;
      font-size: 1rem;
      color: rgba(255, 255, 255, 0.8);
      user-select: none;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 1.8rem;
    }

    .input-group {
      position: relative;
    }

    .input-group i {
      position: absolute;
      top: 50%;
      left: 18px;
      transform: translateY(-50%);
      color: rgba(255, 255, 255, 0.6);
      font-size: 1.3rem;
      pointer-events: none;
      transition: all 0.3s ease;
    }

    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 16px 20px 16px 50px;
      border-radius: 20px;
      border: 2px solid rgba(255, 255, 255, 0.3);
      background: rgba(255, 255, 255, 0.1);
      color: white;
      font-size: 1.1rem;
      outline: none;
      transition: all 0.3s ease;
      backdrop-filter: blur(10px);
      box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
    }

    input[type="text"]::placeholder, input[type="password"]::placeholder {
      color: rgba(255, 255, 255, 0.5);
    }

    input[type="text"]:focus, input[type="password"]:focus {
      border-color: #4ecdc4;
      box-shadow: 0 0 20px rgba(78, 205, 196, 0.6), inset 0 0 10px rgba(78, 205, 196, 0.2);
      background: rgba(255, 255, 255, 0.15);
    }

    input[type="text"]:focus + i, input[type="password"]:focus + i {
      color: #4ecdc4;
      transform: translateY(-50%) scale(1.1);
    }

    .btn-login {
      padding: 16px 0;
      background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
      border: none;
      border-radius: 25px;
      font-weight: 700;
      font-size: 1.3rem;
      color: white;
      cursor: pointer;
      box-shadow: 0 10px 20px rgba(255, 107, 107, 0.4);
      transition: all 0.4s ease;
      user-select: none;
      position: relative;
      overflow: hidden;
    }

    .btn-login::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.5s;
    }

    .btn-login:hover::before {
      left: 100%;
    }

    .btn-login:hover, .btn-login:focus {
      background: linear-gradient(45deg, #4ecdc4, #ff6b6b);
      box-shadow: 0 15px 30px rgba(78, 205, 196, 0.6);
      transform: translateY(-5px) scale(1.02);
      outline: none;
    }

    .alert {
      border-radius: 20px;
      margin-top: 1.5rem;
      font-weight: 600;
      font-size: 1rem;
      text-shadow: none;
      box-shadow: 0 10px 25px rgba(220, 53, 69, 0.4);
      animation: bounceIn 0.6s ease;
      background: rgba(220, 53, 69, 0.9);
      color: white;
    }

    @keyframes bounceIn {
      0% { opacity: 0; transform: scale(0.3); }
      50% { opacity: 1; transform: scale(1.05); }
      70% { transform: scale(0.9); }
      100% { opacity: 1; transform: scale(1); }
    }

    .forgot-password {
      margin-top: 1.5rem;
      text-align: center;
      color: #4ecdc4;
      cursor: pointer;
      font-weight: 600;
      font-size: 1rem;
      user-select: none;
      transition: all 0.3s ease;
      text-decoration: none;
    }

    .forgot-password:hover, .forgot-password:focus {
      color: #ff6b6b;
      text-decoration: underline;
      transform: scale(1.05);
      outline: none;
    }

    @media (max-width: 480px) {
      .login-container {
        width: 90%;
        padding: 2rem 1.5rem;
      }
      .login-header h2 {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>
  <div class="login-container" role="main" aria-label="Formulir Login Admin Kiko Editing">
    <header class="login-header">
      <i class="fas fa-palette" aria-hidden="true"></i>
      <h2>Admin Login</h2>
      <p>KIKO EDITING - Akses Dashboard</p>
    </header>
    <?php if (isset($error)): ?>
      <div class="alert alert-danger" role="alert" tabindex="0">
        <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
      </div>
    <?php endif; ?>
    <form action="" method="POST" autocomplete="off" novalidate>
      <div class="input-group">
        <input type="text" name="username" id="username" placeholder="Masukkan username" required aria-required="true" aria-label="Username"/>
        <i class="fas fa-user" aria-hidden="true"></i>
      </div>
      <div class="input-group">
        <input type="password" name="password" id="password" placeholder="Masukkan password" required aria-required="true" aria-label="Password"/>
        <i class="fas fa-lock" aria-hidden="true"></i>
      </div>
      <button type="submit" class="btn-login" aria-label="Login ke dashboard Kiko Editing">
        <i class="fas fa-sign-in-alt"></i> Login
      </button>
    </form>
    <div class="forgot-password" tabindex="0" role="button" aria-pressed="false" onclick="alert('Silakan hubungi administrator untuk reset password.');" onkeypress="if(event.key === 'Enter'){this.onclick();}">
      Lupa password? Hubungi administrator.
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>