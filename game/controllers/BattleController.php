<?php
require_once '../models/Player.php';
require_once '../models/Monster.php';

class BattleController {
    private $player;
    private $monster;

    public function __construct($playerId, $monsterId) {
        $this->player = new Player($playerId);
        $this->monster = new Monster($monsterId);
    }

    public function startBattle() {
        $playerDamage = $this->calculateDamage($this->player->getAttack(), $this->monster->getDefense());
        $monsterDamage = $this->calculateDamage($this->monster->getAttack(), $this->player->getDefense());

        $this->player->reduceHealth($monsterDamage);
        $this->monster->reduceHealth($playerDamage);

        if ($this->monster->isDead()) {
            return ['outcome' => 'win', 'reward' => $this->monster->getReward()];
        } elseif ($this->player->isDead()) {
            return ['outcome' => 'lose'];
        }

        return ['outcome' => 'ongoing'];
    }

    private function calculateDamage($attack, $defense) {
        return max(1, $attack - $defense);
    }
}
