<?php

  class Dao {

    private $db;

    public function __construct () {
       $this->db = new SQLite3("partygames.db");
       if (!$this->db) {
          echo $this->db->lastErrorMsg();
       }
    }

    public function newGame($gameName){
        $stmt = $this->db->prepare("CREATE TABLE IF NOT EXISTS $gameName (id INTEGER PRIMARY KEY, word TEXT)");
        $stmt->execute();
    }

    public function addEntry($gameName, $word){
        $stmt = $this->db->prepare("INSERT INTO $gameName (word) VALUES (:word)");
        $stmt->bindValue(':word', $word, SQLITE3_TEXT);
        $stmt->execute();
    }

    public function getWords($gameName){
        $stmt = $this->db->prepare("SELECT * FROM $gameName");
        $result = $stmt->execute();
        $names = array();
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            array_push($names, $row['word']);
        }
        return $names;
    }

    public function deleteGame($gameName){
        $stmt = $this->db->prepare("DROP TABLE IF EXISTS $gameName");
        $stmt->execute();
    }

    public function close() {
        $this->db->close();
    }

  }