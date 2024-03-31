<?php
require_once "header.php";
require_once "Dao.php";
$dao = new Dao();

$roomCode = $_SESSION['roomCode'];

$names = $dao->getAliasesInRoom($roomCode);
$herrings = $dao->getRedHerrings($roomCode);
$list = array_merge($names, $herrings);

echo "<div class = nameList><h2>Aliases:</h2>";
foreach ($list as $name) {
    echo "<ul>$name</ul>";
}


if ($_SESSION['isHost']): ?> 
    <div>
        <form action="abort_game.php" method="POST">
            <button type="submit" name="abortGame">End Game</button>
        </form>
    </div>
<?php endif;
echo "</div>";
require_once "footer.php";