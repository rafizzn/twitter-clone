<?php
include_once "conn/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = koneksidb();
    $username = $_POST['Username'] ?? '';
    $email = $_POST['Email'] ?? '';
    $pass = $_POST['Password'] ?? '';

    if (!empty($username) && !empty($email) && !empty($pass)) {
        $sql = "INSERT INTO register (username, email, password) VALUES ($1, $2, $3)";
        pg_prepare($conn, "my_query", $sql);
        $result = pg_execute($conn, "my_query", array($username, $email, $pass));
        if ($result) {
            echo "<script>alert('Registrasi berhasil!');</script>";
        } else {
            echo "<script>alert('Registrasi gagal: " . pg_last_error($conn) . "');</script>";
        }
        pg_close($conn);

    } else {
        echo "<script>alert('Mohon isi semua data.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>form regist</title>
    <link rel="stylesheet" href="regis.css">
</head>

<body>
    <div class="box">
        <div class="btn-back">
            <a href="main.php">
                <img src="img/back.png" alt="back">
            </a>
        </div> 

        <img class="tweet" src="img/twitter.png" alt="logo twitter">

        <form action="" method="POST">
            <div class="judul">
                <p>Create your account</p>
            </div>

            <div class="username">
                <input type="text" name="Username" id="username" placeholder="Username" required>
            </div>

            <div class="email">
                <input type="email" name="Email" id="email" placeholder="Email" required>
            </div>

            <div class="password">
                <input type="password" name="Password" id="password" Placeholder="Password" required>
            </div>

            <div class="daftar">
                <button type="submit">Next</button>
            </div>
        </form>
    </div>
</body>

</html>