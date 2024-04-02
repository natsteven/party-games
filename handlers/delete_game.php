<?php
require_once "../includes/Dao.php";

$dao = new Dao();

if ($_SERVER['REQUEST_METHOD'] == 'POST'&& isset($_POST['room_code'])) {
    $room_code = $_POST['room_code'];
    $dao->abort($room_code);
}

header("Location: ../admin.php");
exit;