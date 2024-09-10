<?php
class ChatController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Add message to chat
    public function addMessage($playerId, $message) {
        $this->db->query("INSERT INTO chat (player_id, message) VALUES (?, ?)", [$playerId, $message]);
    }

    // Get chat messages
    public function getMessages() {
        return $this->db->query("SELECT chat.message, player_stats.username FROM chat JOIN player_stats ON chat.player_id = player_stats.player_id ORDER BY chat.created_at DESC LIMIT 50")->fetchAll();
    }
}
