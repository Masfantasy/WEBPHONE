<?php
require_once __DIR__ .  '/../../vendor/autoload.php'; 
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class CheckToken{
    public static function checktoken(){
        $headers = getallheaders();
        $secret_key = "123"; // Đảm bảo secret_key đồng nhất với khi tạo token

        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            echo json_encode([
                "success" => false,
                "message" => "Vui lòng đăng nhập"
            ]);
            exit();
        }

        try {
            $jwt = str_replace("Bearer ", "", $headers['Authorization']);
            $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));
            return $customer_id = $decoded->data->customer_id;
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode([
                "success" => false,
                "message" => "Vui lòng đăng nhập",
                "error" => $e->getMessage()
            ]);
            exit();
        }
    }
}