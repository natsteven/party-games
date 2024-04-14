<?php
require_once "includes/Dao.php";
require_once "includes/header.php";
$dao = new Dao();

if (!($_SERVER['REQUEST_METHOD'] == 'POST') && !isset($_SESSION['roomCode'])) {
    header("Location: index.php");
    exit;
}

if (isset($_SESSION['list']) && $_SESSION['isHost']) {
    header("Location: show_names.php");
}

// Check if actaully creating game or being redirected from add_host.php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['roomCode'])) {
    // session_unset();
    // Generate a unique game key and ID for the host
    do {
        $roomCode = rand(10000, 99999);  // Generate a random 5-digit number
    } while ($dao->roomExists($roomCode));  // Check if the game key already exists
    $hostId = uniqid();

    // Get the number of players and red herrings from the form
    $expectedPlayers = $_POST['numPlayers'];
    $numRedHerrings = $_POST['numRedHerrings'];

    // Create a new game session with the generated game key
    $dao->startGame($roomCode, $hostId, $expectedPlayers, $numRedHerrings);

    // Store id, roomCode, expectedPlayers, and host flag in the session
    $_SESSION['Id'] = $hostId;  
    $_SESSION['isHost'] = True;
    $_SESSION['roomCode'] = $roomCode;
    $_SESSION['expectedPlayers'] = $expectedPlayers;
    header("Location: game.php");
    exit;
} else {
    if (isset($_SESSION['roomCode']) && !$dao->roomExists($_SESSION['roomCode'])) {
        unset($_SESSION['roomCode']);
        unset($_SESSION['isHost']);
        unset($_SESSION['Alias']);
        header("Location: index.php");
        exit;
    }

    $roomCode = $_SESSION['roomCode'];
    $expectedPlayers = $_SESSION['expectedPlayers'];
}
// Get the current number of players in the game
$currentNumPlayers = $dao->getNumPlayersInRoom($roomCode);

?>
<div class="game"
data-roomCode = "<?php echo $roomCode; ?>"
data-expectedPlayers = "<?php echo $expectedPlayers; ?>"
>
<button class="collapsible">Show Rules</button>
    <div class="rules" style="display: none;">
      <p>After creating a game share the room code with other players so they can join</p>
      <p>Each Player chooses a secret alias which they will input into their device</p>
      <p>These are compiled into a list, with optional additional Red Herrings (fake names from the computer)</p>
      <p>When ready the host can show the list and should read the names out slowly to the group twice</p>
      <p>Someone (perhaps the youngest player) can begin by attempting to guess someone's alias</p>
      <p>If they are correct, that person becomes part of the guesser's Empire and they can guess again</p>
      <p>If they are incorrect the queried person gets to guess next</p>
      <p>This continues until an Empire takes over the entire group, thereby crowning a winner</p>
      <p>Subjects of one's empire are encouraged to aid in the conquering of other empires</p>
    </div>

<div>
    <h2>Share this Room Code: <?php echo $roomCode; ?></h2>
</div>
<div>
    <h3>Players Ready:<span id="numPlayers"> <?php echo $currentNumPlayers; ?></span> / <?php echo $expectedPlayers; ?></h3>
</div>

<?php if (!isset($_SESSION['Alias'])): ?>
<div>
    <form action="handlers/add.php" method="POST">
        <label for="Alias">Choose Alias:</label>
        <input type="text" id="Alias" name="Alias" required>
        <button type="submit">Submit</button>
    </form>
</div>
<?php endif; ?>

<?php if ($_SESSION['isHost']): ?>
<div>
    <form action="show_names.php" method="POST">
        <button type="submit" name="showNames" <?php echo (!isset($_SESSION['Alias']) || $currentNumPlayers < $expectedPlayers) ? 'disabled' : ''; ?>>Show Names</button>
    </form>
</div>


<div>
    <form action="handlers/abort_game.php" method="POST">
        <button type="submit" name="abortGame">Abort Game</button>
    </form>
</div>
<?php endif; ?>

<?php if (!$_SESSION['isHost']): ?>
<div>
    <form action="handlers/leave_game.php" method="POST">
        <button type="submit" name="leaveGame">Leave Game</button>
    </form>
</div>
<?php endif; ?>

<?php if (!$_SESSION['isHost'] && isset($_SESSION['Alias'])): ?>
<div>
    <h3 id="gameStatus">Waiting for Host to start the game...</h3>
</div>
<?php endif;?>

<script src = "js/rules.js"></script>
<script src = "js/num_players.js"></script>
<script src = "js/game_status.js"></script>

<?php require_once "includes/footer.php"; ?>