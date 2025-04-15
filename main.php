<?php
require 'koneksi.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = koneksidb();
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    $query = 'SELECT * FROM "user" WHERE username = $1';
    $result = pg_query_params($conn, $query, [$username]);

    if ($result && $data = pg_fetch_assoc($result)) {
        if ($password === $data['password']) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $data['id'];

            if ($remember) {
                setcookie('username', $username, time() + (86400 * 30), "/"); // 30 days
                setcookie('password', $password, time() + (86400 * 30), "/"); // Not secure for production
            }

            header("Location: beranda.php");
            exit();
        } else {
            echo "<script>alert('Gagal login: username atau password salah!'); window.location.href='main.php';</script>";
        }
    } else {
        echo "<script>alert('Gagal login: username atau password salah!'); window.location.href='main.php';</script>";
    }

    pg_close($conn);
}


$header = "Happening now";
$header2 = "Join today.";
$snk = "By signing up, you agree to the Terms of Service and Privacy Policy, including Cookie Use.";
$already = "Already have an account?";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>XX</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>

    <div class="logo-box">
        <img src="img/twitter.png" alt="X Logo" class="x-logo">
    </div>

    <div class="grid-container">
        <div class="content-group">
            <h1 class="headline"><?php echo $header ?></h1>
            <h2 class="subheadline"><?php echo $header2 ?></h2>

            <div class="button-group">
                <button class="btn google">
                    <img src="img/google.png" alt="Google icon">
                    Sign up with Google
                </button>

                <button class="btn apple">
                    <img src="img/apple.png" alt="Apple icon">
                    Sign up with Apple
                </button>

                <div class="divider"><span>or</span></div>

                <div class="btn create-account">
                    <a class="textCreateAccount" href="regis.php">
                        Create account
                    </a>
                </div>

                <p class="terms">
                    By signing up, you agree to the
                    <a href="#">Terms of Service</a> and
                    <a href="#">Privacy Policy</a>, including
                    <a href="#">Cookie Use</a>.
                </p>

                <div class="signin-section">
                    <p class="signin-text"><?php echo $already ?></p>
                    <a class="signin-button" href="#signinModal">Sign in</a>
                </div>
            </div>
        </div>
    </div>

    <!-- login pop up -->
    <div id="signinModal" class="modal">
        <div class="modal-content">
            <a href="#" class="close">&times;</a>
            <h2>Sign In</h2>

            <?php if (!empty($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>

            <form method="POST" action="main.php">
                <input type="text" name="username" placeholder="Username"
                    value="<?php echo $_COOKIE['username'] ?? ''; ?>" required>
                <input type="password" name="password" placeholder="Password"
                    value="<?php echo $_COOKIE['password'] ?? ''; ?>" required>
                <label>
                    <input type="checkbox" name="remember" <?php echo isset($_COOKIE['username']) ? 'checked' : ''; ?>>
                    Remember me
                </label>
                <button type="submit" class="submit-btn">Login</button>
            </form>
        </div>
    </div>

</body>

</html>