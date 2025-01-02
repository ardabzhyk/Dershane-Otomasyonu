<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dersler Düzenle</title>
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
        <h1>Dersler Düzenle</h1>

        <!-- Ders Ekleme Formu -->
        <h2>Ders Ekle</h2>
        <form action="derslerduzenle.php" method="post">
            <label for="dersAdi">Ders Adı:</label>
            <input type="text" id="dersAdi" name="dersAdi" required>
            <label for="aciklama">Açıklama:</label>
            <textarea id="aciklama" name="aciklama"></textarea>
            <label for="ogretmenId">Öğretmen ID:</label>
            <input type="number" id="ogretmenId" name="ogretmenId" required>
            <button type="submit" name="ekle">Ders Ekle</button>
        </form>

        <!-- Ders Listesi -->
        <h2>Mevcut Dersler</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ders Adı</th>
                    <th>Açıklama</th>
                    <th>Öğretmen ID</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Veritabanı bağlantısı
                $conn = new mysqli("localhost", "root", "", "dershane");

                if ($conn->connect_error) {
                    die("Bağlantı hatası: " . $conn->connect_error);
                }

                // Ders ekleme
                if (isset($_POST['ekle'])) {
                    $dersAdi = $_POST['dersAdi'];
                    $aciklama = $_POST['aciklama'];
                    $ogretmenId = $_POST['ogretmenId'];

                    $sql = "INSERT INTO dersler (ad, aciklama, ogretmen_id) VALUES ('$dersAdi', '$aciklama', '$ogretmenId')";
                    if ($conn->query($sql) === TRUE) {
                        echo "<script>alert('Ders başarıyla eklendi!');</script>";
                    } else {
                        echo "Hata: " . $conn->error;
                    }
                }

                // Ders silme
                if (isset($_GET['sil'])) {
                    $id = $_GET['sil'];
                    $sql = "DELETE FROM dersler WHERE id=$id";
                    if ($conn->query($sql) === TRUE) {
                        echo "<script>alert('Ders başarıyla silindi!');</script>";
                    } else {
                        echo "Hata: " . $conn->error;
                    }
                }

                // Ders düzenleme
                if (isset($_POST['guncelle'])) {
                    $id = $_POST['id'];
                    $dersAdi = $_POST['dersAdi'];
                    $aciklama = $_POST['aciklama'];
                    $ogretmenId = $_POST['ogretmenId'];

                    $sql = "UPDATE dersler SET ad='$dersAdi', aciklama='$aciklama', ogretmen_id='$ogretmenId' WHERE id=$id";
                    if ($conn->query($sql) === TRUE) {
                        echo "<script>alert('Ders başarıyla güncellendi!');</script>";
                    } else {
                        echo "Hata: " . $conn->error;
                    }
                }

                // Mevcut dersler
                $sql = "SELECT * FROM dersler";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['ad'] . "</td>";
                        echo "<td>" . $row['aciklama'] . "</td>";
                        echo "<td>" . $row['ogretmen_id'] . "</td>";
                        echo "<td>
                                <a href='?sil=" . $row['id'] . "'>Sil</a> |
                                <form action='derslerduzenle.php' method='post' style='display:inline;'>
                                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                                    <input type='text' name='dersAdi' value='" . $row['ad'] . "' required>
                                    <input type='text' name='aciklama' value='" . $row['aciklama'] . "'>
                                    <input type='number' name='ogretmenId' value='" . $row['ogretmen_id'] . "' required>
                                    <button type='submit' name='guncelle'>Güncelle</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Henüz ders eklenmedi.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Alt Bilgi -->
    <footer>
        © 2024 Elit Dershane. Tüm Hakları Saklıdır.
    </footer>
</body>
</html>
<style>
    /* Genel Stil */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f9f9f9;
    color: #333;
    line-height: 1.6;
}

.container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

h1, h2 {
    color: #2c3e50;
}

/* Gezinti Çubuğu */
.navbar {
    background: #34495e;
    color: #fff;
    padding: 10px 0;
    text-align: center;
}

.navbar ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
}

.navbar li {
    margin: 0 15px;
}

.navbar a {
    text-decoration: none;
    color: #fff;
    font-weight: bold;
    transition: color 0.3s ease;
}

.navbar a:hover {
    color: #f1c40f;
}

/* Formlar */
form {
    margin-bottom: 20px;
}

form label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
}

form input, form textarea, form button {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

form button {
    background: #3498db;
    color: #fff;
    border: none;
    cursor: pointer;
    font-weight: bold;
    transition: background 0.3s ease;
}

form button:hover {
    background: #2980b9;
}

/* Tablo */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

table th {
    background: #34495e;
    color: #fff;
}

table tr:nth-child(even) {
    background: #f2f2f2;
}

table tr:hover {
    background: #eaeaea;
}

table a {
    color: #3498db;
    text-decoration: none;
    font-weight: bold;
}

table a:hover {
    text-decoration: underline;
}

/* Alt Bilgi */
footer {
    background: #34495e;
    color: #fff;
    text-align: center;
    padding: 10px 0;
    margin-top: 20px;
    font-size: 14px;
    border-top: 3px solid #f1c40f;
}

</style>
