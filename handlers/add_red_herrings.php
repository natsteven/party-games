<?php
require_once "../includes/Dao.php";
$dao = new Dao();
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addRedHerrings'])) {
    $roomCode = $_SESSION['roomCode'];
    $dao->addRedHerrings($roomCode);
    $dao->abortGame($roomCode); //also ends the game
    header("Location: ../show_names.php");
    exit;
}