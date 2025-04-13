<?php
session_start();
require_once "../BackEnd/DB_driver.php";
require_once "../php/function.php";

$db = new DB_driver();
$db->connect();

// Kiểm tra đăng nhập
if (!isset($_SESSION['MaND'])) {
    $_SESSION['redirect_url'] = 'Template/Noti.php';
    header("Location: formNK.php");
    exit();
}

$maND = $_SESSION['MaND'];

// Lấy thông tin khách hàng
$khachHang = $db->get_row("SELECT HoTen FROM khachhang WHERE MaND = ?", [$maND]);
$tenKhachHang = $khachHang['HoTen'] ?? 'Khách hàng';

// Lấy thông báo (giả lập)
$thongBao = [
    ['img' => '../assets/imgs/iphone-15.png', 'noiDung' => "[$tenKhachHang] - Iphone 16 Promax 256gb - Chờ thanh toán", 'loai' => 'donhang', 'trangThai' => 'Chờ thanh toán'],
    ['img' => 'https://cdn.tgdd.vn/Products/Images/5698/325157/asus-s500se-i5-513500008w-thumb-1-600x600.jpg', 'noiDung' => "[$tenKhachHang] - ASUS S500SE i5 13500/8GB/512GB - Đã đổi trả", 'loai' => 'doitra', 'trangThai' => 'Đã giao'],
    ['img' => 'https://cdn.tgdd.vn/Products/Images/54/310123/tai-nghe-bluetooth-true-wireless-havit-tw967-thumb-5-600x600.jpg', 'noiDung' => "[$tenKhachHang] - Tai nghe Bluetooth True Wireless HAVIT TW967 - Giảm giá sốc lên đến 44%", 'loai' => 'khuyenmai', 'trangThai' => 'Đang vận chuyển']
];
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
                                <h3>Thông báo của tôi</h3>
                            </div>
                            <div class="information-right">
                                <ul class="tabs">
                                    <li class="is-active" title="Thông báo chung" data-tab="all">
                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"></path>
                                        </svg>
                                    </li>
                                    <li class="" title="Thông báo khuyến mãi" data-tab="khuyenmai">
                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M20 6h-2.18c.11-.31.18-.65.18-1 0-1.66-1.34-3-3-3-1.05 0-1.96.54-2.5 1.35l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-5-2c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zM9 4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm11 15H4v-2h16v2zm0-5H4V8h5.08L7 10.83 8.62 12 11 8.76l1-1.36 1 1.36L15.38 12 17 10.83 14.92 8H20v6z"></path>
                                        </svg>
                                    </li>
                                    <li class="" title="Thông báo đơn hàng" data-tab="donhang">
                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18 17H6v-2h12v2zm0-4H6v-2h12v2zm0-4H6V7h12v2zM3 22l1.5-1.5L6 22l1.5-1.5L9 22l1.5-1.5L12 22l1.5-1.5L15 22l1.5-1.5L18 22l1.5-1.5L21 22V2l-1.5 1.5L18 2l-1.5 1.5L15 2l-1.5 1.5L12 2l-1.5 1.5L9 2 7.5 3.5 6 2 4.5 3.5 3 2v20z"></path>
                                        </svg>
                                    </li>
                                    <li class="" title="Thông báo đổi trả" data-tab="doitra">
                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21 10.12h-6.78l2.74-2.82c-2.73-2.7-7.15-2.8-9.88-.1-2.73 2.71-2.73 7.08 0 9.79 2.73 2.71 7.15 2.71 9.88 0C18.32 15.65 19 14.08 19 12.1h2c 0 1.98-.88 4.55-2.64 6.29-3.51 3.48-9.21 3.48-12.72 0-3.5-3.47-3.53-9.11-.02-12.58 3.51-3.47 9.14-3.47 12.65 0L21 3v7.12zM12.5 8v4.25l3.5 2.08-.72 1.21L11 13V8h1.5z"></path>
                                        </svg>
                                    </li>
                                </ul>
                                <div class="orders" id="orders-list">
                                    <?php foreach ($thongBao as $tb) { ?>
                                        <div class="order-item" data-loai="<?php echo $tb['loai']; ?>" data-status="<?php echo $tb['trangThai']; ?>">
                                            <img id="item-img" src="<?php echo $tb['img']; ?>">
                                            <?php echo htmlspecialchars($tb['noiDung']); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php addFooter('../'); ?>
    </div>
    <script src="Noti.js"></script>
    <script src="cart.js"></script>
    <script src="logout.js"></script>
</body>
</html>