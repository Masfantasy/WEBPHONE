<?php
require_once __DIR__ .  '/../../config/db.php';
require_once __DIR__ .  '/../../models/vouchers.php';
require_once __DIR__ . '/../../middlewares/jwt.php';


Class Danhsachvoucher{
    public static function danhsachvoucher(){
        $db = new db();
        $connect = $db->connect();

        
        $vouchers = new Vouchers($connect);
        $customer_id = CheckToken::checktoken();
        $vouchers->customer_id = $customer_id;
        $read = $vouchers->customer_vouchers();
        $num = $read->rowCount();
        if($num>0){
        $voucher_array = [];
        $voucher_array ['data'] = [];
        while($row = $read->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $voucher_item = array(
                'voucher_id'=>$voucher_id,
                'is_used' => $is_used,
                'used_at'=>$used_at,
                'code'=>$code,
                'discount_type'=>$discount_type,
                'discount_value'=>$discount_value,
                'end_date'=>$end_date
            );
            array_push($voucher_array ['data'],$voucher_item);
        }
        echo json_encode($voucher_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }
}