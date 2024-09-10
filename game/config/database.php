<?php
// Database connection details
$servername = "localhost";
$username = "nxrpyggb_elisa";
$password = "EdaKeskin!";
$dbname = "nxrpyggb_rpg";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Log error to a file or error tracking system (avoid exposing sensitive info to the user)
    error_log("Database connection failed: " . $conn->connect_error);
    // Display user-friendly message
    die("We are currently experiencing some technical issues. Please try again later.");
}

// Set the character set to utf8mb4 to support special characters
$conn->set_charset("utf8mb4");

?>
