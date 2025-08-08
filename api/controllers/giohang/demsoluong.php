<?php
require_once __DIR__ .  '/../../config/db.php';
require_once __DIR__ .  '/../../models/Giohang.php';
require_once __DIR__ . '/../../middlewares/jwt.php';


Class Demsoluong{
    public static function demsoluong(){
        $db = new db();
        $conn = $db->connect();
        $giohang = new Giohang($conn);
        $customer_id=CheckToken::checktoken();
        $count = $giohang->countItems($customer_id);
        echo json_encode(["count" => $count]);
    }
}