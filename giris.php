<?php
session_start();
$host = "localhost";
$dbname = "Dershane";
$username = "root";
$password = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Veritabanı bağlantısı
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $email = trim($_POST['email']);
        $sifre = $_POST['sifre'];

        // Kullanıcı doğrulama sorgusu
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Kullanıcı doğrulama ve şifre kontrolü
        if ($user && password_verify($sifre, $user['sifre'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['ad'] = $user['ad'];
            $_SESSION['rol'] = $user['rol'];

            // Rol bazlı yönlendirme
            if ($user['rol'] === 'öğrenci') {
                header("Location: dersler.php");
            }
            if($user['rol'] === 'öğretmen') {
                header("Location: admin.html"); 
            }
            if($user['rol'] === 'admin') {
                header("Location: admin.html"); 
            }
            exit;
        } else {
            $hata = "E-posta veya şifre hatalı.";
        }
    } catch (PDOException $e) {
        $hata = "Bağlantı hatası: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="styles.css">
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
            <li><a href="cikis.php">Çıkış Yap</a></li>
        </ul>
    </nav>
    <div class="login-container">
        <h1>Giriş Yap</h1>
        <form method="POST">
            <label for="email">E-posta:</label><br>
            <input type="email" id="email" name="email" required><br><br>
            <label for="sifre">Şifre:</label><br>
            <input type="password" id="sifre" name="sifre" required><br><br>
            <button type="submit">Giriş Yap</button>
        </form>
        <?php if (isset($hata)) echo "<p class='error'>" . htmlspecialchars($hata) . "</p>"; ?>
    </div>
</body>
</html>
<style>
 * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-image: url('images/a\ large\ corridor\ with\ locked\ cabinets\ where\ students\ are\ present.png');
    background-size: cover;
    background-position: center;
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

.container {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.form-container {
    background: rgba(0, 0, 0, 0.7); /* Siyah yarı saydam arka plan */
    padding: 80px;
    border-radius: 10px;
    width: 500px;
    height: 500px;
    text-align: center;
    color: white;
}

h2 {
    margin-bottom: 20px;
    font-size: 24px;
}

input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #fff;
    border-radius: 5px;
    background: rgba(32, 3, 3, 0.5);
    color: white;
    font-size: 16px;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #808080; /* Gri buton */
    border: none;
    border-radius: 5px;
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #595959; /* Hover rengi */
}


</style>

