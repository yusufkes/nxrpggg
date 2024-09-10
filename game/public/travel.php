<?php
session_start();
require_once '../controllers/GameController.php';
require_once '../controllers/CombatController.php';

$gameController = new GameController();
$combatController = new CombatController();

// Make sure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$playerId = $_SESSION['user_id'];

// Handle POST request for travel
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $areaId = intval($data['area_id']);

    // Travel logic
    $result = $combatController->travel($playerId, $areaId);

    echo json_encode($result);
    exit();
}
