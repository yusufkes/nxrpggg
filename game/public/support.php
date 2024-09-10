<?php
require_once '../controllers/SupportController.php';
session_start();

$supportController = new SupportController();
$playerId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'];
    $description = $_POST['description'];
    $supportController->submitTicket($playerId, $subject, $description);
}

$tickets = $supportController->getTickets($playerId);
require_once '../views/support.php'; // Load support view
