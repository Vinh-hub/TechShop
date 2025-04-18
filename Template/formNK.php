<?php
session_start();
require_once "../BackEnd/DB_driver.php";
require_once "../php/function.php";

$db = new DB_driver();
$db->connect();

// Xử lý đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $taiKhoan = $_POST['taiKhoan'] ?? '';
    $matKhau = $_POST['matKhau'] ?? '';
    $isAdmin = isset($_POST['isAdmin']) && $_POST['isAdmin'] === 'true';

    if (empty($taiKhoan) || empty($matKhau)) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin.']);
        exit();
    }

    // Kiểm tra tài khoản
    $user = $db->get_row("SELECT * FROM nguoidung WHERE TaiKhoan = ?", [$taiKhoan]);
    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'Tài khoản không tồn tại.']);
        exit();
    }

    // Kiểm tra trạng thái tài khoản
    if ($user['TrangThai'] != 1) {
        echo json_encode(['success' => false, 'message' => 'Tài khoản của bạn đã bị khóa.']);
        exit();
    }

    // Kiểm tra mật khẩu
    if (!password_verify($matKhau, $user['MatKhau'])) {
        echo json_encode(['success' => false, 'message' => 'Mật khẩu không đúng.']);
        exit();
    }

    // Lưu thông tin người dùng vào session
    $_SESSION['MaND'] = $user['MaND'];
    $_SESSION['TaiKhoan'] = $user['TaiKhoan'];
    $_SESSION['MaQuyen'] = $user['MaQuyen'];

    // Chuyển hướng sau khi đăng nhập thành công
    $redirectUrl = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : '../index.php';
    echo json_encode(['success' => true, 'redirect' => $redirectUrl]);
    exit();
}

