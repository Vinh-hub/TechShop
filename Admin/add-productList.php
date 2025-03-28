<?php
require_once "../BackEnd/DB_driver.php";

// Tạo đối tượng DB_driver
$db = new DB_driver();
$db->connect(); // Kết nối cơ sở dữ liệu

// Xử lý dữ liệu từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $ten_sp = $_POST['product_name'] ?? '';
    $don_gia = $_POST['price'] ?? '';
    $mau = $_POST['color'] ?? '';
    $dung_luong = $_POST['capacity'] ?? '';
    $mo_ta = $_POST['description'] ?? '';
    $so_luong = $_POST['quantity'] ?? 1; // Mặc định là 1 nếu không nhập
    $ma_lsp = $_POST['category'] ?? ''; // Giả sử category tương ứng với MaLSP

    // Xử lý upload hình ảnh
    $hinh_anh = "";
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $target_dir = "../assets/imgs/"; // Thư mục lưu ảnh (tương đối từ admin/)
        $image_name = basename($_FILES["product_image"]["name"]);
        $target_file = $target_dir . $image_name;
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            // Lưu đường dẫn từ gốc: /assets/imgs/ten_anh
            $hinh_anh = "/assets/imgs/" . $image_name;
        } else {
            echo "Lỗi khi upload hình ảnh.";
            exit();
        }
    }

    // Giá trị mặc định cho các trường không có trong form
    $ma_km = 0; // Mã khuyến mãi mặc định (có thể thay đổi)
    $trang_thai = 1; // Trạng thái mặc định (1 = hoạt động, có thể thay đổi)

    // Chuẩn bị dữ liệu để lưu vào bảng sanpham
    $data = [
        'MaLSP' => $ma_lsp, // Giả sử category là MaLSP (cần điều chỉnh nếu khác)
        'TenSP' => $ten_sp,
        'DonGia' => $don_gia,
        'Mau' => $mau,
        'DungLuong' => $dung_luong,
        'HinhAnh' => $hinh_anh,
        'MaKM' => $ma_km,
        'MoTa' => $mo_ta,
        'SoLuong' => $so_luong,
        'TrangThai' => $trang_thai
    ];

    // Sử dụng phương thức insert của DB_driver
    $result = $db->insert('sanpham', $data);

    if ($result) {
        // Chuyển hướng về trang quản lý sản phẩm
        header("Location: Quanlisanpham.php");
        exit();
    } else {
        echo "Lỗi khi thêm sản phẩm.";
    }
}

// Ngắt kết nối
$db->dis_connect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản Phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group textarea {
            resize: vertical;
        }
        .form-actions {
            text-align: right;
        }
        .form-actions button {
            padding: 10px 15px;
            font-size: 16px;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <h1>Thêm Sản Phẩm Mới</h1>
    <form action="./add-productList.php" method="POST" enctype="multipart/form-data">
        <!-- Tên sản phẩm -->
        <div class="form-group">
            <label for="product-name">Tên sản phẩm</label>
            <input type="text" id="product-name" name="product_name" required>
        </div>

        <!-- Giá -->
        <div class="form-group">
            <label for="price">Giá</label>
            <input type="text" id="price" name="price" step="0.01" required>
        </div>

        <!-- Màu sắc -->
        <div class="form-group">
            <label for="color">Màu sắc</label>
            <input type="text" id="color" name="color">
        </div>

        <!-- Dung lượng -->
        <div class="form-group">
            <label for="capacity">Dung lượng</label>
            <input type="text" id="capacity" name="capacity">
        </div>

        <!-- Nhà cung cấp -->
        <div class="form-group">
            <label for="supplier">Nhà cung cấp</label>
            <input type="text" id="supplier" name="supplier">
        </div>

        <!-- Danh mục -->
        <div class="form-group">
            <label for="category">Loại sản phẩm</label>
            <select id="category" name="category" required>
                <option value="">-- Danh mục --</option>
                <option value="1">Điện thoại</option>
                <option value="2">Laptop</option>
                <option value="3">Đồng hồ</option>
                <option value="4">Máy tính bảng</option>
                <option value="5">Màn hình</option>
            </select>
        </div>

        <!-- Hình ảnh sản phẩm -->
        <div class="form-group">
            <label for="product-image">Hình ảnh sản phẩm</label>
            <input type="file" id="product-image" name="product_image" accept="image/*">
        </div>

        <!-- Mô tả sản phẩm -->
        <div class="form-group">
            <label for="description">Mô tả sản phẩm</label>
            <textarea id="description" name="description" rows="4"></textarea>
        </div>

        <!-- Số lượng -->
        <div class="form-group">
            <label for="quantity">Số lượng</label>
            <input type="number" id="quantity" name="quantity" min="1">
        </div>

        <!-- Hành động -->
        <div class="form-actions">
            <button type="submit">Thêm sản phẩm</button>
            <button type="reset">Làm lại</button>
        </div>
    </form>
</body>
<script>
document.querySelector('button[type="reset"]').addEventListener('click', function() {
    location.reload(); // Load lại trang
});
</script>
</html>