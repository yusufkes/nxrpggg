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

// Fetch player trades
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM trades WHERE player_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$trades = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPG Game - Trade</title>
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
        <h1>Your Trades</h1>
        <ul>
        <?php foreach ($trades as $trade): ?>
            <li>
                Offered: <?php echo htmlspecialchars($trade['item_offered']); ?> for <?php echo htmlspecialchars($trade['item_request']); ?>
                <br>
                Status: <?php echo htmlspecialchars($trade['status']); ?>
                <br>
                <button onclick="acceptTrade('<?php echo htmlspecialchars($trade['id']); ?>')">Accept</button>
            </li>
        <?php endforeach; ?>
        </ul>
        <a href="game.php">Back to Game</a>
    </div>

    <script>
        function acceptTrade(tradeId) {
            alert('Trade ' + tradeId + ' accepted!');
        }
    </script>
</body>
</html>
