<?php
session_start();
require_once "../BackEnd/DB_driver.php";
require_once "../php/function.php";

$db = new DB_driver();
$db->connect();

// Lấy tham số tìm kiếm và bộ lọc
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$minPrice = isset($_GET['minPrice']) ? (int)$_GET['minPrice'] : 0;
$maxPrice = isset($_GET['maxPrice']) ? (int)$_GET['maxPrice'] : PHP_INT_MAX;
$categoryId = isset($_GET['categoryId']) && (int)$_GET['categoryId'] > 0 ? (int)$_GET['categoryId'] : 0;
$page = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

// Lưu lịch sử tìm kiếm
if (!empty($searchTerm)) {
    saveSearchHistory($db, $searchTerm);
}

// Xây dựng truy vấn SQL
$query = "SELECT * FROM sanpham WHERE 1=1";
$params = [];
$priceCondition = '';

if (!empty($searchTerm)) {
    $query .= " AND TenSP LIKE ?";
    $params[] = "%$searchTerm%";
}
if ($categoryId > 0) {
    $query .= " AND MaLSP = ?";
    $params[] = $categoryId;
}
if ($minPrice > 0 || $maxPrice < PHP_INT_MAX) {
    $priceCondition = " AND (DonGia * (1 - COALESCE(PhanTramGiam, 0) / 100)) BETWEEN ? AND ?";
    $params[] = $minPrice;
    $params[] = $maxPrice;
}

// Tính tổng số sản phẩm
$totalQuery = "SELECT COUNT(*) as total FROM sanpham WHERE 1=1" . ($searchTerm ? " AND TenSP LIKE ?" : "") . ($categoryId > 0 ? " AND MaLSP = ?" : "") . $priceCondition;
$totalParams = array_merge($searchTerm ? ["%$searchTerm%"] : [], $categoryId > 0 ? [$categoryId] : [], $minPrice > 0 || $maxPrice < PHP_INT_MAX ? [$minPrice, $maxPrice] : []);
$totalProducts = $db->get_row($totalQuery, $totalParams)['total'];
$totalPages = ceil($totalProducts / $perPage);

// Lấy danh sách sản phẩm
$query .= $priceCondition . " LIMIT ?, ?";
$params[] = $offset;
$params[] = $perPage;
$products = $db->get_list($query, $params);
?>

