<?php
session_start();
require_once "../includes/Dao.php";
$dao = new Dao();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['abortGame'])) {
    $roomCode = $_SESSION['roomCode'];

    // Remove the game from the database
    $dao->abortGame($roomCode);

    // Clear the session
    unset($_SESSION['roomCode']);
    unset($_SESSION['isHost']);
    unset($_SESSION['Alias']);
    unset($_SESSION['list']);
    // session_destroy();

    // Redirect the user to the home page
    header("Location: ../index.php");
    exit;
}
?>