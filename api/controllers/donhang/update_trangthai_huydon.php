<?php
require_once __DIR__ .  '/../../config/db.php';
require_once __DIR__ .  '/../../models/Donhang.php';
require_once __DIR__ .  '/../../models/Giohang.php';
require_once __DIR__ . '/../../middlewares/jwt.php';


Class update_trangthai{
    public static function update_trangthai(){
        $db = new db();
        $connect = $db->connect();
        $donhang = new Donhang($connect);
        $customer_id = CheckToken::checktoken();
        $donhang->customer_id = $customer_id;
        $data = json_decode(file_get_contents("php://input"));
        $donhang->order_id = $data->order_id;
        $result = $donhang->update();
        
        if ($result === true) {
        echo json_encode(["message" => "Update thành công"]);
    } elseif ($result === false) {
        echo json_encode(["message" => "Update thất bại"]);
    } elseif ($result === "not_found") {
        echo json_encode(["message" => "Không tìm thấy order_id, hãy kiểm tra lại order_id"]);
    }
    }
}