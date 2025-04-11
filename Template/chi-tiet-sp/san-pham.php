<?php
session_start();
require_once "../../BackEnd/DB_driver.php";
require_once "../../php/function.php";

$db = new DB_driver();
$db->connect();

// Kiểm tra trạng thái đăng nhập
$isLoggedIn = isset($_SESSION['MaND']) && !empty($_SESSION['MaND']); // Sử dụng MaND để đồng bộ với giohang.php

// Lấy mã sản phẩm từ URL
$maSP = isset($_GET['maSP']) && $_GET['maSP'] !== '' ? (int)$_GET['maSP'] : null;
if (!$maSP) {
    die("Không tìm thấy sản phẩm! Vui lòng cung cấp mã sản phẩm hợp lệ.");
}

// Truy vấn thông tin sản phẩm từ cơ sở dữ liệu
$product = $db->get_row("SELECT * FROM sanpham WHERE MaSP = ?", [$maSP]);
if (!$product) {
    die("Sản phẩm không tồn tại trong cơ sở dữ liệu!");
}

// Xử lý đường dẫn ảnh
$hinhAnh = isset($product['HinhAnh']) ? trim($product['HinhAnh']) : '';
$imagePath = !empty($hinhAnh) ? $hinhAnh : '/assets/imgs/default.png';
if ($imagePath && $imagePath[0] !== '/') {
    $imagePath = '/' . $imagePath;
}
$displayImagePath = '/TechShop' . $imagePath;

