<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

  <div class="row justify-content-center">
    <div class="col-md-6">
      <h3 class="mb-4">🔐 Đăng nhập hệ thống</h3>
      <form id="login-form">
        <div class="mb-3">
          <label for="username" class="form-label">Tên đăng nhập</label>
          <input type="text" class="form-control" id="username" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Mật khẩu</label>
          <input type="password" class="form-control" id="password" required>
        </div>
        <div class="mb-3">
          Chưa có tài khoản? <a href="http://localhost/DIDONG2.0/public/views/register.php">Đăng ký ngay</a>
        </div>
        <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
      </form>
      <div id="error-msg" class="text-danger mt-3"></div>
    </div>
  </div>
  <script src="http://localhost/DIDONG2.0/public/js/login.js"></script>
</body>
</html>
