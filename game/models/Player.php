<?php
require_once '../config/database.php';

class Player {
    private $id;
    private $db;
    private $stats;

    public function __construct($id) {
        $this->id = $id;
        $this->db = Database::getConnection();
        $this->loadPlayerData();
    }

    private function loadPlayerData() {
        $query = $this->db->prepare("SELECT * FROM player_attributes WHERE player_id = ?");
        $query->bind_param('i', $this->id);
        $query->execute();
        $this->stats = $query->get_result()->fetch_assoc();
    }

    public function getStats() {
        return $this->stats;
    }

    public function getGold() {
        return $this->stats['gold'];
    }

    public function getCredits() {
        return $this->stats['credits'];
    }
}
