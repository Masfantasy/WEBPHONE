 // Lấy token từ localStorage
    const token = localStorage.getItem("token");

    // 1. Lấy thông tin cá nhân
    fetch("/DIDONG2.0/api/routes/api.php?action=show_tt_khachhang", {
      method: "GET",
      headers: { "Authorization": "Bearer " + token }
    })
      .then(res => res.json())
      .then(data => {
        if (data.success && data.data) {
          document.getElementById("username").value = data.data.username || "";
          document.getElementById("name").value = data.data.name || "";
          document.getElementById("email").value = data.data.email || "";
          document.getElementById("phone").value = data.data.phone || "";
          document.getElementById("address").value = data.data.address || "";
        } else {
          document.getElementById("profile-msg").innerHTML = "<span class='text-danger'>Không lấy được thông tin cá nhân.</span>";
        }
      })
      .catch(() => {
        document.getElementById("profile-msg").innerHTML = "<span class='text-danger'>Lỗi khi tải thông tin.</span>";
      });

    // 2. Sửa thông tin cá nhân
    document.getElementById("profile-form").addEventListener("submit", function(e) {
      e.preventDefault();

      const name = document.getElementById("name").value.trim();
      const email = document.getElementById("email").value.trim();
      const phone = document.getElementById("phone").value.trim();
      const address = document.getElementById("address").value.trim();

      fetch("/DIDONG2.0/api/routes/api.php?action=sua_tt_khachhang", {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
          "Authorization": "Bearer " + token
        },
        body: JSON.stringify({ name, email, phone, address })
      })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            document.getElementById("profile-msg").innerHTML = "<span class='text-success'>Cập nhật thành công!</span>";
          } else {
            document.getElementById("profile-msg").innerHTML = "<span class='text-danger'>" + (data.message || "Cập nhật thất bại.") + "</span>";
          }
        })
        .catch(() => {
          document.getElementById("profile-msg").innerHTML = "<span class='text-danger'>Lỗi khi cập nhật.</span>";
        });
    });