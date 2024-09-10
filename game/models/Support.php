<?php
require_once '../config/database.php';

class Support {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function addTicket($playerId, $subject, $description) {
        $stmt = $this->db->prepare("INSERT INTO support_tickets (player_id, subject, description) VALUES (?, ?, ?)");
        $stmt->bind_param('iss', $playerId, $subject, $description);
        $stmt->execute();
    }

    public function fetchTickets($playerId) {
        $query = $this->db->prepare("SELECT * FROM support_tickets WHERE player_id = ?");
        $query->bind_param('i', $playerId);
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
