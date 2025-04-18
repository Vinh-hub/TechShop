<?php
session_start();
require_once "../BackEnd/DB_driver.php";

// Kiểm tra đăng nhập admin
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

// Lấy danh sách danh mục
$categories = $db->get_list("SELECT MaLSP, TenLSP FROM loaisanpham");

// Lấy thông tin sản phẩm
if (!isset($_GET['maSP']) || !is_numeric($_GET['maSP'])) {
    $_SESSION['error'] = "Không tìm thấy sản phẩm.";
    header("Location: Quanlisanpham.php");
    exit();
}

$maSP = (int)$_GET['maSP'];
$product = $db->get_row("SELECT * FROM sanpham WHERE MaSP = ?", [$maSP]);
if (!$product) {
    $_SESSION['error'] = "Sản phẩm không tồn tại.";
    header("Location: Quanlisanpham.php");
    exit();
}

// Xử lý form khi submit
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenSP = trim($_POST['product_name'] ?? '');
    $donGia = trim($_POST['price'] ?? '');
    $phanTramGiam = trim($_POST['discount_percent'] ?? '');
    $mau = trim($_POST['color'] ?? '');
    $dungLuong = trim($_POST['storage'] ?? '');
    $moTa = trim($_POST['description'] ?? '');
    $maLSP = trim($_POST['category'] ?? '');
    $hinhAnh = $product['HinhAnh'];

    // Kiểm tra dữ liệu đầu vào
    if (empty($tenSP)) $errors[] = "Tên sản phẩm không được để trống.";
    if (!is_numeric($donGia) || $donGia < 0) $errors[] = "Giá hiện tại phải là số không âm.";
    if (!empty($phanTramGiam) && (!is_numeric($phanTramGiam) || $phanTramGiam < 0 || $phanTramGiam > 100)) {
        $errors[] = "Phần trăm giảm giá phải từ 0 đến 100.";
    }
    if (empty($mau)) $errors[] = "Màu không được để trống.";
    if (empty($maLSP)) $errors[] = "Loại sản phẩm không được để trống.";

    // Xử lý upload hình ảnh mới
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
            $image_name = time() . '_' . basename($_FILES["product_image"]["name"]);
            $target_file = $target_dir . $image_name;
            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                $hinhAnh = "/assets/imgs/" . $image_name;
            } else {
                $errors[] = "Lỗi khi upload hình ảnh.";
            }
        }
    }

    // Xử lý xóa hình ảnh
    if (isset($_POST['delete_image']) && $_POST['delete_image'] == '1') {
        $hinhAnh = '';
    }

    // Nếu không có lỗi, cập nhật dữ liệu
    if (empty($errors)) {
        $data = [
            'TenSP' => $tenSP,
            'DonGia' => $donGia,
            'PhanTramGiam' => $phanTramGiam ?: null,
            'Mau' => $mau,
            'DungLuong' => $dungLuong ?: null,
            'MoTa' => $moTa,
            'MaLSP' => $maLSP,
            'HinhAnh' => $hinhAnh
        ];

        $result = $db->update('sanpham', $data, 'MaSP = ?', [$maSP]);
        if ($result) {
            $_SESSION['message'] = "Cập nhật sản phẩm thành công!";
            header("Location: Quanlisanpham.php");
            exit();
        } else {
            $errors[] = "Lỗi khi cập nhật sản phẩm.";
        }
    }
}

