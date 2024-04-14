<?php
require_once "../includes/Dao.php";
$dao = new Dao();

if (isset($_GET['roomCode'])) {
    $roomCode = $_GET['roomCode'];

    $gameStatus = $dao->getGameStarted($roomCode);

    echo $gameStatus;
}
?>