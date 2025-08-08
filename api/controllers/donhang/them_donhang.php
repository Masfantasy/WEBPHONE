<?php
require_once __DIR__ .  '/../../config/db.php';
require_once __DIR__ .  '/../../models/Donhang.php';
require_once __DIR__ .  '/../../models/Giohang.php';
require_once __DIR__ . '/../../middlewares/jwt.php';

class them_donhang {
    public static function them_donhang() {
        $db = new db();
        $connect = $db->connect();
        
        $donhang = new Donhang($connect);
        $giohang = new Giohang($connect);
        $customer_id = CheckToken::checktoken();
        $donhang->customer_id = $customer_id;
        $giohang->customer_id = $customer_id;

        $data = json_decode(file_get_contents("php://input"));
        $donhang->status = $data->status ?? "Chờ xử lý";
        $donhang->voucher_id = $data->voucher_id ?? null;

        // Thông tin giao nhận
        $donhang->delivery_type = $data->delivery_type ?? null;
        $donhang->receiver_name = $data->receiver_name ?? null;
        $donhang->receiver_phone = $data->receiver_phone ?? null;
        $donhang->delivery_address = $data->delivery_address ?? null;
        $donhang->store_code = $data->store_code ?? null;
        if (strlen($donhang->receiver_phone) > 11) {
            echo json_encode(["error" => "Số điện thoại không hợp lệ"]);
            exit();
        }
        $cart_id = $giohang->GetCartID();
        if (!$cart_id) {
            echo json_encode(["error" => "Không tìm thấy giỏ hàng"]);
            exit();
        }

        $giohang->GetCartItems($cart_id);

        if ($donhang->create($cart_id)) {
            // Xoá giỏ hàng sau khi đặt thành công
            $giohang->DeleteCart($cart_id);
            echo json_encode(["message" => "Thanh toán thành công"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Thanh toán thất bại"]);
            http_response_code(300);
        }
    }
}