<!DOCTYPE html>
<html lang="vi">
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
        <?php addHeader('../', $db); ?>
        <section class="container">
            <div class="grid wide">
                <div class="row">
                    <?php addCTN__cate('../'); ?>
                    <div class="col l-10 m-12 c-12">
                        <header class="row container__menu title_menu">
                            <span class="title">Kết quả tìm kiếm<?php echo $searchTerm ? ' cho "' . htmlspecialchars($searchTerm) . '"' : ''; ?></span>
                        </header>
                        <article class="row protech container__product">
                            <header class="product-choice hide-on-mobile-table">
                                <span class="product-filter">Sắp xếp theo</span>
                                <div class="produce__btn-group">
                                    <section class="produce__btn-option poppular">
                                        <button id="btn-more"><i class="fa-solid fa-filter"></i></button>
                                    </section>
                                </div>
                            </header>
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
                                            <a href="./chi-tiet-sp/san-pham.php?maSP=<?php echo htmlspecialchars($row['MaSP']); ?>" class="product-item-link">
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
                                    <h1 style="font-size: 2.0rem; margin: auto;">Không tìm thấy sản phẩm</h1>
                                <?php endif; ?>
                            </div>
                        </article>
                        <ul class="pagination-list pagination-list-top">
                            <?php
                            $baseUrl = "?search=" . urlencode($searchTerm);
                            if ($categoryId > 0) {
                                $baseUrl .= "&categoryId=$categoryId";
                            }
                            if ($minPrice > 0) {
                                $baseUrl .= "&minPrice=$minPrice";
                            }
                            if ($maxPrice < PHP_INT_MAX) {
                                $baseUrl .= "&maxPrice=$maxPrice";
                            }
                            if ($page > 1) {
                                echo '<li class="pagination-item"><a href="' . $baseUrl . '&page=' . ($page - 1) . '" class="pagination-number-link"><i class="pagination-icon fa-solid fa-chevron-left"></i></a></li>';
                            }
                            for ($i = 1; $i <= $totalPages; $i++) {
                                echo '<li class="pagination-item' . ($i == $page ? ' pagination-item--active' : '') . '"><a href="' . $baseUrl . '&page=' . $i . '" class="pagination-number-link">' . $i . '</a></li>';
                            }
                            if ($page < $totalPages) {
                                echo '<li class="pagination-item"><a href="' . $baseUrl . '&page=' . ($page + 1) . '" class="pagination-number-link"><i class="pagination-icon fa-solid fa-chevron-right"></i></a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <?php addFooter('../'); ?>
    </div>
    <div class="modal-review" style="display: none;">
        <div class="modal__overlay"></div>
        <div class="modal__body">
            <div class="filter-container">
                <div>
                    <input type="text" class="search3" placeholder="Nhập thông tin để tìm kiếm sản phẩm" value="<?php echo htmlspecialchars($searchTerm); ?>">
                </div>
                <div class="filter-section">
                    <h3>Hãng</h3>
                    <div class="filter-options brand-options">
                        <button data-brand="Samsung">Samsung</button>
                        <button data-brand="iPhone">iPhone</button>
                        <button data-brand="Oppo">Oppo</button>
                        <button data-brand="Tecno">Tecno</button>
                        <button data-brand="Nokia">Nokia</button>
                        <button data-brand="Masstel">Masstel</button>
                    </div>
                </div>
                <div class="filter-section">
                    <h3>Giá</h3>
                    <div class="filter-options price-range">
                        <button data-min="0" data-max="2000000">Dưới 2 triệu</button>
                        <button data-min="2000000" data-max="4000000">Từ 2 - 4 triệu</button>
                        <button data-min="4000000" data-max="7000000">Từ 4 - 7 triệu</button>
                        <button data-min="7000000" data-max="13000000">Từ 7 - 13 triệu</button>
                        <button data-min="13000000" data-max="20000000">Từ 13 - 20 triệu</button>
                        <button data-min="20000000" data-max="999999999">Trên 20 triệu</button>
                    </div>
                    <div class="custom-price">
                        <p>Hoặc chọn mức giá phù hợp với bạn</p>
                        <div class="range-container">
                            <input type="range" id="min-range" min="300000" max="50000000" value="<?php echo $minPrice ?: 300000; ?>" step="100000">
                            <input type="range" id="max-range" min="300000" max="50000000" value="<?php echo $maxPrice < PHP_INT_MAX ? $maxPrice : 50000000; ?>" step="100000">
                            <div class="progress-bar" id="progress"></div>
                        </div>
                        <div class="slider-labels">
                            <span id="min-label"><?php echo number_format($minPrice ?: 300000, 0, ',', '.'); ?>đ</span>
                            <span id="max-label"><?php echo $maxPrice < PHP_INT_MAX ? number_format($maxPrice, 0, ',', '.') : '50.000.000'; ?>đ</span>
                        </div>
                    </div>
                </div>
                <div class="btn-search2">
                    <button class="btn search2-save">Lưu</button>
                    <button class="btn search2-cancel">Hủy</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/template.js"></script>
    <script>
        // Xử lý nút tìm kiếm
        const btnSearch = document.querySelector('.header_search-button');
        btnSearch.addEventListener('click', () => {
            const searchTerm = document.querySelector('.header_search-input').value;
            window.location.href = `?search=${encodeURIComponent(searchTerm)}`;
        });

        // Xử lý nút lọc
        const btnMore = document.getElementById('btn-more');
        const modal = document.querySelector('.modal-review');
        btnMore.addEventListener('click', () => {
            modal.style.display = 'flex';
        });

        // Xử lý nút lưu bộ lọc
        document.querySelector('.search2-save').addEventListener('click', () => {
            const searchTerm = document.querySelector('.search3').value;
            const minPrice = document.getElementById('min-range').value;
            const maxPrice = document.getElementById('max-range').value;
            window.location.href = `?search=${encodeURIComponent(searchTerm)}&minPrice=${minPrice}&maxPrice=${maxPrice}`;
        });

        // Xử lý nút hủy
        document.querySelector('.search2-cancel').addEventListener('click', () => {
            modal.style.display = 'none';
        });
        document.querySelector('.modal__overlay').addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Xử lý thanh trượt giá
        const minRange = document.getElementById('min-range');
        const maxRange = document.getElementById('max-range');
        const progress = document.getElementById('progress');
        const minLabel = document.getElementById('min-label');
        const maxLabel = document.getElementById('max-label');

        minRange.addEventListener('input', () => {
            minLabel.textContent = `${parseInt(minRange.value).toLocaleString()}đ`;
            updateProgress();
        });

        maxRange.addEventListener('input', () => {
            maxLabel.textContent = `${parseInt(maxRange.value).toLocaleString()}đ`;
            updateProgress();
        });

        function updateProgress() {
            const minValue = parseInt(minRange.value);
            const maxValue = parseInt(maxRange.value);
            const rangeWidth = maxRange.max - minRange.min;
            const progressWidth = ((maxValue - minValue) / rangeWidth) * 100;
            const progressLeft = ((minValue - minRange.min) / rangeWidth) * 100;
            progress.style.left = `${progressLeft}%`;
            progress.style.width = `${progressWidth}%`;
        }
        updateProgress();
    </script>
</body>
</html>