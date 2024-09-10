<?php
session_start();
require_once '../controllers/SupportController.php';

$supportController = new SupportController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $playerId = $_SESSION['user_id'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    $supportController->submitReport($playerId, $category, $description);
    echo json_encode(['success' => true]);
    exit();
}
?>

<h3>Submit a Support Ticket</h3>
<form id="support-form">
    <label for="category">Category:</label>
    <select id="category" name="category">
        <option value="bug">Bug</option>
        <option value="suggestion">Suggestion</option>
        <option value="help">Help</option>
    </select>
    <br>
    <label for="description">Description:</label>
    <textarea id="description" name="description"></textarea>
    <br>
    <button type="button" id="submit-support">Submit</button>
</form>

<script>
    document.getElementById('submit-support').addEventListener('click', function () {
        let category = document.getElementById('category').value;
        let description = document.getElementById('description').value;

        fetch('support.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'category=' + encodeURIComponent(category) + '&description=' + encodeURIComponent(description)
        }).then(response => response.json()).then(data => {
            if (data.success) {
                alert('Support ticket submitted successfully');
            }
        });
    });
</script>
