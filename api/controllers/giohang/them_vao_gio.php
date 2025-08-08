<?php
require_once __DIR__ .  '/../../config/db.php';
require_once __DIR__ .  '/../../models/Giohang.php';
require_once __DIR__ . '/../../middlewares/jwt.php';

Class Them_vao_gio{
    public static function them_vao_gio(){
        $db = new db();
        $connect = $db->connect();
        
        $giohang = new Giohang($connect);
        $customer_id=CheckToken::checktoken();
        $giohang->customer_id = $customer_id;

        $data = json_decode(file_get_contents("php://input"));
        $giohang->cart_id = $giohang->GetCartID($customer_id);
        $giohang->product_id = $data->product_id;
        $giohang->quantity = $data->quantity;

        if($giohang->create()){
            echo json_encode(array('message' => 'Thêm sản phẩm vào giỏ hàng thành công'));
        }else{
            echo json_encode(array('message' => 'Thêm sản phẩm vào giỏ hàng thất bại'));
        }
    }
}