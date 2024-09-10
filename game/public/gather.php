<?php
require_once '../controllers/GatheringController.php';
session_start();

$gatheringController = new GatheringController();
$playerId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $skill = $_POST['skill'];
    $result = $gatheringController->gather($playerId, $skill);
    echo json_encode($result);
    exit();
}

$gatheringStats = $gatheringController->getPlayerStats($playerId);
require_once '../views/gathering.php';
