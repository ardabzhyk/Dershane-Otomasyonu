<?php
// Veritabanı bağlantısı
$conn = new mysqli("localhost", "root", "", "dershane");

if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

// Ders programı silme işlemi
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM program WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Ders programı başarıyla silindi.";
    } else {
        echo "Hata: " . $conn->error;
    }
}

// Ders programı düzenleme işlemi
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $ders_id = $_POST['ders_id'];
    $gun = $_POST['gun'];
    $baslangic_saat = $_POST['baslangic_saat'];
    $bitis_saat = $_POST['bitis_saat'];
    $sinif = $_POST['sinif'];

    $sql = "UPDATE program SET ders_id = $ders_id, gun = '$gun', baslangic_saat = '$baslangic_saat', 
            bitis_saat = '$bitis_saat', sinif = '$sinif' WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Ders programı başarıyla güncellendi.";
    } else {
        echo "Hata: " . $conn->error;
    }
}

// Ders ekleme işlemi
if (isset($_POST['add'])) {
    $ders_id = $_POST['ders_id'];
    $gun = $_POST['gun'];
    $baslangic_saat = $_POST['baslangic_saat'];
    $bitis_saat = $_POST['bitis_saat'];
    $sinif = $_POST['sinif'];

    $sql = "INSERT INTO program (ders_id, gun, baslangic_saat, bitis_saat, sinif) VALUES 
            ($ders_id, '$gun', '$baslangic_saat', '$bitis_saat', '$sinif')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Ders başarıyla eklendi.";
    } else {
        echo "Hata: " . $conn->error;
    }
}

