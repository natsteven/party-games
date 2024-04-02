<?php 
require_once "includes/header.php";
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
        <?php if (isset($_SESSION['admin'])): ?>
            <div class="navLink">
                <a href="admin.php">Admin</a>
            </div>
        <?php endif; ?>
    </nav>
<?php require_once "includes/footer.php"; ?>