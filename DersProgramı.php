<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ders Programı</title>
    <link rel="stylesheet" href="dersprogrami.css">
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: giris.php");
        exit;
    }
    ?>

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

    <!-- Sayfa İçeriği -->
    <div class="container">
        <div class="header">
            <h1>Ders Programı</h1>
            <p>Elit Dershane'deki tüm derslerin zaman çizelgesini görüntüleyebilirsiniz.</p>
        </div>

        <!-- Ders Programı Tablosu -->
        <table>
            <thead>
                <tr>
                    <th>Ders Adı</th>
                    <th>Öğretmen</th>
                    <th>Gün</th>
                    <th>Saat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Veritabanı bağlantısı
                    $conn = new mysqli("localhost", "root", "", "dershane");

                    if ($conn->connect_error) {
                        die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
                    }

                    // Oturumdaki kullanıcı ID'sini al
                    $ogrenci_id = $_SESSION['user_id'];

                    // SQL sorgusu
                    $sql = "SELECT program.id, dersler.ad AS ders_ad, users.ad AS ogretmen, program.gun, program.baslangic_saat, program.bitis_saat 
                            FROM program 
                            JOIN dersler ON program.ders_id = dersler.id
                            JOIN users ON dersler.ogretmen_id = users.id
                            JOIN kayitlar ON dersler.id = kayitlar.ders_id
                            WHERE kayitlar.ogrenci_id = ?";

                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $ogrenci_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Veritabanından verileri çekip tabloya yazdırma
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['ders_ad']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['ogretmen']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['gun']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['baslangic_saat'] . " - " . $row['bitis_saat']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Henüz programda ders bulunmamaktadır.</td></tr>";
                    }

                    $stmt->close();
                    $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer>
        © 2024 Elit Dershane. Tüm Hakları Saklıdır.
    </footer>
</body>
</html>
<style>
    /* Genel Stil */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background-color: #111;
    color: #fff;
    display: flex;
    flex-direction: column;
    min-height: 100vh; /* Sayfanın yüksekliğini tüm ekran boyutu yap */
}

.navbar {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: transparent;
    color: #fff;
    padding: 20px 30px;
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
    margin: 0 10px;
}

.navbar ul li a {
    text-decoration: none;
    color: #fff;
    background-color: #000;
    padding: 10px 15px;
    border-radius: 10px;
    transition: 0.3s;
}

.navbar ul li a.active {
    background-color: #f00;
    color: #fff;
}

.navbar ul li a:hover {
    background-color: #f00;
    color: #fff;
}

/* Sayfanın tam ortası */
.container {
    flex: 1; /* Esnek alanı doldurur */
    display: flex;
    flex-direction: column;
    justify-content: center; /* Dikey ortalama */
    align-items: center; /* Yatay ortalama */
    text-align: center;
    padding: 20px;
    margin-top: 80px; /* Navbar için alan bırak */
}

.header h1 {
    font-size: 36px;
    margin-bottom: 10px;
}

.header p {
    font-size: 16px;
    color: #aaa;
    margin-bottom: 20px;
}

/* Tablo Stilleri */
table {
    width: 100%;
    max-width: 1200px;
    border-collapse: collapse;
    margin: 20px 0;
    background-color: #222;
    color: #fff;
    border: 1px solid #333;
    border-radius: 5px;
    overflow: hidden;
}

th, td {
    padding: 15px;
    border: 1px solid #333;
    text-align: center;
}

th {
    background-color: #333;
    color: #fff;
    font-weight: bold;
}

td {
    background-color: #2a2a2a;
}

/* Footer */
footer {
    text-align: center;
    padding: 10px 0;
    background-color: #111;
    color: #aaa;
    font-size: 12px;
}
</style>