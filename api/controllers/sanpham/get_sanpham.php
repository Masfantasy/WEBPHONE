<?php
require_once __DIR__ .  '/../../config/db.php';
require_once __DIR__ .  '/../../models/Sanpham.php';


Class get_sanpham{
    public static function get_sanpham(){
        $db = new db();
        $connect = $db->connect();

        $sanpham = new Sanpham($connect);
        $read = $sanpham->read();

        $num = $read->rowCount();
        if($num>0){
        $sanpham_array = [];
        $sanpham_array ['data'] = [];

        while($row = $read->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $sanpham_item = array(
                'id Sản Phẩm'=>$product_id,
                'Tên Sản Phẩm' => $name,
                'Công ty sản xuất'=>$company,
                'Ảnh'=>$img,
                'Giá'=>$price
            );
            array_push($sanpham_array ['data'],$sanpham_item);
        }
        echo json_encode($sanpham_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }
}