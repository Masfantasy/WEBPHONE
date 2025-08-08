<?php
require_once __DIR__ .  '/../../config/db.php';
require_once __DIR__ .  '/../../models/Giohang.php';
require_once __DIR__ . '/../../middlewares/jwt.php';

Class Show_giohang{
    public static function show_giohang(){
        $db = new db();
        $connect = $db->connect();
        $giohang = new Giohang($connect);
        $customer_id=CheckToken::checktoken();
        $giohang->customer_id = $customer_id;
        $show=$giohang->show();
        $num = $show->rowCount();
        if($num>0){
            $giohang_array = [];
            $giohang_array ['data'] = [];
            while($row = $show->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $giohang_item = array(
                    'cart_id'=>$cart_id,
                    'customer_id' => $customer_id,
                    'created_at'=>$created_at,
                    'id'=>$id,
                    'product_id'=>$product_id,
                    'quantity'=>$quantity,
                    'name'=>$name,
                    'img'=>$img,
                    'price'=>$price
                );
                array_push($giohang_array ['data'],$giohang_item);
            }
        echo json_encode ($giohang_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }
}