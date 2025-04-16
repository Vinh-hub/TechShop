<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

function addHeader($basePath = '', $db = null) {
    $isLoggedIn = isset($_SESSION['MaND']);
    $taiKhoan = $isLoggedIn ? htmlspecialchars($_SESSION['TaiKhoan']) : 'Tài khoản';
    $accountLink = $isLoggedIn ? $basePath . 'Template/Information.php' : $basePath . 'Template/formNK.php';

    // Lấy lịch sử tìm kiếm
    $searchHistory = [];
    if ($db && $isLoggedIn) {
        $userId = $_SESSION['MaND'];
        $query = "SELECT keyword FROM search_history WHERE user_id = ? ORDER BY search_time DESC LIMIT 5";
        $searchHistory = $db->get_list($query, [$userId]);
    } elseif (!$isLoggedIn) {
        $searchHistory = isset($_SESSION['search_history']) ? array_slice($_SESSION['search_history'], 0, 5) : [];
    }

    $historyItems = '';
    foreach ($searchHistory as $item) {
        $keyword = is_array($item) ? htmlspecialchars($item['keyword']) : htmlspecialchars($item);
        $historyItems .= "<li class='header_navbar-search-history-item'><a href='{$basePath}Template/resultSearch.php?search=" . urlencode($keyword) . "'><i class='header_search-icon fa-solid fa-clock-rotate-left'></i> $keyword</a></li>";
    }
    if (empty($historyItems)) {
        $historyItems = "<li class='header_navbar-search-history-item'>Chưa có lịch sử tìm kiếm</li>";
    }

    $header = <<<HTML
    <header class="header">
        <div class="grid wide">
            <div class="header_navbar">
                <div class="header_navbar-search">
                    <div class="header_width-search">
                        <a href="{$basePath}index.php" class="header_logo home-page">
                            <img class="header_logo-img" src="{$basePath}assets/imgs/logo.png" alt="ProTech-logo" width="96" height="40">
                        </a>
                    </div>
                    <div class="header_search">
                        <i class="header_search-icon fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="search" class="header_search-input" placeholder="Nhập thông tin để tìm kiếm sản phẩm">
                        <button type="button" class="header_search-button">Tìm kiếm</button>
                        <div class="header_navbar-search-history">
                            <div class="header_navbar-search-history-heading">Lịch sử tìm kiếm</div>
                            <ul class="header_navbar-search-history-list">
                                {$historyItems}
                            </ul>
                        </div>
                    </div>
                    <ul class="header_navbar-list">
                        <li class="header_navbar-item">
                            <a href="{$basePath}index.php" class="header_navbar-icon-link"><i class="fa-solid fa-house"></i> Trang chủ</a>
                        </li>
                        <li class="header_navbar-item">
                            <a href="{$accountLink}" class="header_navbar-item-link">
                                <i class="fa-regular fa-face-smile-wink"></i>
                                <span class="header_navbar-icon-link header_navbar-link--strong" id="account-link">{$taiKhoan}</span>
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
                            <a href="{$basePath}giohang.php" class="header_navbar-icon-link">
                                <i class="header_navbar-icon-cart fa-solid fa-cart-shopping"></i> <span id="cart-count">0</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="header_navbar-discount">
                <ul class="header_navbar-discount-list">
                    <li class="header_navbar-discount-item"><a href="#" class="header_navbar-dis-link header_navbar-dis-link--strong">Cam kết</a></li>
                    <li class="header_navbar-discount-item"><a href="#" class="header_navbar-dis-link"><i class="header_navbar-dis-icon fa-solid fa-award"></i> 100% hàng thật</a></li>
                    <li class="header_navbar-discount-item"><a href="#" class="header_navbar-dis-link"><i class="header_navbar-dis-icon fa-solid fa-circle-check"></i> Chính hãng</a></li>
                    <li class="header_navbar-discount-item"><a href="#" class="header_navbar-dis-link"><i class="header_navbar-dis-icon fa-solid fa-tags"></i> Giá ưu đãi</a></li>
                    <li class="header_navbar-discount-item"><a href="#" class="header_navbar-dis-link"><i class="header_navbar-dis-icon fa-solid fa-rotate"></i> 30 ngày đổi trả</a></li>
                    <li class="header_navbar-discount-item"><a href="#" class="header_navbar-dis-link"><i class="header_navbar-dis-icon fa-solid fa-truck-fast"></i> Giao nhanh trong 2h</a></li>
                </ul>
            </div>
        </div>
    </header>
HTML;
    echo $header;
}

