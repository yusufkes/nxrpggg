<div class="combat-container">
    <h2>Combat in Area: <?= $_SESSION['current_area_name']; ?></h2>

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

<script>
    let fightInterval;
    const progressBar = document.getElementById('progress');
    const fightResults = document.getElementById('fight-results');
    let fightCount = 0;

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
                    fightResults.innerHTML = `Outcome: ${data.outcome}, Player Health: ${data.player_health}`;
                    if (data.outcome === 'win') {
                        fightResults.innerHTML += `, Gold Earned: ${data.gold}`;
                    }
                });

                fightCount--;
                progressBar.style.width = `${(100 - fightCount)}%`;
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
