<?php
session_start();  // Oturum başlat

// Tüm oturum verilerini sil
session_unset();

// Oturumu sonlandır
session_destroy();

// Giriş sayfasına yönlendir
header("Location: giris.php");
exit();
?>
