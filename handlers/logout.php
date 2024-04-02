<?php
session_start();
unset($_SESSION['logged']);
unset($_SESSION['admin']);
// session_destroy();

header("Location: ../index.php");