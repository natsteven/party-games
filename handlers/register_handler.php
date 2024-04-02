<?php
session_start();
require_once "../includes/Dao.php";
$dao = new Dao();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])):
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordconf = $_POST['passwordconf'];

    $messages = array();

    // Check if the email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)):
        $messages[] = "Invalid email address.";
    endif;

    // Check if the email is available
    if ($dao->emailExists($email)):
        $messages[] = "Email already in use.";
    endif;

    // Check if the passwords match
    if ($password !== $passwordconf):
        $messages[] = "Passwords do not match.";
    endif;

    if (!empty($messages)):
        $_SESSION['messages'] = $messages;
        $_SESSION['inputs']['email'] = $email;
        header("Location: ../register.php");
        exit;
    endif;


    $dao->addUser($email, $password);

    $_SESSION['logged'] = true;

    header("Location: ../index.php");
    exit;
endif;