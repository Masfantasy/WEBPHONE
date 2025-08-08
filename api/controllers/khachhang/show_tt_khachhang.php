<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/khachhang.php';
require_once __DIR__ . '/../../middlewares/jwt.php';

Class Show_tt_khachhang{
    public static function show_tt_khachhang(){
        $db = new db();
        $connect = $db->connect();
        $customer_id=CheckToken::checktoken();
        $khachhang = new Khachhang($connect);
        $khachhang->customer_id = $customer_id;
        $khachhang->show();

        // Nếu lấy được thông tin
        if ($khachhang->name) {
            $khachhang_item = [
                'username' => $khachhang->username,
                'name' => $khachhang->name,
                'email' => $khachhang->email,
                'phone' => $khachhang->phone,
                'address' => $khachhang->address,
                // Có thể bổ sung thêm các trường khác nếu cần
            ];
            echo json_encode([
                "success" => true,
                "data" => $khachhang_item
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Không tìm thấy thông tin khách hàng"
            ]);
        }
    }
}
