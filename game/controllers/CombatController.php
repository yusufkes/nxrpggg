<?php
class CombatController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Auto-Fight logic for combat
    public function autoFight($playerId, $monsterId) {
        $player = $this->db->getPlayerById($playerId);
        $monster = $this->db->getMonsterById($monsterId);

        $playerDamage = rand($player['attack'], $player['attack'] + $player['level']);
        $monsterDamage = rand($monster['attack'], $monster['attack'] + $monster['level']);

        $outcome = 'ongoing';
        $goldEarned = 0;

        if ($player['health'] > $monsterDamage) {
            // Player wins
            $outcome = 'win';
            $goldEarned = $monster['gold_reward'];
            $this->db->updatePlayerGold($playerId, $goldEarned);
        } else {
            // Player loses
            $outcome = 'lose';
        }

        return [
            'outcome' => $outcome,
            'player_health' => $player['health'] - $monsterDamage,
            'gold' => $goldEarned,
            'total_gold' => $player['gold'] + $goldEarned,
        ];
    }

    // Travel logic to switch areas
    public function travel($playerId, $newAreaId) {
        $this->db->updatePlayerArea($playerId, $newAreaId);
        return ['success' => true];
    }
}
