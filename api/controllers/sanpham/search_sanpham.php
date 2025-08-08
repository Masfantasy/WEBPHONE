<?php
require_once __DIR__ .  '/../../config/db.php';
require_once __DIR__ .  '/../../models/Sanpham.php';


Class search_sanpham{
    public static function search_sanpham(){
        $db = new db();
        $connect = $db->connect();

        // Lấy các tham số từ URL
        $keyword = $_GET['q'] ?? '';
        $company    = $_GET['company'] ?? '';
        $min_price = is_numeric($_GET['min_price'] ?? '') ? (float)$_GET['min_price'] : 0;
        $max_price = is_numeric($_GET['max_price'] ?? '') ? (float)$_GET['max_price'] : PHP_INT_MAX;

        // Gọi class model
        $sp = new Sanpham($connect);
        $stmt = $sp->search($keyword, $company, $min_price, $max_price);

        // Đọc dữ liệu
        $product_list = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $product_list[] = [
                'product_id' => $row['product_id'],
                'name'       => $row['name'],
                'company'    => $row['company'],
                'img'        => $row['img'],
                'price'      => $row['price']
            ];
        }

        if (empty($product_list)) {
            echo json_encode([
                "success" => false,
                "message" => "Sản phẩm không tồn tại"
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else {
            echo json_encode([
                "success" => true,
                "data" => $product_list
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }
}