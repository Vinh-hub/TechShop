<?php
session_start();
require_once "../BackEnd/DB_driver.php";

$db = new DB_driver();
$db->connect();

// Lấy danh sách danh mục từ bảng loaisanpham
$categories = $db->get_list("SELECT MaLSP, TenLSP FROM loaisanpham");

// Lấy thông tin sản phẩm từ MaSP
if (!isset($_GET['maSP'])) {
    echo "Không tìm thấy sản phẩm.";
    exit();
}

$maSP = $_GET['maSP'];
$product = $db->get_row("SELECT * FROM sanpham WHERE MaSP = ?", [$maSP]);

if (!$product) {
    echo "Sản phẩm không tồn tại.";
    exit();
}

// Xử lý form khi submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenSP = $_POST['product_name'] ?? '';
    $donGia = $_POST['price'] ?? '';
    $phanTramGiam = $_POST['discount_percent'] ?? ''; // Phần trăm giảm giá
    $mau = $_POST['color'] ?? '';
    $dungLuong = $_POST['storage'] ?? '';
    $moTa = $_POST['description'] ?? '';
    $maLSP = $_POST['category'] ?? '';
    $hinhAnh = $product['HinhAnh']; // Giữ nguyên hình cũ nếu không thay đổi

    // Kiểm tra dữ liệu đầu vào
    $errors = [];
    if (empty($tenSP)) $errors[] = "Tên sản phẩm không được để trống.";
    if (!is_numeric($donGia) || $donGia < 0) $errors[] = "Giá hiện tại phải là số không âm.";
    if (!empty($giaCu) && (!is_numeric($giaCu) || $giaCu < 0)) $errors[] = "Giá cũ phải là số không âm.";
    if (!empty($phanTramGiam) && (!is_numeric($phanTramGiam) || $phanTramGiam < 0 || $phanTramGiam > 100)) $errors[] = "Phần trăm giảm giá phải từ 0 đến 100.";
    if (empty($mau)) $errors[] = "Màu không được để trống.";
    if (empty($dungLuong)) $errors[] = "Dung lượng không được để trống.";
    if (empty($maLSP)) $errors[] = "Loại sản phẩm không được để trống.";

    // Xử lý upload hình ảnh mới
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $target_dir = "../assets/imgs/";
        $image_name = basename($_FILES["product_image"]["name"]);
        $target_file = $target_dir . $image_name;
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            $hinhAnh = "/assets/imgs/" . $image_name; // Cập nhật đường dẫn hình ảnh mới
        } else {
            $errors[] = "Lỗi khi upload hình ảnh.";
        }
    }

    // Xử lý xóa hình ảnh
    if (isset($_POST['delete_image']) && $_POST['delete_image'] == '1') {
        $hinhAnh = ''; // Xóa hình ảnh bằng cách đặt về rỗng
    }

    // Nếu không có lỗi, cập nhật dữ liệu
    if (empty($errors)) {
        $data = [
            'TenSP' => $tenSP,
            'DonGia' => $donGia,
            'PhanTramGiam' => $phanTramGiam ?: null, // Lưu phần trăm giảm giá (NULL nếu không nhập)
            'Mau' => $mau,
            'DungLuong' => $dungLuong,
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
    <title>Sửa Thông Tin Sản Phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
            max-width: 100%;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .form-group img {
            width: 100%;
            max-width: 316px;
            height: auto;
            display: block;
            margin-bottom: 10px;
        }

        .form-actions, .form-actionss {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-actions button,
        .form-actionss button {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .form-actionss button {
            margin-right: 10px;
        }

        .form-actions .btn-submit {
            background-color: #007bff;
            color: #ffffff;
        }

        .form-actions .btn-cancel {
            background-color: #6c757d;
            color: #ffffff;
        }

        .form-actionss .btn-changeimage {
            background-color: #007bff;
            color: #ffffff;
        }

        .form-actionss .btn-deleteimage {
            background-color: #e74c3c;
            color: #ffffff;
        }

        .form-actions .btn-submit:hover {
            background-color: #0056b3;
        }

        .form-actions .btn-cancel:hover {
            background-color: #5a6268;
        }

        .form-actionss .btn-changeimage:hover {
            background-color: #0056b3;
        }

        .form-actionss .btn-deleteimage:hover {
            background-color: #c0392b;
        }

        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
        
        .form-group textarea {
            width: 100%;
            min-height: 150px; 
            resize: vertical; 
            white-space: pre-wrap; 
            overflow-wrap: break-word; 
            display: block;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Sửa Thông Tin Sản Phẩm</h2>
        <?php
        if (!empty($errors)) {
            echo '<div class="error">';
            foreach ($errors as $error) {
                echo $error . '<br>';
            }
            echo '</div>';
        }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="product-name">Tên Sản Phẩm:</label>
                <input type="text" id="product-name" name="product_name" value="<?php echo htmlspecialchars($product['TenSP']); ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Giá Hiện Tại:</label>
                <input type="number" id="price" name="price" value="<?php echo $product['DonGia']; ?>" step="1" min="0" required>
            </div>
            <div class="form-group">
                <label for="discount-percent">Phần Trăm Giảm Giá (nếu có):</label>
                <input type="number" id="discount-percent" name="discount_percent" value="<?php echo $product['PhanTramGiam'] ?? ''; ?>" step="1" min="0" max="100">
            </div>
            <div class="form-group">
                <label for="color">Màu:</label>
                <select id="color" name="color" required>
                    <option value="Đen" <?php echo $product['Mau'] == 'Đen' ? 'selected' : ''; ?>>Đen</option>
                    <option value="Xanh" <?php echo $product['Mau'] == 'Xanh' ? 'selected' : ''; ?>>Xanh</option>
                    <option value="Xanh lá" <?php echo $product['Mau'] == 'Xanh lá' ? 'selected' : ''; ?>>Xanh lá</option>
                    <option value="Đỏ" <?php echo $product['Mau'] == 'Đỏ' ? 'selected' : ''; ?>>Đỏ</option>
                </select>
            </div>
            <div class="form-group">
                <label for="storage">Dung Lượng:</label>
                <input type="text" id="storage" name="storage" value="<?php echo htmlspecialchars($product['DungLuong']); ?>" required>
            </div>
            <div class="form-group">
                <label for="category">Loại sản phẩm:</label>
                <select id="category" name="category" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['MaLSP']); ?>" <?php echo $product['MaLSP'] == $category['MaLSP'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['TenLSP']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">Không có danh mục nào</option>
                    <?php endif; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="product-image">Hình ảnh:</label>
                <img id="productImage" src="<?php echo $product['HinhAnh'] ?: '../assets/imgs/default.jpg'; ?>" alt="<?php echo htmlspecialchars($product['TenSP']); ?>">
                <input type="file" id="product-image" name="product_image" accept="image/*" style="display: none;">
                <input type="hidden" id="delete-image" name="delete_image" value="0">
            </div>
            <div class="form-actionss">
                <button type="button" class="btn-changeimage">Thay đổi hình</button>
                <button type="button" class="btn-deleteimage">Xóa hình</button>
            </div>
            <div class="form-group">
                <label for="description">Mô tả sản phẩm:</label>
                <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($product['MoTa']); ?></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-submit">Lưu Thay Đổi</button>
                <button type="button" class="btn-cancel">Hủy</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('product-image');
            const productImage = document.getElementById('productImage');
            const changeImageButton = document.querySelector('.btn-changeimage');
            const deleteImageButton = document.querySelector('.btn-deleteimage');
            const deleteImageInput = document.getElementById('delete-image');
            const cancelButton = document.querySelector('.btn-cancel');

            // Nút Thay đổi hình
            changeImageButton.addEventListener('click', function() {
                fileInput.click();
            });

            // Khi chọn file mới
            fileInput.addEventListener('change', function() {
                if (fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        productImage.src = e.target.result;
                        deleteImageInput.value = '0'; // Đặt lại flag xóa hình
                        alert('Hình ảnh đã được thay đổi (chưa lưu)!');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Nút Xóa hình
            deleteImageButton.addEventListener('click', function() {
                if (confirm('Bạn có chắc muốn xóa hình này không?')) {
                    productImage.src = '../assets/imgs/default.jpg'; // Hình mặc định
                    fileInput.value = ''; // Xóa file đã chọn
                    deleteImageInput.value = '1'; // Đặt flag để xóa hình khi submit
                    alert('Hình ảnh sẽ bị xóa khi bạn lưu thay đổi!');
                }
            });

            // Nút Hủy
            cancelButton.addEventListener('click', function() {
                window.location.href = 'Quanlisanpham.php';
            });
        });
    </script>
</body>
</html>