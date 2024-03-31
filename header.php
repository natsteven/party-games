<?php 
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
if (isset($_SESSION['roomCode']) && $currentPage != 'game.php' && $currentPage != 'show_names.php')  {
    header("Location: game.php");
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
    <link rel="icon" href="favicon.ico">
</head>
<body>
    <header>
        <div id="banner">
            <a href="index.php"><img src="logo.jpg" alt="Party Games!" id="bannerImage"></a>
            <div class="login">
                <a href="login.php">Login</a>
            </div>
        </div>
    </header>
    <main>