function addCTN__cate($basePath = '') {
    echo '
    <div class="col l-2 m-0 c-0">
        <nav class="container__category">
            <span class="header__category">Danh mục</span>
            <ul class="category__list">
                <li class="category__item">
                    <a href="' . $basePath . 'Template/Category/Dien-thoai.php" class="category__item-link">
                        <img src="' . $basePath . 'assets/imgs/phonne-24x24.png" alt="" class="category__item-icon">
                        Điện thoại
                    </a>
                </li>
                <li class="category__item">
                    <a href="' . $basePath . 'Template/Category/Laptop.php" class="category__item-link">
                        <img src="' . $basePath . 'assets/imgs/laptop-24x24.png" alt="" class="category__item-icon">
                        Laptop
                    </a>
                </li>
                <li class="category__item">
                    <a href="' . $basePath . 'Template/Category/Phu-kien.php" class="category__item-link">
                        <img src="' . $basePath . 'assets/imgs/phu-kien-24x24.png" alt="" class="category__item-icon">
                        Phụ kiện
                    </a>
                </li>
            </ul>
        </nav>
        <nav class="container__category">
            <span class="header__category">Tiện ích</span>
            <ul class="category__list">
                <li class="category__item">
                    <a href="' . $basePath . 'Template/Utility/voucher.php" class="category__item-link">
                        <img src="' . $basePath . 'assets/imgs/voucher.png" alt="" class="category__item-icon">
                        Voucher
                    </a>
                </li>
                <li class="category__item">
                    <a href="' . $basePath . 'Template/Utility/khac.php" class="category__item-link">
                        <img src="' . $basePath . 'assets/imgs/tien-ich-24x24.png" alt="" class="category__item-icon">
                        Đóng tiền, nạp thẻ
                    </a>
                </li>
            </ul>
        </nav>
    </div>';
}

function addFooter($basePath = '') {
    echo '
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
                            <a href="#" class="end__pay-item-link"><img
                                    src="https://down-vn.img.susercontent.com/file/d4bbea4570b93bfd5fc652ca82a262a8"
                                    alt="logo"></a>
                        </li>
                        <li class="end__pay-item">
                            <a href="#" class="end__pay-item-link"><img
                                    src="https://down-vn.img.susercontent.com/file/38fd98e55806c3b2e4535c4e4a6c4c08"
                                    alt="logo"></a>
                        </li>
                    </ul>
                    <h3 class="end__heading">ĐƠN VỊ VẬN CHUYỂN</h3>
                    <ul class="end__deliver-list">
                        <li class="end__deliver-item">
                            <a href="#" class="end__deliver-item-link"><img
                                    src="https://down-vn.img.susercontent.com/file/59270fb2f3fbb7cbc92fca3877edde3f"
                                    alt="logo"></a>
                        </li>
                        <li class="end__deliver-item">
                            <a href="#" class="end__deliver-item-link"><img
                                    src="https://down-vn.img.susercontent.com/file/0d349e22ca8d4337d11c9b134cf9fe63"
                                    alt="logo"></a>
                        </li>
                    </ul>
                </div>
                <div class="col l-2-4 m-4 c-6">
                    <h3 class="end__heading">THEO DÕI PROTECH</h3>
                    <ul class="end__heading-list">
                        <li class="end__heading-item">
                            <i class="end__heading-link-icon fa-brands fa-facebook"></i>
                            <a href="#" class="end__heading-link">
                                Facebook
                            </a>
                        </li>
                        <li class="end__heading-item">
                            <i class="end__heading-link-icon fa-brands fa-square-instagram"></i>
                            <a href="#" class="end__heading-link">
                                Instagram
                            </a>
                        </li>
                        <li class="end__heading-item">
                            <i class="end__heading-link-icon fa-brands fa-linkedin"></i>
                            <a href="#" class="end__heading-link">
                                LinkedIn
                            </a>
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
                <div class="end__certificate">
                    <a href="#" class="end-certificate-link">
                        <img src="' . $basePath . 'assets/imgs/BCT.png" alt="" class="end-certificate-img">
                    </a>
                    <a href="#" class="end-certificate-link">
                        <img src="https://img.lazcdn.com/g/tps/tfs/TB1jyJMv.H1gK0jSZSyXXXtlpXa-184-120.png" style="height: 60px;" alt="" class="end-certificate-img">
                    </a>
                    <a href="#" class="end-certificate-link">
                        <img src="' . $basePath . 'assets/imgs/NKVHG.png" alt="" class="end-certificate-img-HG">
                    </a>
                    <a href="#" class="end-certificate-link">
                        <img src="https://images.dmca.com/Badges/dmca-badge-w150-2x1-02.png?ID=73ee7811-7aa7-44d0-bb06-6c0df0da41d8" style="height: 60px;" alt="" class="end-certificate-img">
                    </a>
                </div>
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
    </footer>';
}

function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function saveSearchHistory($db, $keyword) {
    if (empty($keyword)) return;
    $keyword = trim($keyword);
    $isLoggedIn = isset($_SESSION['MaND']);
    if ($isLoggedIn) {
        $userId = $_SESSION['MaND'];
        $existing = $db->get_row("SELECT id FROM search_history WHERE user_id = ? AND keyword = ?", [$userId, $keyword]);
        if ($existing) {
            $db->query("UPDATE search_history SET search_time = NOW() WHERE id = ?", [$existing['id']]);
        } else {
            $db->query("INSERT INTO search_history (user_id, keyword) VALUES (?, ?)", [$userId, $keyword]);
            $db->query("DELETE FROM search_history WHERE user_id = ? AND id NOT IN (SELECT id FROM (SELECT id FROM search_history WHERE user_id = ? ORDER BY search_time DESC LIMIT 5) AS sub)", [$userId, $userId]);
        }
    } else {
        if (!isset($_SESSION['search_history'])) $_SESSION['search_history'] = [];
        $_SESSION['search_history'] = array_diff($_SESSION['search_history'], [$keyword]);
        array_unshift($_SESSION['search_history'], $keyword);
        $_SESSION['search_history'] = array_slice($_SESSION['search_history'], 0, 5);
    }
}

?>

