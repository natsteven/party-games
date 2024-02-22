<?php require_once "header.php"; ?>

<div class="join">
  <form action="join_game.php" method="POST">
    <label for="roomCode">Enter Room Code:</label>
    <input type="text" id="roomCode" name="roomCode" required>
    <button type="submit">Join Game</button>
  </form>
</div>


<?php require_once "footer.php"; ?>