<?php
session_start();
require_once "Dao.php";
$dao = new Dao();

// Get the host's alias and game key from the form
$Alias = $_POST['Alias'];
$roomCode = $_SESSION['roomCode'];
$_SESSION['Alias'] = $Alias;
// Get the host's ID from the session
$Id = $_SESSION['Id'];
print_r($_SESSION);
// Add the host as the first player in the game
$dao->addPlayer($Id, $Alias, $roomCode);

// Redirect back to the host game page
header("Location: game.php");
exit;