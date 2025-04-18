<?php
session_start();
require_once "./BackEnd/DB_driver.php";
require_once "php/function.php";

// Kết nối cơ sở dữ liệu
$db = new DB_driver();
$db->connect();

// Kiểm tra đăng nhập
if (!isset($_SESSION['MaND'])) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: ./Template/formNK.php");
    exit();
}

$maND = $_SESSION['MaND']; // Lấy MaND từ session

// Xử lý yêu cầu AJAX để lấy số lượng sản phẩm trong giỏ hàng
if (isset($_GET['action']) && $_GET['action'] === 'getCartCount') {
    $cartItems = $db->get_list(
        "SELECT COUNT(*) as count FROM giohang WHERE MaND = ?",
        [$maND]
    );
    $cartCount = $cartItems[0]['count'] ?? 0;
    header('Content-Type: application/json');
    echo json_encode(['cartCount' => $cartCount]);
    exit();
}

// Xử lý thêm sản phẩm vào giỏ hàng
if (isset($_GET['action']) && $_GET['action'] === 'add' && isset($_GET['maSP'])) {
    $maSP = (int)$_GET['maSP'];

    // Kiểm tra xem sản phẩm có tồn tại không
    $product = $db->get_row("SELECT * FROM sanpham WHERE MaSP = ?", [$maSP]);
    if (!$product) {
        header('Content-Type: text/plain');
        echo "Sản phẩm không tồn tại.";
        exit();
    }

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    $existingItem = $db->get_row("SELECT * FROM giohang WHERE MaND = ? AND MaSP = ?", [$maND, $maSP]);
    if ($existingItem) {
        // Nếu đã có, tăng số lượng
        $newQuantity = $existingItem['SoLuong'] + 1;
        $db->update('giohang', ['SoLuong' => $newQuantity], 'MaGH = ?', [$existingItem['MaGH']]);
    } else {
        // Nếu chưa có, thêm mới vào giỏ hàng
        $db->insert('giohang', [
            'MaND' => $maND,
            'MaSP' => $maSP,
            'SoLuong' => 1
        ]);
    }
    header('Content-Type: text/plain');
    echo "Sản phẩm đã được thêm vào giỏ hàng.";
    exit();
}

// Xử lý xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['maGH'])) {
    $maGH = (int)$_GET['maGH'];
    $db->remove('giohang', 'MaGH = ? AND MaND = ?', [$maGH, $maND]);
    header("Location: giohang.php");
    exit();
}

// Lấy danh sách sản phẩm trong giỏ hàng
$cartItems = $db->get_list(
    "SELECT ct.MaHD, ct.MaSP, ct.SoLuong, s.TenSP, s.DonGia, s.PhanTramGiam, s.HinhAnh 
     FROM chitiethoadon ct
     JOIN sanpham s ON g.MaSP = s.MaSP 
     WHERE g.MaND = ?",
    [$maND]
);

