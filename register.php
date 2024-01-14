<?php
session_start();

require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $fullname = $_POST['fullname'];

    $sql = "INSERT INTO users (username, password, fullname) VALUES ('$username', '$password', '$fullname')";

    if ($conn->query($sql) === TRUE) {
        header('Location: login.php');
        exit;
    } else {
        echo "Kayıt işlemi başarısız: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Kayıt Ol</title>
</head>
<body>

    <div id="container">

        <h1>Kayıt Ol</h1>

        <form action="register.php" method="post">
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Şifre:</label>
            <input type="password" id="password" name="password" required>

            <label for="fullname">Ad Soyad:</label>
            <input type="text" id="fullname" name="fullname" required>

            <button type="submit">Kayıt Ol</button>
        </form>

        <p>Zaten bir hesabınız var mı? <a href="login.php">Giriş Yapın</a></p>

    </div>

</body>
</html>
