<?php
class SupportController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Submit a support ticket
    public function submitReport($playerId, $category, $description) {
        $this->db->query(
            "INSERT INTO support_tickets (player_id, category, description, status) VALUES (?, ?, ?, 'open')", 
            [$playerId, $category, $description]
        );
    }
}
