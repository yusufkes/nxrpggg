<!-- /views/battle.php -->
<div class="battle-container">
    <h2>Fighting <?= $monster->getName(); ?></h2>
    <p>Player Health: <?= $player->getHealth(); ?></p>
    <p>Monster Health: <?= $monster->getHealth(); ?></p>
    <button id="attack">Attack</button>
</div>

<script>
    // JS for handling the battle logic (attacks, progress bar, etc.)
</script>
