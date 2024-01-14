<!-- profile.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Profil</title>
</head>
<body>

    <div id="container">

        <h1>Profil</h1>

        <?php
        session_start();

        require_once('db.php');

        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit;
        }

        $userId = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = $_POST['fullname'];
            $profilePicture = $_FILES['profile_picture'];

            // Profil resmi yükleme işlemleri burada yapılacak
            // Bu örnekte yüklenen resim dosyasını belirtilen klasöre taşıyabilirsiniz

            // Yeni profil bilgilerini veritabanına güncelle
            $sql = "UPDATE users SET fullname='$fullname' WHERE id='$userId'";
            $conn->query($sql);

            // Profil resim adını veritabanına güncelle
            $profilePictureName = 'new_profile_picture.jpg'; // Bu değeri yüklenen resmin adıyla değiştirin
            $sql = "UPDATE users SET profile_picture='$profilePictureName' WHERE id='$userId'";
            $conn->query($sql);

            echo "Profil bilgileri güncellendi.";
        }

        // Kullanıcı bilgilerini çek
        $sql = "SELECT * FROM users WHERE id='$userId'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $fullname = $row['fullname'];
            $profilePicture = $row['profile_picture'];
        }
        ?>

        <form action="profile.php" method="post" enctype="multipart/form-data">
            <label for="fullname">Ad Soyad:</label>
            <input type="text" id="fullname" name="fullname" value="<?php echo $fullname; ?>" required>

            <label for="profile_picture">Profil Resmi:</label>
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*">

            <button type="submit">Güncelle</button>
        </form>

        <?php
        echo '<img src="uploads/profile_pictures/' . $profilePicture . '" alt="Profil Resmi">';
        ?>

        <p><a href="index.php">Anasayfa</a></p>

    </div>

</body>
</html>
