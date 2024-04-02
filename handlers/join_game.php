<?php
session_start();
require_once "../includes/Dao.php";
$dao = new Dao();

// Get the room code from the form
$roomCode = $_POST['roomCode'];

// Check if room code is valid
if (!preg_match('/^\d{5}$/', $roomCode)) {
    $_SESSION['message'] = "Invalid room code";
    $_SESSION['inputs']['roomCode'] = $_POST['roomCode'];
    header("Location: ../join.php");
    exit;
}

// check exists and if not redirect back to room code with error message
if (!$dao->roomExists($roomCode)) {
    $_SESSION['message'] = "Room code does not exist.";
    $_SESSION['inputs']['roomCode'] = $roomCode;
    header("Location: ../join.php");
    exit;
}
// set sessions values
$_SESSION['roomCode'] = $roomCode;
$id = uniqid();
$_SESSION['Id'] = $id;
$_SESSION['isHost'] = False;
$_SESSION['expectedPlayers'] = $dao->getExpectedPlayers($roomCode);

header("Location: ../game.php");
exit;