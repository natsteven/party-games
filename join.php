<?php 
require_once "includes/header.php";

echo '<div class="join">';

if (isset($_SESSION['message'])): ?>
  <div class="message">
    <p><?php echo $_SESSION['message']; ?></p>
  </div>
  <?php unset($_SESSION['message']); ?>
<?php endif; ?>
  <form action="handlers/join_game.php" method="POST">
    <label for="roomCode">Enter Room Code:</label>
    <input type="text" id="roomCode" name="roomCode" required>
    <button type="submit">Join Game</button>
  </form>
</div>


<?php require_once "includes/footer.php"; ?>