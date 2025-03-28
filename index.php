<?php
session_start();
require_once "BackEnd/DB_driver.php";
require_once "php/function.php";

$db = new DB_driver();
$db->connect();

$topDeals = $db->get_list("SELECT * FROM sanpham LIMIT 6");

$perPage = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $perPage;
$totalProducts = $db->get_row("SELECT COUNT(*) as total FROM sanpham")['total'];
$totalPages = ceil($totalProducts / $perPage);

$suggestions = $db->get_list("SELECT * FROM sanpham LIMIT ?, ?", [$offset, $perPage]);

function addContainer() {
    global $topDeals, $suggestions, $page, $totalPages;

    echo '
    <div class="col l-10 m-12 c-12">
        <header class="row container__menu title_menu">
            <a class="title_menu-thumail-link" href="#">
                <img src="./assets/imgs/thumail.png" alt="" class="title_menu-thumail">
            </a>
        </header>
        <article class="row protech container__product">
            <div class="Sale">
                <i class="Sale-icon fa-solid fa-thumbs-up"></i>
                <span class="Sale-text">TOP DEAL</span>
            </div>
            <div class="product-list">';
    
    // Hiển thị TOP DEAL
    foreach ($topDeals as $row) {
        // Debug giá trị HinhAnh từ cơ sở dữ liệu
        echo "<!-- Debug: Raw HinhAnh value for {$row['TenSP']}: " . (isset($row['HinhAnh']) ? $row['HinhAnh'] : 'NULL') . " -->";
        // Loại bỏ khoảng trắng ở đầu và cuối chuỗi HinhAnh
        $hinhAnh = isset($row['HinhAnh']) ? trim($row['HinhAnh']) : '';
        echo "<!-- Debug: Trimmed HinhAnh value for {$row['TenSP']}: " . ($hinhAnh ?: 'NULL') . " -->";
        // Kiểm tra xem HinhAnh có rỗng không
        echo "<!-- Debug: Is HinhAnh empty after trim? " . (empty($hinhAnh) ? 'Yes' : 'No') . " -->";

        // Xử lý đường dẫn ảnh
        $imagePath = !empty($hinhAnh) && is_string($hinhAnh) ? $hinhAnh : '/assets/imgs/default.png';
        // Đảm bảo đường dẫn bắt đầu bằng /
        if ($imagePath && $imagePath[0] !== '/') {
            $imagePath = '/' . $imagePath;
        }
        // Thêm tiền tố /TechShop/ vào đường dẫn ảnh để khớp với cấu trúc thư mục
        $displayImagePath = '/TechShop' . $imagePath;
        echo "<!-- Debug: Final image path for {$row['TenSP']}: $displayImagePath -->";
        echo "<!-- Debug: Link HinhAnh for {$row['TenSP']}: http://{$_SERVER['HTTP_HOST']}$displayImagePath -->";

        // Tính giá mới nếu có giảm giá
        $giaMoi = !empty($row['PhanTramGiam']) && $row['PhanTramGiam'] > 0 && $row['PhanTramGiam'] < 100
            ? $row['DonGia'] * (1 - ($row['PhanTramGiam'] / 100))
            : $row['DonGia'];

        echo '
        <div class="col l-2 m-3 c-6 product-item">
            <a href="Template/chi-tiet-sp/san-pham.php?maSP=' . htmlspecialchars($row['MaSP'])  . '" class="product-item-link">
                <div class="product-item-group">
                    <div class="product-item__mark-favourite"></div>
                    <div class="product-item-img" style="background-image: url(' . htmlspecialchars($displayImagePath) . ');"></div>
                    <div class="product-item-info">
                        <div class="product-item-name">
                            <div class="item-name__group">
                                <h3 id="item-name">' . htmlspecialchars($row['TenSP']) . '</h3>
                            </div>
                            <div class="item-name-deal"></div>
                        </div>
                        <strong class="product-price">
                            <span class="price-current">' . number_format($giaMoi, 0, ',', '.') . '₫</span>';
        if (!empty($row['PhanTramGiam']) && $row['PhanTramGiam'] > 0 && $row['PhanTramGiam'] < 100) {
            echo '
                            <span class="price-and-discount">
                                <label class="price-old black">' . number_format($row['DonGia'], 0, ',', '.') . '₫</label>
                                <small class="price-present">-' . $row['PhanTramGiam'] . '%</small>
                            </span>';
        }
        echo '
                        </strong>
                        <div class="buy__now gutter">
                            <span>Mua ngay</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>';
    }
    echo '
            </div>
        </article>
        <div class="Sale">
            <span class="Sale-suggest">Gợi ý hôm nay</span>
        </div>
        <article class="row protech container__product gutter">
            <div class="product-list gutter">';
    
    // Hiển thị Gợi ý hôm nay
    foreach ($suggestions as $row) {
        // Debug giá trị HinhAnh từ cơ sở dữ liệu
        echo "<!-- Debug: Raw HinhAnh value for {$row['TenSP']}: " . (isset($row['HinhAnh']) ? $row['HinhAnh'] : 'NULL') . " -->";
        // Loại bỏ khoảng trắng ở đầu và cuối chuỗi HinhAnh
        $hinhAnh = isset($row['HinhAnh']) ? trim($row['HinhAnh']) : '';
        echo "<!-- Debug: Trimmed HinhAnh value for {$row['TenSP']}: " . ($hinhAnh ?: 'NULL') . " -->";
        // Kiểm tra xem HinhAnh có rỗng không
        echo "<!-- Debug: Is HinhAnh empty after trim? " . (empty($hinhAnh) ? 'Yes' : 'No') . " -->";

        // Xử lý đường dẫn ảnh
        $imagePath = !empty($hinhAnh) && is_string($hinhAnh) ? $hinhAnh : '/assets/imgs/default.png';
        // Đảm bảo đường dẫn bắt đầu bằng /
        if ($imagePath && $imagePath[0] !== '/') {
            $imagePath = '/' . $imagePath;
        }
        // Thêm tiền tố /TechShop/ vào đường dẫn ảnh để khớp với cấu trúc thư mục
        $displayImagePath = '/TechShop' . $imagePath;
        echo "<!-- Debug: Final image path for {$row['TenSP']}: $displayImagePath -->";
        echo "<!-- Debug: Link HinhAnh for {$row['TenSP']}: http://{$_SERVER['HTTP_HOST']}$displayImagePath -->";

        // Tính giá mới nếu có giảm giá
        $giaMoi = !empty($row['PhanTramGiam']) && $row['PhanTramGiam'] > 0 && $row['PhanTramGiam'] < 100
            ? $row['DonGia'] * (1 - ($row['PhanTramGiam'] / 100))
            : $row['DonGia'];

        echo '
        <div class="col l-2 m-3 c-6 product-item">
            <a href="Template/chi-tiet-sp/san-pham.php?maSP=' . htmlspecialchars($row['MaSP']) . '" class="product-item-link">
                <div class="product-item-group">
                    <div class="product-item__mark-favourite"></div>
                    <div class="product-item-img" style="background-image: url(' . htmlspecialchars($displayImagePath) . ');"></div>
                    <div class="product-item-info">
                        <div class="product-item-name">
                            <div class="item-name__group">
                                <h3 id="item-name">' . htmlspecialchars($row['TenSP']) . '</h3>
                            </div>
                            <div class="item-name-deal"></div>
                        </div>
                        <strong class="product-price">
                            <span class="price-current">' . number_format($giaMoi, 0, ',', '.') . '₫</span>';
        if (!empty($row['PhanTramGiam']) && $row['PhanTramGiam'] > 0 && $row['PhanTramGiam'] < 100) {
            echo '
                            <span class="price-and-discount">
                                <label class="price-old black">' . number_format($row['DonGia'], 0, ',', '.') . '₫</label>
                                <small class="price-present">-' . $row['PhanTramGiam'] . '%</small>
                            </span>';
        }
        echo '
                        </strong>
                        <div class="buy__now">
                            <span>Mua ngay</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>';
    }
    echo '
            </div>
        </article>
        <ul class="pagination-list pagination-list-top">';
    if ($page > 1) {
        echo '<li class="pagination-item"><a href="?page=' . ($page - 1) . '" class="pagination-number-link"><i class="pagination-icon fa-solid fa-chevron-left"></i></a></li>';
    }
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<li class="pagination-item' . ($i == $page ? ' pagination-item--active' : '') . '"><a href="?page=' . $i . '" class="pagination-number-link">' . $i . '</a></li>';
    }
    if ($page < $totalPages) {
        echo '<li class="pagination-item"><a href="?page=' . ($page + 1) . '" class="pagination-number-link"><i class="pagination-icon fa-solid fa-chevron-right"></i></a></li>';
    }
    echo '
        </ul>
    </div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTech - Mua hàng Online giá rẻ</title>
    <link rel="icon" type="image/png" href="/TechShop/assets/imgs/logo-tab.png">
    <link rel="stylesheet" href="./assets/css/base.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/grid.css">
    <link rel="stylesheet" href="./assets/css/responsive.css">
    <link rel="stylesheet" href="./assets/fonts/fontawesome-free-6.6.0-web/fontawesome-free-6.6.0-web/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="web6713">
        <div class="header_first"></div>
        <?php addHeader(''); ?>
        <section class="container">
            <div class="grid wide">
                <div class="row">
                    <?php addCTN__cate(''); ?>
                    <?php addContainer(); ?>
                </div>
            </div>
        </section>
        <?php addFooter(); ?>
    </div>
    <script src="js/dungchung.js"></script>
    <script src="js/cart.js"></script>
    <script src="js/trangchu.js"></script>
</body>
</html>