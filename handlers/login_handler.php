<?php
require_once "../includes/Dao.php";
$dao = new Dao();
session_start();

$message = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($dao->validateUser($email, $password)) {
        $_SESSION['logged'] = true;
        header("Location: ../index.php");
        exit;
    } else {
        $messages[] = "Invalid email or password.";
    }
}

$_SESSION['messages'] = $messages;
header("Location: ../login.php");