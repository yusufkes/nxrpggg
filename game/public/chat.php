<?php
require_once '../controllers/ChatController.php';
session_start();

$chatController = new ChatController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];
    $userId = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    $chatController->postMessage($userId, $username, $message);
}

$messages = $chatController->fetchMessages();
echo json_encode($messages);
