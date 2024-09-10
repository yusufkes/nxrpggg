<?php
session_start();
require_once '../controllers/GameController.php';

$gameController = new GameController();
$playerId = $_SESSION['user_id'];
$playerStats = $gameController->getPlayerStats($playerId);
$currentAreaName = $gameController->getCurrentAreaName($playerId);
$availableAreas = $gameController->getAvailableAreas();
$monsters = $gameController->getMonstersByArea($_SESSION['current_area']);
$gold = $playerStats['gold'];
$credits = $playerStats['credits'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus RPG</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1c1c1c;
            color: #fff;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }
        .navbar {
            background-color: #272727;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #444;
        }
        .navbar .nav-links {
            display: flex;
            gap: 15px;
        }
        .navbar a {
            color: #ddd;
            padding: 8px 15px;
            text-decoration: none;
            font-size: 12px;
            transition: background-color 0.2s;
            cursor: pointer;
        }
        .navbar a:hover {
            background-color: #444;
        }
        .navbar .logout {
            background-color: #e74c3c;
            padding: 8px 15px;
            color: white;
            border-radius: 4px;
        }
        .navbar .logout:hover {
            background-color: #c0392b;
        }
        .gold-credits {
            color: #f1c40f;
            font-size: 12px;
        }
        .container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }
        .left-sidebar {
            width: 20%;
            background-color: #222;
            padding: 20px;
            border-radius: 8px;
            margin-right: 10px;
        }
        .left-sidebar h3 {
            color: #f1c40f;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .left-sidebar p {
            margin: 10px 0;
            font-size: 12px;
        }
        .main-content {
            width: 60%;
            background-color: #333;
            padding: 20px;
            border-radius: 8px;
        }
        .chat-section {
            background-color: #222;
            padding: 10px;
            border-radius: 8px;
            width: 100%;
            margin: 20px auto;
        }
        .chat-box {
            background-color: #333;
            height: 200px;
            overflow-y: auto;
            padding: 10px;
            color: #ddd;
            font-size: 12px;
        }
        .chat-input {
            display: flex;
            margin-top: 10px;
        }
        .chat-input input {
            width: 85%;
            padding: 10px;
            border: none;
            border-radius: 4px;
        }
        .chat-input button {
            width: 15%;
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .chat-input button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<!-- Top Navigation Bar -->
<div class="navbar">
    <div class="gold-credits">
        <span>Gold: <?= number_format($gold); ?></span>
        <span>Credits: <?= $credits; ?></span>
    </div>
    <div class="nav-links">
        <a id="homeLink">Home</a>
        <a id="inventoryLink">Inventory</a>
        <a id="marketLink">Market</a>
        <a id="combatLink">Battling</a>
        <a id="gatheringLink">Gathering</a>
        <a id="craftingLink">Crafting</a>
        <a id="clanLink">Clan</a>
        <a id="landLink">Land</a>
        <a id="petsLink">Pets</a>
        <a id="townLink">Town</a>
    </div>
    <a href="logout.php" class="logout">Logout</a>
</div>

<!-- Left Sidebar: Player Stats -->
<div class="container">
    <div class="left-sidebar">
        <h3>Player Stats</h3>
        <p>Health: <span id="stat-health"><?= $playerStats['health']; ?></span></p>
        <p>Attack: <span id="stat-attack"><?= $playerStats['attack']; ?></span></p>
        <p>Defense: <span id="stat-defense"><?= $playerStats['defense']; ?></span></p>
        <p>Accuracy: <span id="stat-accuracy"><?= $playerStats['accuracy']; ?></span></p>
        <p>Dodge: <span id="stat-dodge"><?= $playerStats['dodge']; ?></span></p>
        <p>Level: <?= $playerStats['level']; ?></p>
        <p>Experience: <?= $playerStats['experience']; ?></p>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Current Area: <?= $currentAreaName; ?></h2>

        <!-- Monster selection -->
        <label for="monster-select">Select Monster:</label>
        <select id="monster-select">
            <?php foreach ($monsters as $monster): ?>
                <option value="<?= $monster['monster_id']; ?>"><?= $monster['name']; ?> (HP: <?= $monster['health']; ?>)</option>
            <?php endforeach; ?>
        </select>

        <!-- Auto Fight button -->
        <button id="auto-fight-button">Auto Fight</button>

        <!-- Progress bar for Auto Fight -->
        <div class="progress-bar">
            <div id="progress" style="width: 0;"></div>
        </div>

        <!-- Travel system -->
        <h3>Travel to a New Area</h3>
        <select id="area-select">
            <?php foreach ($availableAreas as $area): ?>
                <option value="<?= $area['id']; ?>"><?= $area['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <button id="travel-button">Travel</button>

        <!-- Fight results -->
        <div id="fight-results"></div>
    </div>
</div>

<!-- Chat Section -->
<div class="chat-section">
    <div class="chat-box" id="chat-box"></div>
    <div class="chat-input">
        <input type="text" id="chat-message" placeholder="Type your message">
        <button id="send-message">Send</button>
    </div>
</div>

<!-- JavaScript -->
<script>
    let fightInterval;
    const progressBar = document.getElementById('progress');
    const fightResults = document.getElementById('fight-results');
    let fightCount = 100; // Maximum auto fights

    document.getElementById('auto-fight-button').addEventListener('click', function() {
        let monsterId = document.getElementById('monster-select').value;
        fightCount = 100; // Max auto fights

        fightInterval = setInterval(() => {
            if (fightCount > 0) {
                fetch('combat.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=autoFight&monster_id=${monsterId}`
                })
                .then(response => response.json())
                .then(data => {
                    // Update fight results and stats
                    fightResults.innerHTML = `Outcome: ${data.outcome}, Player Health: ${data.player_health}`;
                    document.getElementById('stat-health').textContent = data.player_health;
                    
                    if (data.outcome === 'win') {
                        fightResults.innerHTML += `, Gold Earned: ${data.gold}`;
                        document.querySelector('.gold-credits span').textContent = `Gold: ${data.total_gold}`;
                    }

                    fightCount--;
                    progressBar.style.width = `${(100 - fightCount)}%`;
                });
            } else {
                clearInterval(fightInterval);
            }
        }, 5000); // Fight every 5 seconds
    });

    document.getElementById('travel-button').addEventListener('click', function() {
        let areaId = document.getElementById('area-select').value;

        fetch('combat.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=travel&new_area=${areaId}`
        })
        .then(response => response.json())
        .then(data => {
            location.reload(); // Reload page to update area and monsters
        });
    });
</script>

</body>
</html>
