<?php 
require_once "header.php";
if (isset($_SESSION['messages'])) {
    foreach ($_SESSION['messages'] as $message) {
       echo "<div class='message'>{$message}</div>";
    }
    unset($_SESSION['messages']);
}
?>
    <nav>
        <div class="navLink">
            <a href="join.php">Join Game</a>
        </div>
        <div class="navLink">
            <a href="games.php">Create Game</a>
        </div>
        <div class="navLink">
            <a href="about.php">About</a>
        </div>
    </nav>
<?php require_once "footer.php"; ?>