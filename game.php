<?php
require_once "Dao.php";
require_once "header.php";
$dao = new Dao();

// Check if actaully creating game or being redirected from add_host.php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['roomCode'])) {
    session_unset();
    // Generate a unique game key and ID for the host
    do {
        $roomCode = rand(10000, 99999);  // Generate a random 5-digit number
    } while ($dao->roomCodeExists($roomCode));  // Check if the game key already exists
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
        session_unset();
        header("Location: index.php");
        exit;
    }

    $roomCode = $_SESSION['roomCode'];
    $expectedPlayers = $_SESSION['expectedPlayers'];
}
// Get the current number of players in the game
$currentNumPlayers = $dao->getNumPlayersInRoom($roomCode);

?>
<div class="game">
<div>
    <h2>Room Code: <?php echo $roomCode; ?></h2>
</div>
<div>
    <h3>Players:<span id="numPlayers"> <?php echo $currentNumPlayers; ?></span> / <?php echo $expectedPlayers; ?></h3>
</div>

<?php if (!isset($_SESSION['Alias'])): ?>
<div>
    <form action="add.php" method="POST">
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
    <form action="abort_game.php" method="POST">
        <button type="submit" name="abortGame">Abort Game</button>
    </form>
</div>
<?php endif; ?>

<?php if (!$_SESSION['isHost']): ?>
<div>
    <form action="leave_game.php" method="POST">
        <button type="submit" name="leaveGame">Leave Game</button>
    </form>
</div>
<?php endif; ?>

<?php if (!$_SESSION['isHost'] && isset($_SESSION['Alias'])): ?>
<div>
    <h3>Waiting for Host to start the game...</h3>
</div>
<?php endif; ?>
<?php require_once "footer.php"; ?>