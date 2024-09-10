<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// If logged in, redirect to the game page
header('Location: game.php');
exit();
?>
