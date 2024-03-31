<?php
session_start();
require_once "Dao.php";
$dao = new Dao();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['abortGame'])) {
    $roomCode = $_SESSION['roomCode'];

    // Remove the game from the database
    $dao->abortGame($roomCode);

    // Clear the session
    session_unset();
    session_destroy();

    // Redirect the user to the home page
    header("Location: index.php");
    exit;
}
?>