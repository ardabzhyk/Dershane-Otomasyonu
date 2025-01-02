<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Veritabanı bağlantısını dahil et
include 'connection.php'; // PDO bağlantısı içermelidir

// Form gönderildiyse verileri işle
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kullanıcıdan gelen verileri al
    $adsoyad = $_POST['adsoyad'];
    $eposta = $_POST['eposta'];
    $mesaj = $_POST['mesaj'];
    try {

        // Eğer e-posta yoksa kayıt ekle
        $sql = "INSERT INTO iletisim (adsoyad,eposta,mesaj) VALUES (:adsoyad, :eposta, :mesaj)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':adsoyad', $adsoyad);
        $stmt->bindParam(':eposta', $eposta);
        $stmt->bindParam(':mesaj', $mesaj);
        $stmt->execute();

        // Kayıt başarılıysa anasayfaya gönder
        header("Location: anasayfa.html");
        exit();
    } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
}
?>