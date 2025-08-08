    document.getElementById("login-form").addEventListener("submit", function(e) {
      e.preventDefault();
      const username = document.getElementById("username").value.trim();
      const password = document.getElementById("password").value.trim();

      fetch("/DIDONG2.0/api/routes/api.php?action=login", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ username, password })
      })
      .then(res => res.json())
      .then(data => {
        if (data.token) {
          // ✅ Lưu token vào localStorage
          localStorage.setItem("token", data.token);
          alert("Đăng nhập thành công!");
          // ✅ Điều hướng sang trang đơn hàng
          window.location.href = "http://localhost/DIDONG2.0/public/index.php";
        } else {
          document.getElementById("error-msg").innerText = data.message || "Sai tài khoản hoặc mật khẩu";
        }
      })
      .catch(err => {
        console.error(err);
        document.getElementById("error-msg").innerText = "Lỗi kết nối tới server.";
      });
    });
