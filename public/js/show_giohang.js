const token = localStorage.getItem("token");

    fetch("/DIDONG2.0/api/routes/api.php?action=show_giohang", {
      method: "GET",
      headers: {
        "Authorization": `Bearer ${token}`
      }
    })
    .then(res => res.json())
    .then(data => {
      const cartList = document.getElementById("cart-list");

      if (data.data && Array.isArray(data.data) && data.data.length > 0) {
        data.data.forEach(item => {
          const imgPath = `http://localhost/DIDONG2.0/public/Pictures/Products/${item.img || "default.png"}`;
          const html = `
            <div class="col-md-6 col-lg-4">
              <div class="cart-card bg-white d-flex align-items-start">
                <img src="${imgPath}" alt="${item.name}" class="cart-img me-3">
                <div>
                  <div class="product-name">${item.name}</div>
                  <div class="d-flex align-items-center mt-2">
                    <input type="number" class="form-control qty-input me-2" id="qty-${item.id}" value="${item.quantity}" min="1">
                    <button class="btn btn-sm btn-primary me-2 update-btn" data-id="${item.id}">Cập nhật</button>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="${item.id}">Xóa</button>
                  </div>
                  <div class="product-price mt-2">${parseInt(item.price).toLocaleString()}₫</div>
                </div>
              </div>
            </div>
          `;
          cartList.innerHTML += html;
        });

        setTimeout(() => {
          // Xử lý nút cập nhật
          document.querySelectorAll(".update-btn").forEach(btn => {
            btn.addEventListener("click", () => {
              const id = btn.getAttribute("data-id");
              const qty = document.getElementById(`qty-${id}`).value;
              if (qty < 1) return alert("Số lượng phải lớn hơn 0");

              fetch("/DIDONG2.0/api/routes/api.php?action=update_soluong", {
                method: "PUT",
                headers: {
                  "Content-Type": "application/json",
                  "Authorization": `Bearer ${token}`
                },
                body: JSON.stringify({ id: id, quantity: qty })
              })
              .then(res => res.json())
              .then(res => {
                alert(res.message || "Đã cập nhật số lượng");
              })
              .catch(err => {
                console.error(err);
                alert("Lỗi khi cập nhật");
              });
            });
          });

          // Xử lý nút xóa
          document.querySelectorAll(".delete-btn").forEach(btn => {
            btn.addEventListener("click", () => {
              const id = btn.getAttribute("data-id");
              if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này?")) {
                fetch("/DIDONG2.0/api/routes/api.php?action=xoa_sanpham_giohang", {
                  method: "PUT",
                  headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${token}`
                  },
                  body: JSON.stringify({ id: id })
                })
                .then(res => res.json())
                .then(res => {
                  alert(res.message || "Đã xóa sản phẩm");
                  location.reload();
                })
                .catch(err => {
                  console.error(err);
                  alert("Lỗi khi xóa sản phẩm");
                });
              }
            });
          });
        }, 100);
      } else {
        cartList.innerHTML = `<div class="alert alert-info">Không có sản phẩm nào trong giỏ hàng.</div>`;
      }
    })
    .catch(err => {
      console.error(err);
      document.getElementById("cart-list").innerHTML = `<div class="alert alert-info">Không có sản phẩm nào trong giỏ hàng.</div>`;
    });
    
    
    //Thanh toán
    let selectedVoucherId = null;

// Mở modal giao nhận khi click "Thanh toán"
  document.getElementById("checkout-btn").onclick = function () {
    // document.getElementById("delivery-modal").style.display = "block";
    // document.getElementById("delivery-overlay").style.display = "block";
    // // Giao tiếp với giaonhan.js (gọi hàm loadStores nếu cần)
    // if (typeof window.loadStores === 'function') window.loadStores();
    showDeliveryModal();
  };

function showDeliveryModal() {
  document.getElementById("delivery-modal").style.display = "block";
  document.getElementById("delivery-overlay").style.display = "block";
  // Load danh sách cửa hàng nếu cần
  if (typeof window.loadStores === 'function') window.loadStores();
}
document.addEventListener("DOMContentLoaded", function() {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get("buynow") === "1") {
    showDeliveryModal();
  }
});