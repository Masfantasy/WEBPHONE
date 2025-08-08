<?php
require_once __DIR__ .  '/../../config/db.php';
require_once __DIR__ .  '/../../models/Khachhang.php';
require_once __DIR__ .  '/../../../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Login {
    public static function login() {
        $db = new db();
        $connect = $db->connect();

        $khachhang = new Khachhang($connect);
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['username']) || empty($data['password'])) {
            http_response_code(400);
            echo json_encode(["message" => "Vui lòng điền đầy đủ thông tin"]);
            return;
        }

        $username = $data['username'];
        $password = $data['password'];
        $login = $khachhang->login($username, $password);

        if (!$login) {
            http_response_code(401);
            echo json_encode(["message" => "Sai tài khoản hoặc mật khẩu"]);
        } else {
            //tạo token
            $secret_key = "123";
            $issuer = "Didong";
            $issued_at = time();
            $expiration_time = $issued_at + 3600; // 1h

            $payload = [
                "iss" => $issuer,
                "iat" => $issued_at,
                "exp" => $expiration_time,
                "data" => [
                    "customer_id" => $khachhang->customer_id,
                    "username" => $khachhang->username,
                    "name" => $khachhang->name,
                    "is_active" => $khachhang->is_active
                ]
            ];

            $jwt = JWT::encode($payload, $secret_key, 'HS256');

            echo json_encode([
                "message" => "Đăng nhập thành công",
                "token" => $jwt
            ]);
        }
    }
}
