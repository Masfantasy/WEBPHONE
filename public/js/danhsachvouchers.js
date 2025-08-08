const token = localStorage.getItem("token");

fetch("/DIDONG2.0/api/routes/api.php?action=danhsachvoucher", {
  headers: { "Authorization": `Bearer ${token}` }
})
  .then(res => res.json())
  .then(data => {
    const list = document.getElementById("my-voucher-list");
    if (data.data && data.data.length > 0) {
      list.innerHTML = data.data.map(v => `
        <div class="border p-3 mb-2 rounded bg-light">
          <strong>${v.code}</strong> - Giảm 
          ${v.discount_type === 'percent' ? v.discount_value + '%' : parseInt(v.discount_value).toLocaleString() + '₫'}
          <br>
          Hạn sử dụng: ${v.end_date}
          <span class="badge bg-${v.is_used == 1 ? 'secondary' : 'success'} float-end">
            ${v.is_used == 1 ? 'Đã dùng' : 'Chưa dùng'}
          </span>
        </div>
      `).join('');
    } else {
      list.innerHTML = `<div class="alert alert-info">Bạn chưa thu thập voucher nào.</div>`;
    }
  })
  .catch(() => {
    document.getElementById("my-voucher-list").innerHTML = `<div class="alert alert-danger">Không thể tải danh sách.</div>`;
  });