<?php
include_once "koneksi.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = koneksidb();
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $pass = $_POST['password'] ?? '';

    if (!empty($username) && !empty($email) && !empty($pass)) {
        $sql = 'INSERT INTO "user" (username, email, password, create_at) VALUES ($1, $2, $3, NOW())';
        $stmt = uniqid('stmt_');
        pg_prepare($conn, $stmt, $sql);
        $result = pg_execute($conn, $stmt, array($username, $email, $pass));
        $message = $result ? "Registrasi berhasil!" : "Registrasi gagal: " . pg_last_error($conn);
        pg_close($conn);
    } else {
        $message = "Mohon isi semua data.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="regis.css">
</head>

<body>
    <?php if (!empty($message)): ?>
        <script>alert("<?= $message ?>");</script>
    <?php endif; ?>
    <div class="box">
        <div class="btn-back">
            <a href="main.php">
                <img src="img/back.png" alt="back">
            </a>
        </div>

        <img class="tweet" src="img/twitter.png" alt="logo twitter">

        <form action="regis.php" method="POST">
            <div class="judul">
                <p>Create your account</p>
            </div>

            <?php if (!empty($error)): ?>
                <p class="error-msg"><?= $error ?></p>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <p class="success-msg"><?= $success ?></p>
            <?php endif; ?>

            <div class="username">
                <input type="text" name="username" id="username" placeholder="Username" required>
            </div>

            <div class="email">
                <input type="email" name="email" id="email" placeholder="Email" required>
            </div>

            <div class="password">
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>

            <div class="daftar">
                <button type="submit">Register</button>
            </div>
        </form>
    </div>
</body>

</html>