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

    public function emailExists($email){
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    public function addUser($email, $password){
        $stmt = $this->db->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $stmt->execute();
    }

    public function validateUser($email, $password){
        $stmt = $this->db->prepare("SELECT password FROM users WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $hash = $stmt->fetchColumn();
        return password_verify($password, $hash);
    }

    public function isAdmin($email){
        $stmt = $this->db->prepare("SELECT * FROM admins WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch() !== false;
    }

    public function getAdmins(){
        $stmt = $this->db->prepare("SELECT * FROM admins");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsers(){
        $stmt = $this->db->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGames(){
        $stmt = $this->db->prepare("SELECT * FROM game_sessions");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGamePlayers(){
        $stmt = $this->db->prepare("SELECT * FROM game_players");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllRedHerrings(){
        $stmt = $this->db->prepare("SELECT * FROM redherrings");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addRedHerrings($roomCode){
        $newRedHerrings = $this->getAliasesInRoom($roomCode);
        $stmt = $this->db->prepare("INSERT INTO redherrings (name) VALUES (:name)");
        foreach ($newRedHerrings as $name) {
            $name = ucwords(strtolower($name));
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->execute();
        }
    }

    public function close() {
        $this->db->close();
    }

}