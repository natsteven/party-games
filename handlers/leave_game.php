<?php
session_start();
require_once "../includes/Dao.php";
$dao = new Dao();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['leaveGame'])) {
    $Id = $_SESSION['Id'];

    // Remove the player from the game
    $dao->removePlayer($Id);

    // Clear the session
    unset($_SESSION['roomCode']);
    unset($_SESSION['isHost']);
    unset($_SESSION['Alias']);
    // session_destroy();

    // Redirect the user to the home page
    header("Location: ../index.php");
    exit;
}