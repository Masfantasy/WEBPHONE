document.getElementById("register-form").addEventListener("submit", function(e) {
      e.preventDefault();
        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim();
        const phone = document.getElementById("phone").value.trim();
        const address = document.getElementById("address").value.trim();
        const is_active = 1;
        const username = document.getElementById("username").value.trim();
        const password = document.getElementById("password").value.trim();
        const repassword = document.getElementById("repassword").value.trim();
        const errorMsg = document.getElementById("error-msg");
        if (password !== repassword) {
        errorMsg.innerText = "Mật khẩu nhập lại không khớp.";
        return;
    }
        if (!email.includes("@") || !email.includes(".")) {
      errorMsg.innerText = "Email không hợp lệ.";
      return;
    }
    if (password.length < 6) {
    errorMsg.innerText = "Mật khẩu phải có ít nhất 6 ký tự.";
    return;
    }
    if (isNaN(phone)) {
    errorMsg.innerText = "Số điện thoại phải là số.";
    return;
    }

      fetch("/DIDONG2.0/api/routes/api.php?action=register", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ 
          name,
          email,
          phone,
          address,
          username,
          password,
          is_active
  })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
        alert("Đăng ký thành công! Vui lòng đăng nhập.");
        window.location.href = "http://localhost/DIDONG2.0/public/index.php?page=login";
        } else {
            errorMsg.innerText = data.message || "Đăng ký thất bại";
        }
      })
      .catch(err => {
        console.error(err);
        document.getElementById("error-msg").innerText = "Lỗi kết nối tới server.";
      });
    });