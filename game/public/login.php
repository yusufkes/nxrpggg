<?php
require_once '../controllers/AuthController.php';
require_once '../views/login.php'; // Render the login form

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $authController = new AuthController();
    $success = $authController->login($username, $password);

    if ($success) {
        header('Location: game.php'); // Redirect to the game if login is successful
    } else {
        echo "Invalid username or password";
    }
}
