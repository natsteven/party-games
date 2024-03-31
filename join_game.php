<?php
session_start();
require_once "Dao.php";
$dao = new Dao();

// Get the room code from the form
$roomCode = $_POST['roomCode'];

// check exists and if not redirect back to room code with error message
if (!$dao->roomExists($roomCode)) {
    $_SESSION['message'] = "Room code does not exist.";
    header("Location: join.php");
    exit;
}
// set sessions values
$_SESSION['roomCode'] = $roomCode;
$id = uniqid();
$_SESSION['Id'] = $id;
$_SESSION['isHost'] = False;
$_SESSION['expectedPlayers'] = $dao->getExpectedPlayers($roomCode);

header("Location: game.php");
exit;