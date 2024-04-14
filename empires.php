<?php require_once "includes/header.php"; ?>

<div class="empires">
    <h1>Empires</h1>
    <button class="collapsible">Show Rules</button>
    <div class="rules" style="display: none;">
      <p>After creating a game <b>share the room code</b> with other players so they can join.</p>
      <p>Each Player should <b>choose an alias</b>, which should be kept secret, and input into their device. 
      These are compiled into a list, with optional additional Red Herrings (fake names from the computer)</p>
      <p>When ready the host can <b>show the aliases</b> list and should read the names out <i>slowly</i> to the group twice</p>
      <p>Someone (perhaps the youngest player) will begin and should attempt to <b>guess a player's alias</b>. 
        If they are correct, that person becomes part of the guesser's <i>Empire</i> and they can guess again. 
        If they are incorrect the queried person gets to guess next</p>
      <p>This continues until an Empire takes over the entire group, thereby crowning a winner. Subjects of one's empire are encouraged to aid in the conquering of other empires</p>
    </div>

    <h2>Game Settings</h2>
    <form action="game.php" method="POST">
        <label for="numPlayers">Number of Players:</label>
        <input type="number" id="numPlayers" name="numPlayers" min="2" value="6">

        <label for="numRedHerrings" title="additional fake names added by the computer">Number of Red Herrings:</label>
        <input type="number" id="numRedHerrings" name="numRedHerrings" min="0" value="1">

        <!-- <label>Format:</label> -->
        <!-- <div class="radio-button">
            <input type="radio" id="local" name="format" value="local">
            <label for="local">Local</label>
        </div>
        <div class="radio-button">
            <input type="radio" id="remote" name="format" value="remote" checked>
            <label for="remote">Remote</label>
        </div> -->

        <button class="createButton" type="submit">Create Game</button>
    </form>
</div>
<script src = "js/rules.js"></script>
<?php require_once "includes/footer.php"; ?>