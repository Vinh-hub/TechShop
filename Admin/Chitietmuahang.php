<?php
session_start();
require_once "../BackEnd/DB_driver.php";

// Kiểm tra đăng nhập và quyền admin (MaQuyen = 2 hoặc 3)
if (!isset($_SESSION['MaND'])) {
    $_SESSION['error'] = "Vui lòng đăng nhập.";
    file_put_contents('debug.log', "Redirect to login.php from Chitietmuahang.php at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
    header("Location: ../login.php");
    exit();
}

$db = new DB_driver();
$db->connect();

try {
    $user = $db->get_row("SELECT * FROM nguoidung WHERE MaND = ?", [$_SESSION['MaND']]);
    if (!$user || !in_array($user['MaQuyen'], [2, 3])) {
        $_SESSION['error'] = !$user ? "Người dùng không tồn tại." : "Bạn không có quyền truy cập.";
        file_put_contents('debug.log', "Redirect to index.php from Chitietmuahang.php at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
        header("Location: ../index.php");
        exit();
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Lỗi DB: " . $e->getMessage();
    file_put_contents('debug.log', "Redirect to index.php: DB error in Chitietmuahang.php at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
    header("Location: ../index.php");
    exit();
}

// Kiểm tra CSRF token và MaHD
if (!isset($_GET['MaHD']) || !is_numeric($_GET['MaHD']) || !isset($_GET['csrf_token']) || $_GET['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['error'] = "Yêu cầu không hợp lệ.";
    header("Location: Quanlydonhang.php");
    exit();
}

$maHD = (int)$_GET['MaHD'];

// Xử lý cập nhật trạng thái
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    $newStatus = $_POST['status'];
    $currentOrder = $db->get_row("SELECT TrangThai FROM hoadon WHERE MaHD = ?", [$maHD]);
    
    if ($currentOrder) {
        $currentStatus = $currentOrder['TrangThai'];
        $allowedTransitions = [
            'Chưa xử lý' => ['Đã xác nhận', 'Đã giao thành công', 'Đã hủy'],
            'Đã xác nhận' => ['Đã giao thành công', 'Đã hủy'],
            'Đã giao thành công' => [],
            'Đã hủy' => []
        ];

        if (in_array($newStatus, $allowedTransitions[$currentStatus])) {
            try {
                $db->update('hoadon', ['TrangThai' => $newStatus], 'MaHD = ?', [$maHD]);
                $_SESSION['message'] = "Cập nhật trạng thái thành công!";
            } catch (Exception $e) {
                $_SESSION['error'] = "Lỗi khi cập nhật trạng thái: " . $e->getMessage();
            }
        } else {
            $_SESSION['error'] = "Trạng thái không hợp lệ hoặc không thể chuyển ngược.";
        }
    } else {
        $_SESSION['error'] = "Đơn hàng không tồn tại.";
    }
    header("Location: Chitietmuahang.php?MaHD=$maHD&csrf_token=" . $_SESSION['csrf_token']);
    exit();
}

// Lấy thông tin đơn hàng
$order = $db->get_row("
    SELECT h.MaHD, h.NguoiNhan, h.SDT, h.DiaChi, h.PhuongThucTT, h.TrangThai, h.TongTien
    FROM hoadon h
    WHERE h.MaHD = ?
", [$maHD]);

if (!$order) {
    $_SESSION['error'] = "Đơn hàng không tồn tại.";
    header("Location: Quanlydonhang.php");
    exit();
}

// Lấy chi tiết sản phẩm
$orderDetails = $db->get_list("
    SELECT ct.MaSP, sp.TenSP, lsp.TenLSP, ct.SoLuong, ct.DonGia
    FROM chitiethoadon ct
    JOIN sanpham sp ON ct.MaSP = sp.MaSP
    JOIN loaisanpham lsp ON sp.MaLSP = lsp.MaLSP
    WHERE ct.MaHD = ?
", [$maHD]);

// Định nghĩa trạng thái hợp lệ tiếp theo
$allowedTransitions = [
    'Chưa xử lý' => ['Đã xác nhận', 'Đã giao thành công', 'Đã hủy'],
    'Đã xác nhận' => ['Đã giao thành công', 'Đã hủy'],
    'Đã giao thành công' => [],
    'Đã hủy' => []
];
$nextStatuses = $allowedTransitions[$order['TrangThai']] ?? [];

$db->dis_connect();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTech - Chi Tiết Đơn Hàng</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="/TechShop/assets/css/Dashboard.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f8fa;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
            color: #333;
        }
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            font-family: 'Montserrat', sans-serif;
            color: #333;
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 30px;
        }
        .order-info, .customer-info, .order-details, .order-total {
            margin-top: 30px;
        }
        .order-info h2, .customer-info h2, .order-details h2, .order-total h2 {
            font-size: 24px;
            color: #333;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 15px;
            font-family: 'Montserrat', sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            font-weight: 700;
            background-color: #f0f0f0;
        }
        .order-total {
            text-align: right;
        }
        .order-total th, .order-total td {
            font-size: 18px;
            font-weight: 700;
        }
        .error, .message {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .message {
            background-color: #d4edda;
            color: #155724;
        }
        footer {
            margin-top: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .status-form {
            margin: 20px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .status-form select {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
        }
        .status-form select:disabled {
            background-color: #f0f0f0;
            cursor: not-allowed;
        }
        .status-form button {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
        .status-form button:hover {
            background-color: #2980b9;
        }
        .status-form button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
        .back-btn {
            display: inline-block;
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #666;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .back-btn:hover {
            background-color: #555;
        }
        .order-details table td, .order-details table th {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Chi Tiết Mua Hàng</h1>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message">
                <?= htmlspecialchars($_SESSION['message']) ?>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <a href="./Quanlidonhang.php" class="back-btn">Quay lại</a>

        <div class="order-info">
            <h2>Thông Tin Đơn Hàng</h2>
            <table>
                <tr>
                    <th>Mã Đơn Hàng</th>
                    <td>#DH<?= sprintf("%03d", $order['MaHD']) ?></td>
                </tr>
                <tr>
                    <th>Phương Thức Thanh Toán</th>
                    <td><?= htmlspecialchars($order['PhuongThucTT']) ?></td>
                </tr>
                <tr>
                    <th>Trạng Thái Hàng</th>
                    <td><?= htmlspecialchars($order['TrangThai']) ?></td>
                </tr>
            </table>
            <!-- Form cập nhật trạng thái -->
            <form class="status-form" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <label for="status">Cập nhật trạng thái:</label>
                <select name="status" id="status" <?= empty($nextStatuses) ? 'disabled' : '' ?>>
                    <option value="">Chọn trạng thái</option>
                    <?php foreach ($nextStatuses as $status): ?>
                        <option value="<?= $status ?>"><?= $status ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="update_status" <?= empty($nextStatuses) ? 'disabled' : '' ?>>Cập nhật</button>
            </form>
        </div>

        <div class="customer-info">
            <h2>Thông Tin Khách Hàng</h2>
            <table>
                <tr>
                    <th>Tên Khách Hàng</th>
                    <td><?= htmlspecialchars($order['NguoiNhan']) ?></td>
                </tr>
                <tr>
                    <th>Địa Chỉ</th>
                    <td><?= htmlspecialchars($order['DiaChi']) ?></td>
                </tr>
                <tr>
                    <th>SĐT</th>
                    <td><?= htmlspecialchars($order['SDT']) ?></td>
                </tr>
            </table>
        </div>

        <div class="order-details">
            <h2>Chi Tiết Sản Phẩm</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tên Sản Phẩm</th>
                        <th>Danh mục</th>
                        <th>Số Lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orderDetails)): ?>
                        <tr>
                            <td colspan="5">Không có sản phẩm trong đơn hàng.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($orderDetails as $detail): ?>
                            <tr>
                                <td><?= htmlspecialchars($detail['TenSP']) ?></td>
                                <td><?= htmlspecialchars($detail['TenLSP']) ?></td>
                                <td><?= $detail['SoLuong'] ?></td>
                                <td><?= number_format($detail['DonGia'], 0, ',', '.') ?> VNĐ</td>
                                <td><?= number_format($detail['SoLuong'] * $detail['DonGia'], 0, ',', '.') ?> VNĐ</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="order-total">
            <h2>Tổng Cộng Đơn Hàng</h2>
            <table>
                <tr>
                    <th>Tổng Cộng</th>
                    <td><?= number_format($order['TongTien'], 0, ',', '.') ?> VNĐ</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>