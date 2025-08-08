<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../../config/db.php';

class show_store {
    public static function show_store() {
        $db = new db();
        $conn = $db->connect();
        $stmt = $conn->query("SELECT store_code, store_name, store_address FROM stores");
        $stores = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $stores[] = $row;
        }
        echo json_encode(['data' => $stores], JSON_UNESCAPED_UNICODE);
    }
}