<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Thông Tin Người Dùng</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container">
        <h1>Điền Thông Tin Người Dùng</h1>
        
        <!-- Form để nhập thông tin người dùng -->
        <form id="userForm" action="#" method="POST">
            <div class="form-group">
                <label for="name">Tên:</label>
                <input type="text" id="name" name="name" placeholder="Nhập tên" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Số điện thoại:</label>
                <input type="text" id="phone" name="phone" placeholder="Nhập số điện thoại" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Nhập email" required>
            </div>

            <div class="form-group">
                <label for="address">Địa chỉ:</label>
                <input type="text" id="address" name="address" placeholder="Nhập địa chỉ" required>
            </div>

            <div class="form-group">
                <label for="role">Vai trò:</label>
                <select id="role" name="role" required>
                    <option value="admin">Quản trị viên</option>
                    <option value="user">Người dùng</option>
                    <option value="manager">Quản lý</option>
                </select>
            </div>
            <button type="submit" class="submit-btn">Gửi</button>
        </form>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
    // Lấy form và nút submit
    const form = document.getElementById('userForm');

    // Lắng nghe sự kiện submit của form
    form.addEventListener('submit', function(event) {
        // Ngăn chặn hành động mặc định (tải lại trang khi submit form)
        event.preventDefault();

        // Lấy các giá trị từ các input
        const name = document.getElementById('name').value;
        const phone = document.getElementById('phone').value;
        const email = document.getElementById('email').value;
        const address = document.getElementById('address').value;
        const role = document.getElementById('role').value;

        // Kiểm tra xem có giới tính nào được chọn không
        const genderRadio = document.querySelector('input[name="gender"]:checked');

        // Hiển thị thông báo alert
        alert(`Thông tin đã được gửi:
            Tên: ${name}
            Số điện thoại: ${phone}
            Email: ${email}
            Địa chỉ: ${address}
            Vai trò: ${role}
    `);
    window.location.href = "Quanlinguoidung.php"; // Thay "quanlynguoidung.phpl" bằng đường dẫn trang của bạn
    });
});


    </script>

    <style>
        /* Thiết lập kiểu chữ chung và margin */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f7f8fa;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    color: #333;
}

/* Container chính */
.container {
    width: 80%;
    max-width: 600px;
    margin: 50px auto;
    padding: 40px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Tiêu đề */
h1 {
    text-align: center;
    color: #333;
    font-size: 28px;
    margin-bottom: 20px;
}

/* Các nhóm input */
.form-group {
    margin-bottom: 20px;
}

.form-group label {
    font-size: 16px;
    margin-bottom: 8px;
    display: block;
}

/* Các input và select */
.form-group input, .form-group select {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 5px;
    outline: none;
}

/* Các radio button cho giới tính nằm ngang */
.gender-options {
    display: flex;
    gap: 20px;
    align-items: center;
}

.gender-options input[type="radio"] {
    width: auto;
    margin-right: 5px;
}

.gender-options label {
    margin-right: 20px;
}

/* Nút submit */
.submit-btn {
    width: 100%;
    padding: 12px;
    background-color: #3498db;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.submit-btn:hover {
    background-color: #2980b9;
}

    </style>
</body>
</html>
