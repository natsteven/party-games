<?php 
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
if (isset($_SESSION['roomCode']) && ($currentPage == "join.php"|| $currentPage == "games.php"))  {
    # locally, ah well
    // header("Location: /party-games/game.php");
    # deployed
    header("Location: /game.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PartyGames</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="assets/favicon.ico">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <div id="banner">
            <a href="index.php"><img src="assets/logo.jpg" alt="Party Games!" id="bannerImage"></a>
            <div class="login">
            <?php
                if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
                    echo '<a href="handlers/logout.php">Logout</a>';
                } else {
                    echo '<a href="login.php">Login</a>';
                }
            ?>
            </div>
        </div>
    </header>
    <main>
