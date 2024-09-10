<?php
require_once '../config/database.php';

class Combat {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function fetchPlayerStats($playerId) {
        $query = $this->db->prepare("SELECT * FROM player_attributes WHERE player_id = ?");
        $query->bind_param('i', $playerId);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function fetchMonstersByArea($areaId) {
        $query = $this->db->prepare("SELECT * FROM monsters WHERE area_id = ?");
        $query->bind_param('i', $areaId);
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function executeAutoFight($playerId, $monsterId) {
        // Similar logic as provided before, calculating damage and rewards
    }

    public function updatePlayerArea($playerId, $newAreaId) {
        $stmt = $this->db->prepare("UPDATE users SET current_area = ? WHERE id = ?");
        $stmt->bind_param('ii', $newAreaId, $playerId);
        $stmt->execute();
    }

    public function fetchAreas() {
        $query = $this->db->prepare("SELECT * FROM areas");
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
