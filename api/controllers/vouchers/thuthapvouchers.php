<?php
require_once __DIR__ .  '/../../config/db.php';
require_once __DIR__ .  '/../../models/vouchers.php';
require_once __DIR__ . '/../../middlewares/jwt.php';


Class Thuthapvouchers{
    public static function thuthapvouchers(){
        $db = new db();
        $connect = $db->connect();
        
        $voucher = new Vouchers($connect);
        $customer_id = CheckToken::checktoken();
        $voucher->customer_id = $customer_id;


        $data = json_decode(file_get_contents("php://input"));
        $voucher->voucher_id = $data->voucher_id;


        if($voucher->create()){
            echo json_encode(array('Thêm voucher thành công'));
        }else{
            echo json_encode(array('Thêm voucher thất bại'));
        }
    }
}