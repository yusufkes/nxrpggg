<div class="gathering-container">
    <h2>Gathering Skills</h2>
    <ul>
        <li>Mining Level: <?= $gatheringStats['mining_level']; ?></li>
        <li>Harvesting Level: <?= $gatheringStats['harvesting_level']; ?></li>
        <li>Woodcutting Level: <?= $gatheringStats['woodcutting_level']; ?></li>
        <li>Skinning Level: <?= $gatheringStats['skinning_level']; ?></li>
    </ul>

    <form id="gather-form">
        <select name="skill" id="skill-select">
            <option value="mining">Mine</option>
            <option value="harvesting">Harvest</option>
            <option value="woodcutting">Woodcut</option>
            <option value="skinning">Skin</option>
        </select>
        <button type="submit">Gather</button>
    </form>

    <div id="gather-results"></div>
</div>

<script>
document.getElementById('gather-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const skill = document.getElementById('skill-select').value;

    fetch('gather.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `skill=${skill}`
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('gather-results').innerHTML = `You gained ${data.amount} from ${skill}.`;
    });
});
</script>
