document.addEventListener("DOMContentLoaded", function () {
  // Đóng modal
  document.getElementById("cancel-delivery").onclick = hideDeliveryModal;
  document.getElementById("delivery-overlay").onclick = hideDeliveryModal;

  function hideDeliveryModal() {
    document.getElementById("delivery-modal").style.display = "none";
    document.getElementById("delivery-overlay").style.display = "none";
  }

  // Hiện/ẩn form ship
  document.querySelectorAll('input[name="delivery_type"]').forEach(radio => {
    radio.onchange = function () {
      if (this.value === "store") {
        document.getElementById('store-select').style.display = '';
        document.getElementById('ship-info').style.display = 'none';
      } else {
        document.getElementById('store-select').style.display = 'none';
        document.getElementById('ship-info').style.display = '';
      }
    };
  });

  // Hàm load danh sách cửa hàng (export global để show_giohang.js gọi được)
  window.loadStores = function () {
    fetch("/DIDONG2.0/api/routes/api.php?action=show_stores")
      .then(res => res.json())
      .then(data => {
        const select = document.getElementById("store-list");
        select.innerHTML = "";
        if (data.data) {
          data.data.forEach(store => {
            select.innerHTML += `<option value="${store.store_code}">${store.store_name} - ${store.store_address}</option>`;
          });
        }
      });
  };

  // Xác nhận thanh toán
  document.getElementById("confirm-delivery").onclick = function () {
    const token = localStorage.getItem("token");
    const deliveryType = document.querySelector('input[name="delivery_type"]:checked').value;
    let body = { delivery_type: deliveryType };

    // Voucher
    if (window.selectedVoucherId) body.voucher_id = window.selectedVoucherId;

    if (deliveryType === "store") {
      body.store_code = document.getElementById("store-list").value;
    } else {
      body.receiver_name = document.getElementById("receiver_name").value.trim();
      body.receiver_phone = document.getElementById("receiver_phone").value.trim();
      body.delivery_address = document.getElementById("delivery_address").value.trim();
      if (!body.receiver_name || !body.receiver_phone || !body.delivery_address) {
        alert("Hãy nhập đủ thông tin giao hàng!");
        return;
      }
    }
    
    if (window.selectedVoucherId) {
    body.voucher_id = window.selectedVoucherId;
  }

    fetch("/DIDONG2.0/api/routes/api.php?action=them_donhang", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${token}`
      },
      body: JSON.stringify({
        voucher_id: window.selectedVoucherId
      })
    })
      .then(res => res.json())
      .then(data => {
        alert(data.message || "Thanh toán thành công!");
        document.getElementById("delivery-modal").style.display = "none";
        document.getElementById("delivery-overlay").style.display = "none";
        window.location.reload();
      })
      .catch(() => alert("Lỗi khi thanh toán."));
  };
});