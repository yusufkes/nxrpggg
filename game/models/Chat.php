<?php
require_once '../config/database.php';

class Chat {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getMessages() {
        $query = $this->db->query("SELECT username, message, timestamp FROM chat_messages ORDER BY timestamp DESC LIMIT 50");
        return $query->fetch_all(MYSQLI_ASSOC);
    }

    public function addMessage($userId, $username, $message) {
        $stmt = $this->db->prepare("INSERT INTO chat_messages (user_id, username, message) VALUES (?, ?, ?)");
        $stmt->bind_param('iss', $userId, $username, $message);
        $stmt->execute();
    }
}
