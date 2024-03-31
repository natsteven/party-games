<?php require_once "header.php"; ?>

<div class="join">
  <form action="join_game.php" method="POST">
    <label for="roomCode">Enter Room Code:</label>
    <input type="text" id="roomCode" name="roomCode" required>
    <button type="submit">Join Game</button>
  </form>
</div>
<?php if (isset($_SESSION['message'])): ?>
  <div class="message">
    <p><?php echo $_SESSION['message']; ?></p>
  </div>
  <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<?php require_once "footer.php"; ?>