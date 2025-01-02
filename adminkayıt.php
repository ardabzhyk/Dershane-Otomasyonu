<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Veritabanı bağlantısını dahil et
include 'connection.php'; // PDO bağlantısı içermelidir

// Form gönderildiyse verileri işle
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kullanıcıdan gelen verileri al
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $email = $_POST['email'];
    $sifre = $_POST['sifre'];  // sadece şifreyi alıyoruz
    $rol = $_POST['rol'];

    // Şifreyi güvenli şekilde hashle
    $sifre_hash = password_hash($sifre, PASSWORD_DEFAULT);

    try {
        // E-posta kontrolü: Bu e-posta veritabanında var mı?
        $checkSql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($checkSql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Aynı e-posta zaten var
            echo "<script>alert('Bu e-posta adresi zaten kullanılıyor. Lütfen farklı bir e-posta deneyin.'); window.location.href = 'adminkayıt.html';</script>";
            exit();
        }

        // Eğer e-posta yoksa kayıt ekle
        $sql = "INSERT INTO users (ad, soyad, email, sifre, rol) VALUES (:ad, :soyad, :email, :sifre, :rol)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':ad', $ad);
        $stmt->bindParam(':soyad', $soyad);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':sifre', $sifre_hash);
        $stmt->bindParam(':rol', $rol);

        $stmt->execute();

        // Kayıt başarılıysa giriş sayfasına yönlendir
        header("Location: giris.html");
        exit();
    } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
}
?>
