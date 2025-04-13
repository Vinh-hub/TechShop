<?php
session_start();
require_once "BackEnd/DB_driver.php";

$db = new DB_driver();
$db->connect();

// Xử lý đăng nhập admin
$login_errors = [];
$login_success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['admin_login'])) {
    $username_input = trim($_POST['username'] ?? '');
    $password_input = trim($_POST['password'] ?? '');

    if (empty($username_input)) $login_errors[] = "Vui lòng nhập tên đăng nhập";
    if (empty($password_input)) $login_errors[] = "Vui lòng nhập mật khẩu";

    if (empty($login_errors)) {
        try {
            // Sửa tên bảng từ 'users' thành 'nguoidung'
            $user = $db->get_row("SELECT * FROM nguoidung WHERE TaiKhoan = ? AND MaQuyen = ? AND TrangThai = ?", [$username_input, 2, 1]);

            if ($user && password_verify($password_input, $user['MatKhau'])) {
                $_SESSION['admin'] = $user;
                $login_success = true;
                header("Location: ./Admin/dashboard.php");
                exit();
            } else {
                $login_errors[] = "Tên đăng nhập hoặc mật khẩu không đúng";
            }
        } catch (Exception $e) {
            $login_errors[] = "Lỗi hệ thống: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTech - Đăng nhập Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* CSS cho trang đăng nhập, đồng bộ với dashboard.php */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .login-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .login-box {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-box h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #333;
        }
        .login-box input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
        }
        .login-box button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 1.1rem;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .login-box button:hover {
            background-color: #0056b3;
        }
        .login-box .error {
            color: #dc3545;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }
        .input-wrapper {
            position: relative;
        }
        .input-wrapper i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }
        .end__heading-end {
        position: fixed; /* Cố định footer ở cuối trang */
        bottom: 0;
        left: 0;
        width: 100%;
        height:50px;
        background-color: #f1f1f1; /* Màu nền nhẹ cho footer */
        text-align: center; /* Căn giữa nội dung trong footer */
        padding: 10px 0; /* Thêm khoảng cách trên và dưới cho footer */
        font-size: 14px; /* Kích thước chữ nhỏ hơn */
        color: #333; /* Màu chữ tối */
        }

        /* Group thông tin trong footer */
        .end__heading-end-information-group {
        display: flex;
        flex-direction: column; /* Đặt các phần tử thành cột */
        align-items: center; /* Căn giữa các phần tử theo chiều ngang */
        }

        /* Thông tin trong footer */
        .end__heading-end-information {
        margin: 5px 0; /* Thêm khoảng cách giữa các dòng */
        }

        /* Tên công ty nổi bật */
        .end__heading-end-information-name {
        font-weight: bold;
        font-size: 16px; /* Lớn hơn một chút so với các thông tin khác */
        }

    </style>
</head>
<body>
    <!-- Form đăng nhập admin -->
    <div class="login-container">
        <div class="login-box">
            <h2>Đăng nhập Admin</h2>
            <?php if (!empty($login_errors)): ?>
                <div class="error">
                    <?= implode('<br>', $login_errors) ?>
                </div>
            <?php endif; ?>
            <form method="POST">
                <div class="input-wrapper">
                    <input type="text" name="username" placeholder="Tên đăng nhập" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
                </div>
                <div class="input-wrapper">
                    <input type="password" name="password" id="password" placeholder="Mật khẩu" required>
                    <i class="fas fa-eye eye-icon" onclick="togglePassword(this)"></i>
                </div>
                <button type="submit" name="admin_login">Đăng nhập</button>
            </form>
        </div>
    </div>

    <!-- Footer từ dashboard.php -->
    <footer class="end__heading-end">
        <div class="end__heading-end-information-group">
            <span class="end__heading-end-information end__heading-end-information-name"><b>CÔNG TY PROTECH</b></span>
            <span class="end__heading-end-information">© 2024 - Bản quyền thuộc về Công ty ProTech</span>
        </div>
    </footer>

    <script>
        // Toggle hiển thị mật khẩu
        function togglePassword(icon) {
            const input = icon.previousElementSibling;
            const type = input.getAttribute("type") === "password" ? "text" : "password";
            input.setAttribute("type", type);
            icon.classList.toggle("fa-eye");
            icon.classList.toggle("fa-eye-slash");
        }

        // Ẩn/hiện icon mắt khi nhập mật khẩu
        document.querySelectorAll('.input-wrapper input[type="password"]').forEach(input => {
            const icon = input.nextElementSibling;
            icon.style.display = 'none';

            input.addEventListener('input', () => {
                icon.style.display = input.value ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>