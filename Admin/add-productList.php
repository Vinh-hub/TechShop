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
            <label for="color">Dung lượng</label>
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
                <option value="electronics">Điện thoại</option>
                <option value="fashion">Laptop</option>
                <option value="home">Đồng hồ</option>
                <option value="beauty">Máy tính bảng</option>
                <option value="sports">Màn hình</option>
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
//     // Chọn nút Thêm sản phẩm
// document.querySelector('button[type="submit"]').addEventListener('click', function(event) {
//     event.preventDefault(); // Ngăn form submit nếu có
//     alert('Đã thêm sản phẩm');
//     // Chuyển đến trang add-productList
//     window.location.href = 'Quanlisanpham.php';
// });

// Chọn nút Làm lại
document.querySelector('button[type="reset"]').addEventListener('click', function() {
    location.reload(); // Load lại trang
});
</script>
</html>