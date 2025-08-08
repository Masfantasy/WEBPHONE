const token = localStorage.getItem("token");
    const urlParams = new URLSearchParams(window.location.search);
    const orderId = urlParams.get('order_id');

    if (!orderId) {
      alert("Thiếu order_id trên URL");
      window.location.href = "http://localhost/DIDONG2.0/public/index.php?page=xem_lichsu_donhang";
    }

    fetch(`/DIDONG2.0/api/routes/api.php?action=show_chitietdonhang&order_id=${orderId}`, {
      headers: {
        "Authorization": `Bearer ${token}`
      }
    })
    .then(res => res.json())
    .then(data => {
      if (data.data && data.data.length > 0) {
        const first = data.data[0];
        document.getElementById("order-id").textContent = first["order_id"];
        document.getElementById("order-status").textContent = first["status"];
        document.getElementById("order-date").textContent = first["order_date"];
        

        //Hủy đơn hàng
        const cancelBtn = document.getElementById("cancel-btn");
        if (first["status"] === "Chờ xử lý") {
        cancelBtn.classList.remove("d-none");
        }

        cancelBtn.addEventListener("click", () => {
        if (confirm("Bạn có chắc muốn hủy đơn hàng này?")) {
            fetch(`/DIDONG2.0/api/routes/api.php?action=update_trangthai_huydon`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${token}`
            },
            body: JSON.stringify({ order_id: first["order_id"] })
            })
            .then(res => res.json())
            .then(result => {
            alert(result.message || "Đơn hàng đã được hủy");
            location.reload(); // Tải lại để cập nhật trạng thái
            })
            .catch(err => {
            console.error(err);
            alert("Lỗi khi hủy đơn hàng");
            });
        }
        });
        const list = document.getElementById("product-list");
        let total = 0;

        data.data.forEach(item => {
          const imgPath = `http://localhost/DIDONG2.0/public/Pictures/Products/${item["img"] || "default.png"}`;
          const subtotal = item["quantity"] * item["price"];
          total += subtotal;

          const html = `
            <div class="col-md-6 col-lg-4">
              <div class="product-card d-flex align-items-center">
                <img src="${imgPath}" alt="${item["name"]}" class="product-img me-3">
                <div>
                  <div class="product-name">${item["name"]}</div>
                  <div>Số lượng: ${item["quantity"]}</div>
                  <div>Đơn giá: ${parseInt(item["price"]).toLocaleString()}₫</div>
                  <div class="product-price">Thành tiền: ${subtotal.toLocaleString()}₫</div>
                </div>
              </div>
            </div>
          `;
          list.innerHTML += html;
        });

        document.getElementById("total").innerHTML = `Tổng tiền: ${total.toLocaleString()}₫`;

      } else {
        document.querySelector(".container").innerHTML = `<div class="alert alert-warning">Không tìm thấy đơn hàng này.</div>`;
      }
    })
    .catch(err => {
      console.error(err);
      alert("Lỗi khi tải chi tiết đơn hàng");
    });
    //Quay lại trang trước
    document.getElementById("back-btn").addEventListener("click", () => {
    window.location.href = "http://localhost/DIDONG2.0/public/index.php?page=xem_lichsu_donhang"
  });