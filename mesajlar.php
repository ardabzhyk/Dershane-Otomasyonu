<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim Tablosu</title>
   
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
    <?php
    // Veritabanı bağlantı bilgileri
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dershane";

    try {
        // PDO kullanarak veritabanına bağlanma
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Veritabanından verileri çekme sorgusu
        $stmt = $conn->prepare("SELECT adsoyad, eposta, mesaj FROM iletisim");
        $stmt->execute();

        // Sonuçları al
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h1>Gelen Mesajlar</h1>";
        if (count($result) > 0) {
            echo "<table>";
            echo "<tr><th>Ad Soyad</th><th>E-posta</th><th>Mesaj</th></tr>";
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['adsoyad']) . "</td>";
                echo "<td>" . htmlspecialchars($row['eposta']) . "</td>";
                echo "<td>" . nl2br(htmlspecialchars($row['mesaj'])) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Henüz kayıtlı bir veri bulunmamaktadır.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Bağlantı hatası: " . $e->getMessage() . "</p>";
    }
    ?>
</body>
</html>
<style>
        /* Sayfa genel stilleri */
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
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


        h1 {
            color: #ff9800;
            margin: 20px 0;
        }

        /* Tablo stilleri */
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #1e1e1e;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #333;
        }

        th {
            background-color: #333;
            color: #ff9800;
            text-transform: uppercase;
        }

        td {
            color: #ffffff;
        }

        tr:nth-child(even) {
            background-color: #2c2c2c;
        }

        tr:nth-child(odd) {
            background-color: #1e1e1e;
        }

        /* Mesaj boşsa uyarı */
        p {
            color: #ff5252;
        }
    </style>
