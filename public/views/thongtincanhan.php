<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thông tin cá nhân</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
  <h2 class="mb-4"><span style="font-size:32px; color:#673ab7;">👤</span> Thông tin cá nhân</h2>
  <form id="profile-form">
    <div class="mb-3">
      <label class="form-label">Tên đăng nhập</label>
      <input type="text" class="form-control" id="username" disabled>
    </div>
    <div class="mb-3">
      <label class="form-label">Họ tên</label>
      <input type="text" class="form-control" id="name" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" class="form-control" id="email" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Số điện thoại</label>
      <input type="text" class="form-control" id="phone" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Địa chỉ</label>
      <input type="text" class="form-control" id="address" required>
    </div>
    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
    <div id="profile-msg" class="mt-3"></div>
  </form>
  <script src="http://localhost/DIDONG2.0/public/js/thongtincanhan.js"></script>
</body>
</html>