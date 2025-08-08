// Lấy id sản phẩm từ URL
function getProductIdFromUrl() {
  const params = new URLSearchParams(window.location.search);
  return params.get("id");
}
const productId = getProductIdFromUrl();
const apiUrl = "http://localhost/DIDONG2.0/api/controllers/sanpham/show_tt_sanpham.php";

if (productId) {
  fetch(`${apiUrl}?id=${productId}`)
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        const sp = data.data;
        document.getElementById("product-detail").innerHTML = `
          <div class="card mb-4">
            <div class="row g-0">
              <div class="col-md-4">
                <img src="http://localhost/DIDONG2.0/public/Pictures/Products/${sp.img}" class="img-fluid rounded-start" alt="${sp.name}">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h3 class="card-title">${sp.name}</h3>
                  <h4 class="text-danger">${parseInt(sp.price).toLocaleString()}₫</h4>
                  <div class="d-flex align-items-center gap-2 mt-3">
                  <label for="quantity-input" class="mb-0">Số lượng:</label>
                  <input type="number" min="1" value="1" id="quantity-input" style="width: 70px;" class="form-control form-control-sm">
                  <button class="btn btn-success" id="buy-now-btn">Mua ngay</button>
                  <button class="btn btn-sm btn-primary" id="add-to-cart-btn">🛒 Thêm vào giỏ</button>
                </div>
                  <div id="msg-action" class="mt-3"></div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>Hãng:</b> ${sp.company}</li>
                    <li class="list-group-item"><b>Màn hình:</b> ${sp.screen}</li>
                    <li class="list-group-item"><b>Hệ điều hành:</b> ${sp.os}</li>
                    <li class="list-group-item"><b>Camera:</b> ${sp.camera}</li>
                    <li class="list-group-item"><b>Camera trước:</b> ${sp.camera_front}</li>
                    <li class="list-group-item"><b>CPU:</b> ${sp.cpu}</li>
                    <li class="list-group-item"><b>RAM:</b> ${sp.ram}</li>
                    <li class="list-group-item"><b>ROM:</b> ${sp.rom}</li>
                    <li class="list-group-item"><b>MicroUSB:</b> ${sp.microUSB}</li>
                    <li class="list-group-item"><b>Pin:</b> ${sp.battery}</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        `;

        // Đặt ở đây, vì lúc này nút mới xuất hiện trên DOM!
        document.getElementById("add-to-cart-btn").onclick = function() {
          if (!token) return alert("Bạn cần đăng nhập để thêm vào giỏ hàng.");
          const quantity = parseInt(document.getElementById("quantity-input").value) || 1;
          fetch(`http://localhost/DIDONG2.0/api/routes/api.php?action=them_vao_gio`, {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "Authorization": `Bearer ${token}`
            },
            body: JSON.stringify({ product_id: productId, quantity })
          })
          .then(res => res.json())
          .then(data => {
            alert(data.message || "Đã thêm vào giỏ!");
            // Gọi updateCartCount nếu muốn cập nhật số trên icon giỏ hàng
          })
          .catch(() => alert("Lỗi khi thêm vào giỏ."));
        };

        // Xử lý mua ngay nếu muốn
        document.getElementById("buy-now-btn").onclick = function() {
          if (!token) {
    alert("Bạn cần đăng nhập để mua hàng.");
    return;
  }
  const quantity = parseInt(document.getElementById("quantity-input").value) || 1;
  fetch("/DIDONG2.0/api/routes/api.php?action=them_vao_gio", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "Authorization": `Bearer ${token}`
    },
    body: JSON.stringify({ product_id: productId, quantity })
  })
  .then(res => res.json())
  .then(data => {
    // Nếu thêm thành công, chuyển sang trang giỏ hàng + mở form thanh toán luôn
    if (data.success || data.message?.includes("thành công")) {
      // Chuyển sang giỏ hàng (hoặc modal thanh toán luôn nếu bạn muốn)
      window.location.href = "http://localhost/DIDONG2.0/public/index.php?page=show_giohang&buynow=1";
    } else {
      alert(data.message || "Không thể mua hàng lúc này.");
    }
  })
  .catch(() => alert("Có lỗi khi mua hàng!"));
        };

      } else {
        document.getElementById("product-detail").innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
      }
    });
} else {
  document.getElementById("product-detail").innerHTML = "<div class='alert alert-danger'>Không tìm thấy sản phẩm!</div>";
}

function getQuantity() {
  return parseInt(document.getElementById("quantity-input").value) || 1;
}

