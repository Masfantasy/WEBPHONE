<?php
    require_once __DIR__ . '/../../config/db.php';
    require_once __DIR__ . '/../../models/khachhang.php';
    class Register {
        public static function register() {
            $db = new db();
            $connect = $db->connect();
            
            $khachhang = new Khachhang($connect);

            $data = json_decode(file_get_contents("php://input"));
            $khachhang->name = $data->name;
            $khachhang->email = $data->email;
            $khachhang->phone = $data->phone;
            $khachhang->address = $data->address;
            $khachhang->username = $data->username;
            $khachhang->password = $data->password;
            $khachhang->is_active = $data->is_active;


            if ($khachhang->create()) {
            echo json_encode(['success' => true, 'message' => 'Tạo tài khoản thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Tạo tài khoản thất bại']);
        }
    }
}
