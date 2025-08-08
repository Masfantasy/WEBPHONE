document.addEventListener("DOMContentLoaded", function () {
  const token = localStorage.getItem("token");

  // Khi click chọn voucher
  document.getElementById("open-voucher-modal").onclick = function () {
    const modal = new bootstrap.Modal(document.getElementById("voucherModal"));
    modal.show();
   document.getElementById("delivery-modal").style.display = "none";
  document.getElementById("delivery-overlay").style.display = "none";
    // Gọi API lấy voucher
    fetch("/DIDONG2.0/api/routes/api.php?action=danhsachvoucher", {
      method: "GET",
      headers: { "Authorization": `Bearer ${token}` }
    })
      .then(res => res.json())
      .then(data => {
        const list = document.getElementById("voucher-list");
        if (data.data && data.data.length > 0) {
          list.innerHTML = data.data.map(v => `
            <div class="form-check">
              <input class="form-check-input" type="radio" name="voucher" id="voucher-${v.voucher_id}" value="${v.voucher_id}">
              <label class="form-check-label" for="voucher-${v.voucher_id}">
                🎟 ${v.code} - Giảm ${v.discount_type === 'percent' ? v.discount_value + '%' : parseInt(v.discount_value).toLocaleString() + '₫'}
              </label>
            </div>
          `).join('');
        } else {
          list.innerHTML = `<div class="alert alert-warning">Không có voucher nào khả dụng.</div>`;
        }
      });
  };
  let selectedVoucherId = null;
  let selectedVoucherText = null; 
  // Xác nhận chọn voucher
  document.getElementById("confirm-voucher-btn").onclick = function () {
   const checked = document.querySelector('input[name="voucher"]:checked');
  if (checked) {
    selectedVoucherId = checked.value;
    selectedVoucherText = checked.parentElement.innerText.trim();

    // Hiển thị tên voucher đã chọn lên giao diện
    document.getElementById("selected-voucher-text").innerText = selectedVoucherText;

    // Đóng modal voucher
    var modal = bootstrap.Modal.getInstance(document.getElementById('voucherModal'));
    if (modal) modal.hide();

    document.getElementById("delivery-modal").style.display = "block";
  document.getElementById("delivery-overlay").style.display = "block";
  } else {
    alert("Bạn chưa chọn voucher!");
  }
  };

  document.querySelector("#voucherModal .btn-secondary").onclick = function () {
  var voucherModal = bootstrap.Modal.getInstance(document.getElementById('voucherModal'));
  if (voucherModal) voucherModal.hide();
  // Hiện lại modal giao nhận
  document.getElementById("delivery-modal").style.display = "block";
  document.getElementById("delivery-overlay").style.display = "block";
};
});