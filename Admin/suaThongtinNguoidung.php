<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Chỉnh Sửa Thông Tin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f9;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555555;
        }

        .form-group input, 
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-group input:focus, 
        .form-group select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-actions button {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .form-actions .btn-submit {
            background-color: #007bff;
            color: #ffffff;
        }

        .form-actions .btn-cancel {
            background-color: #6c757d;
            color: #ffffff;
        }

        .form-actions .btn-submit:hover {
            background-color: #0056b3;
        }

        .form-actions .btn-cancel:hover {
            background-color: #5a6268;
        }
    </style>
    <script>

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        
        // Lắng nghe sự kiện submit form
        form.addEventListener('submit', function(event) {
            event.preventDefault();  // Ngừng gửi form mặc định

            // Hiển thị thông báo alert
            alert('Thông tin đã được lưu thành công!');
            
            // Quay về trang Quanlinguoidung.php
            window.location.href = 'Quanlinguoidung.php';
        });

        // Lắng nghe sự kiện click vào nút hủy
        const cancelButton = document.querySelector('.btn-cancel');
        cancelButton.addEventListener('click', function() {
            // Quay về trang Quanlinguoidung.php mà không có thông báo
            window.location.href = 'Quanlinguoidung.php';
        });
    });


    </script>
</head>
<body>
    <div class="form-container">
        <h2>Chỉnh Sửa Thông Tin</h2>
        <form action="#" method="POST">
            <div class="form-group">
                <label for="name">Tên:</label>
                <input type="text" id="name" name="name" placeholder="Nhập tên của bạn" value="Trần Thị Ngọc" required>
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ:</label>
                <input type="text" id="address" name="address" placeholder="Nhập địa chỉ của bạn" value="45, Long Hòa, Cần Đước, Long An" required>
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại:</label>
                <input type="tel" id="phone" name="phone" placeholder="Nhập số điện thoại của bạn" value="0987654321" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Nhập email của bạn" value="b@example.com" required>
            </div>
            <div class="form-group">
                <label for="role">Vai trò:</label>
                <select id="role" name="role" required>
                    <option value="">-- Chọn vai trò --</option>
                    <option value="admin">Quản trị viên</option>
                    <option value="editor">Admin</option>
                    <option value="user" selected>Khách hàng</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-submit">Lưu Thay Đổi</button>
                <button type="button" class="btn-cancel">Hủy</button>
            </div>
        </form>
    </div>
</body>
</html>