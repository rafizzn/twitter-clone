<!-- <?php
session_start();
include_once "conn/koneksi.php";

function login()
{
    if (empty($_POST['username']) || empty($_POST['password'])) {
        return;
    }

    $conn = koneksidb();
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM register WHERE username = $1";
    pg_prepare($conn, "my_query", $sql);
    $result = pg_execute($conn, "my_query", array($username));

    if (!$result || pg_num_rows($result) <= 0) {
        echo "<script>alert('Gagal login: username atau password salah!'); window.location.href='login.php';</script>";
        pg_close($conn);
        return;
    }

    $row = pg_fetch_array($result);
    $password_db = $row["password"];

    if ($password_db == $password) {
        // Set session dan redirect ke main.php
        $_SESSION['username'] = $username;

        setcookie("ingat_aku", $username, time() + (60 * 60 * 24 * 30), "/");

        pg_close($conn);
        echo "<script>alert('Login berhasil!'); window.location.href='main.php';</script>";
        exit();
    } else {
        echo "<script>alert('Gagal login: username atau password salah!'); window.location.href='login.php';</script>";
        pg_close($conn);
    }
}

login();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>form login</title>
    <link rel="stylesheet" href="login.css">
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
                <p>Sign In to X</p>
            </div>

            <div class="email">
                <input type="email" name="Email" id="email" placeholder="Email" required>
            </div>

            <div class="password">
                <input type="password" name="Password" id="password" Placeholder="Password" required>
            </div>

            <div class="login">
                <button type="submit">Next</button>
            </div>
        </form>
    </div>
</body>

</html> -->