<head>
<link rel="stylesheet" href="http://localhost/DIDONG2.0/public/css/masterlayout.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light px-4 shadow-sm">
    <a class="navbar-brand" href="http://localhost/DIDONG2.0/public/index.php">📱 Shop Di Động</a>
    <div style="position: absolute; top: 10px; right: 30px;">
      <div id="user-menu-toggle" style="cursor: pointer;">
        <img src="http://localhost/DIDONG2.0/public/Pictures/user.png" width="32" alt="User Icon">
      </div>
      <div id="user-menu" style="display: none; position: absolute; top: 40px; right: 0; background: white; border: 1px solid #ccc; border-radius: 5px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); z-index: 100;">
        <a href="http://localhost/DIDONG2.0/public/index.php?page=login">Đăng nhập</a>
        <a href="http://localhost/DIDONG2.0/public/index.php?page=register">Đăng ký</a>
        <a href="http://localhost/DIDONG2.0/public/index.php?page=thongtincanhan" id="profile-link" style="display: none;">Thông tin cá nhân</a>
        <a href="http://localhost/DIDONG2.0/public/index.php?page=xem_lichsu_donhang">Hóa đơn</a>
        <a href="http://localhost/DIDONG2.0/public/index.php?page=danhsachvouchers">Voucher</a>
        <a href="#" id="logout-btn" style="display: none; color: red;">Đăng xuất</a>
      </div>
    </div>
    <div style="position: absolute; top: 10px; right: 80px;">
      <a href="http://localhost/DIDONG2.0/public/index.php?page=hienthivouchers" class="btn btn-warning btn-sm">
        🎁 Voucher
      </a>
      <a href="http://localhost/DIDONG2.0/public/index.php?page=show_giohang" style="position: relative;">
        <img src="http://localhost/DIDONG2.0/public/Pictures/cart.png" width="32" alt="Giỏ hàng" style="cursor: pointer;">
        <span id="cart-count" style="position: absolute; top: -8px; right: -8px; background: red; color: white; font-size: 12px; padding: 2px 6px; border-radius: 50%;">0</span>
      </a>
    </div>
</nav>
  <script src="http://localhost/DIDONG2.0/public/js/masterlayout.js"></script>
  <?php
  $data['page'] = $_GET['page'] ?? 'home';  // mặc định trang home
        $data['totalProduct'] = 0; 
        $filePath = __DIR__ . '/views/' . $data['page'] . '.php';
        if (file_exists($filePath)) {
        include_once $filePath;
    } else {
        echo "<p style='color:red; text-align:center;'>⛔ Trang <strong>{$data['page']}</strong> không tồn tại.</p>";
    }
    ?>
</body>