<?php
class GameController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Fetch player stats
    public function getPlayerStats($playerId) {
        return $this->db->query("SELECT * FROM player_stats WHERE player_id = ?", [$playerId])->fetch();
    }

    // Fetch monsters by area
    public function getMonstersByArea($areaId) {
        return $this->db->query("SELECT * FROM monsters WHERE level_required <= ?", [$areaId])->fetchAll();
    }

    // Fetch player's current area
    public function getCurrentAreaName($playerId) {
        $areaId = $this->db->query("SELECT current_area_id FROM player_area WHERE player_id = ?", [$playerId])->fetchColumn();
        return $this->db->query("SELECT name FROM areas WHERE area_id = ?", [$areaId])->fetchColumn();
    }

    // Fetch available areas for travel
    public function getAvailableAreas() {
        return $this->db->query("SELECT * FROM areas ORDER BY level_required")->fetchAll();
    }
}
