<?php
session_start();
require_once "../BackEnd/DB_driver.php";
require_once "../php/function.php";

$db = new DB_driver();
$db->connect();

// Kiểm tra đăng nhập
if (!isset($_SESSION['MaND'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location:./Template/formNK.php");
    exit();
}

$maND = $_SESSION['MaND'];

// Lấy danh sách sản phẩm trong giỏ hàng
$cartItems = $db->get_list(
    "SELECT g.MaGH, g.MaSP, g.SoLuong, s.TenSP, s.DonGia, s.PhanTramGiam, s.HinhAnh 
     FROM giohang g 
     JOIN sanpham s ON g.MaSP = s.MaSP 
     WHERE g.MaND = ?",
    [$maND]
);

if (empty($cartItems)) {
    header("Location: ./giohang.php");
    exit();
}

// Tính tổng giá dựa trên giá mới (sau khi giảm giá)
$totalPrice = 0;
foreach ($cartItems as $item) {
    $giaMoi = !empty($item['PhanTramGiam']) && $item['PhanTramGiam'] > 0 && $item['PhanTramGiam'] < 100
        ? $item['DonGia'] * (1 - ($item['PhanTramGiam'] / 100))
        : $item['DonGia'];
    $totalPrice += $giaMoi * $item['SoLuong'];
}

// Xử lý đặt hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hoTen = $_POST['hoTen'] ?? '';
    $soDienThoai = $_POST['soDienThoai'] ?? '';
    $email = $_POST['email'] ?? '';
    $phuongThucGiaoHang = $_POST['phuongThucGiaoHang'] ?? '';
    $mien = $_POST['mien'] ?? '';
    $tinh = $_POST['tinh'] ?? '';
    $quan = $_POST['quan'] ?? '';
    $yeuCauKhac = $_POST['yeuCauKhac'] ?? '';
    $phuongThucThanhToan = $_POST['phuongThucThanhToan'] ?? '';

    // Kiểm tra thông tin bắt buộc
    if (empty($hoTen) || empty($soDienThoai) || empty($email) || empty($phuongThucGiaoHang) || empty($phuongThucThanhToan)) {
        $error = "Vui lòng điền đầy đủ thông tin bắt buộc.";
    } else {
        // Lưu đơn hàng vào bảng donhang
        $ngayDat = date('Y-m-d H:i:s');
        $diaChi = "$quan, $tinh, $mien";
        $trangThai = 'Chờ xử lý';

        $maDH = $db->insert('donhang', [
            'MaND' => $maND,
            'NgayDat' => $ngayDat,
            'TongTien' => $totalPrice,
            'DiaChiGiaoHang' => $diaChi,
            'PhuongThucThanhToan' => $phuongThucThanhToan,
            'TrangThai' => $trangThai
        ]);

        // Lưu chi tiết đơn hàng vào bảng chitietdonhang
        foreach ($cartItems as $item) {
            $giaMoi = !empty($item['PhanTramGiam']) && $item['PhanTramGiam'] > 0 && $item['PhanTramGiam'] < 100
                ? $item['DonGia'] * (1 - ($item['PhanTramGiam'] / 100))
                : $item['DonGia'];
            $thanhTien = $giaMoi * $item['SoLuong'];

            $db->insert('chitietdonhang', [
                'MaDH' => $maDH,
                'MaSP' => $item['MaSP'],
                'SoLuong' => $item['SoLuong'],
                'DonGia' => $giaMoi,
                'ThanhTien' => $thanhTien
            ]);
        }

        // Xóa giỏ hàng sau khi đặt hàng thành công
        $db->remove('giohang', 'MaND = ?', [$maND]);

        // Chuyển hướng đến trang xác nhận đơn hàng (tạm thời hiển thị thông báo)
        echo "<script>alert('Đặt hàng thành công!'); window.location.href = '../index.php';</script>";
        exit();
    }
}
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
        <div class="Infomation">
            <div class="info-page">
                <div class="info-product-heading">
                    <span class="info-product-heading-item">Thông tin sản phẩm</span>
                </div>
                <div class="info-product">
                    <?php foreach ($cartItems as $item): ?>
                        <?php
                        $giaMoi = !empty($item['PhanTramGiam']) && $item['PhanTramGiam'] > 0 && $item['PhanTramGiam'] < 100
                            ? $item['DonGia'] * (1 - ($item['PhanTramGiam'] / 100))
                            : $item['DonGia'];
                        ?>
                        <div class="info-product-item">
                            <img class="info-product-img" src="<?php echo htmlspecialchars($item['HinhAnh']); ?>" alt="<?php echo htmlspecialchars($item['TenSP']); ?>">
                        </div>
                        <div class="info-product-discribe">
                            <span class="discribe-item"><?php echo htmlspecialchars($item['TenSP']); ?></span>
                            <span class="discribe-price"><?php echo number_format($giaMoi, 0, ',', '.'); ?>đ</span>
                            <?php if (!empty($item['PhanTramGiam']) && $item['PhanTramGiam'] > 0): ?>
                                <span class="discribe-price-sub"><?php echo number_format($item['DonGia'], 0, ',', '.'); ?>đ</span>
                            <?php endif; ?>
                            <ul class="discribe-list">
                                <li class="discribe-list-item">Sản phẩm chính hãng, chất lượng cao</li>
                                <li class="discribe-list-item">Bảo hành 12 tháng</li>
                                <li class="discribe-list-item">Hỗ trợ giao hàng nhanh</li>
                            </ul>
                        </div>
                        <div class="info-product-count">
                            <span class="count-item">Số lượng:</span>
                            <span class="count"><?php echo $item['SoLuong']; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Thông tin khách hàng -->
                <div class="info-item">
                    <span class="info-heading">Thông tin khách hàng</span>
                </div>
                <?php if (isset($error)): ?>
                    <p style="color: red; text-align: center;"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="info-input">
                        <input type="text" name="hoTen" class="info-input-item" placeholder="Họ và tên" required>
                        <input type="text" name="soDienThoai" class="info-input-item" placeholder="Số điện thoại" required>
                        <input type="email" name="email" class="info-input-item" placeholder="Email" required>
                    </div>

                    <!-- Chọn cách thức giao hàng -->
                    <div class="info-delivery">
                        <span class="delivery-item">Chọn cách thức giao hàng</span>
                    </div>
                    <div class="radio-wrap">
                        <div class="radio">
                            <label>
                                <input type="radio" name="phuongThucGiaoHang" value="Giao hàng tận nơi" checked>
                                <span>Giao hàng tận nơi</span>
                            </label>
                            <label>
                                <input type="radio" name="phuongThucGiaoHang" value="Nhận tại cửa hàng">
                                <span>Nhận tại cửa hàng</span>
                            </label>
                        </div>
                    </div>

                    <!-- Địa chỉ giao hàng -->
                    <div class="info-address">
                        <div class="info-address-item">
                            <div class="address-1">
                                <select class="select-1" name="mien">
                                    <option value="Miền Bắc">Miền Bắc</option>
                                    <option value="Miền Nam">Miền Nam</option>
                                </select>
                            </div>
                            <div class="address-1">
                                <select class="select-1" name="tinh">
                                    <option value="Hồ Chí Minh">Hồ Chí Minh</option>
                                    <option value="Hà Nội">Hà Nội</option>
                                    <option value="Hải Phòng">Hải Phòng</option>
                                    <option value="Đà Nẵng">Đà Nẵng</option>
                                    <option value="Đồng Nai">Đồng Nai</option>
                                    <option value="Hà Giang">Hà Giang</option>
                                </select>
                            </div>
                        </div>
                        <div class="address-1">
                            <select class="select-2" name="quan">
                                <option value="Quận Hoàn Kiếm">Quận Hoàn Kiếm</option>
                                <option value="Quận 3">Quận 3</option>
                                <option value="Huyện Nhà Bè">Huyện Nhà Bè</option>
                                <option value="TP Hải Phòng">TP Hải Phòng</option>
                                <option value="TP Biên Hòa">TP Biên Hòa</option>
                                <option value="Huyện Bắc Quang">Huyện Bắc Quang</option>
                            </select>
                        </div>
                        <div class="address-input">
                            <div class="address-input-main">
                                <input type="text" name="yeuCauKhac" class="address-input-item" placeholder="Yêu cầu khác">
                            </div>
                        </div>
                    </div>

                    <!-- Phương thức thanh toán -->
                    <div class="pay-main">
                        <div class="pay">
                            <div class="money">
                                <label>
                                    <input type="radio" name="phuongThucThanhToan" value="Tiền mặt" checked>
                                    <span>Tiền mặt</span>
                                </label>
                                <img class="radio-img-money" src="../assets/imgs/money-removebg-preview.png">
                            </div>
                            <div class="momo">
                                <label>
                                    <input type="radio" name="phuongThucThanhToan" value="Momo">
                                    <span>Momo</span>
                                </label>
                                <img class="radio-img" src="../assets/imgs/ảnh_momo-removebg-preview.png">
                            </div>
                            <div class="vn-pay">
                                <label>
                                    <input type="radio" name="phuongThucThanhToan" value="VnPay">
                                    <span>VnPay</span>
                                </label>
                                <img class="radio-img-vnpay" src="../assets/imgs/vnpay.png">
                            </div>
                        </div>
                    </div>

                    <!-- Nút đặt hàng -->
                    <div class="info-button">
                        <button type="submit" class="button-item">Đặt hàng</button>
                    </div>
                </form>
            </div>
        </div>

        <footer class="end__heading-end">
            <div class="end__heading-end-information-group-sub">
                <span class="end__heading-end-information end__heading-end-information-name"><b>CÔNG TY PROTECH</b></span>
                <span class="end__heading-end-information">Địa chỉ: 273 Đ. An Dương Vương, Phường 3, Quận 5, Hồ Chí Minh, Vietnam</span>
                <span class="end__heading-end-information">Chịu Trách Nhiệm Quản Lý Nội Dung: Thành Viên 6713</span>
                <span class="end__heading-end-information">© 2024 - Bản quyền thuộc về Công ty ProTech</span>
            </div>
        </footer>
    </div>
    <script src="../cart.js"></script>
</body>
</html>