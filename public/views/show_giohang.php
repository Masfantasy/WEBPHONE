<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Giỏ hàng của bạn</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="http://localhost/DIDONG2.0/public/css/show_giohang.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light p-4">
  <div class="container">
    <h2 class="mb-4">🛒 Giỏ hàng của bạn</h2>
    <div id="cart-list" class="row"></div>
  </div>
  <div class="text-end mt-4">
    <button class="btn btn-success" id="checkout-btn">💳 Thanh toán</button>
  </div>

  <!-- Overlay cho modal giao nhận -->
<div id="delivery-overlay" style="display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:#0007;z-index:1100"></div>

<!-- Modal giao nhận -->
<div id="delivery-modal" class="p-4 border rounded bg-white"
     style="max-width:500px; margin:auto; display:none; position:fixed; top:12%; left:0; right:0; z-index:1101;">
  <h5 class="mb-3">Thanh toán</h5>
  <div class="mb-2">
    <button class="btn btn-outline-primary btn-sm" type="button" id="open-voucher-modal">🎁 Chọn voucher</button>
    <span id="selected-voucher-text" class="ms-2 text-success"></span>
  </div>
  <div class="mb-2">
    <label><input type="radio" name="delivery_type" value="store" checked> Nhận tại cửa hàng</label>
    <label class="ms-3"><input type="radio" name="delivery_type" value="ship"> Giao tận nơi</label>
  </div>
  <div id="store-select" class="mb-3">
    <label>Chọn cửa hàng</label>
    <select class="form-select" id="store-list"></select>
  </div>
  <div id="ship-info" class="mb-3" style="display:none;">
    <input type="text" id="receiver_name" class="form-control mb-2" placeholder="Họ tên người nhận">
    <input type="text" id="receiver_phone" class="form-control mb-2" placeholder="Số điện thoại">
    <input type="text" id="delivery_address" class="form-control" placeholder="Địa chỉ giao hàng">
  </div>
  <div class="d-flex gap-2 justify-content-end mt-3">
    <button class="btn btn-secondary" id="cancel-delivery">Huỷ</button>
    <button class="btn btn-primary" id="confirm-delivery">Xác nhận & Thanh toán</button>
  </div>
</div>

<!-- Modal voucher (chuẩn Bootstrap) -->
<div class="modal fade" id="voucherModal" tabindex="-1" aria-labelledby="voucherModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="voucherModalLabel">🎁 Chọn voucher</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        <div id="voucher-list">Không có voucher nào khả dụng.</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bỏ qua</button>
        <button type="button" class="btn btn-primary" id="confirm-voucher-btn">Xác nhận</button>
      </div>
    </div>
  </div>
</div>

  <!-- Import script theo đúng thứ tự! -->
  <script src="http://localhost/DIDONG2.0/public/js/voucher.js"></script>
  <script src="http://localhost/DIDONG2.0/public/js/giaonhan.js"></script>
  <script src="http://localhost/DIDONG2.0/public/js/show_giohang.js"></script> 
</body>
</html>
