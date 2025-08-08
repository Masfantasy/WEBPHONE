<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/khachhang.php';
require_once __DIR__ . '/../../middlewares/jwt.php';

Class Sua_tt_khachhang{
    public static function sua_tt_khachhang(){
        $db = new db();
        $connect = $db->connect();
        $khachhang = new Khachhang($connect);

        $data = json_decode(file_get_contents("php://input"));
        $customer_id=CheckToken::checktoken();
        $khachhang->customer_id = $customer_id;
        $khachhang->name = $data->name ?? null;
        $khachhang->email = $data->email ?? null;
        $khachhang->phone = $data->phone ?? null;
        $khachhang->address = $data->address ?? null;

        if ($khachhang->update()) {
            echo json_encode([
                "success" => true,
                "message" => "Cập nhật thành công"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Cập nhật thất bại"
            ]);
        }
    }
}