<!-- js script handling that doesnt work yet -->
<?php
require_once "Dao.php";
$dao = new Dao();

if (isset($_GET['roomCode'])) {
    $roomCode = $_GET['roomCode'];

    // Get the current number of players in the game
    $currentNumPlayers = $dao->getNumPlayersInRoom($roomCode);

    echo $currentNumPlayers;
}
?>