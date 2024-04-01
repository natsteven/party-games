<?php 
require_once "header.php";

echo "<div class='registerform'>";

if (isset($_SESSION['messages'])) {
  foreach ($_SESSION['messages'] as $message) {
     echo "<div class='message'>{$message}</div>";
  }
  unset($_SESSION['messages']);
}
?>
  <form action="register_handler.php" method="POST">
    <label for="email">Email:</label>
    <input type="text" id="email" name="email" required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <label for="passwordconf">Confirm Password:</label>
    <input type="password" id="passwordconf" name="passwordconf" required>
    <button type="submit">Register/Login</button>
  </form>
</div>

<?php require_once "footer.php"; ?>