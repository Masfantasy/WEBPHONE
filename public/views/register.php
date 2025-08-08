<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng ký</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

  <div class="row justify-content-center">
    <div class="col-md-6">
      <h3 class="mb-4">🔐 Đăng ký tài khoản</h3>
      <form id="register-form">
        <div class="mb-3">
          <label for="name" class="form-label">Họ và tên</label>
          <input type="text" class="form-control" id="name" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="text" class="form-control" id="email" required>
        </div>
        <div class="mb-3">
          <label for="phone" class="form-label">Số điện thoại</label>
          <input type="text" class="form-control" id="phone" >
        </div>
        <div class="mb-3">
          <label for="address" class="form-label">Địa chỉ</label>
          <input type="text" class="form-control" id="address" >
        </div>
        <div class="mb-3">
          <label for="username" class="form-label">Tên đăng nhập</label>
          <input type="text" class="form-control" id="username" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Mật khẩu</label>
          <input type="password" class="form-control" id="password" required>
        </div>
        <div class="mb-3">
          <label for="repassword" class="form-label">Nhập lại mật khẩu</label>
          <input type="password" class="form-control" id="repassword" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
      </form>
      <div id="error-msg" class="text-danger mt-3"></div>
    </div>
  </div>
    <script src="http://localhost/DIDONG2.0/public/js/register.js"></script>
  </body>
</html>