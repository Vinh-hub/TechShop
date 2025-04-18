<?php
session_start();
require_once "./BackEnd/DB_driver.php";

$db = new DB_driver();
$db->connect();

$login_errors = [];
$login_success = false;

// Tạo CSRF token nếu chưa có
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Reset số lần sai sau khi load lại (có thể bỏ nếu muốn giữ cứng hơn)
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['admin_login'])) {
    $username_input = trim($_POST['username'] ?? '');
    $password_input = trim($_POST['password'] ?? '');
    $csrf_token = $_POST['csrf_token'] ?? '';

    // Giới hạn đăng nhập sai
    if ($_SESSION['login_attempts'] >= 5) {
        $login_errors[] = "Bạn đã nhập sai quá nhiều lần. Vui lòng thử lại sau.";
    } else {
        // Kiểm tra CSRF token
        if (!hash_equals($_SESSION['csrf_token'], $csrf_token)) {
            $login_errors[] = "Yêu cầu không hợp lệ. Vui lòng tải lại trang.";
        }

        if (empty($username_input)) $login_errors[] = "Vui lòng nhập tên đăng nhập";
        if (empty($password_input)) $login_errors[] = "Vui lòng nhập mật khẩu";

        if (empty($login_errors)) {
            try {
                $user = $db->get_row("SELECT * FROM nguoidung WHERE TaiKhoan = ? AND MaQuyen IN (?, ?) AND TrangThai = ?", [$username_input, 2, 3, 1]);


                if ($user && password_verify($password_input, $user['MatKhau'])) {
                    $_SESSION['admin'] = $user;
                    $_SESSION['MaND'] = $user['MaND'];
                    $_SESSION['login_attempts'] = 0; 
                    header("Location: ./Admin/dashboard.php");
                    exit();
                } else {
                    $_SESSION['login_attempts']++;
                    $login_errors[] = "Tên đăng nhập hoặc mật khẩu không đúng";
                }
            } catch (Exception $e) {
                $login_errors[] = "Lỗi hệ thống: " . $e->getMessage();
            }
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
    <link rel="stylesheet" href="./Admin/assets/css/demo.css">
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
<form method="POST" autocomplete="off">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <div class="input-wrapper">
        <input type="text" name="username" placeholder="Tên đăng nhập"
               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
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