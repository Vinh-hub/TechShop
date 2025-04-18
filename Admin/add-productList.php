<?php
session_start();
require_once "../BackEnd/DB_driver.php";

if (!isset($_SESSION['MaND'])) {
    header("Location: ../login.php");
    exit();
}

$db = new DB_driver();
$db->connect();
$user = $db->get_row("SELECT * FROM nguoidung WHERE MaND = ?", [$_SESSION['MaND']]);
if (!$user || (isset($user['MaQuyen']) && !in_array($user['MaQuyen'], [2, 3]))) {
    header("Location: ../login.php");
    exit();
}
// Lấy danh sách danh mục từ bảng loaisanpham
$categories = $db->get_list("SELECT MaLSP, TenLSP FROM loaisanpham");

// Xử lý dữ liệu từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $ten_sp = trim($_POST['product_name'] ?? '');
    $don_gia = trim($_POST['price'] ?? '');
    $mau = trim($_POST['color'] ?? '');
    $dung_luong = trim($_POST['capacity'] ?? '');
    $mo_ta = trim($_POST['description'] ?? '');
    $so_luong = trim($_POST['quantity'] ?? 1);
    $ma_lsp = trim($_POST['category'] ?? '');

    // Kiểm tra dữ liệu đầu vào
    $errors = [];
    if (empty($ten_sp)) $errors[] = "Tên sản phẩm không được để trống.";
    if (!is_numeric($don_gia) || $don_gia < 0) $errors[] = "Giá phải là số không âm.";
    if (!is_numeric($so_luong) || $so_luong < 1) $errors[] = "Số lượng phải là số nguyên dương.";
    if (empty($ma_lsp)) $errors[] = "Vui lòng chọn danh mục.";

    // Xử lý upload hình ảnh
    $hinh_anh = "";
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB
        $file_type = $_FILES['product_image']['type'];
        $file_size = $_FILES['product_image']['size'];

        if (!in_array($file_type, $allowed_types)) {
            $errors[] = "Chỉ chấp nhận file JPEG, PNG hoặc GIF.";
        } elseif ($file_size > $max_size) {
            $errors[] = "Kích thước file không được vượt quá 5MB.";
        } else {
            $target_dir = "../assets/imgs/";
            $image_name = basename($_FILES["product_image"]["name"]);
            $target_file = $target_dir . $image_name;
            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                $hinh_anh = "/assets/imgs/" . $image_name;
            } else {
                $errors[] = "Lỗi khi upload hình ảnh.";
            }
        }
    }

    // Nếu không có lỗi, lưu vào DB
    if (empty($errors)) {
        $data = [
            'MaLSP' => $ma_lsp,
            'TenSP' => $ten_sp,
            'DonGia' => $don_gia,
            'Mau' => $mau,
            'DungLuong' => $dung_luong,
            'HinhAnh' => $hinh_anh,
            'MaKM' => 0, // Mã khuyến mãi mặc định
            'MoTa' => $mo_ta,
            'SoLuong' => $so_luong,
            'TrangThai' => 1
        ];

        $result = $db->insert('sanpham', $data);
        if ($result) {
            header("Location: Quanlisanpham.php");
            exit();
        } else {
            $errors[] = "Lỗi khi thêm sản phẩm vào cơ sở dữ liệu.";
        }
    }
}