// Tính tổng giá dựa trên giá mới (sau khi giảm giá)
$totalPrice = 0;
foreach ($cartItems as $item) {
    $giaMoi = !empty($item['PhanTramGiam']) && $item['PhanTramGiam'] > 0 && $item['PhanTramGiam'] < 100
        ? $item['DonGia'] * (1 - ($item['PhanTramGiam'] / 100))
        : $item['DonGia'];
    $totalPrice += $giaMoi * $item['SoLuong'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTech - Mua hàng Online giá rẻ</title>
    <link rel="icon" type="image/x-icon" href="./assets/imgs/logo-tab.png">
    <!-- assets -->
    <link rel="stylesheet" href="./assets/css/base.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/grid.css">
    <link rel="stylesheet" href="./assets/css/responsive.css">
    <!--fonts-->
    <link rel="stylesheet" href="./assets/fonts/fontawesome-free-6.6.0-web/fontawesome-free-6.6.0-web/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;800&display=swap" rel="stylesheet">

</head>
<body>
    <div class="web6713">
        <div class="header_first"></div>
        <?php addHeader(''); ?>
        <!-- Giỏ hàng -->
        <div class="header_navbar-cart-wrap">
            <h3 class="header_cart-heading">Giỏ hàng của bạn</h3>
            <?php if (empty($cartItems)): ?>
                <div class="header_navbar-cart">
                    <img class="header_navbar-cart-no-cart-img" src="./assets/imgs/cart-empty.png" alt="Giỏ hàng trống">
                    <p class="header_navbar-cart-no-cart-text">Không có sản phẩm nào trong giỏ hàng của bạn</p>
                    <a href="./index.php" class="header_navbar-cart-home">Về trang chủ</a>
                </div>
            <?php else: ?>
                <div class="header_cart-has-product">
                    <?php foreach ($cartItems as $item): ?>
                        <?php
                        $giaMoi = !empty($item['PhanTramGiam']) && $item['PhanTramGiam'] > 0 && $item['PhanTramGiam'] < 100
                            ? $item['DonGia'] * (1 - ($item['PhanTramGiam'] / 100))
                            : $item['DonGia'];
                        ?>
                        <div class="header_cart-wrap">
                            <div class="header_cart">
                                <img class="header_cart-img" src=".<?php echo htmlspecialchars($item['HinhAnh']); ?>" alt="<?php echo htmlspecialchars($item['TenSP']); ?>">
                                <div class="header_cart-item-name">
                                    <div class="name-group">
                                        <span class="header_cart-item"><?php echo htmlspecialchars($item['TenSP']); ?> (Số lượng: <?php echo $item['SoLuong']; ?>)</span>
                                        <a class="header_cart-trash-can" href="giohang.php?action=delete&maGH=<?php echo $item['MaGH']; ?>">
                                            <i class="cart-icon-1 fa-regular fa-trash-can"></i>
                                        </a>
                                    </div>
                                    <div class="header-price">
                                        <span class="header_cart-price-1" data-price="<?php echo $giaMoi; ?>"><?php echo number_format($giaMoi, 0, ',', '.'); ?>đ</span>
                                        <?php if (!empty($item['PhanTramGiam']) && $item['PhanTramGiam'] > 0): ?>
                                            <span class="header_cart-price-2"><?php echo number_format($item['DonGia'], 0, ',', '.'); ?>đ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="header_cart-discount">
                                <div class="header_cart-discount-item">
                                    <i class="cart-icon-2 fa-solid fa-gift"></i>
                                    <span class="cart-item">Chương trình khuyến mãi</span>
                                    <ul>
                                        <li>Trả góp 0% đến 12 tháng, 0đ trả trước qua Samsung Finance+</li>
                                        <li>Giảm ngay 500.000đ thanh toán qua thẻ MB Bank</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="cart_footer">
                    <div class="footer">
                        <span class="footer-item">Tạm tính:</span>
                        <span class="footer-price"><?php echo number_format($totalPrice, 0, ',', '.'); ?>đ</span>
                        <span class="footer-vat">Chưa bao gồm chiết khấu</span>
                    </div>
                    <a href="./Template/buyNow.php" target="_blank">
                        <button class="button-item-footer">Mua ngay</button>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Cập nhật trạng thái giỏ hàng
        function updateCartStatus() {
            const cartProducts = document.querySelectorAll('.header_cart-wrap');
            const cartEmptyMessage = document.querySelector('.header_navbar-cart');
            const cartFooter = document.querySelector('.cart_footer');

            if (cartProducts.length === 0) {
                cartEmptyMessage.style.display = 'block';
                cartFooter.style.display = 'none';
            } else {
                cartEmptyMessage.style.display = 'none';
                cartFooter.style.display = 'flex';
            }

            // Cập nhật số lượng sản phẩm trong giỏ hàng
            const cartCountElement = document.getElementById('cart-count');
            cartCountElement.textContent = cartProducts.length;
            localStorage.setItem('cartCount', cartProducts.length);
        }

        // Tính tổng giá
        function calculateTotalPrice() {
            let total = 0;
            const priceElements = document.querySelectorAll('.header_cart-price-1[data-price]');
            priceElements.forEach(function (priceElement) {
                const price = parseInt(priceElement.getAttribute('data-price')) || 0;
                total += price;
            });
            const footerPriceElement = document.querySelector('.footer-price');
            footerPriceElement.textContent = total.toLocaleString('vi-VN') + 'đ';
        }
        function fetchCartCount() {
            fetch('./giohang.php?action=getCartCount')
            .then(response => response.json())
            .then(data => {
                const cartCountElement = document.getElementById('cart-count');
                if (cartCountElement) {
                    cartCountElement.textContent = data.cartCount;
                }
            })
            .catch(error => console.error('Error fetching cart count:', error));
        }

        // Khởi tạo trạng thái ban đầu
        updateCartStatus();
        calculateTotalPrice();
    </script>
</body>
</html>