<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus RPG</title>
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>

<!-- Top Navigation Bar -->
<div class="navbar">
    <div class="gold-credits">
        <span>Gold: <?= $player['gold'] ?></span>
        <span>Credits: <?= $player['credits'] ?></span>
    </div>
    <div class="nav-links">
        <a href="game.php">Home</a>
        <a href="inventory.php">Inventory</a>
        <a href="market.php">Market</a>
        <a href="combat.php">Battling</a>
        <a href="gathering.php">Gathering</a>
        <a href="crafting.php">Crafting</a>
        <a href="clan.php">Clan</a>
        <a href="land.php">Land</a>
        <a href="pets.php">Pets</a>
        <a href="town.php">Town</a>
    </div>
    <a href="logout.php" class="logout">Logout</a>
</div>

<!-- Main Content Area -->
<div class="container">
    <div class="left-sidebar">
        <h3>Player Stats</h3>
        <ul>
            <li>Health: <?= $player['health'] ?></li>
            <li>Attack: <?= $player['attack'] ?></li>
            <li>Defense: <?= $player['defense'] ?></li>
            <li>Accuracy: <?= $player['accuracy'] ?></li>
            <li>Dodge: <?= $player['dodge'] ?></li>
            <li>Strength: <?= $player['strength'] ?></li>
            <li>Agility: <?= $player['agility'] ?></li>
            <li>Intelligence: <?= $player['intelligence'] ?></li>
        </ul>

        <h3>Current Area: <?= $currentArea ?></h3>
    </div>

    <div class="main-content">
        <h1>Welcome to Nexus RPG</h1>
        <p>Select a feature to begin.</p>

        <div class="combat-section">
            <h2>Auto Fight</h2>
            <select id="monster-select">
                <?php foreach ($monsters as $monster): ?>
                    <option value="<?= $monster['monster_id'] ?>"><?= $monster['name'] ?> (Level <?= $monster['level_required'] ?>)</option>
                <?php endforeach; ?>
            </select>
            <button id="auto-fight-btn">Auto Fight</button>
            <div id="auto-fight-status"></div>
        </div>

        <div class="travel-section">
            <h2>Travel</h2>
            <select id="area-select">
                <?php foreach ($areas as $area): ?>
                    <option value="<?= $area['area_id'] ?>"><?= $area['name'] ?></option>
                <?php endforeach; ?>
            </select>
            <button id="travel-btn">Travel</button>
            <div id="travel-status"></div>
        </div>
    </div>
</div>

<script>
    // Handle auto-fight
    document.getElementById('auto-fight-btn').addEventListener('click', function () {
        const monsterId = document.getElementById('monster-select').value;
        autoFight(monsterId);
    });

    function autoFight(monsterId) {
        fetch('/combat.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ monster_id: monsterId })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('auto-fight-status').textContent = `Outcome: ${data.outcome}. Gold earned: ${data.gold}`;
        });
    }

    // Handle travel
    document.getElementById('travel-btn').addEventListener('click', function () {
        const areaId = document.getElementById('area-select').value;
        travel(areaId);
    });

    function travel(areaId) {
        fetch('/travel.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ area_id: areaId })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('travel-status').textContent = data.success ? 'Travel successful' : 'Travel failed';
        });
    }
</script>

</body>
</html>
