const token = localStorage.getItem("token");

fetch("/DIDONG2.0/api/routes/api.php?action=hienthivouchers", {
  headers: { "Authorization": `Bearer ${token}` }
})
  .then(res => res.json())
  .then(data => {
    const list = document.getElementById("voucher-list");
    if (data.data && data.data.length > 0) {
      list.innerHTML = data.data.map(v => `
        <div class="border p-3 mb-2 rounded bg-light">
          <strong>${v.code}</strong> - 
          Giảm ${v.discount_type === 'percent' ? v.discount_value + '%' : parseInt(v.discount_value).toLocaleString() + '₫'} <br>
          Hạn: ${v.end_date}
          <button class="btn btn-sm btn-primary float-end thu-btn" data-id="${v.voucher_id}">Thu thập</button>
        </div>
      `).join('');
    } else {
      list.innerHTML = `<div class="alert alert-warning">Không có voucher nào khả dụng.</div>`;
    }

    document.querySelectorAll(".thu-btn").forEach(btn => {
      btn.addEventListener("click", () => {
        const voucher_id = btn.getAttribute("data-id");
        fetch("/DIDONG2.0/api/routes/api.php?action=thuthapvouchers", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`
          },
          body: JSON.stringify({ voucher_id })
        })
        .then(res => res.json())
        .then(result => {
          alert(result.message || "Đã thu thập voucher");
          location.reload();
        });
      });
    });
  })
  .catch(err => {
  console.error("LỖI FETCH:", err);
  document.getElementById("voucher-list").innerHTML = `<div class="alert alert-danger">Hiện không có voucher khả dụng để thu thập</div>`;
});

