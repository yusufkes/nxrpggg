<?php
session_start();
require_once '../controllers/ChatController.php';

$chatController = new ChatController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $playerId = $_SESSION['user_id'];
    $message = $_POST['message'];

    $chatController->addMessage($playerId, $message);
    echo json_encode(['success' => true]);
    exit();
}

$messages = $chatController->getMessages();
?>

<div class="chat-box" id="chat-box">
    <?php foreach ($messages as $msg): ?>
        <p><strong><?= htmlspecialchars($msg['username']); ?>:</strong> <?= htmlspecialchars($msg['message']); ?></p>
    <?php endforeach; ?>
</div>

<!-- Chat Input -->
<div class="chat-input">
    <input type="text" id="chat-message" placeholder="Type your message">
    <button id="send-message">Send</button>
</div>

<script>
    document.getElementById('send-message').addEventListener('click', function () {
        let message = document.getElementById('chat-message').value;

        fetch('chat.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'message=' + encodeURIComponent(message)
        }).then(response => response.json()).then(data => {
            if (data.success) {
                location.reload(); // Reload chat
            }
        });
    });

    // Auto-reload chat every 5 seconds
    setInterval(function () {
        location.reload();
    }, 5000);
</script>
