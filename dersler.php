<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'öğrenci') {
    header("Location: giris.php");
    exit;
}

$host = "localhost";
$dbname = "Dershane";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $ogrenci_id = $_SESSION['user_id'];

    // Öğrencinin derslerini getir
    $stmt = $conn->prepare("
        SELECT d.ad AS ders_adi, d.aciklama, u.ad AS ogretmen 
        FROM kayitlar k
        JOIN dersler d ON k.ders_id = d.id
        JOIN users u ON d.ogretmen_id = u.id
        WHERE k.ogrenci_id = :ogrenci_id
    ");
    $stmt->bindParam(':ogrenci_id', $ogrenci_id);
    $stmt->execute();
    $dersler = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Derslerim</title>
    <link rel="stylesheet" href="dersler.css">
</head>
<body>
    <!-- Gezinti Çubuğu -->
    <nav class="navbar">
        <ul>
        <li><a href="duyurular.php">Duyurular</a></li>
            <li><a href="dersler.php">Dersler</a></li>
            <li><a href="anasayfa.html">Anasayfa</a></li>
            <li><a href="DersProgramı.php">Ders Programı</a></li>
            <li><a href="İletisim.html">İletişim</a></li>
            <li><a href="kayitol.html">Kayıt Ol</a></li>
            <li><a href="giris.php">Giriş</a></li>
        </ul>
    </nav>

    <!-- Ana İçerik -->
    <div class="container">
        <div class="header">
            <h1>Derslerim</h1>
            <p>Uzman eğitmenlerle kaliteli ve modern eğitim içerikleri.</p>
        </div>

        <div class="cards">
            <?php
            if ($dersler) {
                foreach ($dersler as $ders) {
                    echo "<div class='card'>";
                    echo "<h3>" . htmlspecialchars($ders['ders_adi']) . "</h3>";
                    echo "<p>" . htmlspecialchars($ders['aciklama']) . "</p>";
                    echo "<p><strong>Öğretmen:</strong> " . htmlspecialchars($ders['ogretmen']) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>Henüz kayıtlı bir dersiniz bulunmamaktadır.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Alt Bilgi -->
    <footer>
        © 2024 Elit Dershane. Tüm Hakları Saklıdır.
    </footer>
</body>
</html>
<style>
    /* Genel vücut stili */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #121212; /* Koyu arka plan */
    color: #e0e0e0; /* Açık metin rengi */
}

/* Gezinti çubuğu */
.navbar {
    background-color: #1f1f1f; /* Koyu gri arka plan */
    padding: 15px 0;
    text-align: center;
    border-bottom: 2px solid #444;
}

.navbar ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

.navbar ul li {
    display: inline;
    margin-right: 20px;
}

.navbar ul li a {
    color: #e0e0e0; /* Açık metin rengi */
    text-decoration: none;
    font-size: 18px;
    padding: 10px 15px;
    transition: background-color 0.3s ease;
}

.navbar ul li a:hover {
    background-color: #575757; /* Hover rengi */
    border-radius: 5px;
}

/* Ana içerik kısmı */
.container {
    width: 80%;
    margin: 0 auto;
    padding: 30px;
}

/* Başlık kısmı */
.header {
    text-align: center;
    margin-bottom: 40px;
}

.header h1 {
    font-size: 38px;
    color: #e0e0e0;
}

.header p {
    font-size: 18px;
    color: #b0b0b0; /* Daha açık metin rengi */
}

/* Kartlar kısmı */
.cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
}

.card {
    background-color: #2b2b2b; /* Koyu gri kart arka planı */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-10px);
}

.card h3 {
    font-size: 24px;
    color: #f5f5f5; /* Beyaz metin rengi */
    margin-bottom: 15px;
}

.card p {
    font-size: 16px;
    color: #ccc; /* Gri metin rengi */
}

/* Alt bilgi kısmı */
footer {
    text-align: center;
    padding: 15px;
    background-color: #1f1f1f;
    color: #e0e0e0;
    position: fixed;
    width: 100%;
    bottom: 0;
}

footer a {
    color: #f5f5f5;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s ease;
}

footer a:hover {
    color: #ff7043; /* Alt bilgi bağlantısı hover rengi */
}

</style>