// Xử lý đăng ký
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'signup') {
    $taiKhoan = $_POST['taiKhoan'] ?? '';
    $matKhau = $_POST['matKhau'] ?? '';
    $matKhauXacNhan = $_POST['matKhauXacNhan'] ?? '';
    $diaChi = $_POST['diaChi'] ?? '';

    if (empty($taiKhoan) || empty($matKhau) || empty($matKhauXacNhan) || empty($diaChi)) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin.']);
        exit();
    }

    if ($matKhau !== $matKhauXacNhan) {
        echo json_encode(['success' => false, 'message' => 'Mật khẩu xác nhận không khớp.']);
        exit();
    }

    // Kiểm tra tài khoản đã tồn tại chưa
    $existingUser = $db->get_row("SELECT * FROM nguoidung WHERE TaiKhoan = ?", [$taiKhoan]);
    if ($existingUser) {
        echo json_encode(['success' => false, 'message' => 'Tài khoản đã tồn tại.']);
        exit();
    }

    // Mã hóa mật khẩu
    $matKhauHash = password_hash($matKhau, PASSWORD_DEFAULT);

    // Lưu người dùng mới vào cơ sở dữ liệu
    $db->insert('nguoidung', [
        'TaiKhoan' => $taiKhoan,
        'MatKhau' => $matKhauHash,
        'DiaChi' => $diaChi,
        'MaQuyen' => 1, // Mặc định là user
        'TrangThai' => 1 // Mặc định là hoạt động
    ]);

    echo json_encode(['success' => true, 'message' => 'Đăng ký thành công! Vui lòng đăng nhập.']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTech - Điện thoại, SmartPhone chính hãng</title>
    <link rel="icon" type="image/x-icon" href="../assets/imgs/logo-tab.png">
    <link rel="stylesheet" href="../normalize.css">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/grid.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-free-6.6.0-web/fontawesome-free-6.6.0-web/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="web6713">
        <div class="modal">
            <img src="../assets/imgs/logo_white_text.png" alt="" class="modal__img">
            <div class="modal__body">
                <!-- Đăng ký -->
                <section class="auht-form" id="signUpSection" style="display: none;">
                    <div class="auth-form__container">
                        <header class="auth-form__heaader">
                            <h3 class="auth-form__header--heading">Đăng ký</h3>
                            <span class="auth-form__header--switch-btn" id="showLogin">Đăng nhập</span>
                        </header>
                        <form class="auth-form__body" id="signupForm">
                            <div class="auth_form__body">
                                <input type="text" class="auth-form__body__group--input" name="taiKhoan" placeholder="Tên tài khoản" required>
                            </div>
                            <div class="auth_form__body__group">
                                <input type="password" class="auth-form__body__group--input" name="matKhau" placeholder="Mật khẩu" required>
                            </div>
                            <div class="auth_form__body__group">
                                <input type="password" class="auth-form__body__group--input" name="matKhauXacNhan" placeholder="Nhập lại mật khẩu" required>
                            </div>
                            <div class="auth_form__body__group">
                                <input type="text" class="auth-form__body__group--input" name="diaChi" placeholder="Nhập địa chỉ" required>
                            </div>
                        </form>
                        <article class="auth-form__aside">
                            <p class="auth-form__aside-policy">
                                Bằng việc đăng ký, bạn đã đồng ý với ProTech về
                                <a href="#" class="auth-form__aside-policy--link">Điều khoản dịch vụ</a>
                                &
                                <a href="#" class="auth-form__aside-policy--link">Chính sách bảo mật</a>
                            </p>
                        </article>
                        <footer class="auth-form__controls">
                            <button class="btn auth-form__controls-back" onclick="window.location.href='../index.php'">TRỞ LẠI</button>
                            <button class="btn btn--primary" id="btn--signup">Đăng ký</button>
                        </footer>
                    </div>
                    <footer class="auth-form__socials">
                        <a href="#" class="btn btn-size-s btn-color-face btn--with-icon">
                            <i class="auth-form__socials-icon fa-brands fa-square-facebook"></i>
                            Kết nối với Facebook
                        </a>
                        <a href="#" class="btn btn-size-s btn-color-gg btn--with-icon">
                            <i class="auth-form__socials-icon fa-brands fa-google"></i>
                            Kết nối với Google
                        </a>
                    </footer>
                </section>

                <!-- Đăng nhập -->
                <section class="auht-form" id="loginSection" style="display: block;">
                    <div class="auth-form__container">
                        <header class="auth-form__heaader">
                            <h3 class="auth-form__header--heading">Đăng nhập</h3>
                            <span class="auth-form__header--switch-btn" id="showSignUp">Đăng ký</span>
                        </header>
                        <form class="auth-form__body" id="loginForm">
                            <div class="auth_form__body__group">
                                <input type="text" class="auth-form__body__group--input" name="taiKhoan" placeholder="Tên tài khoản" required>
                            </div>
                            <div class="auth_form__body__group">
                                <input type="password" class="auth-form__body__group--input" name="matKhau" id="mk" placeholder="Mật khẩu" required>
                                <i class="fas fa-eye" onclick="daoTT()"></i>
                            </div>
                        </form>
                        <article class="auth-form__aside">
                            <p class="auth-form__aside-help">
                                <a href="#" class="auth-form__aside-help-link">Quên mật khẩu</a>
                                <span class="auth-form__aside-help-link-separate"></span>
                                <a href="#" class="auth-form__aside-help-link">Cần trợ giúp?</a>
                                <span class="auth-form__aside-help-link-separate"></span>
                                <a href="#" class="auth-form__aside-help-link" id="dnAdmin">Đăng nhập với tư cách là Admin</a>
                            </p>
                        </article>
                        <footer class="auth-form__controls">
                            <button class="btn auth-form__controls-back" id="btn--returnlog" onclick="window.location.href='../index.php'">TRỞ LẠI</button>
                            <button class="btn btn--primary" id="btn--login">Đăng nhập</button>
                        </footer>
                    </div>
                    <footer class="auth-form__socials">
                        <a href="#" class="btn btn-size-s btn-color-face btn--with-icon">
                            <i class="auth-form__socials-icon fa-brands fa-square-facebook"></i>
                            Kết nối với Facebook
                        </a>
                        <a href="#" class="btn btn-size-s btn-color-gg btn--with-icon">
                            <i class="auth-form__socials-icon fa-brands fa-google"></i>
                            Kết nối với Google
                        </a>
                    </footer>
                </section>
            </div>
        </div>
        <?php addFooter('../'); ?>
    </div>
    <script src="../js/login.js"></script>
</body>
</html>