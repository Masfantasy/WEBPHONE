<?php

use Dom\ChildNode;

require_once __DIR__ .  '/../../config/db.php';
require_once __DIR__ .  '/../../models/Donhang.php';
require_once __DIR__ .  '/../../models/Giohang.php';
require_once __DIR__ . '/../../middlewares/jwt.php';


Class xem_lichsu_donhang{
    public static function xem_lichsu_donhang(){
        $db = new db();
        $connect = $db->connect();
        $donhang = new Donhang($connect);
        $customer_id = CheckToken::checktoken();
        $donhang->customer_id = $customer_id;
        $show=$donhang->show();
        $num = $show->rowCount();
        if($num>0){
            $donhang_array = [];
            $donhang_array ['data'] = [];
            while($row = $show->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $donhang_item = array(
                    'order_id'=>$order_id,
                    'order_date' => $order_date,
                    'status'=>$status,
                    'total'=>$total
                );
                array_push($donhang_array ['data'],$donhang_item);
            }
            echo json_encode ($donhang_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }else{
        echo json_encode(["data" => []], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }
}