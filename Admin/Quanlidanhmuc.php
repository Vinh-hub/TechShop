<?php
session_start();
require_once "../BackEnd/DB_driver.php";

$db = new DB_driver();
$db->connect();

// Xử lý thêm danh mục
if (isset($_POST['add_category'])) {
    $tenLSP = $_POST['tenLSP'];
    $moTa = $_POST['moTa'];

    // Xử lý upload hình ảnh
    $hinhAnh = '';
    if (isset($_FILES['hinhAnh']) && $_FILES['hinhAnh']['error'] == 0) {
        $upload_dir = '../assets/imgs/';
        $file_name = time() . '_' . basename($_FILES['hinhAnh']['name']);
        $target_file = $upload_dir . $file_name;

        // Kiểm tra loại file (chỉ cho phép hình ảnh)
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES['hinhAnh']['tmp_name'], $target_file)) {
                $hinhAnh = '/assets/imgs/' . $file_name;
            } else {
                $_SESSION['error'] = "Lỗi khi tải lên hình ảnh.";
                header("Location: Quanlidanhmuc.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Chỉ chấp nhận file hình ảnh (JPG, JPEG, PNG, GIF).";
            header("Location: Quanlidanhmuc.php");
            exit();
        }
    }

    $data = [
        'TenLSP' => $tenLSP,
        'HinhAnh' => $hinhAnh,
        'Mota' => $moTa
    ];

    $result = $db->insert('loaisanpham', $data);
    if ($result) {
        $_SESSION['message'] = "Thêm danh mục thành công!";
    } else {
        $_SESSION['error'] = "Lỗi khi thêm danh mục.";
    }
    header("Location: Quanlidanhmuc.php");
    exit();
}

// Xử lý xóa danh mục
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Kiểm tra xem danh mục có đang được sử dụng trong bảng sanpham hay không
    $check_usage = $db->get_row("SELECT COUNT(*) as count FROM sanpham WHERE MaLSP = ?", [$delete_id]);
    if ($check_usage['count'] > 0) {
        $_SESSION['error'] = "Không thể xóa danh mục này vì có sản phẩm đang sử dụng nó.";
    } else {
        // Xóa danh mục
        $result = $db->remove('loaisanpham', 'MaLSP = ?', [$delete_id]);
        if ($result) {
            $_SESSION['message'] = "Xóa danh mục thành công!";
        } else {
            $_SESSION['error'] = "Lỗi khi xóa danh mục.";
        }
    }
    // Chuyển hướng lại trang để làm mới danh sách
    header("Location: Quanlidanhmuc.php");
    exit();
}

// Lấy danh sách danh mục từ cơ sở dữ liệu
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
if (!empty($search_query)) {
    $categories = $db->get_list("SELECT * FROM loaisanpham WHERE TenLSP LIKE ?", ["%$search_query%"]);
} else {
    $categories = $db->get_list("SELECT * FROM loaisanpham");
}

$db->dis_connect();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý danh mục</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <style>
        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-container {
            margin-bottom: 20px;
            text-align: center;
        }

        .search-container input {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .addcate {
            text-align: center;
            margin-bottom: 20px;
        }

        .addcate button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .addcate button:hover {
            background-color: #218838;
        }

        .form-container {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
            display: none;
        }

        .form-container h2 {
            margin-top: 0;
        }

        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-container input, .form-container textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-container button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 10px;
        }

        .form-container button[type="submit"] {
            background-color: #28a745;
            color: white;
        }

        .form-container button[type="submit"]:hover {
            background-color: #218838;
        }

        .form-container button.cancel-btn {
            background-color: #6c757d;
            color: white;
        }

        .form-container button.cancel-btn:hover {
            background-color: #5a6268;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f9;
            font-weight: bold;
        }

        td img {
            width: 100px;
            height: 100px;
            border-radius: 4px;
        }

        .description {
            max-width: 300px;
            white-space: pre-wrap;
            overflow-wrap: break-word;
        }

        .details-btn, .delete-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 5px;
        }

        .details-btn {
            background-color: #007bff;
            color: white;
        }

        .details-btn:hover {
            background-color: #0056b3;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        .message, .error {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
        }

        .message {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Quản Lý Danh Mục</h1>

        <!-- Hiển thị thông báo -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Nút thêm danh mục -->
        <div class="addcate">
            <button onclick="toggleForm()">Thêm danh mục</button>
        </div>

        <!-- Form thêm danh mục -->
        <div class="form-container" id="addCategoryForm">
            <h2>Thêm Danh Mục Mới</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <label for="tenLSP">Tên Loại Sản Phẩm:</label>
                <input type="text" name="tenLSP" id="tenLSP" required>
                
                <label for="hinhAnh">Hình Ảnh:</label>
                <input type="file" name="hinhAnh" id="hinhAnh" accept="image/*">
                
                <label for="moTa">Mô Tả:</label>
                <textarea name="moTa" id="moTa" rows="4"></textarea>
                
                <button type="submit" name="add_category">Thêm Danh Mục</button>
                <button type="button" class="cancel-btn" onclick="toggleForm()">Hủy</button>
            </form>
        </div>

        <!-- Ô tìm kiếm -->
        <div class="search-container">
            <input type="text" id="searchInput1" placeholder="Tìm kiếm danh mục" value="<?php echo htmlspecialchars($search_query); ?>" />
        </div>

        <!-- Bảng quản lý danh mục -->
        <table id="categoriesTable">
            <thead>
                <tr>
                    <th>MaLSP</th>
                    <th>TenLSP</th>
                    <th>HinhAnh</th>
                    <th>Mota</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($category['MaLSP']); ?></td>
                            <td><?php echo htmlspecialchars($category['TenLSP']); ?></td>
                            <td>
                                <?php if (!empty($category['HinhAnh'])): ?>
                                    <img src="..<?php echo htmlspecialchars('/' . $category['HinhAnh']); ?>" alt="<?php echo htmlspecialchars($category['TenLSP']); ?>">

                                <?php else: ?>
                                    Không có hình ảnh
                                <?php endif; ?>
                            </td>
                            <td class="description"><?php echo htmlspecialchars($category['Mota'] ?? 'Chưa có mô tả.'); ?></td>
                            <td>
                                <button class="details-btn" onclick="window.location.href='suaDanhmuc.php?id=<?php echo $category['MaLSP']; ?>'">Sửa</button>
                                <button class="delete-btn" onclick="confirmDelete(<?php echo $category['MaLSP']; ?>)">Xóa</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Không có danh mục nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Lắng nghe sự kiện khi người dùng nhấn phím Enter để tìm kiếm
        document.getElementById('searchInput1').addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                let inputValue = document.getElementById('searchInput1').value.trim();
                let newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?search=' + encodeURIComponent(inputValue);
                window.location.href = newUrl;
            }
        });

        // Hàm xác nhận xóa danh mục
        function confirmDelete(categoryId) {
            if (confirm("Bạn có chắc chắn muốn xóa danh mục này không?")) {
                window.location.href = 'Quanlidanhmuc.php?delete_id=' + categoryId;
            }
        }

        // Hàm hiển thị/ẩn form thêm danh mục
        function toggleForm() {
            const form = document.getElementById('addCategoryForm');
            form.style.display = form.style.display === 'none' || form.style.display === '' ? 'block' : 'none';
        }
    </script>
</body>
</html>