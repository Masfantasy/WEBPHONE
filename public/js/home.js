const apiUrl = "http://localhost/DIDONG2.0/api/routes/api.php";
const token = localStorage.getItem("token");

// Load danh sách sản phẩm
function loadProducts() {
  const keyword = document.getElementById("search-input").value.trim();
  const company = document.getElementById("company-filter").value;
  const minPrice = document.getElementById("min-price").value;
  const maxPrice = document.getElementById("max-price").value;

  let url = `${apiUrl}?action=search_sanpham&q=${encodeURIComponent(keyword)}`;
  if (company) url += `&company=${encodeURIComponent(company)}`;
  if (minPrice) url += `&min_price=${encodeURIComponent(minPrice)}`;
  if (maxPrice) url += `&max_price=${encodeURIComponent(maxPrice)}`;

  fetch(url)
    .then(res => res.json())
    .then(data => {
      const list = document.getElementById("product-list");
      list.innerHTML = "";
      if (data.success && data.data.length > 0) {
        data.data.forEach(sp => {
          const productId = sp.product_id || sp["id Sản Phẩm"];
          console.log('ID:', productId);
          const img = `http://localhost/DIDONG2.0/public/Pictures/Products/${sp.img || sp["Ảnh"]}`;
          const col = document.createElement("div");
          col.className = "col-md-3 mb-4";
          col.innerHTML = `
            <div class="card product-card h-100" style="cursor:pointer;">
              <img src="${img}" class="card-img-top product-img" alt="">
              <div class="card-body text-center">
                <div class="product-name">${sp.name || sp["Tên Sản Phẩm"]}</div>
                <div class="product-price mb-2">${parseInt(sp.price || sp["Giá"]).toLocaleString()}₫</div>
                <button class="btn btn-sm btn-primary add-to-cart" data-id="${productId}">🛒 Thêm vào giỏ</button>
              </div>
            </div>
          `;
          col.querySelector('.product-card').addEventListener('click', function(e) {
           if (e.target.classList.contains('add-to-cart')) return;
           window.location.href = `http://localhost/DIDONG2.0/public/index.php?page=chitietsanpham&id=${productId}`;
          });
          col.querySelector(".add-to-cart").addEventListener("click", function(e) {
          e.stopPropagation();
          addToCart(productId);
         });
          list.appendChild(col);
          });
      } else {
        list.innerHTML = "<p>Không tìm thấy sản phẩm phù hợp.</p>";
      }
    });
}

function addToCart(productId) {
  if (!token) return alert("Bạn cần đăng nhập để thêm vào giỏ hàng.");

  fetch(`${apiUrl}?action=them_vao_gio`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "Authorization": `Bearer ${token}`
    },
    body: JSON.stringify({ product_id: productId, quantity: 1 })
  })
    .then(res => res.json())
    .then(data => {
      alert(data.message || "Đã thêm vào giỏ!");
      updateCartCount();
    })
    .catch(() => alert("Lỗi khi thêm vào giỏ."));
}

function updateCartCount() {
  if (!token) return (document.getElementById("cart-count").innerText = "0");

  fetch(`${apiUrl}?action=demsoluong`, {
    headers: { "Authorization": `Bearer ${token}` }
  })
    .then(res => res.json())
    .then(data => {
      document.getElementById("cart-count").innerText = data.count || "0";
    })
    .catch(() => {
      document.getElementById("cart-count").innerText = "0";
    });
}

document.addEventListener("DOMContentLoaded", () => {
  loadProducts();
  updateCartCount();

  document.getElementById("search-input").addEventListener("input", loadProducts);
  document.getElementById("filter-btn").addEventListener("click", loadProducts);
});





