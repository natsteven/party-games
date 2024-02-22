<?php require_once "header.php"; ?>

<div class="loginform">
  <form action="login.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Login</button>
  </form>
  <p>Don't have an account?</p>
  <button onclick="location.href='register.php'">Register</button>
</div>

<?php require_once "footer.php"; ?>