$db->dis_connect();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTech - Sửa Sản Phẩm</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="/TechShop/assets/css/Dashboard.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 20px;
            background-color: #f5f7fa;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            font-family: 'Montserrat', sans-serif;
            color: #333;
            margin-bottom: 20px;
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
        .form-group img {
            max-width: 200px;
            max-height: 200px;
            border-radius: 5px;
            margin-top: 10px;
            display: block;
        }
        .form-actions, .form-actionss {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 10px;
        }
        .form-actions button,
        .form-actionss button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-actions .btn-submit {
            background-color: #007bff;
            color: white;
        }
        .form-actions .btn-cancel {
            background-color: #6c757d;
            color: white;
        }
        .form-actionss .btn-changeimage {
            background-color: #007bff;
            color: white;
        }
        .form-actionss .btn-deleteimage {
            background-color: #dc3545;
            color: white;
        }
        .form-actions button:hover,
        .form-actionss button:hover {
            opacity: 0.9;
        }
        .error {
            color: #dc3545;
            font-size: 0.9rem;
            margin-bottom: 10px;
            text-align: center;
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
    <div class="form-container">
        <h2>Sửa Thông Tin Sản Phẩm</h2>
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?= implode('<br>', $errors) ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <!-- Tên sản phẩm -->
            <div class="form-group">
                <label for="product-name">Tên sản phẩm</label>
                <input type="text" id="product-name" name="product_name" value="<?= htmlspecialchars($product['TenSP']) ?>" required>
            </div>
            <!-- Giá -->
            <div class="form-group">
                <label for="price">Giá hiện tại</label>
                <input type="number" id="price" name="price" step="0.01" min="0" value="<?= htmlspecialchars($product['DonGia']) ?>" required>
            </div>
            <!-- Phần trăm giảm giá -->
            <div class="form-group">
                <label for="discount-percent">Phần trăm giảm giá (nếu có)</label>
                <input type="number" id="discount-percent" name="discount_percent" step="1" min="0" max="100" value="<?= htmlspecialchars($product['PhanTramGiam'] ?? '') ?>">
            </div>
            <!-- Màu -->
            <div class="form-group">
                <label for="color">Màu</label>
                <select id="color" name="color" required>
                    <option value="Đen" <?= $product['Mau'] == 'Đen' ? 'selected' : '' ?>>Đen</option>
                    <option value="Xanh" <?= $product['Mau'] == 'Xanh' ? 'selected' : '' ?>>Xanh</option>
                    <option value="Xanh lá" <?= $product['Mau'] == 'Xanh lá' ? 'selected' : '' ?>>Xanh lá</option>
                    <option value="Đỏ" <?= $product['Mau'] == 'Đỏ' ? 'selected' : '' ?>>Đỏ</option>
                </select>
            </div>
            <!-- Dung lượng -->
            <div class="form-group">
                <label for="storage">Dung lượng</label>
                <input type="text" id="storage" name="storage" value="<?= htmlspecialchars($product['DungLuong'] ?? '') ?>">
            </div>
            <!-- Danh mục -->
            <div class="form-group">
                <label for="category">Loại sản phẩm</label>
                <select id="category" name="category" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category['MaLSP']) ?>" <?= $product['MaLSP'] == $category['MaLSP'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['TenLSP']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">Không có danh mục nào</option>
                    <?php endif; ?>
                </select>
            </div>
            <!-- Hình ảnh -->
            <div class="form-group">
                <label for="product-image">Hình ảnh</label>
                <img id="productImage" src="<?= $product['HinhAnh'] ? '/TechShop' . htmlspecialchars($product['HinhAnh']) : '/TechShop/assets/imgs/default.jpg' ?>" alt="<?= htmlspecialchars($product['TenSP']) ?>">
                <input type="file" id="product-image" name="product_image" accept="image/jpeg,image/png,image/gif" style="display: none;">
                <input type="hidden" id="delete-image" name="delete_image" value="0">
            </div>
            <div class="form-actionss">
                <button type="button" class="btn-changeimage">Thay đổi hình</button>
                <button type="button" class="btn-deleteimage">Xóa hình</button>
            </div>
            <!-- Mô tả -->
            <div class="form-group">
                <label for="description">Mô tả sản phẩm</label>
                <textarea id="description" name="description" rows="4"><?= htmlspecialchars($product['MoTa'] ?? '') ?></textarea>
            </div>
            <!-- Hành động -->
            <div class="form-actions">
                <button type="submit" class="btn-submit">Lưu thay đổi</button>
                <button type="button" class="btn-cancel">Hủy</button>
            </div>
        </form>
    </div>

    <footer class="end__heading-end">
        <div class="end__heading-end-information-group">
            <span class="end__heading-end-information end__heading-end-information-name"><b>CÔNG TY PROTECH</b></span>
            <span class="end__heading-end-information">© 2024 - Bản quyền thuộc về Công ty ProTech</span>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('product-image');
            const productImage = document.getElementById('productImage');
            const changeImageButton = document.querySelector('.btn-changeimage');
            const deleteImageButton = document.querySelector('.btn-deleteimage');
            const deleteImageInput = document.getElementById('delete-image');
            const cancelButton = document.querySelector('.btn-cancel');

            // Thay đổi hình
            changeImageButton.addEventListener('click', function() {
                fileInput.click();
            });

            // Preview ảnh mới
            fileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                const maxSize = 5 * 1024 * 1024; // 5MB

                if (file) {
                    if (!allowedTypes.includes(file.type)) {
                        alert('Chỉ chấp nhận file JPEG, PNG hoặc GIF.');
                        fileInput.value = '';
                        return;
                    }
                    if (file.size > maxSize) {
                        alert('Kích thước file không được vượt quá 5MB.');
                        fileInput.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        productImage.src = e.target.result;
                        deleteImageInput.value = '0';
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Xóa hình
            deleteImageButton.addEventListener('click', function() {
                if (confirm('Bạn có chắc muốn xóa hình này không?')) {
                    productImage.src = '/TechShop/assets/imgs/default.jpg';
                    fileInput.value = '';
                    deleteImageInput.value = '1';
                }
            });

            // Hủy
            cancelButton.addEventListener('click', function() {
                window.location.href = 'Quanlisanpham.php';
            });
        });
    </script>
</body>
</html>