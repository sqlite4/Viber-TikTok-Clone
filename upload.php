<!-- upload.php -->

<?php
session_start();

require_once('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'];
    $userId = $_SESSION['user_id'];

    // Yüklenecek dosyanın adı
    $videoFileName = basename($_FILES['video']['name']);

    // Yüklenecek dosyanın geçici adı
    $videoTmpName = $_FILES['video']['tmp_name'];

    // Yüklenecek dosyanın boyutu
    $videoFileSize = $_FILES['video']['size'];

    // Yüklenecek dosyanın tipi
    $videoFileType = strtolower(pathinfo($videoFileName, PATHINFO_EXTENSION));

    // İzin verilen video türleri
    $allowedVideoTypes = array('mp4');

    // Dosyanın uzantısını kontrol et
    if (!in_array($videoFileType, $allowedVideoTypes)) {
        echo "Sadece MP4 formatındaki videoları yükleyebilirsiniz.";
    } else {
        // Veritabanına video bilgilerini ekle
        $videoPath = "cdn/videos/" . uniqid() . '.' . $videoFileType;

        $sql = "INSERT INTO videos (user_id, description, video_path) VALUES ('$userId', '$description', '$videoPath')";

        if ($conn->query($sql) === TRUE) {
            // Videoyu belirtilen dizine taşı
            move_uploaded_file($videoTmpName, $videoPath);
            
            echo "Video başarıyla yüklendi.";
        } else {
            echo "Video yükleme hatası: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Video Yükle</title>
</head>
<body>

    <div id="container">

        <h1>Video Yükle</h1>

        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="description">Açıklama:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="video">Video Dosyası Seçin:</label>
            <input type="file" id="video" name="video" accept="video/*" required>

            <button type="submit">Videoyu Yükle</button>
        </form>

        <p><a href="index.php">Anasayfa</a></p>

    </div>

</body>
</html>
