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

    echo "<table>";
    echo "<tr><th>Room Code</th><th>Host ID</th><th>Expected Players</th><th>Number of Red Herrings</th></tr>";
    foreach ($rows as $row) {
        echo "<tr><td>" . $row['room_code'] . "</td><td>" . $row['host_id'] . "</td><td>" . $row['expected_players'] . "</td><td>" . $row['num_red_herrings'] . "</td></tr>";
    }
    echo "</table>";
}

function printGamePlayers($dao) {
    $rows = $dao->getGamePlayers();

    echo "<table>";
    echo "<tr><th>Player ID</th><th>Alias</th><th>Room Code</th></tr>";
    foreach ($rows as $row) {
        echo "<tr><td>" . $row['player_id'] . "</td><td>" . $row['alias'] . "</td><td>" . $row['room_code'] . "</td></tr>";
    }
    echo "</table>";
}

function printUsers($dao) {
    $rows = $dao->getUsers();

    echo "<table>";
    echo "<tr><th>ID</th><th>Email</th><th>Password</th></tr>";
    foreach ($rows as $row) {
        echo "<tr><td>" . $row['id'] . "</td><td>" . $row['email'] . "</td><td>" . $row['password'] . "</td></tr>";
    }
    echo "</table>";
}

function printRedHerrings() {
    $rows = $dao->getAllRedHerrings();

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
<h2>Current Games:</h2>
<?php
printGames($dao);
?>
<h2>Current Players:</h2>
<?php
printGamePlayers($dao);
?>

</div>

<?php
require_once "includes/footer.php";