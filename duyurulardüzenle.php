<?php
// Veritabanı bağlantısı
$servername = "localhost";
$username = "root"; // Kullanıcı adı
$password = ""; // Parola
$dbname = "Dershane"; // Veritabanı adı

$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı Hatası Kontrolü
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Silme İşlemi
if (isset($_GET['sil'])) {
    $id = intval($_GET['sil']);
    $conn->query("DELETE FROM duyurular WHERE id = $id");
    header("Location: duyurulardüzenle.php");
    exit();
}

// Düzenlenecek Duyuruyu Getirme
$edit_id = "";
$edit_baslik = "";
$edit_icerik = "";

if (isset($_GET['duzenle'])) {
    $edit_id = intval($_GET['duzenle']);
    $result = $conn->query("SELECT * FROM duyurular WHERE id = $edit_id");
    if ($row = $result->fetch_assoc()) {
        $edit_baslik = $row['baslik'];
        $edit_icerik = $row['icerik'];
    }
}

// Yeni Duyuru Ekleme veya Düzenleme
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $baslik = $conn->real_escape_string($_POST['baslik']);
    $icerik = $conn->real_escape_string($_POST['icerik']);
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Düzenleme
        $id = intval($_POST['id']);
        $conn->query("UPDATE duyurular SET baslik='$baslik', icerik='$icerik' WHERE id=$id");
    } else {
        // Ekleme
        $conn->query("INSERT INTO duyurular (baslik, icerik) VALUES ('$baslik', '$icerik')");
    }
    header("Location: duyurulardüzenle.php");
    exit();
}

// Tüm Duyuruları Listele
$result = $conn->query("SELECT * FROM duyurular ORDER BY olusturulma_tarihi DESC");
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
    <!-- Navbar -->
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

    <!-- Duyuru Formu -->
    <div class="form-container">
        <h2><?php echo $edit_id ? "Duyuru Düzenle" : "Yeni Duyuru Ekle"; ?></h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($edit_id); ?>">
            <label for="baslik">Başlık:</label>
            <input type="text" id="baslik" name="baslik" value="<?php echo htmlspecialchars($edit_baslik); ?>" required>

            <label for="icerik">İçerik:</label>
            <textarea id="icerik" name="icerik" rows="5" required><?php echo htmlspecialchars($edit_icerik); ?></textarea>

            <button type="submit"><?php echo $edit_id ? "Güncelle" : "Kaydet"; ?></button>
        </form>
    </div>

    <!-- Duyurular Liste -->
    <div class="card-container">
        <h2>Mevcut Duyurular</h2>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <h3><?php echo htmlspecialchars($row['baslik']); ?></h3>
                <p><?php echo htmlspecialchars($row['icerik']); ?></p>
                <a href="?duzenle=<?php echo $row['id']; ?>">Düzenle</a> |
                <a href="?sil=<?php echo $row['id']; ?>" onclick="return confirm('Silmek istediğinize emin misiniz?');">Sil</a>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Footer -->
    <footer>
        © 2024 Elit Dershane. Tüm Hakları Saklıdır.
    </footer>
</body>
<style>
    /* Genel Body Stili */
body {
    font-family: Arial, sans-serif;
    background-color: #2c2f38; /* Koyu gri arka plan */
    color: #e0e0e0; /* Açık gri metin */
    margin: 0;
    padding: 0;
}

/* Navbar Stili */
.navbar {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #1d2226; /* Koyu siyah navbar */
    color: #fff;
    padding: 15px;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 10;
}

.navbar ul {
    list-style: none;
    display: flex;
    margin: 0;
    padding: 0;
}

.navbar ul li {
    margin: 0 15px;
}

.navbar ul li a {
    text-decoration: none;
    color: #fff;
    padding: 10px 20px;
    background-color: #444; /* Butonlar için koyu gri */
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s;
}

.navbar ul li a:hover {
    background-color: #ff6600; /* Hoverda turuncu renk */
    color: #fff;
}

/* Sayfa içeriği */
h2 {
    text-align: center;
    color: #ffa500; /* Altın rengi başlık */
    margin-top: 80px; /* Navbar'ın altında başlık için boşluk */
}

.form-container {
    background-color: #333;
    max-width: 600px;
    margin: 40px auto;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
}

form input,
form textarea,
form button {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #555;
    background-color: #444;
    color: #fff;
    font-size: 16px;
}

form input:focus,
form textarea:focus {
    outline: none;
    border-color: #ffa500;
}

form button {
    background-color: #ff6600;
    cursor: pointer;
    transition: background-color 0.3s;
}

form button:hover {
    background-color: #e65c00;
}

/* Duyuru Kartları */
.card-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    padding: 20px;
}

.card {
    background-color: #444;
    padding: 20px;
    width: 300px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
}

.card h3 {
    font-size: 1.5em;
    color: #ffa500;
}

.card p {
    font-size: 1em;
    color: #ddd;
    margin-bottom: 15px;
}

.card a {
    text-decoration: none;
    color: #ff6600;
    font-weight: bold;
}

.card a:hover {
    color: #ff4500;
}

/* Footer */
footer {
    background-color: #1d2226;
    text-align: center;
    padding: 15px;
    color: #fff;
    position: fixed;
    bottom: 0;
    width: 100%;
}
</style>
</html>

<?php
$conn->close();
?>
