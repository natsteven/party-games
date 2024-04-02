<?php
require_once "../includes/Dao.php";
$dao = new Dao();

if (isset($_GET['roomCode'])) {
    $roomCode = $_GET['roomCode'];

    // Get the current number of players in the game
    $currentNumPlayers = $dao->getNumPlayersInRoom($roomCode);

    echo $currentNumPlayers;
}
?>