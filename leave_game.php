<?php
session_start();
require_once "Dao.php";
$dao = new Dao();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['leaveGame'])) {
    $Id = $_SESSION['Id'];

    // Remove the player from the game
    $dao->removePlayer($Id);

    // Clear the session
    session_unset();
    session_destroy();

    // Redirect the user to the home page
    header("Location: index.php");
    exit;
}