<?php
require_once '../config/database.php';

class Monster {
    private $id;
    private $db;
    private $stats;

    public function __construct($id) {
        $this->id = $id;
        $this->db = Database::getConnection();
        $this->loadMonsterData();
    }

    private function loadMonsterData() {
        $query = $this->db->prepare("SELECT * FROM monsters WHERE monster_id = ?");
        $query->bind_param('i', $this->id);
        $query->execute();
        $this->stats = $query->get_result()->fetch_assoc();
    }

    public function getAttack() {
        return $this->stats['attack'];
    }

    public function getDefense() {
        return $this->stats['defense'];
    }

    public function reduceHealth($damage) {
        $this->stats['health'] -= $damage;
    }

    public function isDead() {
        return $this->stats['health'] <= 0;
    }

    public function getReward() {
        return $this->stats['reward'];
    }
}
