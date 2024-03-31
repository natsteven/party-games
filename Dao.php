<?php

class Dao {

    private $db;

    public function __construct () {
       $this->db = new SQLite3("partygames.db");
       if (!$this->db) {
          echo $this->db->lastErrorMsg();
       }
    }

    public function startGame($roomCode, $Id, $expectedPlayers, $numRedHerrings){
        $stmt = $this->db->prepare("INSERT INTO game_sessions (room_code, host_id, expected_players, num_red_herrings) VALUES (:room_code, :host_id, :expected_players, :num_red_herrings)");
        $stmt->bindValue(':room_code', $roomCode, SQLITE3_INTEGER);
        $stmt->bindValue(':host_id', $Id, SQLITE3_TEXT);
        $stmt->bindValue(':expected_players', $expectedPlayers, SQLITE3_INTEGER);
        $stmt->bindValue(':num_red_herrings', $numRedHerrings, SQLITE3_INTEGER);
        $stmt->execute();
    }

    public function addPlayer($userId, $alias, $roomCode){
        $alias = ucwords(strtolower($alias));
        $stmt = $this->db->prepare("INSERT INTO game_players (user_id, alias, room_code) VALUES (:user_id, :alias, :room_code)");
        $stmt->bindValue(':user_id', $userId, SQLITE3_TEXT); 
        $stmt->bindValue(':alias', $alias, SQLITE3_TEXT);
        $stmt->bindValue(':room_code', $roomCode, SQLITE3_INTEGER);
        $stmt->execute();
    }

    public function roomExists($roomCode){
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM game_sessions WHERE room_code = :room_code");
        $stmt->bindValue(':room_code', $roomCode, SQLITE3_TEXT);
        $result = $stmt->execute();
        $count = $result->fetchArray()[0];
        return $count > 0;
    }

    public function getNumPlayersInRoom($roomCode){
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM game_players WHERE room_code = :roomCode");
        $stmt->bindValue(':roomCode', $roomCode, SQLITE3_INTEGER);
        $result = $stmt->execute();
        return $result->fetchArray()[0];
    }

    public function getRedHerrings($roomCode){
        $stmt = $this->db->prepare("SELECT num_red_herrings FROM game_sessions WHERE room_code = :room_code");
        $stmt->bindValue(':room_code', $roomCode, SQLITE3_TEXT);
        $result = $stmt->execute();
        $numRedHerrings = $result->fetchArray()[0];
        $redHerrings = $this->getRandomRedHerrings($numRedHerrings);
        return $redHerrings;
    }

    public function getRandomRedHerrings($num){
        $stmt = $this->db->prepare("SELECT * FROM redherrings ORDER BY RANDOM() LIMIT :num");
        $stmt->bindValue(':num', $num, SQLITE3_INTEGER);
        $result = $stmt->execute();
        $redHerrings = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $redHerrings[] = $row['name'];
        }
        return $redHerrings;
    }

    public function getExpectedPlayers($roomCode){
        $stmt = $this->db->prepare("SELECT expected_players FROM game_sessions WHERE room_code = :room_code");
        $stmt->bindValue(':room_code', $roomCode, SQLITE3_TEXT);
        $result = $stmt->execute();
        return $result->fetchArray()[0];
    }

    public function getAliasesInRoom($roomCode){
        $stmt = $this->db->prepare("SELECT alias FROM game_players WHERE room_code = :room_code");
        $stmt->bindValue(':room_code', $roomCode, SQLITE3_TEXT);
        $result = $stmt->execute();
        $aliases = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $aliases[] = $row['alias'];
        }
        return $aliases;
    }

    public function roomCodeExists($roomCode) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as gameCount FROM game_players WHERE room_code = :roomCode");
        $stmt->bindValue(':roomCode', $roomCode, SQLITE3_INTEGER);
        $result = $stmt->execute();
        $row = $result->fetchArray(SQLITE3_ASSOC);
        return $row['gameCount'] > 0;
    }

    public function removeGame($roomCode){
        $stmt = $this->db->prepare("DELETE FROM game_sessions WHERE room_code = :roomCode");
        $stmt->bindValue(':roomCode', $roomCode, SQLITE3_INTEGER);
        $stmt->execute();
    }

    public function removePlayers($roomCode){
        $stmt = $this->db->prepare("DELETE FROM game_players WHERE room_code = :roomCode");
        $stmt->bindValue(':roomCode', $roomCode, SQLITE3_INTEGER);
        $stmt->execute();
    }

    public function removePlayer($userId){
        $stmt = $this->db->prepare("DELETE FROM game_players WHERE user_id = :userId");
        $stmt->bindValue(':userId', $userId, SQLITE3_TEXT);
        $stmt->execute();
    }

    public function close() {
        $this->db->close();
    }

}