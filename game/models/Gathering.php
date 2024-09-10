<?php
require_once '../config/database.php';

class Gathering {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function fetchStats($playerId) {
        $query = $this->db->prepare("SELECT * FROM gathering_stats WHERE player_id = ?");
        $query->bind_param('i', $playerId);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function gather($playerId, $skill) {
        $expGained = rand(5, 10); // Random EXP gain for gathering

        // Update EXP for the skill
        $query = $this->db->prepare("UPDATE gathering_stats SET {$skill}_exp = {$skill}_exp + ? WHERE player_id = ?");
        $query->bind_param('ii', $expGained, $playerId);
        $query->execute();

        // Check for level up
        $this->checkLevelUp($playerId, $skill);
    }

    private function checkLevelUp($playerId, $skill) {
        $skillExpField = "{$skill}_exp";
        $skillLevelField = "{$skill}_level";

        $query = $this->db->prepare("SELECT {$skillLevelField}, {$skillExpField} FROM gathering_stats WHERE player_id = ?");
        $query->bind_param('i', $playerId);
        $query->execute();
        $stats = $query->get_result()->fetch_assoc();

        $currentLevel = $stats[$skillLevelField];
        $currentExp = $stats[$skillExpField];

        $expToNextLevel = $currentLevel * 100;

        if ($currentExp >= $expToNextLevel) {
            // Level up!
            $query = $this->db->prepare("UPDATE gathering_stats SET {$skillLevelField} = {$skillLevelField} + 1 WHERE player_id = ?");
            $query->bind_param('i', $playerId);
            $query->execute();
        }
    }
}
