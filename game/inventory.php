<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit();
}

// Database connection details
$servername = "localhost";
$username = "nxrpyggb_elisa";
$password = "EdaKeskin!";
$dbname = "nxrpyggb_rpg";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch player equipment and inventory
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM equipment WHERE player_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$inventory = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPG Game - Inventory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Inventory</h1>
        <ul>
        <?php foreach ($inventory as $item): ?>
            <li>
                <?php echo htmlspecialchars($item['name']); ?> (Level: <?php echo htmlspecialchars($item['level']); ?>)
                <br>
                <button onclick="useItem('<?php echo htmlspecialchars($item['name']); ?>')">Use</button>
            </li>
        <?php endforeach; ?>
        </ul>
        <a href="game.php">Back to Game</a>
    </div>

    <script>
        function useItem(itemName) {
            alert(itemName + ' used!');
        }
    </script>
</body>
</html>
