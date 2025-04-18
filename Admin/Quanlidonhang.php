<?php
session_start();
require_once "../BackEnd/DB_driver.php";

// Kiểm tra đăng nhập và quyền admin (MaQuyen = 3)
if (!isset($_SESSION['MaND'])) {
    $_SESSION['error'] = "Vui lòng đăng nhập.";
    file_put_contents('debug.log', "Redirect to login.php from Quanlydonhang.php at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
    header("Location: ../login.php");
    exit();
}

$db = new DB_driver();
$db->connect();

try {
    $user = $db->get_row("SELECT * FROM nguoidung WHERE MaND = ?", [$_SESSION['MaND']]);
    if  (!$user || (isset($user['MaQuyen']) && !in_array($user['MaQuyen'], [2, 3]))) {
        $_SESSION['error'] = !$user ? "Người dùng không tồn tại." : "Bạn không có quyền admin.";
        file_put_contents('debug.log', "Redirect to index.php from Quanlydonhang.php at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
        header("Location: ../index.php");
        exit();
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Lỗi DB: " . $e->getMessage();
    file_put_contents('debug.log', "Redirect to index.php: DB error in Quanlydonhang.php at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
    header("Location: ../index.php");
    exit();
}

// Tạo CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Xử lý tìm kiếm
$searchDate = trim($_GET['search_date'] ?? '');
$searchStatus = trim($_GET['search_status'] ?? '');
$conditions = [];
$params = [];

if ($searchDate) {
    $conditions[] = "DATE_FORMAT(h.NgayLap, '%Y-%m-%d') LIKE ?";
    $params[] = "%$searchDate%";
}

if ($searchStatus) {
    $statusMap = [
        'chưa xử lý' => 'Chưa xử lý',
        'đã xác nhận' => 'Đã xác nhận',
        'đã giao thành công' => 'Đã giao thành công',
        'đã hủy' => 'Đã hủy'
    ];
    $searchStatusLower = strtolower($searchStatus);
    foreach ($statusMap as $key => $value) {
        if (strpos($searchStatusLower, $key) !== false) {
            $conditions[] = "h.TrangThai = ?";
            $params[] = $value;
            break;
        }
    }
}

$whereClause = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';

// Phân trang
$itemsPerPage = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

// Đếm tổng số hóa đơn
$countQuery = "SELECT COUNT(*) as total FROM hoadon h $whereClause";
$totalOrders = $db->get_row($countQuery, $params)['total'];
$totalPages = ceil($totalOrders / $itemsPerPage);

// Lấy danh sách hóa đơn
$query = "
    SELECT h.MaHD, h.NguoiNhan, h.SDT, h.NgayLap, h.TrangThai, h.DiaChi, h.TongTien, 
           nd.TaiKhoan, SUM(ct.SoLuong) as SoLuong
    FROM hoadon h
    JOIN nguoidung nd ON h.MaND = nd.MaND
    LEFT JOIN chitiethoadon ct ON h.MaHD = ct.MaHD
    $whereClause
    GROUP BY h.MaHD
    ORDER BY h.NgayLap DESC
    LIMIT ? OFFSET ?
";

$orders = $db->get_list($query, array_merge($params, [$itemsPerPage, $offset]));

$db->dis_connect();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTech - Quản Lý Đơn Hàng</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="/TechShop/assets/css/Dashboard.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f8fa;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            color: #333;
        }
        .container {
            width: 90%;
            margin: 40px auto;
            padding: 20px 40px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            font-family: 'Montserrat', sans-serif;
            color: #333;
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 30px;
        }
        .search-container {
            text-align: center;
            margin-bottom: 20px;
            display: flex;
            gap: 20px;
            align-items: center;
            justify-content: center;
        }

        .search-container button{
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }


        #searchInput1, #searchInput2 {
            padding: 12px 20px;
            font-size: 16px;
            width: 30%;
            border: 1px solid #ddd;
            border-radius: 25px;
            outline: none;
            transition: border-color 0.3s ease;
        }
        #searchInput1:focus, #searchInput2:focus {
            border-color: #3498db;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
        }
        th {
            padding: 16px 20px;
            text-align: center;
            font-weight: 700;
            font-size: 16px;
            background-color: #f0f0f0;
            color: #333;
            border: 1px solid #ddd;
        }
        td {
            padding: 16px 20px;
            text-align: center;
            font-size: 14px;
            color: #555;
            border: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        tr:hover {
            background-color: #f1f1f1;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .details-btn {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .details-btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        .details-btn:active {
            background-color: #1f618d;
            transform: translateY(2px);
        }
        .status-processing {
            font-weight: 600;
            color: #f39c12;
        }
        .status-completed {
            font-weight: 600;
            color: #2ecc71;
        }
        .status-pending {
            font-weight: 600;
            color: #f1c40f;
        }
        .status-confirmed {
            font-weight: 600;
            color: #3498db;
        }
        .status-cancelled {
            font-weight: 600;
            color: #e74c3c;
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination a {
            display: inline-block;
            padding: 8px 16px;
            margin: 0 4px;
            text-decoration: none;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .pagination a.active {
            background-color: #3498db;
            color: white;
            border-color: #3498db;
        }
        .pagination a:hover:not(.active) {
            background-color: #f1f1f1;
        }
        .pagination a.disabled {
            color: #ccc;
            cursor: not-allowed;
        }
        .message, .error {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
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
        <h1>Quản Lý Đơn Hàng</h1>
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
        <!-- Ô tìm kiếm -->
        <form class="search-container" method="GET">
            <input type="text" id="searchInput1" name="search_date" placeholder="Tìm kiếm theo ngày (YYYY-MM-DD)" value="<?= htmlspecialchars($searchDate) ?>">
            <select id="searchInput2" name="search_status">
                <option value="">Tất cả trạng thái</option>
                <option value="chưa xử lý" <?= $searchStatus == 'chưa xử lý' ? 'selected' : '' ?>>Chưa xử lý</option>
                <option value="đã xác nhận" <?= $searchStatus == 'đã xác nhận' ? 'selected' : '' ?>>Đã xác nhận</option>
                <option value="đã giao thành công" <?= $searchStatus == 'đã giao thành công' ? 'selected' : '' ?>>Đã giao thành công</option>
                <option value="đã hủy" <?= $searchStatus == 'đã hủy' ? 'selected' : '' ?>>Đã hủy</option>
            </select>
            <button type="submit">Tìm kiếm</button>
        </form>
        <!-- Bảng quản lý đơn hàng -->
        <table id="ordersTable">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã đơn hàng</th>
                    <th>Người đặt</th>
                    <th>SĐT</th>
                    <th>Ngày đặt</th>
                    <th>Tình trạng</th>
                    <th>Địa chỉ</th>
                    <th>Số lượng</th>
                    <th>Ghi chú</th>
                    <th>Tổng tiền</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="11">Không tìm thấy đơn hàng nào.</td>
                    </tr>
                <?php else: ?>
                    <?php $stt = ($page - 1) * $itemsPerPage + 1; foreach ($orders as $order): ?>
                        <tr>
                            <td><?= $stt++ ?></td>
                            <td>DH<?= sprintf("%03d", $order['MaHD']) ?></td>
                            <td><?= htmlspecialchars($order['NguoiNhan']) ?></td>
                            <td><?= htmlspecialchars($order['SDT']) ?></td>
                            <td><?= date('Y-m-d', strtotime($order['NgayLap'])) ?></td>
                            <td class="<?php
                                switch (strtolower($order['TrangThai'])) {
                                    case 'chưa xử lý': echo 'status-pending'; break;
                                    case 'đã xác nhận': echo 'status-confirmed'; break;
                                    case 'đã giao thành công': echo 'status-completed'; break;
                                    case 'đã hủy': echo 'status-cancelled'; break;
                                    default: echo '';
                                }
                            ?>">
                                <?= htmlspecialchars($order['TrangThai']) ?>
                            </td>
                            <td><?= htmlspecialchars($order['DiaChi']) ?></td>
                            <td><?= $order['SoLuong'] ?? 0 ?></td>
                            <td>-</td> <!-- Ghi chú chưa có trong DB -->
                            <td><?= number_format($order['TongTien'], 0, ',', '.') ?>đ</td>
                            <td><button class="details-btn" onclick="window.location.href='Chitietmuahang.php?MaHD=<?= $order['MaHD'] ?>&csrf_token=<?= $_SESSION['csrf_token'] ?>'">Xem chi tiết</button></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <!-- Phân trang -->
        <div class="pagination">
            <?php
            $queryParams = http_build_query(['search_date' => $searchDate, 'search_status' => $searchStatus]);
            ?>
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>&<?= $queryParams ?>">Trước</a>
            <?php else: ?>
                <a class="disabled">Trước</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>&<?= $queryParams ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>&<?= $queryParams ?>">Sau</a>
            <?php else: ?>
                <a class="disabled">Sau</a>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Xử lý tìm kiếm bằng phím Enter
        document.getElementById('searchInput1').addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.querySelector('.search-container form').submit();
            }
        });
        document.getElementById('searchInput2').addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.querySelector('.search-container form').submit();
            }
        });
    </script>
</body>
</html>