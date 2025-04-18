<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../BackEnd/DB_driver.php";

// Kiểm tra đăng nhập admin
if (!isset($_SESSION['MaND'])) {
    header("Location: ../login.php");
    exit();
}
$db = new DB_driver();
$db->connect();
$user = $db->get_row("SELECT * FROM nguoidung WHERE MaND = ?", [$_SESSION['MaND']]);
if (!$user || !in_array((int)$user['MaQuyen'], [2, 3])) {
    header("Location: ../login.php");
    exit();
}


// Lấy từ khóa tìm kiếm từ GET (nếu có)
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

// Số sản phẩm trên mỗi trang
$itemsPerPage = 6;

// Lấy số trang hiện tại từ GET (nếu có)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $itemsPerPage;

// Truy vấn với tìm kiếm (nếu có)
if ($keyword !== '') {
    $sql = "SELECT * FROM sanpham WHERE TenSP LIKE ? LIMIT ?, ?";
    $products = $db->get_list($sql, ["%$keyword%", $start, $itemsPerPage]);
    
    // Thay thế get_single_value() bằng get_row()
    $sqlCount = "SELECT COUNT(*) as total FROM sanpham WHERE TenSP LIKE ?";
    $rowCount = $db->get_row($sqlCount, ["%$keyword%"]);
    $totalItems = isset($rowCount['total']) ? $rowCount['total'] : 0;
} else {
    $sql = "SELECT * FROM sanpham LIMIT ?, ?";
    $products = $db->get_list($sql, [$start, $itemsPerPage]);
    
    // Thay thế get_single_value() bằng get_row()
    $sqlCount = "SELECT COUNT(*) as total FROM sanpham";
    $rowCount = $db->get_row($sqlCount);
    $totalItems = isset($rowCount['total']) ? $rowCount['total'] : 0;
}

// Kiểm tra và đảm bảo totalItems có giá trị hợp lệ
if ($totalItems === null) {
    $totalItems = 0;
}

// Tổng số trang
$totalPages = ceil($totalItems / $itemsPerPage);

// Ngắt kết nối DB
$db->dis_connect();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <style>
        /* Các styles không thay đổi */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        header {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        header h1 {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-right: 20px;
        }

        .search-bar {
            display: flex;
            gap: 10px;
        }

        .search-bar input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 25px;
            width: 300px;
            color: #333;
        }

        .search-bar button {
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .image-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            width: 100%;
            max-width: 900px;
        }

        .image-item {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            text-align: center;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .image-item img {
            width: 100%;
            height: 230px;
            border-radius: 8px;
            object-fit: cover;
        }

        .image-item h3 {
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .buttons {
            margin-top: 15px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .buttons button {
            padding: 5px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .buttons .edit {
            background-color: #3498db;
            color: white;
        }

        .buttons .delete {
            background-color: #e74c3c;
            color: white;
        }

        .image-item .price {
            font-size: 18px;
            font-weight: bold;
            color: #e74c3c;
            margin-top: 10px;
        }

        .price-and-discount {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 5px;
        }

        .price-new {
            font-size: 16px;
            font-weight: bold;
            color: #2ecc71; /* Màu xanh lá cho giá mới */
        }

        .price-present {
            font-size: 14px;
            color: #d0021b; /* Màu đỏ cho phần trăm giảm giá */
            font-weight: bold;
        }

        button:hover {
            opacity: 0.8;
        }

        /* Phân trang */
        .pagination {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .pagination a {
            padding: 10px 15px;
            text-decoration: none;
            background-color: #3498db;
            color: white;
            border-radius: 5px;
            font-weight: bold;
        }

        .pagination a:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <header>
        <h1>Quản lý sản phẩm</h1>
        <form class="search-bar" method="get" action="">
            <input type="text" name="keyword" placeholder="Nhập tên sản phẩm" value="<?= htmlspecialchars($keyword) ?>">
            <button type="submit">Tìm kiếm</button>
            <button type="button" onclick="window.location.href='add-productList.php'">+ Thêm sản phẩm</button>
        </form>
    </header>

    <div class="image-grid">
        <?php
        if (!empty($products)) {
            foreach ($products as $row) {
                $hinhAnh = isset($row['HinhAnh']) ? trim($row['HinhAnh']) : '';
                // Đảm bảo đường dẫn ảnh là tuyệt đối
                $imagePath = !empty($hinhAnh) && is_string($hinhAnh) ? $hinhAnh : '/assets/imgs/default.png';
                if ($imagePath && $imagePath[0] !== '/') {
                    $imagePath = '/' . $imagePath;
                }
                echo '<div class="image-item">';
                echo '<img src="..' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($row['TenSP']) . '">';
                echo '<h3>' . htmlspecialchars($row['TenSP']) . '</h3>';
                echo '<p class="price">' . number_format($row['DonGia'], 0, ',', '.') . ' đ</p>';

                if (!empty($row['PhanTramGiam']) && $row['PhanTramGiam'] > 0 && $row['PhanTramGiam'] < 100) {
                    $giaMoi = $row['DonGia'] * (1 - ($row['PhanTramGiam'] / 100));
                    echo '
                        <div class="price-and-discount">
                            <label class="price-new">' . number_format($giaMoi, 0, ',', '.') . ' đ</label>
                            <small class="price-present">-' . $row['PhanTramGiam'] . '%</small>
                        </div>';
                }

                echo '<div class="buttons">';
                echo '<button class="edit" data-id="' . $row['MaSP'] . '">Sửa</button>';
                echo '<button class="delete" data-id="' . $row['MaSP'] . '">Xóa</button>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>Chưa có sản phẩm nào.</p>';
        }
        ?>
    </div>
    <!-- Phân trang -->
<?php if ($totalPages > 1): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>&keyword=<?= urlencode($keyword) ?>" style="
                display: inline-block;
                padding: 8px 12px;
                margin: 0 5px;
                border: 1px solid #3498db;
                color: <?= ($i == $page) ? '#fff' : '#3498db' ?>;
                background-color: <?= ($i == $page) ? '#3498db' : '#fff' ?>;
                text-decoration: none;
                border-radius: 5px;
                font-weight: bold;">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
<?php endif; ?>

    <script>
        document.querySelectorAll('.edit').forEach(function(button) {
            button.addEventListener('click', function() {
                const maSP = this.getAttribute('data-id');
                window.location.href = `suaThongtinSanpham.php?maSP=${maSP}`;
            });
        });

        document.querySelectorAll('.delete').forEach(function(button) {
            button.addEventListener('click', function() {
                const maSP = this.getAttribute('data-id');
                if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
                    window.location.href = `xoaSanPham.php?maSP=${maSP}`;
                }
            });
        });
    </script>
</body>
</html>
