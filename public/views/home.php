<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Danh sách sản phẩm</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="http://localhost/DIDONG2.0/public/css/home.css">
</head>
<body class="p-4 bg-light">
    <div class="container mt-4">
        <div class="owl-carousel owl-theme" id="banner-container"></div>
    </div>
    <div class="container mt-4">
    <div class="mb-3">
        <input type="text" class="form-control" id="search-input" placeholder="Tìm sản phẩm...">
    </div>
    <div class="row mb-3">
    <div class="col-md-3">
        <select class="form-select" id="company-filter">
        <option value="">Tất cả hãng</option>
        <option value="xiaomi">Xiaomi</option>
        <option value="samsung">Samsung</option>
        <option value="apple">Apple</option>
        <!-- Bổ sung thêm các hãng khác -->
        </select>
    </div>
    <div class="col-md-3">
        <input type="number" id="min-price" class="form-control" placeholder="Giá thấp nhất">
    </div>
    <div class="col-md-3">
        <input type="number" id="max-price" class="form-control" placeholder="Giá cao nhất">
    </div>
    <div class="col-md-3">
        <button class="btn btn-secondary w-100" id="filter-btn">Lọc</button>
    </div>
    </div>
    <div class="row" id="product-list"></div>
    </div>
    <!-- File home.js -->
    <script src="http://localhost/DIDONG2.0/public/js/home.js"></script>
</body>