// Ngắt kết nối
$db->dis_connect();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTech - Thêm Sản Phẩm</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="/TechShop/assets/css/Dashboard.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 20px;
            background-color: #f5f7fa;
        }
        h1 {
            text-align: center;
            font-family: 'Montserrat', sans-serif;
            color: #333;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: 'Inter', sans-serif;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        .form-actions {
            text-align: right;
        }
        .form-actions button {
            padding: 10px 20px;
            font-size: 16px;
            margin-left: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-actions button[type="submit"] {
            background-color: #007bff;
            color: white;
        }
        .form-actions button[type="reset"] {
            background-color: #6c757d;
            color: white;
        }
        .form-actions button:hover {
            opacity: 0.9;
        }
        .error {
            color: #dc3545;
            font-size: 0.9rem;
            margin-bottom: 10px;
            text-align: center;
        }
        .image-preview {
            margin-top: 10px;
            text-align: center;
        }
        .image-preview img {
            max-width: 200px;
            max-height: 200px;
            border-radius: 5px;
            display: none;
        }
        footer {
            margin-top: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h1>Thêm Sản Phẩm Mới</h1>
    <form action="./add-productList.php" method="POST" enctype="multipart/form-data" class="form-container">
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?= implode('<br>', $errors) ?>
            </div>
        <?php endif; ?>
        <!-- Tên sản phẩm -->
        <div class="form-group">
            <label for="product-name">Tên sản phẩm</label>
            <input type="text" id="product-name" name="product_name" value="<?= htmlspecialchars($_POST['product_name'] ?? '') ?>" required>
        </div>
        <!-- Giá -->
        <div class="form-group">
            <label for="price">Giá</label>
            <input type="number" id="price" name="price" step="0.01" min="0" value="<?= htmlspecialchars($_POST['price'] ?? '') ?>" required>
        </div>
        <!-- Màu sắc -->
        <div class="form-group">
            <label for="color">Màu sắc</label>
            <input type="text" id="color" name="color" value="<?= htmlspecialchars($_POST['color'] ?? '') ?>">
        </div>
        <!-- Dung lượng -->
        <div class="form-group">
            <label for="capacity">Dung lượng</label>
            <input type="text" id="capacity" name="capacity" value="<?= htmlspecialchars($_POST['capacity'] ?? '') ?>">
        </div>
        <!-- Nhà cung cấp (lưu ý: không lưu vào DB) -->
        <div class="form-group">
            <label for="supplier">Nhà cung cấp</label>
            <input type="text" id="supplier" name="supplier" value="<?= htmlspecialchars($_POST['supplier'] ?? '') ?>">
        </div>
        <!-- Danh mục -->
        <div class="form-group">
            <label for="category">Loại sản phẩm</label>
            <select id="category" name="category" required>
                <option value="">-- Chọn danh mục --</option>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['MaLSP']) ?>" <?= isset($_POST['category']) && $_POST['category'] == $category['MaLSP'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['TenLSP']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">Không có danh mục nào</option>
                <?php endif; ?>
            </select>
        </div>
        <!-- Hình ảnh sản phẩm -->
        <div class="form-group">
            <label for="product-image">Hình ảnh sản phẩm</label>
            <input type="file" id="product-image" name="product_image" accept="image/jpeg,image/png,image/gif">
            <div class="image-preview">
                <img id="image-preview-img" src="#" alt="Ảnh sản phẩm">
            </div>
        </div>
        <!-- Mô tả sản phẩm -->
        <div class="form-group">
            <label for="description">Mô tả sản phẩm</label>
            <textarea id="description" name="description" rows="4"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        </div>
        <!-- Số lượng -->
        <div class="form-group">
            <label for="quantity">Số lượng</label>
            <input type="number" id="quantity" name="quantity" min="1" value="<?= htmlspecialchars($_POST['quantity'] ?? '1') ?>">
        </div>
        <!-- Hành động -->
        <div class="form-actions">
            <button type="submit">Thêm sản phẩm</button>
            <button type="reset">Làm lại</button>
        </div>
    </form>

    <footer class="end__heading-end">
        <div class="end__heading-end-information-group">
            <span class="end__heading-end-information end__heading-end-information-name"><b>CÔNG TY PROTECH</b></span>
            <span class="end__heading-end-information">© 2024 - Bản quyền thuộc về Công ty ProTech</span>
        </div>
    </footer>

    <script>
        // Preview ảnh
        document.getElementById('product-image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewImg = document.getElementById('image-preview-img');
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            const maxSize = 5 * 1024 * 1024; // 5MB

            if (file) {
                if (!allowedTypes.includes(file.type)) {
                    alert('Chỉ chấp nhận file JPEG, PNG hoặc GIF.');
                    event.target.value = '';
                    previewImg.style.display = 'none';
                    return;
                }
                if (file.size > maxSize) {
                    alert('Kích thước file không được vượt quá 5MB.');
                    event.target.value = '';
                    previewImg.style.display = 'none';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                previewImg.style.display = 'none';
            }
        });

        // Reset form
        document.querySelector('button[type="reset"]').addEventListener('click', function() {
            document.querySelector('form').reset();
            document.getElementById('image-preview-img').style.display = 'none';
        });
    </script>
</body>
</html>