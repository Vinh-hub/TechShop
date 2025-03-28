<?php
require_once "../BackEnd/DB_driver.php";

// Tạo đối tượng DB_driver và kết nối
$db = new DB_driver();
$db->connect();

// Truy vấn tất cả sản phẩm từ bảng sanpham
$sql = "SELECT * FROM sanpham";
$products = $db->get_list($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <style>
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
    </style>
</head>
<body>
    <header>
        <h1>Quản lý sản phẩm</h1>
        <div class="search-bar">
            <input type="text" placeholder="Nhập tên sản phẩm">
            <button>+ Thêm sản phẩm</button>
        </div>
    </header>

    <div class="image-grid">
        <?php
        if (!empty($products)) {
            foreach ($products as $row) {
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
                echo "<!-- Debug: Final image path for {$row['TenSP']}: $imagePath -->";
                echo "<!-- Debug: Link HinhAnh for {$row['TenSP']}: http://{$_SERVER['HTTP_HOST']}$imagePath -->";

                echo '<div class="image-item">';
                echo '<img src="..' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($row['TenSP']) . '">';
                echo '<h3>' . htmlspecialchars($row['TenSP']) . '</h3>';
                echo '<p class="price">' . number_format($row['DonGia'], 0, ',', '.') . ' đ</p>';

                // Tính giá mới và hiển thị phần trăm giảm giá nếu có
                if (!empty($row['PhanTramGiam']) && $row['PhanTramGiam'] > 0 && $row['PhanTramGiam'] < 100) {
                    $giaMoi = $row['DonGia'] * (1 - ($row['PhanTramGiam'] / 100)); // Tính giá mới
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

        $db->dis_connect();
        ?>
    </div>

    <script>
        document.querySelector('.search-bar button').addEventListener('click', function() {
            window.location.href = 'add-productList.php';
        });

        document.querySelector('.search-bar input').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                location.reload();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
</body>
</html>