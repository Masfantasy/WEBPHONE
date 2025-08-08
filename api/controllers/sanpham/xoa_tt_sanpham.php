<?php
require_once __DIR__ .  '/../../config/db.php';
require_once __DIR__ .  '/../../models/Sanpham.php';

Class xoa_tt_sanpham{
    public static function xoa_tt_sanpham(){
        $db = new db();
        $connect = $db->connect();
        
        $sanpham = new Sanpham($connect);

        $data = json_decode(file_get_contents("php://input"));
            
            $sanpham->product_id = $data->product_id;

        if($sanpham->delete()){
            echo json_encode(array('message','Xóa thành công'));
        }else{
            echo json_encode(array('message','Xóa thất bại'));
        }
    }
}