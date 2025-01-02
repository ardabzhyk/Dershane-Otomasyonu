-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 31 Ara 2024, 10:08:21
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `dershane`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dersler`
--

CREATE TABLE `dersler` (
  `id` int(10) UNSIGNED NOT NULL,
  `ad` varchar(100) NOT NULL,
  `aciklama` text DEFAULT NULL,
  `ogretmen_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `dersler`
--

INSERT INTO `dersler` (`id`, `ad`, `aciklama`, `ogretmen_id`) VALUES
(5, 'Görsel Proglamlama-2', 'C# üzerinde form nesneleri veritabanı işlemleri ', 9),
(6, 'İnternet Programcılığı-2', 'Php ve mysql işlemleri', 8),
(7, 'Sunucu İşletim Sistemi', 'regex komutları', 10),
(8, 'Nesne Tabanlı proglamlama', 'nesnelerle proglamayı bir bütün haline getirmek', 11),
(9, 'Grafik Animasyon', 'Photoshop uygulamasında fotoğraf düzenleme edit işlemleri', 12),
(10, 'Matematik', 'polinom,fonksiyonlar,üstlü sayılar', 13);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `duyurular`
--

CREATE TABLE `duyurular` (
  `id` int(10) UNSIGNED NOT NULL,
  `baslik` varchar(150) NOT NULL,
  `icerik` text NOT NULL,
  `olusturulma_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  `yayinlayan_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `duyurular`
--

INSERT INTO `duyurular` (`id`, `baslik`, `icerik`, `olusturulma_tarihi`, `yayinlayan_id`) VALUES
(5, '2024-2025 Yılı Erasmus+ Personel Ders Verme ve Eğitim Alma Başvuruları Başladı', 'Değerli Katılımcılar,\r\n\r\nManisa Celal Bayar Üniversitesi, Erasmus Kurum Koordinatörlüğü tarafından yürütülmekte olan 2023-1-TR01-KA131-HED-000164143 numaralı proje kapsamında Erasmus+ Personel Ders Verme ve Eğitim Alma hareketliliklerine yönelik başvurular başlamıştır.\r\n\r\nİlgilenen akademik ve idari personeller başvurularını; 10 Aralık 2024 – 24 Ocak 2025 tarihleri arasında gerçekleştirebilirler.\r\n\r\nBaşvurular, belirtilen tarihler arasında e-devlet sistemi üzerinden giriş yapılarak Erasmus Başvuru Portalı (https://turnaportal.ua.gov.tr/) üzerinden alınacaktır.\r\n\r\nBu proje kapsamında yapılacak hareketliliklerin 31 Temmuz 2025 tarihine kadar gerçekleştirilmesi gerekmektedir. Bu proje kapsamında kazanılan hak, belirtilen tarihten sonra geçersiz olur.\r\n\r\n \r\n\r\nSağlıklı günler dileriz.\r\n\r\nErasmus Kurum Koordinatörlüğü', '2024-12-27 09:49:06', NULL),
(6, ' MCBÜ Yükseköğrenim Vakfı Burs Duyurusu', 'Manisa Celal Bayar Üniversitesi Yükseköğrenim Vakfı, Ocak - Haziran 2025 tarihleri arasında önlisans, lisans ve lisansüstü öğrencilerine ayda 2.000,00-TL burs verecektir. İlgilenen öğrenciler 31.12.2024 Salı günü mesai bitimine kadar fakülte, yüksekokul, meslek yüksekokulları ve enstitü öğrenci işlerine aşağıda istenen belgeleri ile birlikte başvurmaları gerekmektedir.\r\n\r\nBAŞVURUDA İSTENEN KRİTERLER;\r\n\r\n1. Ailesi üzerine mal varlığı bulunmaması,\r\n\r\n2. KYK veya herhangi başka bir kuruluş ve dernekten burs almıyor olmak,\r\n\r\n3. Sigortalı çalışıyor olmaması,\r\n\r\nBAŞVURUDA İSTENEN BELGELER;\r\n\r\n1. Başvuru Dilekçesi (Kendi el yazısı ile kendisini, ailesini anlatan dilekçe),\r\n\r\n2. Sigorta tescil hizmet dökümü belgesi (E-Devletten çıktı alınabilir),\r\n\r\n3. Nüfus kayıt Örneği (E-Devletten çıktı alınabilir),\r\n\r\n4. Transkript (Hazırlık Sınıfı ve 1. Sınıflar için zorunlu değil)\r\n\r\n5. Nüfus Cüzdanı fotokopisi,\r\n\r\n6. Bir adet vesikalık fotoğraf,\r\n\r\n7. Ailesi ve öğrencinin üzerine mal varlığı olmadığını gösteren belge (E-Devlet - TAPU BİLGİLERİ SORGULAMA kısmından belge alınabilir.)\r\n\r\n8. Öğrenci Belgesi (E-Devletten çıktı alınabilir).\r\n\r\nNot: 31.12.2024 tarihinden sonra gelen başvurular kabul edilmeyecektir.', '2024-12-27 09:50:11', NULL),
(7, ' Vefat ve Başsağlığı', 'Üniversitemiz, Tıp Fakültesi Tıbbi Biyoloji Anabilim Dalı Öğretim Üyesi Prof. Dr. Mehmet Korkmaz\'in Eşi Havva Korkmaz vefat etmiştir.\r\n\r\nMerhumeye Allah\'tan rahmet, ailesi ve yakınlarına sabır ve başsağlığı dileriz.\r\n\r\n', '2024-12-27 09:50:57', NULL),
(8, ' GEÇMİŞ OLSUN TÜRKİYE\'M', 'Manisa Celal Bayar Üniversitesi olarak Manisa ve diğer illerimizde çıkan yangınlar nedeniyle büyük bir üzüntü içerisindeyiz...\r\n\r\n \r\n\r\nBaşta ilimizin çeşitli bölgelerinde çıkan yangınlar olmak üzere ülkemizin farklı bölgelerinde yürütülen yangın söndürme süreçlerini yakından takip ediyoruz. \r\n\r\n \r\n\r\nÜlkemizin yangınlarla mücadele ettiği bu süreç sonrasında başta öğrencilerimiz ve personelimiz olmak üzere milletçe daha duyarlı olacağımıza inanıyoruz.\r\n\r\n \r\n\r\nYangının hasar verdiği bölgelerdeki vatandaşlarımıza geçmiş olsun dileklerimizi iletiyor ve yangınla mücadele eden tüm ekiplerimize kolaylıklar diliyoruz.\r\n\r\n \r\n\r\nProf. Dr. Rana Kibar\r\n\r\nManisa Celal Bayar Üniversitesi Rektörü', '2024-12-27 09:52:04', NULL),
(9, ' International Conference on Optimization and Data Science in Industrial Engineering (ODSIE 2024)', 'International Conference on Optimization and Data Science in Industrial Engineering (ODSIE 2024) Üniversitemiz Bilimsel Sponsorluğunda 07 - 08 Kasım 2024 tarihlerinde online olarak gerçekleştirilecek olup, konferansta tüm öğrenci ve personelimize % 30 indirim hakkı tanımlanmıştır.\r\n\r\nKonferansa bildiri göndermek isteyen öğrenci ve personellerimiz için konferans linki: https://odsie2024.refconf.com/', '2024-12-27 09:52:36', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `iletisim`
--

CREATE TABLE `iletisim` (
  `adsoyad` varchar(50) NOT NULL,
  `eposta` varchar(50) NOT NULL,
  `mesaj` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `iletisim`
--

INSERT INTO `iletisim` (`adsoyad`, `eposta`, `mesaj`) VALUES
('arda bozhüyük', 'bzhykarda@gmail.com', 'paket fiyatlarını öğrenmek istiyorum\r\n'),
('Ahmet Ülker', 'ahmetulker@gmail.com', 'dershanenizin güvenlik sistemi için sizlerle görüşmek istiyoruz'),
('onur mengünoğul', 'onurmengunogul09@gmail.com', 'iyi günler öğretmen kadronuza  katılmak istiyorum ');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kayitlar`
--

CREATE TABLE `kayitlar` (
  `id` int(10) UNSIGNED NOT NULL,
  `ogrenci_id` int(10) UNSIGNED NOT NULL,
  `ders_id` int(10) UNSIGNED NOT NULL,
  `kayit_tarihi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kayitlar`
--

INSERT INTO `kayitlar` (`id`, `ogrenci_id`, `ders_id`, `kayit_tarihi`) VALUES
(2, 15, 10, '2024-12-27'),
(3, 14, 5, '2024-12-27'),
(4, 14, 6, '2024-12-27'),
(5, 14, 7, '2024-12-27'),
(6, 14, 8, '2024-12-27'),
(7, 14, 9, '2024-12-27'),
(8, 14, 10, '2024-12-27'),
(9, 15, 8, '2024-12-27'),
(10, 17, 10, '2024-12-27'),
(11, 16, 5, '2024-12-27'),
(12, 16, 5, '2024-12-27'),
(15, 16, 5, '2024-12-27');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `program`
--

CREATE TABLE `program` (
  `id` int(10) UNSIGNED NOT NULL,
  `ders_id` int(10) UNSIGNED NOT NULL,
  `gun` enum('Pazartesi','Salı','Çarşamba','Perşembe','Cuma','Cumartesi','Pazar') NOT NULL,
  `baslangic_saat` time NOT NULL,
  `bitis_saat` time NOT NULL,
  `sinif` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `program`
--

INSERT INTO `program` (`id`, `ders_id`, `gun`, `baslangic_saat`, `bitis_saat`, `sinif`) VALUES
(5, 5, 'Pazartesi', '09:00:00', '12:30:00', 'A'),
(6, 6, 'Salı', '13:30:00', '17:00:00', 'B'),
(7, 8, 'Çarşamba', '10:30:00', '14:00:00', 'B'),
(8, 9, 'Perşembe', '10:00:00', '12:00:00', 'B'),
(9, 10, 'Cuma', '13:30:00', '15:00:00', 'A'),
(10, 7, 'Cuma', '09:00:00', '12:00:00', 'B');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `ad` varchar(100) NOT NULL,
  `soyad` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `rol` enum('öğrenci','öğretmen','admin') NOT NULL DEFAULT 'öğrenci'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `ad`, `soyad`, `email`, `sifre`, `rol`) VALUES
(7, 'admin', 'admin', 'adminadmin@gmail.com', '$2y$10$z4s2KwNXZL/S6QYBjocViucwLuoI6vW7oYrR/6NMoaImL6YovPNMS', 'admin'),
(8, 'mehmet emin ', 'salman', 'mehmeteminsalman@gmail.com', '$2y$10$z6HXD22omKlawZaIJbpxzOsUflrS/HaEANK28hSoBhA2ULCnARqkC', 'öğretmen'),
(9, 'Hüseyin ', 'Taş', 'HuseyinTas@gmail.com', '$2y$10$u/HB3M84YR4DXZ.ag6hbFuiz2mYaD8JECSRIctMhXzDj45k9g1yPy', 'öğretmen'),
(10, 'efe ', 'çoşan', 'efecosan@gmail.com', '$2y$10$I7aBQAFqvpkjYq0qKMc5zO3iAAgFNG2rI8EY1UnmrIbP7/Fw9RYee', 'öğretmen'),
(11, 'Emrah', 'Kuzu', 'EmrahKuzu@gmail.com', '$2y$10$DUqEyLtccT1CL.aWmJ3Sju74G0l.lbdDSiLw.pjSX18q41xmj1T5q', 'öğretmen'),
(12, 'İsmail ', 'Bektaş', 'ismailBektas@gmail.com', '$2y$10$pUdEQffg2XiE5uLyWTVmuO8htaiN3oyO34gKVSrppxxiAnFHGpZSu', 'öğretmen'),
(13, 'Aslan', 'Bozkurt', 'AslanBozkurt@gmail.com', '$2y$10$5rujcxaTeCQ406NYtbFuuujyeizujiPCiJKrnxQVIcj70M3eUD5IW', 'öğretmen'),
(14, 'Veli', 'Cibi', 'Velicibi07@gmail.com', '$2y$10$ydHFg8/dVtqu7nB5G3hP3e/OQMKJInqP3MK06z1skRorfAI6rm0l.', 'öğrenci'),
(15, 'ruhi', 'çenet', 'ruhicenet@gmail.com', '$2y$10$smiyDbHee4pgWVKse.YEveQkNpJ6r3HBmSu6PDlSf6l43UER3J5uq', 'öğrenci'),
(16, 'Halil', 'Esen', 'Halilesen@gmail.com', '$2y$10$YwL8OMsM/VNgJyrvCXUY7Os3IoU7iIJEj5rBTN5Eahw4l3.KnKr/K', 'öğrenci'),
(17, 'Ahmet', 'Ülker', 'Ahmetulker@gmail.com', '$2y$10$KG1lDWW5mvk2ZV9w6QqD8.adGf.4QxUCwepE51NdtWyF78jsvQie2', 'öğrenci');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `dersler`
--
ALTER TABLE `dersler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ogretmen_id` (`ogretmen_id`);

--
-- Tablo için indeksler `duyurular`
--
ALTER TABLE `duyurular`
  ADD PRIMARY KEY (`id`),
  ADD KEY `yayinlayan_id` (`yayinlayan_id`);

--
-- Tablo için indeksler `kayitlar`
--
ALTER TABLE `kayitlar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ogrenci_id` (`ogrenci_id`),
  ADD KEY `ders_id` (`ders_id`);

--
-- Tablo için indeksler `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ders_id` (`ders_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `dersler`
--
ALTER TABLE `dersler`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `duyurular`
--
ALTER TABLE `duyurular`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `kayitlar`
--
ALTER TABLE `kayitlar`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Tablo için AUTO_INCREMENT değeri `program`
--
ALTER TABLE `program`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `dersler`
--
ALTER TABLE `dersler`
  ADD CONSTRAINT `dersler_ibfk_1` FOREIGN KEY (`ogretmen_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `duyurular`
--
ALTER TABLE `duyurular`
  ADD CONSTRAINT `duyurular_ibfk_1` FOREIGN KEY (`yayinlayan_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Tablo kısıtlamaları `kayitlar`
--
ALTER TABLE `kayitlar`
  ADD CONSTRAINT `kayitlar_ibfk_1` FOREIGN KEY (`ogrenci_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kayitlar_ibfk_2` FOREIGN KEY (`ders_id`) REFERENCES `dersler` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `program`
--
ALTER TABLE `program`
  ADD CONSTRAINT `program_ibfk_1` FOREIGN KEY (`ders_id`) REFERENCES `dersler` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
