<?php
require_once __DIR__ .  '/../../config/db.php';
require_once __DIR__ .  '/../../models/Sanpham.php';

class ShowProductDetail {
    public static function show() {
        $db = new db();
        $connect = $db->connect();
        $sanpham = new Sanpham($connect);

        // Lấy product_id từ GET, trả về lỗi nếu thiếu
        $product_id = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$product_id) {
            echo json_encode([
                "success" => false,
                "message" => "Thiếu id sản phẩm!"
            ]);
            exit();
        }

        $sanpham->product_id = $product_id;
        $sanpham->show();  // Gán dữ liệu vào thuộc tính

        // Nếu không tìm thấy sản phẩm
        if (empty($sanpham->name)) {
            echo json_encode([
                "success" => false,
                "message" => "Sản phẩm không tồn tại!"
            ]);
            exit();
        }

        $sanpham_item = [
            "product_id"     => $product_id,
            "name"           => $sanpham->name,
            "company"        => $sanpham->company,
            "img"            => $sanpham->img,
            "price"          => $sanpham->price,
            "screen"         => $sanpham->screen,
            "os"             => $sanpham->os,
            "camera"         => $sanpham->camera,
            "camera_front"   => $sanpham->camera_front,
            "cpu"            => $sanpham->cpu,
            "ram"            => $sanpham->ram,
            "rom"            => $sanpham->rom,
            "microUSB"       => $sanpham->microUSB,
            "battery"        => $sanpham->battery
        ];

        echo json_encode([
            "success" => true,
            "data"    => $sanpham_item
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}

// Gọi hàm để thực thi (nếu file này được truy cập trực tiếp)
ShowProductDetail::show();