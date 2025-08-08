<?php
require_once __DIR__ .  '/../../config/db.php';
require_once __DIR__ .  '/../../models/vouchers.php';
require_once __DIR__ . '/../../middlewares/jwt.php';



Class hienthivouchers{
    public static function hienthivouchers(){
        $db = new db();
        $connect = $db->connect();

        $vouchers = new Vouchers($connect);
        $customer_id = CheckToken::checktoken();
        $vouchers->customer_id = $customer_id;
        $read = $vouchers->read();

        $num = $read->rowCount();
        if($num>0){
        $voucher_array = [];
        $voucher_array ['data'] = [];

        while($row = $read->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $voucher_item = array(
                'voucher_id'=>$voucher_id,
                'code' => $code,
                'discount_type'=>$discount_type,
                'discount_value'=>$discount_value,
                'min_order_value'=>$min_order_value,
                'start_date'=>$start_date,
                'end_date'=>$end_date
            );
            array_push($voucher_array ['data'],$voucher_item);
        }
        echo json_encode($voucher_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }
}