// Tính giá mới nếu có giảm giá
$giaMoi = !empty($product['PhanTramGiam']) && $product['PhanTramGiam'] > 0 && $product['PhanTramGiam'] < 100
    ? $product['DonGia'] * (1 - ($product['PhanTramGiam'] / 100))
    : $product['DonGia'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTech - <?php echo htmlspecialchars($product['TenSP']); ?></title>
    <link rel="icon" type="image/x-icon" href="../../assets/imgs/logo-tab.png">
    <link rel="stylesheet" href="../../normalize.css">
    <link rel="stylesheet" href="../../assets/css/base.css">
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link rel="stylesheet" href="../../assets/css/grid.css">
    <link rel="stylesheet" href="./assets/ctsp.css">
    <link rel="stylesheet" href="../../assets/css/responsive.css">
    <link rel="stylesheet" href="../../assets/fonts/fontawesome-free-6.6.0-web/fontawesome-free-6.6.0-web/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="web6713">
        <?php addHeader('../../'); ?>
        <article>
            <div class="grid wide">
                <div class="row">
                    <div class="col l-8 m-12 c-12">
                        <div class="product-page">
                            <div class="product-banner">
                                <div class="product-image-container">
                                    <img src="<?php echo htmlspecialchars($displayImagePath); ?>" alt="<?php echo htmlspecialchars($product['TenSP']); ?>" class="product-image">
                                </div>
                            </div>
                            <div class="product-commitment">
                                <span class="product-commitment-header">ProTech xin cam kết</span>
                                <div class="product-commitment-text">
                                    <p><i class="fa fa-shield-alt"></i> Hư gì đổi nấy 12 tháng (miễn phí tháng đầu)</p>
                                    <p><i class="fa fa-box"></i> Bộ sản phẩm gồm: Hộp, Sách hướng dẫn, Cáp, Cây lấy sim</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col l-4 m-0 c-0">
                        <div class="product-option">
                            <div class="name-product"><?php echo htmlspecialchars($product['TenSP']); ?></div>
                            <?php if (!empty($product['DungLuong'])): ?>
                            <div class="options-GB"> 
                                <p class="options-GB-link active">
                                    <?php echo htmlspecialchars($product['DungLuong']) . " GB"; ?>
                                </p>
                            </div>
                            <?php endif; ?> 
                            <div class="options-color"> 
                                <p class="options-color-link active"><?php echo htmlspecialchars($product['Mau']); ?></p>
                            </div> 
                            <div class="product-option-price">
                                <span><?php echo number_format($giaMoi, 0, ',', '.'); ?>₫</span>
                                <?php if (!empty($product['PhanTramGiam']) && $product['PhanTramGiam'] > 0): ?>
                                    <span class="price-old"><?php echo number_format($product['DonGia'], 0, ',', '.'); ?>₫</span>
                                    <small class="price-present">-<?php echo $product['PhanTramGiam']; ?>%</small>
                                <?php endif; ?>
                                <span>Trả góp 0%</span>
                            </div>
                            <div class="product-option-promotions">
                                <span class="option-promotions__sale"><strong>Mô tả</strong></span>
                                <div class="option-promotions__p">
                                    <span class="description-text"><?php echo htmlspecialchars($product['MoTa'] ?? 'Chưa có mô tả sản phẩm.'); ?></span>
                                </div>
                            </div>
                            <div class="product-option-actions">
                                <button class="btn--option-actions add-to-cart" onclick="handleAddToCart(<?php echo $maSP; ?>)">Thêm vào giỏ</button>
                                <button class="btn--option-actions buy-now" onclick="handleBuyNow(<?php echo $maSP; ?>)">Mua ngay</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <?php addFooter('../../'); ?>
    </div>

    <script src="./assets/ctsp.js"></script>
    <script src="../../item.js"></script>
    <script src="../../cart.js"></script>
    <script>
        // Xử lý đăng nhập cho nút "Tài khoản"
        document.addEventListener("DOMContentLoaded", () => {
            const accountLink = document.getElementById('account-link');
            const accountIconLink = document.getElementById('account-icon-link');

            function handleAccountLinkClick(event) {
                event.preventDefault();
                const isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
                if (isLoggedIn) {
                    window.location.href = `../Information.php`;
                } else {
                    window.location.href = `../formNK.php`;
                }
            }

            if (accountLink) accountLink.addEventListener('click', handleAccountLinkClick);
            if (accountIconLink) accountIconLink.addEventListener('click', handleAccountLinkClick);
        });

        // Xử lý "Thêm vào giỏ hàng"
        function handleAddToCart(maSP) {
            const isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
            if (!isLoggedIn) {
                alert('Vui lòng đăng nhập để thêm vào giỏ hàng!');
                window.location.href = '../formNK.php';
                return;
            }

            // Gửi yêu cầu AJAX để thêm sản phẩm vào giỏ hàng
            fetch(`../../giohang.php?action=add&maSP=${maSP}`, {
                method: 'GET'
            })
            .then(response => response.text())
            .then(data => {
                alert('Sản phẩm đã được thêm vào giỏ hàng!');
                // Cập nhật số lượng sản phẩm trong giỏ hàng trên giao diện
                fetchCartCount();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.');
            });
        }

        // Xử lý "Mua ngay"
        function handleBuyNow(maSP) {
            const isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
            if (!isLoggedIn) {
                alert('Vui lòng đăng nhập để mua hàng!');
                window.location.href = '../formNK.php';
                return;
            }

            // Thêm sản phẩm vào giỏ hàng trước khi chuyển hướng đến trang mua ngay
            fetch(`../giohang.php?action=add&maSP=${maSP}`, {
                method: 'GET'
            })
            .then(response => response.text())
            .then(data => {
                // Chuyển hướng đến trang mua ngay
                window.location.href = '../Info.php';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi xử lý mua ngay.');
            });
        }

        // Hàm lấy số lượng sản phẩm trong giỏ hàng để cập nhật giao diện
        function fetchCartCount() {
            fetch('../../giohang.php?action=getCartCount')
            .then(response => response.json())
            .then(data => {
                const cartCountElement = document.getElementById('cart-count');
                if (cartCountElement) {
                    cartCountElement.textContent = data.cartCount;
                }
            })
            .catch(error => console.error('Error fetching cart count:', error));
        }
    </script>
</body>
<link rel="stylesheet" href="../">
</html>