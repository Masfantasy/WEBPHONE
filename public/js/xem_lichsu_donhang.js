const token = localStorage.getItem("token");

    fetch("/DIDONG2.0/api/routes/api.php?action=xem_lichsu_donhang", {
      method: "GET",
      headers: {
        "Authorization": `Bearer ${token}`
      }
    })
    .then(res => res.json())
    .then(data => {
      const list = document.getElementById("order-list");
      if (data.data && Array.isArray(data.data)) {
        data.data.forEach(order => {
          const html = `
            <div class="col-md-6 col-lg-4">
              <div class="card order-card p-3" onclick="window.location.href='index.php?page=chitietdonhang&order_id=${order["order_id"]}'">
                <h5 class="mb-2">Đơn hàng #${order["order_id"]}</h5>
                <p class="mb-1"><strong>Ngày đặt:</strong> ${order["order_date"]}</p>
                <p class="mb-1 order-status"><strong>Trạng thái:</strong> ${order["status"]}</p>
                <p class="mb-0 order-total"><strong>Tổng tiền:</strong> ${parseInt(order["total"] ?? 0).toLocaleString()}₫</p>
              </div>
            </div>
          `;
          list.innerHTML += html;
        });
      } else {
        list.innerHTML = `<div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>`;
      }
    })
    .catch(err => {
      console.error(err);
      alert("Lỗi khi tải đơn hàng");
    });
    //Quay lại trang trước
    document.getElementById("back-btn").addEventListener("click", () => {
    window.location.href = "http://localhost/DIDONG2.0/public/index.php";
  });