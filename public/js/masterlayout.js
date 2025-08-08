document.addEventListener('DOMContentLoaded', function () {
  // === LẤY TOKEN ===
  window.token = localStorage.getItem("token");

  // === PHẦN TỬ MENU ===
  const userToggle = document.getElementById('user-menu-toggle');
  const userMenu = document.getElementById('user-menu');
  const loginLink = document.querySelector('#user-menu a[href*="page=login"]');
  const registerLink = document.querySelector('#user-menu a[href*="page=register"]');
  const profileLink = document.getElementById("profile-link");
  const logoutBtn = document.getElementById("logout-btn");

  // === TOGGLE HIỆN/ẨN MENU NGƯỜI DÙNG ===
  if (userToggle && userMenu) {
    userToggle.addEventListener('click', function () {
      userMenu.style.display = (userMenu.style.display === 'block') ? 'none' : 'block';
    });

    document.addEventListener('click', function (event) {
      if (!userMenu.contains(event.target) && !userToggle.contains(event.target)) {
        userMenu.style.display = 'none';
      }
    });
  }

  // === ẨN/HIỆN LINK DỰA TRÊN TOKEN ===
  const isLoggedIn = !!window.token;

  if (loginLink) loginLink.style.display = isLoggedIn ? "none" : "block";
  if (registerLink) registerLink.style.display = isLoggedIn ? "none" : "block";
  if (profileLink) profileLink.style.display = isLoggedIn ? "block" : "none";
  if (logoutBtn) logoutBtn.style.display = isLoggedIn ? "block" : "none";

  // === XỬ LÝ ĐĂNG XUẤT ===
    logoutBtn.addEventListener("click", function (e) {
        e.preventDefault();
        localStorage.removeItem("token");
        alert("Đăng xuất thành công!");
        window.location.href = "http://localhost/DIDONG2.0/public/index.php";
    });
    updateCartCount();
});
function updateCartCount() {
  if (!token) return (document.getElementById("cart-count").innerText = "0");

  fetch(`/DIDONG2.0/api/routes/api.php?action=demsoluong`, {
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
