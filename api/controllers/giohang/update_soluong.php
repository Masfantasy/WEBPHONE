<?php
require_once __DIR__ .  '/../../config/db.php';
require_once __DIR__ .  '/../../models/Giohang.php';
require_once __DIR__ . '/../../middlewares/jwt.php';

Class update_soluong{
    public static function update_soluong(){
        $db = new db();
        $connect = $db->connect();
        $giohang = new Giohang($connect);
        $customer_id = CheckToken::checktoken();
        $giohang->customer_id = $customer_id;
        $data = json_decode(file_get_contents("php://input"));
        $giohang->id = $data->id;
        $giohang->quantity = $data->quantity;
        

        if($giohang->update()){
            echo json_encode(['message' => 'Update thành công']);
        }else{
            echo json_encode(['message' => 'Update thất bại']);
    }
    }
}