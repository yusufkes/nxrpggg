<?php
require_once '../models/Gathering.php';

class GatheringController {
    private $gatheringModel;

    public function __construct() {
        $this->gatheringModel = new Gathering();
    }

    public function getGatheringStats($playerId) {
        return $this->gatheringModel->fetchStats($playerId);
    }

    public function gatherResource($playerId, $skill) {
        $this->gatheringModel->gather($playerId, $skill);
    }
}
