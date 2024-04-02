<?php
require_once "includes/header.php";
require_once "includes/Dao.php";
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
        <form action="handlers/abort_game.php" method="POST">
            <button type="submit" name="abortGame">End Game</button>
        </form>
    </div>
<?php endif;
echo "</div>";
require_once "includes/footer.php";