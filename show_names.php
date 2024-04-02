<?php
require_once "includes/header.php";
require_once "includes/Dao.php";
$dao = new Dao();

$roomCode = $_SESSION['roomCode'];

$names = $dao->getAliasesInRoom($roomCode);
$herrings = $dao->getRedHerrings($roomCode);

// Lowercase and capitalize each name
$names = array_map(function($name) {
    return ucwords(strtolower($name));
}, $names);

// Merge the names and herrings arrays
$list = array_merge($names, $herrings);

// Shuffle the list
shuffle($list);

echo "<div class = nameList><h2>Aliases:</h2>";
foreach ($list as $name) {
    echo "<ul>$name</ul>";
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