<?php
session_start();
require_once "../BackEnd/DB_driver.php";
require_once "../php/function.php";

$db = new DB_driver();
$db->connect();

// Kiểm tra đăng nhập
if (!isset($_SESSION['MaND'])) {
    $_SESSION['redirect_url'] = 'Template/Information.php';
    header("Location: formNK.php");
    exit();
}

$maND = $_SESSION['MaND'];

// Lấy thông tin khách hàng từ bảng khachhang
$khachHang = $db->get_row("SELECT * FROM khachhang WHERE MaND = ?", [$maND]);
if (!$khachHang) {
    // Nếu chưa có thông tin khách hàng, tạo mới
    $db->insert('khachhang', ['MaND' => $maND]);
    $khachHang = $db->get_row("SELECT * FROM khachhang WHERE MaND = ?", [$maND]);
}

// Xử lý cập nhật thông tin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hoTen = $_POST['hoTen'] ?? '';
    $nickname = $_POST['nickname'] ?? '';
    $email = $_POST['email'] ?? '';
    $sdt = $_POST['sdt'] ?? '';
    $ngay = $_POST['ngay'] ?? '';
    $thang = $_POST['thang'] ?? '';
    $nam = $_POST['nam'] ?? '';
    $gioiTinh = $_POST['gender'] ?? 'Nam';
    $diaChi = $_POST['diaChi'] ?? '';
    $quocTich = $_POST['quocTich'] ?? '';

    // Kiểm tra định dạng email
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email không hợp lệ.";
    } else {
        // Kiểm tra định dạng số điện thoại
        if (!empty($sdt) && !preg_match('/^[0-9]{10,15}$/', $sdt)) {
            $error = "Số điện thoại không hợp lệ.";
        } else {
            // Tạo ngày sinh
            $ngaySinh = null;
            if ($ngay && $thang && $nam) {
                $ngaySinh = "$nam-$thang-$ngay";
            }

            // Cập nhật thông tin khách hàng
            $db->update('khachhang', [
                'HoTen' => $hoTen,
                'Nickname' => $nickname,
                'Email' => $email,
                'SDT' => $sdt,
                'NgaySinh' => $ngaySinh,
                'GioiTinh' => $gioiTinh,
                'DiaChi' => $diaChi,
                'QuocTich' => $quocTich
            ], "MaND = ?", [$maND]);

            // Cập nhật lại thông tin khách hàng
            $khachHang = $db->get_row("SELECT * FROM khachhang WHERE MaND = ?", [$maND]);
            $success = "Cập nhật thông tin thành công!";
        }
    }
}

