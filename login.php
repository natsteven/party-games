<?php 
require_once "includes/header.php";

echo "<div class='loginform'>";

if (isset($_SESSION['messages'])) {
  foreach ($_SESSION['messages'] as $message) {
     echo "<div class='message'>{$message}</div>";
  }
  unset($_SESSION['messages']);
}
?>
  <div>
  <form action="handlers/login_handler.php" method="POST">
    <label for="email">Email:</label>
    <input type="text" id="email" name="email" required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Login</button>
  </form>
  <p>Don't have an account?</p>
  <button onclick="location.href='register.php'">Register</button>
  </div>
</div>

<?php require_once "includes/footer.php"; ?>