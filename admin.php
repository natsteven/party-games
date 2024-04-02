<?php
require_once "includes/header.php";
require_once "includes/Dao.php";

$dao = new Dao();

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

function printAdmins($dao) {
    $rows = $dao->getAdmins();

    echo "<table>";
    echo "<tr><th>Email</th></tr>";
    foreach ($rows as $row) {
        echo "<tr><td>" . $row['email'] . "</td></tr>";
    }
    echo "</table>";
}

function printGames($dao) {
    $rows = $dao->getGames();
    echo "<h2>Current Games:</h2>";
    echo "<table>";
    echo "<tr><th>Room Code</th><th>Host ID</th><th>Expected Players</th><th>Red Herrings</th><th>Action</th></tr>";
    foreach ($rows as $row) {
        echo "<tr><td>" . $row['room_code'] . "</td><td>" . $row['host_id'] . "</td><td>" . $row['expected_players'] . "</td><td>" . $row['num_red_herrings'] . "</td>";
        echo "<td>
                <form method='POST' action='handlers/delete_game.php'>
                    <input type='hidden' name='room_code' value='" . $row['room_code'] . "'>
                    <input type='submit' value='Delete'>
                </form>
              </td></tr>";
    }
    echo "</table>";
}

function printGamePlayers($dao) {
    $rows = $dao->getGamePlayers();
    echo "<h2>Current Players:</h2>";
    echo "<table>";
    echo "<tr><th>Player ID</th><th>Alias</th><th>Room Code</th></tr>";
    foreach ($rows as $row) {
        echo "<tr><td>" . $row['player_id'] . "</td><td>" . $row['alias'] . "</td><td>" . $row['room_code'] . "</td></tr>";
    }
    echo "</table>";
}

function printUsers($dao) {
    $rows = $dao->getUsers();
    echo "<h2>Registered Users:</h2>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Email</th></tr>";
    foreach ($rows as $row) {
        echo "<tr><td>" . $row['id'] . "</td><td>" . $row['email'] . "</td></tr>";
    }
    echo "</table>";
}

function printRedHerrings($dao) {
    $rows = $dao->getAllRedHerrings();
    echo "<h2>Red Herrings:</h2>";
    echo "<table>";
    echo "<tr><th>Name</th></tr>";
    foreach ($rows as $row) {
        echo "<tr><td>" . $row['name'] . "</td></tr>";
    }
    echo "</table>";
}
?>

<div class = 'admin'>
<h1>Admin Page</h1>

<?php
printGames($dao);
printGamePlayers($dao);
printUsers($dao);
printRedHerrings($dao);
?>

</div>

<?php
require_once "includes/footer.php";