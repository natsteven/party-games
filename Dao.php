<?php

class Dao {

    private $db;

    public function __construct () {
        // LOCAL:
        // $host = 'localhost';
        // $dbname = 'partygames';
        // $user = 'nat';
        // $password = 'Squerryes42';

        // HEROKU:
        $url = parse_url(getenv("DATABASE_URL"));
        $host = $url["host"];
        $dbname = substr($url["path"], 1);
        $user = $url["user"];
        $password = $url["pass"];
    
        $dsn = "pgsql:host=$host;dbname=$dbname";
        try {
            $this->db = new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function startGame($roomCode, $Id, $expectedPlayers, $numRedHerrings){
        $stmt = $this->db->prepare("INSERT INTO game_sessions (room_code, host_id, expected_players, num_red_herrings) VALUES (:room_code, :host_id, :expected_players, :num_red_herrings)");
        $stmt->bindValue(':room_code', $roomCode, PDO::PARAM_INT);
        $stmt->bindValue(':host_id', $Id, PDO::PARAM_STR);
        $stmt->bindValue(':expected_players', $expectedPlayers, PDO::PARAM_INT);
        $stmt->bindValue(':num_red_herrings', $numRedHerrings, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function addPlayer($userId, $alias, $roomCode){
        $alias = ucwords(strtolower($alias));
        $stmt = $this->db->prepare("INSERT INTO game_players (user_id, alias, room_code) VALUES (:user_id, :alias, :room_code)");
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_STR); 
        $stmt->bindValue(':alias', $alias, PDO::PARAM_STR);
        $stmt->bindValue(':room_code', $roomCode, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function roomExists($roomCode){
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM game_sessions WHERE room_code = :room_code");
        $stmt->bindValue(':room_code', $roomCode, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    public function getNumPlayersInRoom($roomCode){
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM game_players WHERE room_code = :roomCode");
        $stmt->bindValue(':roomCode', $roomCode, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getRedHerrings($roomCode){
        $stmt = $this->db->prepare("SELECT num_red_herrings FROM game_sessions WHERE room_code = :room_code");
        $stmt->bindValue(':room_code', $roomCode, PDO::PARAM_STR);
        $stmt->execute();
        $numRedHerrings = $stmt->fetchColumn();
        $redHerrings = $this->getRandomRedHerrings($numRedHerrings);
        return $redHerrings;
    }

    public function getRandomRedHerrings($num){
        $stmt = $this->db->prepare("SELECT * FROM redherrings ORDER BY RANDOM() LIMIT :num");
        $stmt->bindValue(':num', $num, PDO::PARAM_INT);
        $stmt->execute();
        $redHerrings = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $redHerrings[] = $row['name'];
        }
        return $redHerrings;
    }

    public function getExpectedPlayers($roomCode){
        $stmt = $this->db->prepare("SELECT expected_players FROM game_sessions WHERE room_code = :room_code");
        $stmt->bindValue(':room_code', $roomCode, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getAliasesInRoom($roomCode){
        $stmt = $this->db->prepare("SELECT alias FROM game_players WHERE room_code = :room_code");
        $stmt->bindValue(':room_code', $roomCode, PDO::PARAM_STR);
        $stmt->execute();
        $aliases = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $aliases[] = $row['alias'];
        }
        return $aliases;
    }

    public function abortGame($roomCode){
        $this->removePlayers($roomCode);
        $this->removeGame($roomCode);
    }

    public function removeGame($roomCode){
        $stmt = $this->db->prepare("DELETE FROM game_sessions WHERE room_code = :roomCode");
        $stmt->bindValue(':roomCode', $roomCode, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function removePlayers($roomCode){
        $stmt = $this->db->prepare("DELETE FROM game_players WHERE room_code = :roomCode");
        $stmt->bindValue(':roomCode', $roomCode, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function removePlayer($userId){
        $stmt = $this->db->prepare("DELETE FROM game_players WHERE user_id = :userId");
        $stmt->bindValue(':userId', $userId, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function close() {
        $this->db->close();
    }

}