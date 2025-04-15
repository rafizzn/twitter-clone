<?php
require 'koneksi.php';
session_start();

$conn = koneksidb();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['content'])) {
    $content = trim($_POST['content']);

    $userId = $_SESSION['user_id'];

    if (!empty($content)) {
        $queryInsert = 'INSERT INTO postingan (user_id, content, create_at) VALUES ($1, $2, NOW())';
        pg_query_params($conn, $queryInsert, [$userId, $content]);
    }

    header("Location: beranda.php");
    exit();
}

if (!isset($_SESSION['liked_posts'])) {
    $_SESSION['liked_posts'] = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['like_post'])) {
    $postIndex = $_POST['like_post'];

    // Toggle like
    if (in_array($postIndex, $_SESSION['liked_posts'])) {
        $_SESSION['liked_posts'] = array_diff($_SESSION['liked_posts'], [$postIndex]);
    } else {
        $_SESSION['liked_posts'][] = $postIndex;
    }

    header("Location: beranda.php");
    exit();
}

$queryFetchStatus = '
    SELECT p.content, p.create_at, u.username AS author
    FROM postingan p
    JOIN "user" u ON p.user_id = u.id
    ORDER BY p.create_at DESC
';
$resultStatus = pg_query($conn, $queryFetchStatus);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home / X Clone</title>
    <link rel="stylesheet" href="beranda.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <img src="img/twitter.png" alt="X Logo" class="logo">
            <nav>
                <ul>
                    <li><img src="img/home.png" alt="">Home</li>
                    <li><img src="img/search.png" alt="">Explore</li>
                    <li><img src="img/notif.png" alt="">Notifications</li>
                    <li><img src="img/messages.png" alt="">Messages</li>
                    <li><img src="img/grok.png" alt="">Grok</li>
                    <li><img src="img/community.png" alt="">Communities</li>
                    <li><img src="img/user.png" alt="">Profile</li>
                    <li><img src="img/more.png" alt="">More</li>
                </ul>
            </nav>
            <button class="post-btn">Post</button>
            <div class="user-box">
                <img class="user-pic" src="img/saya.png" alt="pfp">
                <div class="user-info">
                    <p class="name">Izzan Rafif</p>
                    <p class="username">@raf1zzn</p>
                </div>
            </div>
        </aside>
        <div class="main-content">

            <!-- Feed -->
            <main class="feed">
                <div class="feed-header">
                    <span class="active-tab">For you</span>
                    <span>Following</span>
                </div>
                <form class="tweet-box" method="POST" action="beranda.php">
                    <input type="text" name="content" placeholder="What's happening?" required>
                    <div class="tweet-box-wrapper">
                        <div class="tweet-tools">
                            <div>📷</div>
                            <div>🎞</div>
                            <div>📊</div>
                            <div>😊</div>
                            <div>📅</div>
                            <div>📍</div>
                        </div>
                        <button type="submit" class="tweet-btn">Post</button>
                    </div>
                </form>

                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        if (pg_num_rows($resultStatus) > 0) {
                            $i = 0;
                            while ($row = pg_fetch_assoc($resultStatus)) {
                                $isLiked = in_array($i, $_SESSION['liked_posts']);

                                echo '<div class="post">';
                                echo '<p><b>' . htmlspecialchars($row["author"]) . '</b><br>';
                                echo nl2br(htmlspecialchars($row["content"])) . '<br>';
                                echo '<div class="post-actions">';

                                // Like form
                                echo '<form method="POST" style="display:inline">';
                                echo '<input type="hidden" name="like_post" value="' . $i . '">';
                                echo '<button type="submit" class="like-btn">';
                                echo '<i class="' . ($isLiked ? 'fa-solid' : 'fa-regular') . ' fa-heart ' . ($isLiked ? 'liked' : '') . '"></i>';
                                echo '</button>';
                                echo '</form>';

                                // Comment icon (static)
                                echo '<i class="fa-regular fa-comment"></i>';

                                echo '</div></p>';
                                echo '<hr></div>';

                                $i++;


                            }
                        } else {
                            echo "<center><p>Tidak ada status untuk ditampilkan</p></center>";
                        }
                        ?>
                    </div>
                </div>
            </main>
        </div>

        <!-- Right Sidebar -->
        <aside class="rightbar">
            <div class="subscribe-box">
                <h3>Subscribe to Premium</h3>
                <p>Unlock new features and share revenue.</p>
                <button class="subscribe-btn">Subscribe</button>
            </div>

            <div class="trending-box">
                <h3>What's happening</h3>
                <ul>
                    <li><strong>Music · Trending</strong><br>JIN IS COMING — 2,131 posts</li>
                    <li><strong>Trending in Indonesia</strong><br>sunny day with yujin — 7,049 posts</li>
                    <li><strong>Trending in Indonesia</strong><br>Abidzar</li>
                </ul>
            </div>
        </aside>
    </div>
    </div>
</body>

</html>