// Tách ngày sinh để hiển thị
$ngaySinh = $khachHang['NgaySinh'] ? new DateTime($khachHang['NgaySinh']) : null;
$ngay = $ngaySinh ? $ngaySinh->format('d') : '';
$thang = $ngaySinh ? $ngaySinh->format('m') : '';
$nam = $ngaySinh ? $ngaySinh->format('Y') : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTech - Mua hàng Online giá rẻ</title>
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
        <div class="header_first"></div>
        <?php addHeader('../'); ?>
        <nav class="mobile-category"></nav>
        <section class="container">
            <div class="grid wide">
                <div class="row">
                    <div class="col l-2 m-0 c-0">
                        <nav class="container__category">
                            <span class="header__category">Danh mục</span>
                            <ul class="category__list">
                                <li class="category__item">
                                    <a href="Information.php" class="category__item-link">
                                        <i class="category__item-icon fa-regular fa-user"></i>
                                        Thông tin tài khoản
                                    </a>
                                </li>
                                <li class="category__item">
                                    <a href="Noti.php" class="category__item-link">
                                        <i class="category__item-icon fa-regular fa-envelope"></i>
                                        Thông báo của tôi
                                    </a>
                                </li>
                                <li class="category__item">
                                    <a href="Orders.php" class="category__item-link">
                                        <i class="category__item-icon fa-solid fa-list"></i>
                                        Lịch sử mua hàng
                                    </a>
                                </li>
                                <li class="category__item">
                                    <a href="Return.php" class="category__item-link">
                                        <i class="category__item-icon fa-solid fa-rotate-left"></i>
                                        Quản lý đổi trả
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <button type="button" class="logout_button">Đăng xuất</button>
                    </div>
                    <div class="col l-10 m-12 c-12">
                        <div class="information-page">
                            <div class="information-heading">
                                <h3>Thông tin tài khoản</h3>
                            </div>
                            <div class="information-left">
                                <div class="styles__StyledAccountInfo-sc-s5c7xj-2 khBVOu">
                                    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
                                    <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>
                                    <form method="POST">
                                        <div class="form-info">
                                            <div class="form-name">
                                                <div class="form-control">
                                                    <label class="input-label">Họ & Tên</label>
                                                    <div>
                                                        <div class="styles__StyledInput-sc-s5c7xj-5 hisWEc">
                                                            <input class="input" type="text" name="hoTen" maxlength="128" placeholder="Thêm họ tên" value="<?php echo htmlspecialchars($khachHang['HoTen'] ?? ''); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-control">
                                                    <label class="input-label">Tên tài khoản</label>
                                                    <div>
                                                        <div class="styles__StyledInput-sc-s5c7xj-5 hisWEc">
                                                            <input class="input" type="text" name="nickname" maxlength="128" placeholder="Thêm nickname" value="<?php echo htmlspecialchars($khachHang[''] ?? ''); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-control">
                                            <label class="input-label">Email</label>
                                            <div>
                                                <div class="styles__StyledInput-sc-s5c7xj-5 hisWEc">
                                                    <input class="input" type="email" name="email" maxlength="128" placeholder="Thêm email" value="<?php echo htmlspecialchars($khachHang['Email'] ?? ''); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-control">
                                            <label class="input-label">SĐT</label>
                                            <div>
                                                <div class="styles__StyledInput-sc-s5c7xj-5 hisWEc">
                                                    <input class="input" type="text" name="sdt" maxlength="15" placeholder="Thêm số điện thoại" value="<?php echo htmlspecialchars($khachHang['SDT'] ?? ''); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-control">
                                            <label class="input-label">Ngày sinh</label>
                                            <div class="style__StyledBirthdayPicker-sc-1325vtm-0 bvIJNZ">
                                                <select name="ngay">
                                                    <option value="0">Ngày</option>
                                                    <?php for ($i = 1; $i <= 31; $i++) {
                                                        $selected = ($ngay == $i) ? 'selected' : '';
                                                        echo "<option value='$i' $selected>$i</option>";
                                                    } ?>
                                                </select>
                                                <select name="thang">
                                                    <option value="0">Tháng</option>
                                                    <?php for ($i = 1; $i <= 12; $i++) {
                                                        $selected = ($thang == $i) ? 'selected' : '';
                                                        echo "<option value='$i' $selected>$i</option>";
                                                    } ?>
                                                </select>
                                                <select name="nam">
                                                    <option value="0">Năm</option>
                                                    <?php for ($i = 2024; $i >= 1975; $i--) {
                                                        $selected = ($nam == $i) ? 'selected' : '';
                                                        echo "<option value='$i' $selected>$i</option>";
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-control">
                                            <label class="input-label">Giới tính</label>
                                            <label class="Radio__StyledRadio-sc-1tpsfw1-0 eQckrx">
                                                <input style="width: 100%;" type="radio" name="gender" value="Nam" <?php echo ($khachHang['GioiTinh'] == 'Nam') ? 'checked' : ''; ?>>
                                                <span class="label">Nam</span>
                                            </label>
                                            <label class="Radio__StyledRadio-sc-1tpsfw1-0 eQckrx">
                                                <input style="width: 100%;" type="radio" name="gender" value="Nu" <?php echo ($khachHang['GioiTinh'] == 'Nu') ? 'checked' : ''; ?>>
                                                <span class="label">Nữ</span>
                                            </label>
                                            <label class="Radio__StyledRadio-sc-1tpsfw1-0 eQckrx">
                                                <input style="width: 100%;" type="radio" name="gender" value="Khac" <?php echo ($khachHang['GioiTinh'] == 'Khac') ? 'checked' : ''; ?>>
                                                <span class="label">Khác</span>
                                            </label>
                                        </div>
                                        <div class="form-control">
                                            <label class="input-label">Địa chỉ</label>
                                            <div>
                                                <div class="styles__StyledInput-sc-s5c7xj-5 hisWEc">
                                                    <input class="input" type="text" name="diaChi" maxlength="128" placeholder="Thêm địa chỉ" value="<?php echo htmlspecialchars($khachHang['DiaChi'] ?? ''); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-control">
                                            <label class="input-label">Quốc tịch</label>
                                            <div>
                                                <div class="styles__StyledInput-sc-s5c7xj-5 hisWEc">
                                                    <input class="input" type="text" name="quocTich" maxlength="128" placeholder="Thêm quốc tịch" value="<?php echo htmlspecialchars($khachHang['QuocTich'] ?? ''); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-control">
                                            <label class="input-label"> </label>
                                            <label class="input-label"> </label>
                                            <button type="submit" class="styles__StyledBtnSubmit-sc-s5c7xj-3 cqEaiM btn-submit">Lưu thay đổi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php addFooter('../'); ?>
    </div>
    <script src="Information.js"></script>
    <script src="../js/cart.js"></script>
    <script src="../js/logout.js"></script>
    
</body>
</html>