// Derslerin listesini al
$sql = "SELECT program.id, dersler.ad AS ders_ad, users.ad AS ogretmen, program.gun, program.baslangic_saat, program.bitis_saat, program.sinif 
        FROM program 
        JOIN dersler ON program.ders_id = dersler.id
        JOIN users ON dersler.ogretmen_id = users.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ders Programı Düzenle</title>
    <link rel="stylesheet" href="dersprogrami.css">
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

    <div class="container">
        <div class="header">
            <h1>Ders Programı Düzenle</h1>
            <p>Elit Dershane'nin ders programını düzenleyebilir veya yeni ders ekleyebilirsiniz.</p>
        </div>

        <!-- Ders Programı Tablosu -->
        <table>
            <thead>
                <tr>
                    <th>Ders Adı</th>
                    <th>Öğretmen</th>
                    <th>Gün</th>
                    <th>Saat</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['ders_ad'] . "</td>";
                        echo "<td>" . $row['ogretmen'] . "</td>";
                        echo "<td>" . $row['gun'] . "</td>";
                        echo "<td>" . $row['baslangic_saat'] . " - " . $row['bitis_saat'] . "</td>";
                        echo "<td>
                                <a href='dersprogramidüzenle.php?edit=" . $row['id'] . "'>Düzenle</a>
                                <a href='dersprogramidüzenle.php?delete=" . $row['id'] . "'>Sil</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Henüz eklenmiş bir ders programı bulunmamaktadır.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Ders Düzenleme veya Ekleme Formu -->
        <?php if (isset($_GET['edit'])): ?>
            <?php
            $id = $_GET['edit'];
            $edit_sql = "SELECT * FROM program WHERE id = $id";
            $edit_result = $conn->query($edit_sql);
            $edit_row = $edit_result->fetch_assoc();
            ?>
            <h2>Ders Programı Düzenle</h2>
            <form method="POST">
                <input type="hidden" name="id" value="<?= $edit_row['id'] ?>">
                <label for="ders_id">Ders:</label>
                <select name="ders_id" id="ders_id">
                    <?php
                    // Dersleri çek
                    $ders_sql = "SELECT * FROM dersler";
                    $ders_result = $conn->query($ders_sql);
                    while ($ders_row = $ders_result->fetch_assoc()) {
                        echo "<option value='" . $ders_row['id'] . "' " . ($edit_row['ders_id'] == $ders_row['id'] ? "selected" : "") . ">" . $ders_row['ad'] . "</option>";
                    }
                    ?>
                </select><br>
                <label for="gun">Gün:</label>
                <select name="gun" id="gun">
                    <option value="Pazartesi" <?= ($edit_row['gun'] == 'Pazartesi') ? 'selected' : ''; ?>>Pazartesi</option>
                    <option value="Salı" <?= ($edit_row['gun'] == 'Salı') ? 'selected' : ''; ?>>Salı</option>
                    <option value="Çarşamba" <?= ($edit_row['gun'] == 'Çarşamba') ? 'selected' : ''; ?>>Çarşamba</option>
                    <option value="Perşembe" <?= ($edit_row['gun'] == 'Perşembe') ? 'selected' : ''; ?>>Perşembe</option>
                    <option value="Cuma" <?= ($edit_row['gun'] == 'Cuma') ? 'selected' : ''; ?>>Cuma</option>
                    <option value="Cumartesi" <?= ($edit_row['gun'] == 'Cumartesi') ? 'selected' : ''; ?>>Cumartesi</option>
                    <option value="Pazar" <?= ($edit_row['gun'] == 'Pazar') ? 'selected' : ''; ?>>Pazar</option>
                </select><br>
                <label for="baslangic_saat">Başlangıç Saati:</label>
                <input type="time" name="baslangic_saat" value="<?= $edit_row['baslangic_saat'] ?>"><br>
                <label for="bitis_saat">Bitiş Saati:</label>
                <input type="time" name="bitis_saat" value="<?= $edit_row['bitis_saat'] ?>"><br>
                <label for="sinif">Sınıf:</label>
                <input type="text" name="sinif" value="<?= $edit_row['sinif'] ?>"><br>
                <button type="submit" name="update">Düzenle</button>
            </form>
        <?php else: ?>
            <h2>Yeni Ders Ekle</h2>
            <form method="POST">
                <label for="ders_id">Ders:</label>
                <select name="ders_id" id="ders_id">
                    <?php
                    $ders_sql = "SELECT * FROM dersler";
                    $ders_result = $conn->query($ders_sql);
                    while ($ders_row = $ders_result->fetch_assoc()) {
                        echo "<option value='" . $ders_row['id'] . "'>" . $ders_row['ad'] . "</option>";
                    }
                    ?>
                </select><br>
                <label for="gun">Gün:</label>
                <select name="gun" id="gun">
                    <option value="Pazartesi">Pazartesi</option>
                    <option value="Salı">Salı</option>
                    <option value="Çarşamba">Çarşamba</option>
                    <option value="Perşembe">Perşembe</option>
                    <option value="Cuma">Cuma</option>
                    <option value="Cumartesi">Cumartesi</option>
                    <option value="Pazar">Pazar</option>
                </select><br>
                <label for="baslangic_saat">Başlangıç Saati:</label>
                <input type="time" name="baslangic_saat"><br>
                <label for="bitis_saat">Bitiş Saati:</label>
                <input type="time" name="bitis_saat"><br>
                <label for="sinif">Sınıf:</label>
                <input type="text" name="sinif"><br>
                <button type="submit" name="add">Ekle</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
<style>
    /* Genel stil */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
    color: #333;
}

/* Navbar */
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

.navbar ul li a:hover {
    background-color: #f00;
    color: #fff;
}
/* Container */
.container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.header {
    text-align: center;
    margin-bottom: 20px;
}

.header h1 {
    color: #0073e6;
    margin-bottom: 10px;
}

.header p {
    font-size: 14px;
    color: #555;
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
    background-color: #0073e6;
    color: #fff;
}

table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:hover {
    background-color: #f1f1f1;
}

table a {
    color: #0073e6;
    text-decoration: none;
    margin-right: 10px;
}

table a:hover {
    text-decoration: underline;
}

/* Form */
form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

form label {
    font-weight: bold;
}

form input, form select {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    width: 100%;
    max-width: 400px;
}

form button {
    padding: 10px 20px;
    background-color: #0073e6;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

form button:hover {
    background-color: #005bb5;
}

</style>
