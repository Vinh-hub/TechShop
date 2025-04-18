<?php
session_start();
require_once "../BackEnd/DB_driver.php";

// Kiểm tra đăng nhập và quyền admin (MaQuyen = 3)
if (!isset($_SESSION['MaND'])) {
    $_SESSION['error'] = "Vui lòng đăng nhập.";
    file_put_contents('debug.log', "Redirect to login.php from Quanlinguoidung.php at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
    header("Location: ../login.php");
    exit();
}

$db = new DB_driver();
$db->connect();

try {
    $user = $db->get_row("SELECT * FROM nguoidung WHERE MaND = ?", [$_SESSION['MaND']]);
    if (!$user || $user['MaQuyen'] != 3) {
        $_SESSION['error'] = !$user ? "Người dùng không tồn tại." : "Bạn không có quyền admin.";
        file_put_contents('debug.log', "Redirect to index.php from Quanlinguoidung.php at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
        header("Location: ../index.php");
        exit();
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Lỗi DB: " . $e->getMessage();
    file_put_contents('debug.log', "Redirect to index.php: DB error in Quanlinguoidung.php at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
    header("Location: ../index.php");
    exit();
}

// Tạo CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Xử lý hành động (khóa, xóa, mở khóa)
if (isset($_GET['action']) && isset($_GET['MaND']) && isset($_GET['csrf_token']) && $_GET['csrf_token'] === $_SESSION['csrf_token']) {
    $maND = (int)$_GET['MaND'];
    if ($maND == $_SESSION['MaND']) {
        $_SESSION['error'] = "Không thể thực hiện hành động với chính mình!";
        header("Location: Quanlinguoidung.php");
        exit();
    }

    try {
        if ($_GET['action'] === 'block') {
            $currentUser = $db->get_row("SELECT MaQuyen FROM nguoidung WHERE MaND = ?", [$maND]);
            $db->update('nguoidung', ['MaQuyen' => 5, 'PreviousMaQuyen' => $currentUser['MaQuyen']], 'MaND = ?', [$maND]);
            $_SESSION['message'] = "Khóa người dùng thành công!";
        } elseif ($_GET['action'] === 'delete') {
            $db->remove('nguoidung', 'MaND = ?', [$maND]);
            $_SESSION['message'] = "Xóa người dùng thành công!";
        } elseif ($_GET['action'] === 'unblock') {
            $currentUser = $db->get_row("SELECT PreviousMaQuyen FROM nguoidung WHERE MaND = ?", [$maND]);
            $newMaQuyen = $currentUser['PreviousMaQuyen'] ?? 1;
            $db->update('nguoidung', ['MaQuyen' => $newMaQuyen, 'PreviousMaQuyen' => NULL], 'MaND = ?', [$maND]);
            $_SESSION['message'] = "Mở khóa người dùng thành công!";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Lỗi: " . $e->getMessage();
    }
    header("Location: Quanlinguoidung.php");
    exit();
} elseif (isset($_GET['action']) && (!isset($_GET['csrf_token']) || $_GET['csrf_token'] !== $_SESSION['csrf_token'])) {
    $_SESSION['error'] = "Yêu cầu không hợp lệ.";
    header("Location: Quanlinguoidung.php");
    exit();
}

// Xử lý tìm kiếm và phân trang
$searchName = trim($_GET['search_name'] ?? '');
$searchRole = trim($_GET['search_role'] ?? '');
$conditions = [];
$params = [];

if ($searchName) {
    $conditions[] = "TaiKhoan LIKE ?";
    $params[] = "%$searchName%";
}

if ($searchRole) {
    $roleMap = [
        'khach hang' => 1,
        'quan tri vien' => 2,
        'admin' => 3,
        'khoa' => 5
    ];
    $searchRoleLower = strtolower($searchRole);
    foreach ($roleMap as $roleName => $roleId) {
        if (strpos($searchRoleLower, $roleName) !== false) {
            $conditions[] = "MaQuyen = ?";
            $params[] = $roleId;
            break;
        }
    }
}

$whereClause = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';

// Phân trang
$itemsPerPage = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

// Đếm tổng số người dùng
$countQuery = "SELECT COUNT(*) as total FROM nguoidung $whereClause";
$totalUsers = $db->get_row($countQuery, $params)['total'];
$totalPages = ceil($totalUsers / $itemsPerPage);

// Lấy danh sách người dùng cho trang hiện tại
$users = $db->get_list("SELECT * FROM nguoidung $whereClause ORDER BY MaND LIMIT ? OFFSET ?", array_merge($params, [$itemsPerPage, $offset]));

$db->dis_connect();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTech - Quản Lý Người Dùng</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
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
            vertical-align: middle;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        button {
            padding: 8px 16px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn-block {
            background-color: #e74c3c;
            color: white;
        }
        .btn-block:hover {
            background-color: #c0392b;
        }
        .btn-unblock {
            background-color: #28a745;
            color: white;
        }
        .btn-unblock:hover {
            background-color: #218838;
        }
        .btn-delete {
            background-color: #3498db;
            color: white;
        }
        .btn-delete:hover {
            background-color: #2980b9;
        }
        .btn-edit {
            background-color: #f1c40f;
            color: white;
        }
        .btn-edit:hover {
            background-color: #e1b307;
        }
        #showAddFormBtn {
            padding: 12px 20px;
            background-color: #3498db;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 20px auto;
        }
        #showAddFormBtn:hover {
            background-color:rgb(37, 108, 155);
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
        footer {
            margin-top: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Quản Lý Người Dùng</h1>
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
            <input type="text" id="searchInput1" name="search_name" placeholder="Nhập tài khoản để tìm kiếm" value="<?= htmlspecialchars($searchName) ?>">
            <select id="searchInput2" name="search_role">
                <option value="">Tất cả vai trò</option>
                <option value="khach hang" <?= $searchRole == 'khach hang' ? 'selected' : '' ?>>Khách hàng</option>
                <option value="quan tri vien" <?= $searchRole == 'quan tri vien' ? 'selected' : '' ?>>Quản trị viên</option>
                <option value="admin" <?= $searchRole == 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="khoa" <?= $searchRole == 'khoa' ? 'selected' : '' ?>>Khóa</option>
            </select>
            <button type="submit">Tìm kiếm</button>
        </form>

        <button id="showAddFormBtn">Thêm Người Dùng</button>
        <!-- Bảng quản lý người dùng -->
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tài Khoản</th>
                    <!-- <th>Họ Tên</th> -->
                    <th>Email</th>
                    <!-- <th>Số Điện Thoại</th> -->
                    <th>Địa Chỉ</th>
                    <th>Vai trò</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="8">Không tìm thấy người dùng nào.</td>
                    </tr>
                <?php else: ?>
                    <?php $stt = ($page - 1) * $itemsPerPage + 1; foreach ($users as $user): ?>
                        <tr>
                            <td><?= $stt++ ?></td>
                            <td><?= htmlspecialchars($user['TaiKhoan'] ?? '') ?></td>
                            <!-- <td><?= htmlspecialchars($user['HoTen'] ?? '') ?></td> -->
                            <td><?= htmlspecialchars($user['Email'] ?? '') ?></td>
                            <!-- <td><?= htmlspecialchars($user['SoDienThoai'] ?? '') ?></td> -->
                            <td><?= htmlspecialchars($user['DiaChi'] ?? '') ?></td>
                            <td>
                                <?php
                                switch ($user['MaQuyen']) {
                                    case 1: echo 'Khách hàng'; break;
                                    case 2: echo 'Quản trị viên'; break;
                                    case 3: echo 'Admin'; break;
                                    case 5: echo 'Khóa'; break;
                                    default: echo 'Không xác định';
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($user['MaQuyen'] != 5): ?>
                                    <button class="btn-block" onclick="confirmBlock(<?= $user['MaND'] ?>, '<?= $_SESSION['csrf_token'] ?>')">Khóa</button>
                                <?php else: ?>
                                    <button class="btn-unblock" onclick="confirmUnblock(<?= $user['MaND'] ?>, '<?= $_SESSION['csrf_token'] ?>')">Mở khóa</button>
                                <?php endif; ?>
                                <button class="btn-delete" onclick="confirmDelete(<?= $user['MaND'] ?>, '<?= $_SESSION['csrf_token'] ?>')">Xóa</button>
                                <button class="btn-edit" onclick="window.location.href='suaThongtinNguoidung.php?MaND=<?= $user['MaND'] ?>'">Sửa</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <!-- Phân trang -->
        <div class="pagination">
            <?php
            $queryParams = http_build_query(['search_name' => $searchName, 'search_role' => $searchRole]);
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
        function confirmBlock(maND, csrfToken) {
            if (confirm('Bạn có chắc chắn muốn khóa người dùng này không?')) {
                window.location.href = `Quanlinguoidung.php?action=block&MaND=${maND}&csrf_token=${csrfToken}`;
            }
        }

        function confirmUnblock(maND, csrfToken) {
            if (confirm('Bạn có chắc chắn muốn mở khóa người dùng này không?')) {
                window.location.href = `Quanlinguoidung.php?action=unblock&MaND=${maND}&csrf_token=${csrfToken}`;
            }
        }

        function confirmDelete(maND, csrfToken) {
            if (confirm('Bạn có chắc chắn muốn xóa người dùng này không?')) {
                window.location.href = `Quanlinguoidung.php?action=delete&MaND=${maND}&csrf_token=${csrfToken}`;
            }
        }

        document.getElementById('showAddFormBtn').addEventListener('click', function() {
            window.location.href = 'addNguoidung.php';
        });
    </script>
</body>
</html>