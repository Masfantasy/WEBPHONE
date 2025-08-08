<?php
require_once __DIR__ .  '/../../config/db.php';
require_once __DIR__ .  '/../../models/Sanpham.php';

Class sua_tt_sanpham{
    public static function sua_tt_sanpham(){
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

        if($sanpham->update()){
            echo json_encode(array('Update thành công'));
        }else{
            echo json_encode(array('Update thất bại'));
        }
    }
}