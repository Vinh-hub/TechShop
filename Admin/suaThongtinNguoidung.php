<?php
session_start();
require_once "../BackEnd/DB_driver.php";

// Kiểm tra đăng nhập và quyền admin (MaQuyen = 3)
if (!isset($_SESSION['MaND'])) {
    $_SESSION['error'] = "Vui lòng đăng nhập.";
    file_put_contents('debug.log', "Redirect to login.php from suaThongtinNguoidung.php at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
    header("Location: ../login.php");
    exit();
}

$db = new DB_driver();
$db->connect();

try {
    $user = $db->get_row("SELECT * FROM nguoidung WHERE MaND = ?", [$_SESSION['MaND']]);
    if (!$user || $user['MaQuyen'] != 3) {
        $_SESSION['error'] = !$user ? "Người dùng không tồn tại." : "Bạn không có quyền admin.";
        file_put_contents('debug.log', "Redirect to index.php from suaThongtinNguoidung.php at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
        header("Location: ../index.php");
        exit();
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Lỗi DB: " . $e->getMessage();
    file_put_contents('debug.log', "Redirect to index.php: DB error in suaThongtinNguoidung.php at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
    header("Location: ../index.php");
    exit();
}

// Lấy thông tin người dùng cần sửa
if (!isset($_GET['MaND']) || !is_numeric($_GET['MaND'])) {
    $_SESSION['error'] = "Không tìm thấy người dùng.";
    header("Location: Quanlinguoidung.php");
    exit();
}

$maND = (int)$_GET['MaND'];
$editUser = $db->get_row("SELECT * FROM nguoidung WHERE MaND = ?", [$maND]);
if (!$editUser) {
    $_SESSION['error'] = "Người dùng không tồn tại.";
    header("Location: Quanlinguoidung.php");
    exit();
}

// Xử lý form chỉnh sửa
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taiKhoan = trim($_POST['tai_khoan'] ?? '');
    // $hoTen = trim($_POST['ho_ten'] ?? '');
    $email = trim($_POST['email'] ?? '');
    // $soDienThoai = trim($_POST['so_dien_thoai'] ?? '');
    $diaChi = trim($_POST['dia_chi'] ?? '');
    $matKhau = trim($_POST['mat_khau'] ?? '');
    $maQuyen = $_POST['ma_quyen'] ?? '';

    // Kiểm tra dữ liệu
    if (empty($taiKhoan)) $errors[] = "Tài khoản không được để trống.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email không hợp lệ.";
    // if (!empty($soDienThoai) && !preg_match('/^[0-9]{10,11}$/', $soDienThoai)) $errors[] = "Số điện thoại không hợp lệ.";
    $roleMap = ['user' => 1, 'manager' => 2, 'admin' => 3, 'locked' => 5];
    if (!isset($roleMap[$maQuyen])) $errors[] = "Vai trò không hợp lệ.";

    // Kiểm tra trùng lặp (trừ chính người dùng đang sửa)
    $existingUser = $db->get_row("SELECT * FROM nguoidung WHERE (TaiKhoan = ? OR Email = ?) AND MaND != ?", [$taiKhoan, $email, $maND]);
    if ($existingUser) $errors[] = "Tài khoản hoặc email đã tồn tại.";

    // Cập nhật dữ liệu
    $data = [
        'TaiKhoan' => $taiKhoan,
        // 'HoTen' => $hoTen ?: null,
        'Email' => $email,
        // 'SoDienThoai' => $soDienThoai ?: null,
        'DiaChi' => $diaChi ?: null,
        'MaQuyen' => $roleMap[$maQuyen]
    ];
    if (!empty($matKhau)) {
        $data['MatKhau'] = password_hash($matKhau, PASSWORD_DEFAULT);
    }

    // Cập nhật nếu không có lỗi
    if (empty($errors)) {
        try {
            $result = $db->update('nguoidung', $data, 'MaND = ?', [$maND]);
            if ($result) {
                $_SESSION['message'] = "Cập nhật người dùng thành công!";
                header("Location: Quanlinguoidung.php");
                exit();
            } else {
                $errors[] = "Lỗi khi cập nhật người dùng.";
            }
        } catch (Exception $e) {
            $errors[] = "Lỗi: " . $e->getMessage();
        }
    }
}

$db->dis_connect();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTech - Sửa Thông Tin Người Dùng</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="/TechShop/assets/css/Dashboard.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f8fa;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            color: #333;
        }
        .container {
            width: 80%;
            max-width: 600px;
            margin: 50px auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            font-family: 'Montserrat', sans-serif;
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
        }
        .form-group input:focus,
        .form-group select:focus {
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .form-actions button {
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-submit {
            background-color: #3498db;
            color: white;
            width: 48%;
        }
        .btn-submit:hover {
            background-color: #2980b9;
        }
        .btn-cancel {
            background-color: #6c757d;
            color: white;
            width: 48%;
        }
        .btn-cancel:hover {
            background-color: #5a6268;
        }
        .error {
            color: #dc3545;
            font-size: 0.9rem;
            margin-bottom: 10px;
            text-align: center;
        }
        footer {
            margin-top: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sửa Thông Tin Người Dùng</h1>
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?= implode('<br>', array_map('htmlspecialchars', $errors)) ?>
            </div>
        <?php endif; ?>
        <form id="userForm" method="POST">
            <div class="form-group">
                <label for="tai_khoan">Tài khoản:</label>
                <input type="text" id="tai_khoan" name="tai_khoan" placeholder="Nhập tài khoản" value="<?= htmlspecialchars($editUser['TaiKhoan'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Nhập email" value="<?= htmlspecialchars($editUser['Email'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="dia_chi">Địa chỉ:</label>
                <input type="text" id="dia_chi" name="dia_chi" placeholder="Nhập địa chỉ" value="<?= htmlspecialchars($editUser['DiaChi'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="mat_khau">Mật khẩu mới (để trống nếu không đổi):</label>
                <input type="password" id="mat_khau" name="mat_khau" placeholder="Nhập mật khẩu mới">
            </div>
            <div class="form-group">
                <label for="ma_quyen">Vai trò:</label>
                <select id="ma_quyen" name="ma_quyen" required>
                    <option value="user" <?= $editUser['MaQuyen'] == 1 ? 'selected' : '' ?>>Khách hàng</option>
                    <option value="manager" <?= $editUser['MaQuyen'] == 2 ? 'selected' : '' ?>>Quản trị viên</option>
                    <option value="admin" <?= $editUser['MaQuyen'] == 3 ? 'selected' : '' ?>>Admin</option>
                    <option value="locked" <?= $editUser['MaQuyen'] == 5 ? 'selected' : '' ?>>Khóa</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-submit">Lưu thay đổi</button>
                <button type="button" class="btn-cancel" onclick="window.location.href='Quanlinguoidung.php'">Hủy</button>
            </div>
        </form>
    </div>

    <!-- <footer class="end__heading-end">
        <div class="end__heading-end-information-group">
            <span class="end__heading-end-information end__heading-end-information-name"><b>CÔNG TY PROTECH</b></span>
            <span class="end__heading-end-information">© 2024 - Bản quyền thuộc về Công ty ProTech</span>
        </div>
    </footer> -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById('userForm');
            form.addEventListener('submit', function(event) {
                // Xử lý form ở server-side, không cần alert
            });
        });
    </script>
</body>
</html>