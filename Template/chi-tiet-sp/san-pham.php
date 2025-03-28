<?php
session_start();
require_once "../../BackEnd/DB_driver.php"; // Đường dẫn tới DB_driver.php

$db = new DB_driver();
$db->connect();

// Lấy mã sản phẩm từ URL
$maSP = $_GET['maSP'] ?? '';
$product = $db->get_row("SELECT * FROM sanpham WHERE MaSP = ?", [$maSP]);

if (!$product) {
    echo "Sản phẩm không tồn tại.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['TenSP']); ?> - ProTech</title>
    <link rel="icon" type="image/x-icon" href="../../../assets/imgs/logo-tab.png">
    <link rel="stylesheet" href="../../../normalize.css">
    <link rel="stylesheet" href="../../../assets/css/base.css">
    <link rel="stylesheet" href="../../../assets/css/main.css">
    <link rel="stylesheet" href="../../../assets/css/grid.css">
    <link rel="stylesheet" href="../assets/ctsp.css">
    <link rel="stylesheet" href="../../../assets/css/responsive.css">
    <link rel="stylesheet" href="../../../assets/fonts/fontawesome-free-6.6.0-web/fontawesome-free-6.6.0-web/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="web6713">
        <header class="header">
            <div class="grid wide"> 
                <div class="header_navbar">
                    <div class="header_navbar-search">  
                        <div class="header_width-search">
                            <a href="../../../index.php" class="header_logo home-page">
                                <img class="header_logo-img" src="../../../assets/imgs/logo.png" alt="ProTech-logo" width="96" height="40">
                            </a>
                        </div> 
                        <div class="header_search">
                            <i class="header_search-icon fa-solid fa-magnifying-glass"></i>
                            <input type="text" class="header_search-input" placeholder="Nhập thông tin để tìm kiếm sản phẩm">
                            <button type="button" class="header_search-button"> Tìm kiếm </button>  
                            <div class="header_navbar-search-history">
                                <div class="header_navbar-search-history-heading">Lịch sử tìm kiếm</div>
                                <ul class="header_navbar-search-history-list">
                                    <li class="header_navbar-search-history-item">
                                        <a href="#">
                                            <i class="header_search-icon fa-solid fa-clock-rotate-left"></i> Iphone 14 promax
                                        </a>
                                    </li>
                                    <li class="header_navbar-search-history-item">
                                        <a href="#">
                                            <i class="header_search-icon fa-solid fa-clock-rotate-left"></i> AirPod Pro 2
                                        </a>
                                    </li>
                                    <li class="header_navbar-search-history-item">
                                        <a href="#">
                                            <i class="header_search-icon fa-solid fa-clock-rotate-left"></i> Laptop Dell Precision
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>    
                        <ul class="header_navbar-list">
                            <li class="header_navbar-item">
                                <a href="#" class="header_navbar-icon-link">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                                <a href="../../../index.php" class="header_navbar-icon-link header_navbar-link--strong home-page">Trang chủ</a>
                            </li>
                            <li class="header_navbar-item">
                                <a href="#" class="header_navbar-item-link">
                                    <a href="#" class="header_navbar-icon-link" id="account-icon-link">
                                        <i class="fa-regular fa-face-smile-wink"></i>
                                    </a>
                                    <a href="#" class="header_navbar-icon-link header_navbar-link--strong" id="account-link">
                                        Tài khoản
                                    </a>
                                </a>
                            </li>
                            <li class="header_navbar-item header_navbar-item-no-pointer">
                                Liên hệ
                                <a href="#" class="header_navbar-icon-link header_navbar-icon-link--separate">
                                    <i class="fa-brands fa-facebook"></i>
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            </li>
                            <li class="header_navbar-item">
                                <a href="../../Cart.php" class="header_navbar-icon-link">
                                    <i class="header_navbar-icon-cart fa-solid fa-cart-shopping"></i> <span id="cart-count">0</span>
                                </a>
                            </li>
                        </ul>                       
                    </div>
                </div>
                <div class="header_navbar-discount">
                    <ul class="header_navbar-discount-list">
                        <li class="header_navbar-discount-item">
                            <a href="#" class="header_navbar-dis-link header_navbar-dis-link--strong">Cam kết</a>
                        </li>
                        <li class="header_navbar-discount-item">
                            <a href="#" class="header_navbar-dis-link">
                                <i class="header_navbar-dis-icon fa-solid fa-award"></i> 100% hàng thật
                            </a>
                        </li>
                        <li class="header_navbar-discount-item">
                            <a href="#" class="header_navbar-dis-link">
                                <i class="header_navbar-dis-icon fa-solid fa-circle-check"></i> Chính hãng
                            </a>
                        </li>
                        <li class="header_navbar-discount-item">
                            <a href="#" class="header_navbar-dis-link">
                                <i class="header_navbar-dis-icon fa-solid fa-tags"></i> Giá ưu đãi
                            </a>
                        </li>
                        <li class="header_navbar-discount-item">
                            <a href="#" class="header_navbar-dis-link">
                                <i class="header_navbar-dis-icon fa-solid fa-rotate"></i> 30 ngày đổi trả
                            </a>
                        </li>
                        <li class="header_navbar-discount-item">
                            <a href="#" class="header_navbar-dis-link">
                                <i class="header_navbar-dis-icon fa-solid fa-truck-fast"></i> Giao nhanh trong 2h
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <article>
            <div class="grid wide">
                <div class="row">
                    <div class="col l-8 m-12 c-12">
                        <div class="product-page">
                            <div class="product-banner">
                                <div class="product-image-container">
                                    <img src="<?php echo $product['HinhAnh'] ?: '../../../assets/imgs/default.jpg'; ?>" alt="<?php echo htmlspecialchars($product['TenSP']); ?>" class="product-image">
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
                            <div class="options-GB"> 
                                <!-- Tùy chọn dung lượng (có thể thêm logic để lấy từ cơ sở dữ liệu nếu cần) -->
                                <p class="options-GB-link active"><?php echo htmlspecialchars($product['DungLuong']); ?></p>
                            </div> 
                            <div class="options-color"> 
                                <!-- Tùy chọn màu sắc (có thể thêm logic để lấy từ cơ sở dữ liệu nếu cần) -->
                                <p href="" class="options-color-link active">
                                    <i style="background-color:<?php echo htmlspecialchars($product['MauHex']) ?: '#BAB4A9'; ?>"></i>
                                    <?php echo htmlspecialchars($product['Mau']); ?>
                                </p>
                            </div> 
                            <div class="product-option-price">
                                <span><?php echo number_format($product['DonGia'], 0, ',', '.'); ?>₫</span>
                                <span>Trả góp 0%</span>
                            </div>
                            <div class="product-option-promotions"> 
                                <span class="option-promotions__sale">
                                    <strong>Mô tả</strong>
                                </span> 
                                <div class="option-promotions__p">
                                    <span><?php echo htmlspecialchars($product['MoTa']); ?></span>
                                </div>
                            </div> 
                            <div class="product-option-actions">
                                <button class="btn--option-actions add-to-cart" onclick="handleAddToCart(this)">Thêm vào giỏ</button>
                                <button class="btn--option-actions buy-now" onclick="handleBuyNow()">Mua ngay</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <footer class="end">
            <div class="grid wide">
                <div class="row row-end">
                    <div class="col l-2-4 m-4 c-6">
                        <h3 class="end__heading">CHĂM SÓC KHÁCH HÀNG</h3>
                        <ul class="end__heading-list">
                            <li class="end__heading-item">
                                <a href="#" class="end__heading-link">Trung Tâm Hỗ Trợ</a>
                            </li>
                            <li class="end__heading-item">
                                <a href="#" class="end__heading-link">Giao & Nhận Hàng</a>
                            </li>
                            <li class="end__heading-item">
                                <a href="#" class="end__heading-link">Hướng Dẫn Mua Hàng</a>
                            </li>
                            <li class="end__heading-item">
                                <a href="#" class="end__heading-link">Hướng Dẫn Trả Góp</a>
                            </li>
                            <li class="end__heading-item">
                                <a href="#" class="end__heading-link">Chính Sách Bảo Hành</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col l-2-4 m-4 c-6">
                        <h3 class="end__heading">VỀ PROTECH</h3>
                        <ul class="end__heading-list">
                            <li class="end__heading-item">
                                <a href="#" class="end__heading-link">Giới Thiệu Về ProTech</a>
                            </li>
                            <li class="end__heading-item">
                                <a href="#" class="end__heading-link">Quy Chế Hoạt Động</a>
                            </li>
                            <li class="end__heading-item">
                                <a href="#" class="end__heading-link">Tuyển Dụng</a>
                            </li>
                            <li class="end__heading-item">
                                <a href="#" class="end__heading-link">Điều Khoản</a>
                            </li>
                            <li class="end__heading-item">
                                <a href="#" class="end__heading-link">Chính Sách Bảo Mật</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col l-2-4 hide-on-mobile-table">
                        <h3 class="end__heading">THANH TOÁN</h3>
                        <ul class="end__pay-list">
                            <li class="end__pay-item">
                                <a href="#" class="end__pay-item-link"><img src="https://down-vn.img.susercontent.com/file/d4bbea4570b93bfd5fc652ca82a262a8" alt="logo"></a>
                            </li>
                            <li class="end__pay-item">
                                <a href="#" class="end__pay-item-link"><img src="https://down-vn.img.susercontent.com/file/38fd98e55806c3b2e4535c4e4a6c4c08" alt="logo"></a>
                            </li>
                        </ul>
                        <h3 class="end__heading">ĐƠN VỊ VẬN CHUYỂN</h3>
                        <ul class="end__deliver-list">
                            <li class="end__deliver-item">
                                <a href="#" class="end__deliver-item-link"><img src="https://down-vn.img.susercontent.com/file/59270fb2f3fbb7cbc92fca3877edde3f" alt="logo"></a>
                            </li>
                            <li class="end__deliver-item">
                                <a href="#" class="end__deliver-item-link"><img src="https://down-vn.img.susercontent.com/file/0d349e22ca8d4337d11c9b134cf9fe63" alt="logo"></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col l-2-4 m-4 c-6">
                        <h3 class="end__heading">THEO DÕI PROTECH</h3>
                        <ul class="end__heading-list">
                            <li class="end__heading-item">
                                <i class="end__heading-link-icon fa-brands fa-facebook"></i>
                                <a href="#" class="end__heading-link">Facebook</a>
                            </li>
                            <li class="end__heading-item">
                                <i class="end__heading-link-icon fa-brands fa-square-instagram"></i>
                                <a href="#" class="end__heading-link">Instagram</a>
                            </li>
                            <li class="end__heading-item">
                                <i class="end__heading-link-icon fa-brands fa-linkedin"></i>
                                <a href="#" class="end__heading-link">LinkedIn</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col l-2-4 m-8 c-6">
                        <h3 class="end__heading">THÔNG TIN LIÊN HỆ</h3>
                        <ul class="end__heading-list">
                            <li class="end__heading-item">
                                <p class="end__heading-p">Tổng đài hỗ trợ</p>
                                <a href="#" class="end__heading-link">1900-6713</a>
                            </li>
                            <li class="end__heading-item">
                                <p class="end__heading-p">Email CSKH</p>
                                <a href="#" class="end__heading-link">cskh@protech.vn</a>
                            </li>
                            <li class="end__heading-item">
                                <p class="end__heading-p">Hợp tác phát triển</p>
                                <a href="#" class="end__heading-link">hoptac@protech.vn</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="end__heading-more">
                    <span class="end__heading-law">© 2024 - Công ty ProTech | Verified by:</span>
                    <a href="#" class="end-certificate-link">
                        <img src="../../../assets/imgs/BCT.png" alt="" class="end-certificate-img">
                    </a>
                    <a href="#" class="end-certificate-link">
                        <img src="https://img.lazcdn.com/g/tps/tfs/TB1jyJMv.H1gK0jSZSyXXXtlpXa-184-120.png" style="height: 60px;" alt="" class="end-certificate-img">
                    </a>
                    <a href="#" class="end-certificate-link">
                        <img src="../../../assets/imgs/NKVHG.png" alt="" class="end-certificate-img-HG">
                    </a>
                    <a href="#" class="end-certificate-link">
                        <img src="https://images.dmca.com/Badges/dmca-badge-w150-2x1-02.png?ID=73ee7811-7aa7-44d0-bb06-6c0df0da41d8" style="height: 60px;" alt="" class="end-certificate-img">
                    </a>
                </div>
            </div>
        </footer>
        <footer class="end__heading-end">
            <div class="end__heading-end-information-group">
                <span class="end__heading-end-information end__heading-end-information-name"><b>CÔNG TY PROTECH</b></span>
                <span class="end__heading-end-information">Địa chỉ: 273 Đ. An Dương Vương, Phường 3, Quận 5, Hồ Chí Minh, Vietnam</span>
                <span class="end__heading-end-information">Chịu Trách Nhiệm Quản Lý Nội Dung: Thành Viên 6713</span>
                <span class="end__heading-end-information">© 2024 - Bản quyền thuộc về Công ty ProTech</span>
            </div>
        </footer>
        <div class="modal-review" style="display: none;">
            <div class="modal__overlay"></div>
            <div class="modal__body">
                <section class="auht-form--review">
                    <div class="auth-form__container">
                        <header class="auth-form__heaader">
                            <h3 class="auth-form__header--heading">Đánh giá sản phẩm </h3>
                            <i class="auth-form__header--icon fa-solid fa-x"></i>
                        </header>
                        <ul class="rating-topzonecr-star">
                            <li data-val="1">
                                <i class="fa-regular fa-star star__review" style="color: #FFD43B;"></i>
                                <p data-val="1">Rất tệ</p>
                            </li>
                            <li data-val="2">
                                <i class="fa-regular fa-star star__review" style="color: #FFD43B;"></i>
                                <p data-val="2">Tệ</p>
                            </li>
                            <li data-val="3">
                                <i class="fa-regular fa-star star__review" style="color: #FFD43B;"></i>
                                <p data-val="3">Tạm ổn</p>
                            </li>
                            <li data-val="4">
                                <i class="fa-regular fa-star star__review" style="color: #FFD43B;"></i>
                                <p data-val="4" class="active-slt">Tốt</p>
                            </li>
                            <li data-val="5">
                                <i class="fa-regular fa-star star__review" style="color: #FFD43B;"></i>
                                <p data-val="5">Rất tốt</p>
                            </li>
                        </ul>
                        <form class="auth-form__body">
                            <div class="auth_form__body__group">
                                <textarea class="fRContent" name="fRContent" placeholder="Mời bạn chia sẻ thêm cảm nhận..."></textarea>              
                            </div>
                            <div class="auth_form__body__group review">
                                <input type="text" class="auth-form--review__body__group--input review" placeholder="Họ và tên (bắt buộc)">  
                                <input type="text" class="auth-form--review__body__group--input review" placeholder="Số điện thoại (bắt buộc)">                
                            </div>
                        </form>
                        <article class="auth-form__aside--review">
                            <input type="checkbox" class="saidyes">
                            <p class="auth-form__aside-policy review">
                                Tôi đồng ý với ProTech về  
                                <a href="#" class="auth-form__aside-policy--link"> Điều khoảng dịch vụ </a>
                                &                                
                                <a href="#" class="auth-form__aside-policy--link"> Chính sách bảo mật </a>          
                            </p>
                        </article>
                        <footer class="auth-form__controls review">
                            <button class="btn btn--primary btn--review">Gửi đánh giá </button>
                        </footer>                   
                    </div>
                </section>
            </div>
        </div>
    </div>    
    <div class="product-list"></div>
</body>
<script src="../../../main.js"></script>
<script src="../assets/ctsp.js"></script>
<script src="../../item.js"></script>
<script src="../../cart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const basePath = localStorage.getItem('basePath');
        const accountLink = document.getElementById('account-link');
        const accountIconLink = document.getElementById('account-icon-link');

        function handleAccountLinkClick(event) {
            event.preventDefault();
            const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
            if (isLoggedIn) {
                window.location.href = `../../Information.php`;
            } else {
                window.location.href = `../../Category/formNK.php`;
            }
        }

        if (accountLink) {
            accountLink.addEventListener('click', handleAccountLinkClick);
        }
        if (accountIconLink) {
            accountIconLink.addEventListener('click', handleAccountLinkClick);
        }
    });

    function handleAddToCart(button) {
        alert("Đã thêm sản phẩm <?php echo htmlspecialchars($product['TenSP']); ?> vào giỏ hàng!");
        // Thêm logic để lưu vào giỏ hàng (ví dụ: lưu vào session hoặc localStorage)
    }

    function handleBuyNow() {
        alert("Chuyển đến trang thanh toán cho sản phẩm <?php echo htmlspecialchars($product['TenSP']); ?>!");
        // Thêm logic để chuyển hướng đến trang thanh toán
    }
</script>
</html>