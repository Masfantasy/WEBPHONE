<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
file_put_contents(__DIR__.'/debug.log', "Bat dau API\n", FILE_APPEND);
require_once __DIR__ .  '/../../config/db.php';
require_once __DIR__ .  '/../../models/Donhang.php';
require_once __DIR__ . '/../../middlewares/jwt.php';


Class show_chitietdonhang{
    public static function show_chitietdonhang(){
        if (!isset($_GET['order_id'])) {
        http_response_code(400);
        echo json_encode(["error" => "Thiếu order_id trên URL"]);
        exit();
        }
        $order_id = intval($_GET['order_id']);

        $db = new db();
        $connect = $db->connect();
        $donhang = new Donhang($connect);
        $customer_id=CheckToken::checktoken();
        $donhang->customer_id = $customer_id;
        $donhang->order_id = $order_id;
        $show=$donhang->Chitietdonhang();
        $num = $show->rowCount();
        if($num>0){
            $donhang_array = [];
            $donhang_array ['data'] = [];
            while($row = $show->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $donhang_item = array(
                'order_id' => $order_id,
                'status' => $status,
                'order_date' => $order_date,
                'name' => $name,
                'img' => $img,
                'quantity' => $quantity,
                'price' => $price
            );

                array_push($donhang_array ['data'],$donhang_item);
            }
        echo json_encode ($donhang_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }
}