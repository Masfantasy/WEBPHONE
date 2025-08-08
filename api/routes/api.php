<?php

$action = $_GET['action'] ?? null;
$method = $_SERVER['REQUEST_METHOD'];

switch ($action) {
    case 'login':
        if ($method === 'POST') {
            require_once __DIR__ . '/../controllers/khachhang/login.php';
            Login::login();
        }
        break;

    case 'register':
        if ($method === 'POST') {
            require_once __DIR__ . '/../controllers/khachhang/register.php';
            Register::register();
        }
        break;

    case 'show_tt_khachhang':
        if ($method === 'GET') {
            require_once __DIR__ . '/../controllers/khachhang/show_tt_khachhang.php';
            Show_tt_khachhang::show_tt_khachhang();
        }
        break;
    case 'sua_tt_khachhang':
        if ($method === 'PUT') {
            require_once __DIR__ . '/../controllers/khachhang/sua_tt_khachhang.php';
            Sua_tt_khachhang::sua_tt_khachhang();
        }
        break;
    case 'show_giohang':
        if ($method === 'GET') {
            require_once __DIR__ . '/../controllers/giohang/show_giohang.php';
            Show_giohang::show_giohang();
        }
        break;
    case 'them_vao_gio':
        if ($method === 'POST') {
            require_once __DIR__ . '/../controllers/giohang/them_vao_gio.php';
            Them_vao_gio::them_vao_gio();
        }
        break;
    case 'demsoluong':
        if ($method === 'GET') {
            require_once __DIR__ . '/../controllers/giohang/demsoluong.php';
            Demsoluong::demsoluong();
        }
        break;
    case 'update_soluong':
        if ($method === 'PUT') {
            require_once __DIR__ . '/../controllers/giohang/update_soluong.php';
            update_soluong::update_soluong();
        }
        break;
    case 'xoa_sanpham_giohang':
        if ($method === 'PUT') {
            require_once __DIR__ . '/../controllers/giohang/xoa_sanpham_giohang.php';
            xoa_sanpham_giohang::xoa_sanpham_giohang();
        }
        break;
    case 'show_chitietdonhang':
        if ($method === 'GET') {
            require_once __DIR__ . '/../controllers/donhang/show_chitietdonhang.php';
            show_chitietdonhang::show_chitietdonhang();
        }
        break;
    case 'them_donhang':
        if ($method === 'POST') {
            require_once __DIR__ . '/../controllers/donhang/them_donhang.php';
            them_donhang::them_donhang();
        }
        break;
    case 'update_trangthai_huydon':
        if ($method === 'PUT') {
            require_once __DIR__ . '/../controllers/donhang/update_trangthai_huydon.php';
            update_trangthai::update_trangthai();
        }
        break;
    case 'xem_lichsu_donhang':
        if ($method === 'GET') {
            require_once __DIR__ . '/../controllers/donhang/xem_lichsu_donhang.php';
            xem_lichsu_donhang::xem_lichsu_donhang();
        }
        break;
    case 'get_sanpham':
        if ($method === 'GET') {
            require_once __DIR__ . '/../controllers/sanpham/get_sanpham.php';
            get_sanpham::get_sanpham();
        }
        break;
    case 'search_sanpham':
        if ($method === 'GET') {
            require_once __DIR__ . '/../controllers/sanpham/search_sanpham.php';
            search_sanpham::search_sanpham();
        }
        break;
    case 'show_tt_sanpham':
        if ($method === 'GET') {
            require_once __DIR__ . '/../controllers/sanpham/show_tt_sanpham.php';
            show_tt_sanpham::show_tt_sanpham();
        }
        break;
    case 'sua_tt_sanpham':
        if ($method === 'POST') {
            require_once __DIR__ . '/../controllers/sanpham/sua_tt_sanpham.php';
            sua_tt_sanpham::sua_tt_sanpham();
        }
        break;
    case 'them_sanpham':
        if ($method === 'POST') {
            require_once __DIR__ . '/../controllers/sanpham/them_sanpham.php';
            them_sanpham::them_sanpham();
        }
        break;
    case 'xoa_tt_sanpham':
        if ($method === 'POST') {
            require_once __DIR__ . '/../controllers/sanpham/xoa_tt_sanpham.php';
            xoa_tt_sanpham::xoa_tt_sanpham();
        }
        break;
    case 'hienthivouchers':
        if ($method === 'GET') {
            require_once __DIR__ . '/../controllers/vouchers/hienthivouchers.php';
            hienthivouchers::hienthivouchers();
        }
        break;
    case 'thuthapvouchers':
        if ($method === 'POST') {
            require_once __DIR__ . '/../controllers/vouchers/thuthapvouchers.php';
            Thuthapvouchers::thuthapvouchers();
        }
        break;
    case 'danhsachvoucher':
        if ($method === 'GET') {
            require_once __DIR__ . '/../controllers/vouchers/danhsachvoucher.php';
            Danhsachvoucher::danhsachvoucher();
        }
        break;
    case 'show_stores':
        if ($method === 'GET') {
            require_once __DIR__ . '/../controllers/cuahang/show_store.php';
            show_store::show_store();
        }
        break;

    default:
        http_response_code(404);
        echo json_encode([
            "success" => false,
            "message" => "API không tồn tại"
        ]);
        break;
}
