<?php

include_once "koneksi.php";
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

                <div class="signin-section">
                    <p class="signin-text">Already have an account?</p>
                    <a class="signin-button" href="login.php">Sign in</a>
                </div>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
