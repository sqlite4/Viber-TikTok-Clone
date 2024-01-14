<!-- index.php -->

<?php
session_start();

require_once('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/vibeloop.css">
    <title>TikTok Clone</title>
    <style>
        .video {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .video video {
            width: 20%;
            border-radius: 15px;
        }

        .video-info {
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            color: #555;
        }

        .video-info p {
            margin: 0;
        }
    </style>
</head>
<body>

    <div id="container">

        <h1>TikTok Clone</h1>

        <?php
        $videoDirectory = 'cdn/videos/';
        $videos = glob($videoDirectory . '*.{mp4}', GLOB_BRACE);

        if (count($videos) > 0) {
            foreach ($videos as $video) {
                $videoInfo = pathinfo($video);
                $videoName = $videoInfo['filename'];
                $videoExtension = $videoInfo['extension'];

                $sql = "SELECT * FROM videos WHERE video_path='$videoDirectory$videoName.$videoExtension'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $videoRow = $result->fetch_assoc();
                    $description = $videoRow['description'];
                    $uploaderId = $videoRow['user_id'];

                    $uploaderSql = "SELECT * FROM users WHERE id='$uploaderId'";
                    $uploaderResult = $conn->query($uploaderSql);

                    if ($uploaderResult->num_rows > 0) {
                        $uploaderRow = $uploaderResult->fetch_assoc();
                        $uploaderName = $uploaderRow['username'];
                    }

                    echo '<div class="video">';
                    echo '<video controls>';
                    echo '<source src="' . $video . '" type="video/mp4">';
                    echo 'Tarayıcınız video etiketini desteklemiyor.';
                    echo '</video>';
                    echo '<div class="video-info">';
                    echo '<p><strong>Açıklama:</strong> ' . $description . '</p>';
                    echo '<p><strong>Yükleyen:</strong> ' . $uploaderName . '</p>';
                    echo '<p><strong>Yükleme Tarihi:</strong> ' . $videoRow['upload_date'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        } else {
            echo '<p>Henüz video yok.</p>';
        }
        ?>

    </div>

</body>
</html>
