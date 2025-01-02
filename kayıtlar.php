<?php
// Veritabanı bağlantısı
$servername = "localhost";
$username = "root"; // Kullanıcı adı
$password = ""; // Parola
$dbname = "Dershane"; // Veritabanı adı

// Veritabanına bağlantı oluşturuluyor
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Bağlantı başarısız: " . $conn->connect_error);
}

// Öğrenciler ve dersleri çekmek için SQL sorguları
$ogrenciler_sql = "SELECT id, ad, soyad FROM users WHERE rol = 'öğrenci'"; // Rolü öğrenci olanlar
$dersler_sql = "SELECT id, ad FROM dersler";

$ogrenciler_result = $conn->query($ogrenciler_sql);
$dersler_result = $conn->query($dersler_sql);

// Kayıt ekleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kayit_ekle'])) {
    $ogrenci_id = $_POST['ogrenci_id'];
    $ders_id = $_POST['ders_id'];
    $kayit_tarihi = date('Y-m-d'); // Bugünün tarihi

    // SQL sorgusu
    $sql = "INSERT INTO kayitlar (ogrenci_id, ders_id, kayit_tarihi) 
            VALUES ('$ogrenci_id', '$ders_id', '$kayit_tarihi')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Kayıt başarıyla eklendi.</p>";
    } else {
        echo "<p>Hata: " . $conn->error . "</p>";
    }
}

// Kayıt silme işlemi
if (isset($_GET['sil_id'])) {
    $sil_id = $_GET['sil_id'];

    // SQL sorgusu
    $sql = "DELETE FROM kayitlar WHERE id = $sil_id";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Kayıt başarıyla silindi.</p>";
    } else {
        echo "<p>Hata: " . $conn->error . "</p>";
    }
}

// Kayıt düzenleme işlemi (öğrenci kaydını güncelleme)
if (isset($_POST['kayit_duzenle'])) {
    $kayit_id = $_POST['kayit_id'];
    $ogrenci_id = $_POST['ogrenci_id'];
    $ders_id = $_POST['ders_id'];

    $sql = "UPDATE kayitlar SET ogrenci_id = '$ogrenci_id', ders_id = '$ders_id' WHERE id = '$kayit_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Kayıt başarıyla güncellendi.</p>";
    } else {
        echo "<p>Hata: " . $conn->error . "</p>";
    }
}

// Öğrenci kayıtlarını çekmek için SQL sorgusu
$sql = "SELECT kayitlar.id, users.ad, users.soyad, dersler.ad AS ders_ad, kayitlar.kayit_tarihi 
        FROM kayitlar 
        INNER JOIN users ON kayitlar.ogrenci_id = users.id 
        INNER JOIN dersler ON kayitlar.ders_id = dersler.id";
$result = $conn->query($sql);

// Eğer düzenleme yapılacaksa, o kaydın bilgilerini alıyoruz
$duzenleme_id = isset($_GET['duzenle_id']) ? $_GET['duzenle_id'] : null;
$duzenleme_sql = "";
if ($duzenleme_id) {
    $duzenleme_sql = "SELECT * FROM kayitlar WHERE id = $duzenleme_id";
    $duzenleme_result = $conn->query($duzenleme_sql);
    $duzenleme_data = $duzenleme_result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğrenci Kayıtları</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #ff6600;
            color: white;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            margin-top: 20px;
            text-align: center;
        }
        select, button {
            padding: 10px;
            margin: 5px;
        }
    </style>
</head>
<body>

    <h2>Öğrenci Kayıtları</h2>

    <!-- Öğrenci Kayıt Formu -->
    <form method="POST" action="">
        <label for="ogrenci_id">Öğrenci Seçin:</label>
        <select name="ogrenci_id" id="ogrenci_id" required>
            <option value="">Öğrenci Seçin</option>
            <?php
            if ($ogrenciler_result->num_rows > 0) {
                while ($row = $ogrenciler_result->fetch_assoc()) {
                    $selected = isset($duzenleme_data) && $duzenleme_data['ogrenci_id'] == $row['id'] ? 'selected' : '';
                    echo "<option value='" . $row['id'] . "' $selected>" . $row['ad'] . " " . $row['soyad'] . "</option>";
                }
            }
            ?>
        </select>

        <label for="ders_id">Ders Seçin:</label>
        <select name="ders_id" id="ders_id" required>
            <option value="">Ders Seçin</option>
            <?php
            if ($dersler_result->num_rows > 0) {
                while ($row = $dersler_result->fetch_assoc()) {
                    $selected = isset($duzenleme_data) && $duzenleme_data['ders_id'] == $row['id'] ? 'selected' : '';
                    echo "<option value='" . $row['id'] . "' $selected>" . $row['ad'] . "</option>";
                }
            }
            ?>
        </select>

        <?php if ($duzenleme_id): ?>
            <input type="hidden" name="kayit_id" value="<?php echo $duzenleme_data['id']; ?>">
            <button type="submit" name="kayit_duzenle">Kayıt Düzenle</button>
        <?php else: ?>
            <button type="submit" name="kayit_ekle">Kayıt Ekle</button>
        <?php endif; ?>
    </form>

    <!-- Öğrenci Kayıtları Tablosu -->
    <?php
    // Eğer kayıt varsa, tabloyu oluştur
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Öğrenci Adı</th>
                    <th>Öğrenci Soyadı</th>
                    <th>Ders Adı</th>
                    <th>Kayıt Tarihi</th>
                    <th>İşlemler</th>
                </tr>";

        // Verileri tabloya yerleştir
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['ad'] . "</td>
                    <td>" . $row['soyad'] . "</td>
                    <td>" . $row['ders_ad'] . "</td>
                    <td>" . $row['kayit_tarihi'] . "</td>
                    <td>
                        <a href='?sil_id=" . $row['id'] . "'>Sil</a> |
                        <a href='?duzenle_id=" . $row['id'] . "'>Düzenle</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Kayıt bulunamadı.</p>";
    }

    // Bağlantıyı kapat
    $conn->close();
    ?>

</body>
</html>
