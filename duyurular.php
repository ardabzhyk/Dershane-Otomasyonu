<?php 
// Veritabanı bağlantısı
$servername = "localhost";
$username = "root"; // Kullanıcı adı
$password = ""; // Parola
$dbname = "Dershane"; // Veritabanı adı
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Duyuruları ve yayınlayan bilgilerini çekme
$sql = "SELECT d.id, d.baslik, d.icerik, d.olusturulma_tarihi, 
               u.ad AS yayinlayan_ad, u.soyad AS yayinlayan_soyad
        FROM duyurular AS d
        LEFT JOIN users AS u ON d.yayinlayan_id = u.id
        ORDER BY d.olusturulma_tarihi DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duyuruları Düzenle</title>
    <link rel="stylesheet" href="duyurular.css">
</head>

<body>
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
    <h1>Duyurular</h1>
    <div class="duyuru-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="duyuru-card">
                    <h3><?php echo htmlspecialchars($row['baslik']); ?></h3>
                    <p><?php echo nl2br(htmlspecialchars($row['icerik'])); ?></p>
                    <small>
                        Yayınlayan: 
                        <?php 
                        echo $row['yayinlayan_ad'] 
                            ? htmlspecialchars($row['yayinlayan_ad'] . ' ' . $row['yayinlayan_soyad']) 
                            : "Bilinmiyor";
                        ?>
                        | Tarih: <?php echo $row['olusturulma_tarihi']; ?>
                    </small>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Henüz duyuru eklenmemiş.</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
$conn->close();
?>
<style>
 body {
    font-family: Arial, sans-serif;
    background-color: #2c2f38; /* Koyu arka plan */
    color: #e0e0e0; /* Açık gri metin */
    margin: 0;
    padding: 0;
}

/* Navbar'ı sayfanın en üst kısmına al */
.navbar {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: transparent;
    color: #fff;
    padding: 20px 30px;
    position: fixed;
    width: 100%;
    z-index: 10;
    top: 0; /* Navbar'ı en üst kısma yerleştiriyoruz */
}

.navbar ul {
    list-style: none;
    display: flex;
    margin: 0;
    padding: 0;
}

.navbar ul li {
    margin: 0 10px;
}

.navbar ul li a {
    text-decoration: none;
    color: #fff; /* Yazılar beyaz */
    background-color: #000; /* Butonlar siyah */
    padding: 10px 15px;
    border-radius: 10px;
    transition: 0.3s;
}

.navbar ul li a:hover {
    background-color: #f00;
    color: #fff;
}

/* Navbar yüksekliği için h1 başlığına boşluk ekleyin */
h1 {
    text-align: center;
    margin-top: 120px; /* Navbar'ın yüksekliği (yaklaşık 100px) ve padding için boşluk */
    color: #f4f4f4; /* Açık renk başlık */
}

.duyuru-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    padding: 20px;
}

.duyuru-card {
    background-color: #3b434f; /* Koyu gri kart arka planı */
    border: 1px solid #4f5a67; /* Hafif koyu gri kenarlık */
    border-radius: 8px;
    padding: 20px;
    width: 300px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Daha belirgin gölge */
    transition: transform 0.3s;
}

.duyuru-card:hover {
    transform: translateY(-5px);
}

.duyuru-card h3 {
    margin-top: 0;
    font-size: 1.5em;
    color: #ffa500; /* Sarımsı turuncu başlık rengi */
}

.duyuru-card p {
    font-size: 1em;
    color: #d1d1d1; /* Açık gri yazı rengi */
    margin-bottom: 10px;
}

.duyuru-card small {
    font-size: 0.9em;
    color: #b0b0b0; /* Daha koyu gri alt bilgi */
}
</style>