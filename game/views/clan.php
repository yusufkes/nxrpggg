<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['err' => 'You must be logged in to manage a clan.']);
    exit();
}

// Database connection
$servername = "localhost";
$username = "nxrpyggb_elisa";
$password = "EdaKeskin!";
$dbname = "nxrpyggb_rpg";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['err' => 'Failed to connect to the database.']);
    exit();
}

// Fetch the requested action from the frontend
$data = json_decode(file_get_contents('php://input'), true);
$mod = isset($data['mod']) ? $data['mod'] : '';

switch ($mod) {
    case 'createclan':
        // Clan creation logic
        $cl_name = $data['cl_name'];
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO clans (name, leader_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $cl_name, $user_id);
        if ($stmt->execute()) {
            echo json_encode(['v' => 'Clan created successfully!']);
        } else {
            echo json_encode(['err' => 'Failed to create clan.']);
        }
        $stmt->close();
        break;

    case 'viewmembers':
        // View members logic
        $clan_id = $data['clan_id'];
        $sql = "SELECT * FROM clan_members WHERE clan_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $clan_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $members = [];
        while ($row = $result->fetch_assoc()) {
            $members[] = $row;
        }
        $stmt->close();

        // Return members as HTML
        $html = '<ul>';
        foreach ($members as $member) {
            $html .= '<li>' . htmlspecialchars($member['username']) . ' (' . htmlspecialchars($member['role']) . ')</li>';
        }
        $html .= '</ul>';
        echo json_encode(['v' => $html]);
        break;

    // Add other clan-related cases here (e.g., promote/demote members, donations, etc.)
    
    default:
        echo json_encode(['v' => 'Welcome to the Clan Management Section']);
}

$conn->close();
?>
