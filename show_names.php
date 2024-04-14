<?php
require_once "includes/header.php";
require_once "includes/Dao.php";
$dao = new Dao();

$roomCode = $_SESSION['roomCode'];

if (!isset($_SESSION['list']) && $_SESSION['isHost']) {
    $names = $dao->getAliasesInRoom($roomCode);
    $herrings = $dao->getRedHerrings($roomCode);
    $dao->setStartedGame($roomCode);

    // Lowercase and capitalize each name
    $names = array_map(function($name) {
        return ucwords(strtolower($name));
    }, $names);

    // Merge the names and herrings arrays
    $list = array_merge($names, $herrings);

    // Shuffle the list
    shuffle($list);

    // Store the list in the session
    $_SESSION['list'] = $list;
} else {
    // Get the list from the session
    $list = $_SESSION['list'];
}

echo "<div class = nameList><h2>Aliases:</h2>";
foreach ($list as $name) {
    $alias = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    echo "<ul>$alias</ul>";
}

// not really necessary to check but whatever
if ($_SESSION['isHost']): ?> 
    <div>
        <form action="handlers/abort_game.php" method="POST">
            <button type="submit" name="abortGame">End Game</button>
        </form>
    </div>
<?php endif;

if (isset($_SESSION['admin'])): ?>
    <div>
        <form action="handlers/add_red_herrings.php" method="POST">
            <button type="submit" name="addRedHerrings">Add Red Herrings</button>
        </form>
    </div>
<?php endif;
echo "</div>";
require_once "includes/footer.php";