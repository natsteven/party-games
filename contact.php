<?php require_once "header.php"; ?>

<div class="container">
  <h1>Contact Us</h1>
  <form action="submit_contact.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="message">Message:</label>
    <textarea id="message" name="message" required></textarea>

    <button type="submit">Submit</button>
  </form>
</div>

<?php require_once "footer.php"; ?>