<?php
require_once __DIR__ .  '/../../config/db.php';
require_once __DIR__ .  '/../../models/sanpham.php';

Class them_sanpham{
    public static function them_sanpham(){
        $db = new db();
        $connect = $db->connect();
        
        $sanpham = new Sanpham($connect);

        $data = json_decode(file_get_contents("php://input"));
        $sanpham->product_id = $data->product_id;
        $sanpham->name = $data->name;
        $sanpham->company = $data->company;
        $sanpham->img = $data->img;
        $sanpham->price = $data->price;
        $sanpham->screen = $data->screen;
        $sanpham->os = $data->os;
        $sanpham->camera = $data->camera;
        $sanpham->camera_front = $data->camera_front;
        $sanpham->cpu = $data->cpu;
        $sanpham->ram = $data->ram;
        $sanpham->rom = $data->rom;
        $sanpham->microUSB = $data->microUSB;
        $sanpham->battery = $data->battery;


        if($sanpham->create()){
            echo json_encode(array('Thêm sản phẩm thành công'));
        }else{
            echo json_encode(array('Thêm sản phẩm thất bại'));
        }
    }
}