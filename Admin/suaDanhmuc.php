<?php
session_start();
require_once "../BackEnd/DB_driver.php";

$db = new DB_driver();
$db->connect();

// Lấy thông tin danh mục để sửa
$category_id = isset($_GET['id']) ? $_GET['id'] : null;
if (!$category_id) {
    $_SESSION['error'] = "Không tìm thấy danh mục!";
    header("Location: Quanlidanhmuc.php");
    exit();
}

$category = $db->get_row("SELECT * FROM loaisanpham WHERE MaLSP = ?", [$category_id]);
if (!$category) {
    $_SESSION['error'] = "Danh mục không tồn tại!";
    header("Location: Quanlidanhmuc.php");
    exit();
}

// Xử lý cập nhật danh mục
if (isset($_POST['update_category'])) {
    $tenLSP = $_POST['tenLSP'];
    $moTa = $_POST['moTa'];

    // Xử lý upload hình ảnh
    $hinhAnh = $category['HinhAnh']; // Giữ hình ảnh cũ nếu không upload hình mới
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
                header("Location: suaDanhmuc.php?id=$category_id");
                exit();
            }
        } else {
            $_SESSION['error'] = "Chỉ chấp nhận file hình ảnh (JPG, JPEG, PNG, GIF).";
            header("Location: suaDanhmuc.php?id=$category_id");
            exit();
        }
    }

    $data = [
        'TenLSP' => $tenLSP,
        'HinhAnh' => $hinhAnh,
        'Mota' => $moTa
    ];

    $result = $db->update('loaisanpham', $data, 'MaLSP = ?', [$category_id]);
    if ($result) {
        $_SESSION['message'] = "Cập nhật danh mục thành công!";
        header("Location: Quanlidanhmuc.php");
        exit();
    } else {
        $_SESSION['error'] = "Lỗi khi cập nhật danh mục.";
        header("Location: suaDanhmuc.php?id=$category_id");
        exit();
    }
}

$db->dis_connect();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Danh Mục</title>
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

        .form-container {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
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

        .form-container img {
            width: 100px;
            height: auto;
            border-radius: 4px;
            margin-bottom: 10px;
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

        .form-container button[type="button"] {
            background-color: #6c757d;
            color: white;
        }

        .form-container button[type="button"]:hover {
            background-color: #5a6268;
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
        <h1>Sửa Danh Mục</h1>

        <!-- Hiển thị thông báo -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Form sửa danh mục -->
        <div class="form-container">
            <h2>Sửa Danh Mục</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <label for="tenLSP">Tên Loại Sản Phẩm:</label>
                <input type="text" name="tenLSP" id="tenLSP" value="<?php echo htmlspecialchars($category['TenLSP']); ?>" required>
                
                <label for="hinhAnh">Hình Ảnh Hiện Tại:</label>
                <?php if (!empty($category['HinhAnh'])): ?>
                    <img src="<?php echo htmlspecialchars($category['HinhAnh']); ?>" alt="<?php echo htmlspecialchars($category['TenLSP']); ?>">
                <?php else: ?>
                    <p>Không có hình ảnh</p>
                <?php endif; ?>
                <label for="hinhAnh">Chọn Hình Ảnh Mới (nếu muốn thay đổi):</label>
                <input type="file" name="hinhAnh" id="hinhAnh" accept="image/*">
                
                <label for="moTa">Mô Tả:</label>
                <textarea name="moTa" id="moTa" rows="4"><?php echo htmlspecialchars($category['Mota'] ?? ''); ?></textarea>
                
                <button type="submit" name="update_category">Cập Nhật</button>
                <button type="button" onclick="window.location.href='Quanlidanhmuc.php'">Hủy</button>
            </form>
        </div>
    </div>
</body>
</html>