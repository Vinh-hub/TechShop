<?php
session_start();
require_once "../../BackEnd/DB_driver.php";
require_once "../../php/function.php";

$db = new DB_driver();
$db->connect();

$categoryId = 2; 
$perPage = 10;  
$page = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $perPage;

// Tính tổng số sản phẩm
$totalProducts = $db->get_row("SELECT COUNT(*) as total FROM sanpham WHERE MaLSP = ?", [$categoryId])['total'];
$totalPages = ceil($totalProducts / $perPage);

// Lấy danh sách sản phẩm
$products = $db->get_list("SELECT * FROM sanpham WHERE MaLSP = ? LIMIT ?, ?", [$categoryId, $offset, $perPage]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTech - Điện thoại chính hãng</title>
    <link rel="icon" type="image/x-icon" href="../../assets/imgs/logo-tab.png">
    <link rel="stylesheet" href="../../assets/css/base.css">
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link rel="stylesheet" href="../../assets/css/grid.css">
    <link rel="stylesheet" href="../../assets/css/responsive.css">
    <link rel="stylesheet" href="../../assets/fonts/fontawesome-free-6.6.0-web/fontawesome-free-6.6.0-web/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="web6713">
        <div class="header_first"></div>
        <?php addHeader('../../'); ?>
        <section class="container">
            <div class="grid wide">
                <div class="row">
                    <?php addCTN__cate('../../'); ?>
                    <div class="col l-10 m-12 c-12">
                        <header class="row container__menu title_menu">
                            <span class="title">Laptop</span>
                        </header>
                        <article class="row protech container__product">
                            <div class="product-list">
                                <?php if (!empty($products)): ?>
                                    <?php foreach ($products as $row): ?>
                                        <?php
                                        $hinhAnh = isset($row['HinhAnh']) ? trim($row['HinhAnh']) : '';
                                        $imagePath = !empty($hinhAnh) && is_string($hinhAnh) ? $hinhAnh : '/assets/imgs/default.png';
                                        if ($imagePath && $imagePath[0] !== '/') {
                                            $imagePath = '/' . $imagePath;
                                        }
                                        $displayImagePath = '/TechShop' . $imagePath;

                                        $giaMoi = !empty($row['PhanTramGiam']) && $row['PhanTramGiam'] > 0 && $row['PhanTramGiam'] < 100
                                            ? $row['DonGia'] * (1 - ($row['PhanTramGiam'] / 100))
                                            : $row['DonGia'];
                                        ?>
                                        <div class="col l-2-4 m-3 c-6 product-item">
                                            <a href="../chi-tiet-sp/san-pham.php?maSP=<?php echo htmlspecialchars($row['MaSP']); ?>" class="product-item-link">
                                                <div class="product-item-group">
                                                    <div class="product-item-img" style="background-image: url('<?php echo htmlspecialchars($displayImagePath); ?>');"></div>
                                                    <div class="product-item-info">
                                                        <div class="product-item-name">
                                                            <h3 id="item-name"><?php echo htmlspecialchars($row['TenSP']); ?></h3>
                                                        </div>
                                                        <strong class="product-price">
                                                            <span class="price-current"><?php echo number_format($giaMoi, 0, ',', '.'); ?>₫</span>
                                                            <?php if (!empty($row['PhanTramGiam']) && $row['PhanTramGiam'] > 0 && $row['PhanTramGiam'] < 100): ?>
                                                                <span class="price-and-discount">
                                                                    <label class="price-old black"><?php echo number_format($row['DonGia'], 0, ',', '.'); ?>₫</label>
                                                                    <small class="price-present">-<?php echo $row['PhanTramGiam']; ?>%</small>
                                                                </span>
                                                            <?php endif; ?>
                                                        </strong>
                                                        <div class="buy__now">
                                                            <span>Mua ngay</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <h1 style="font-size: 2.0rem; margin:auto auto;">Chưa có sản phẩm</h1>
                                <?php endif; ?>
                            </div>
                        </article>
                        <ul class="pagination-list pagination-list-top">
                            <?php
                            if ($page > 1) {
                                echo '<li class="pagination-item"><a href="?page=' . ($page - 1) . '" class="pagination-number-link"><i class="pagination-icon fa-solid fa-chevron-left"></i></a></li>';
                            }
                            for ($i = 1; $i <= $totalPages; $i++) {
                                echo '<li class="pagination-item' . ($i == $page ? ' pagination-item--active' : '') . '"><a href="?page=' . $i . '" class="pagination-number-link">' . $i . '</a></li>';
                            }
                            if ($page < $totalPages) {
                                echo '<li class="pagination-item"><a href="?page=' . ($page + 1) . '" class="pagination-number-link"><i class="pagination-icon fa-solid fa-chevron-right"></i></a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <?php addFooter('../../'); ?>
    </div>
</body>
</html>