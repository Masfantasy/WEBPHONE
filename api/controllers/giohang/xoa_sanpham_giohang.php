<?php
require_once __DIR__ .  '/../../config/db.php';
require_once __DIR__ .  '/../../models/Giohang.php';
require_once __DIR__ . '/../../middlewares/jwt.php';

Class xoa_sanpham_giohang{
    public static function xoa_sanpham_giohang(){
        $db = new db();
        $connect = $db->connect();
        
        $giohang = new Giohang($connect);

        $data = json_decode(file_get_contents("php://input"));
            
        $giohang->id = $data->id;

        if($giohang->delete()){
            echo json_encode(array('message' => 'Xóa thành công'));
        }else{
            echo json_encode(array('message' => 'Xóa thất bại'));
        }
    }
}