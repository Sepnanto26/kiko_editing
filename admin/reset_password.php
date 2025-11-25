     <?php
     include 'includes/db.php';  // Koneksi database

     $new_password = 'admin123';  // Ganti dengan password baru yang Anda inginkan
     $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);  // Generate hash bcrypt

     $stmt = $conn->prepare("UPDATE admin SET password = ? WHERE username = 'admin'");
     $stmt->bind_param("s", $hashed_password);

     if ($stmt->execute()) {
         echo "<h2>Password admin berhasil direset!</h2>";
         echo "<p>Username: admin</p>";
         echo "<p>Password baru: $new_password</p>";
         echo "<p>Hash yang disimpan: $hashed_password</p>";
         echo "<p>Sekarang hapus file ini untuk keamanan, lalu test login di <a href='admin/login.php'>admin/login.php</a>.</p>";
     } else {
         echo "Error: " . $stmt->error;
     }

     $stmt->close();
     $conn->close();
     ?>
     