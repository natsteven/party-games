<?php require_once "header.php"; ?>

<div class="empires">
    <h1>Empires</h1>
    <button class="collapsible">Show Rules</button>
    <div class="rules" style="display: none;">
      <p>Each Player chooses a secret alias which they will input into their device (remote format with room number) or into the hosts device (local format)</p>
      <p>These are compiled into a list which is read out to the group, with optional additional Red Herrings (fake names from the computer)</p>
      <p>After the names have been read out twice the youngest player can begin by choosing someone and guessing their alias</p>
      <p>If they are correct, that person becomes part of the guesser's Empire and they can guess again, if they are incorrect the queried person gets to guess next</p>
      <p>This continues until an Empire takes over the entire group, thereby crowning a winner.</p>
      <p>Subjects of one's empire are encouraged to aid in the conquering of other empires</p>
    </div>

    <script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
      coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.display === "block") {
          content.style.display = "none";
          this.textContent = "Show Rules";
        } else {
          content.style.display = "block";
          this.textContent = "Hide Rules";
        }
      });
    }
    </script>
    <h2>Game Settings</h2>
    <form action="create_game.php" method="POST">
        <label for="numPlayers">Number of Players:</label>
        <input type="number" id="numPlayers" name="numPlayers" min="2" value="6" required>

        <label for="numRedHerrings" title="additional fake names added by the computer">Number of Red Herrings:</label>
        <input type="number" id="numRedHerrings" name="numRedHerrings" min="0" value="1" required>

        <!-- <label>Format:</label> -->
        <div class="radio-button">
            <input type="radio" id="local" name="format" value="local" required>
            <label for="local">Local</label>
        </div>
        <div class="radio-button">
            <input type="radio" id="remote" name="format" value="remote" required>
            <label for="remote">Remote</label>
        </div>

        <button class="createButton" type="submit">Create Game</button>
    </form>
</div>

<?php require_once "footer.php"; ?>