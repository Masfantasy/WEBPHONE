<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chi tiết đơn hàng</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="http://localhost/DIDONG2.0/public/css/chitietdonhang.css">
</head>
<body class="p-4">
  <div class="container">
    <div class="order-header">
      <h3>📄 Chi tiết đơn hàng <span id="order-id"></span></h3>
      <p><strong>Trạng thái:</strong> <span id="order-status"></span></p>
      <p><strong>Ngày đặt:</strong> <span id="order-date"></span></p>
      <button id="cancel-btn" class="btn btn-danger mt-2 d-none">❌ Hủy đơn hàng</button>
    </div>

    <div id="product-list" class="row"></div>

    <div id="total" class="total-section"></div>
  </div>
    <div class="mb-3">
        <button button id="back-btn" class="btn btn-secondary">Quay lại</button>
    </div>
    <script src="http://localhost/DIDONG2.0/public/js/chitietdonhang.js"></script>
</body>
