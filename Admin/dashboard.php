<?php
session_start();
require_once "../BackEnd/DB_driver.php"; // Kết nối DB nếu cần kiểm tra quyền

// Kiểm tra đăng nhập
if (!isset($_SESSION['MaND'])) {
    header("Location: ../login.php");
    exit();
}

// Kiểm tra quyền admin theo MaQuyen = 2
$db = new DB_driver();
$db->connect();
$userId = $_SESSION['MaND'];
$user = $db->get_row("SELECT * FROM nguoidung WHERE MaND = ?", [$userId]);
if (!$user || (isset($user['MaQuyen']) && $user['MaQuyen'] != 2)) {
    header("Location: ../index.php");
    exit();
}

// Xử lý đăng xuất
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Thêm Font Awesome -->

    <link href="./assets/css/Dashboard.css" rel="stylesheet"> 

</head>
<body>
    <header>
        <div class="container">
            <div class="admin-box-icon" id="adminIcon">
                <i class="fa-regular fa-user"></i>
            </div>
            <div class="admin-box" id="adminBox">
                <ul>
                    <p><?php echo htmlspecialchars($user['HoTen'] ?? 'PV Admin'); ?></p>
                    <li><a href="?action=logout">Đăng xuất</a></li>
                </ul>
            </div>
            <div class="welcome">ProTech</div>
            <nav>
                <ul>
                    <li><a href="Tongquan.php" class="nav-link" target="content-frame" data-target="overview">Tổng quan</a></li>
                    <li><a href="user.php" class="nav-link" target="content-frame" data-target="profile">User Profile</a></li>
                    <li><a href="Quanlidonhang.php" class="nav-link" target="content-frame" data-target="orders">Quản lí đơn hàng</a></li>
                    <li><a href="Quanlinguoidung.php" class="nav-link" target="content-frame" data-target="users">Quản lí người dùng</a></li>
                    <li><a href="Quanlisanpham.php" class="nav-link" target="content-frame" data-target="products">Quản lí sản phẩm</a></li>
                </ul>
            </nav>
            <iframe id="content-frame" name="content-frame" style="width:100%; height: 500px; border: none; margin-top: 30px;"></iframe>

            <div id="overview" class="info-section"></div>
            <div id="profile" class="info-section"></div>
            <div id="orders" class="info-section"></div>
            <div id="users" class="info-section"></div>
            <div id="products" class="info-section"></div>
        </div>
        <footer class="end__heading-end">
            <div class="end__heading-end-information-group">
                <span class="end__heading-end-information end__heading-end-information-name"><b>CÔNG TY PROTECH</b></span>
                <span class="end__heading-end-information">© 2024 - Bản quyền thuộc về Công ty ProTech</span>
            </div>
        </footer>
    </header>
    <script>
        // ĐÓNG MỞ BOX ADMIN
        document.addEventListener("DOMContentLoaded", function() {
            const adminIcon = document.getElementById('adminIcon');
            const adminBox = document.getElementById('adminBox');

            adminIcon.addEventListener('click', function(event) {
                event.stopPropagation();
                const rect = adminIcon.getBoundingClientRect();
                const top = rect.bottom + window.scrollY;
                const left = rect.left + window.scrollX;
                adminBox.style.top = top + 'px';
                adminBox.style.left = left + 'px';
                adminBox.style.display = adminBox.style.display === 'block' ? 'none' : 'block';
            });

            // Đóng hộp admin khi click ra ngoài
            document.addEventListener('click', function(event) {
                if (!adminBox.contains(event.target) && event.target !== adminIcon) {
                    adminBox.style.display = 'none';
                }
            });
        });

        // HIỂN THỊ CÁC LIST
        document.addEventListener("DOMContentLoaded", function() {
            const navLinks = document.querySelectorAll("nav ul li a");

            navLinks.forEach(link => {
                link.addEventListener("click", function(event) {
                    event.preventDefault();
                    navLinks.forEach(link => link.classList.remove("active"));
                    link.classList.add("active");

                    const target = link.getAttribute("data-target");
                    document.querySelectorAll(".info-section").forEach(section => {
                        section.classList.remove("active");
                    });
                    document.getElementById(target).classList.add("active");

                    const iframe = document.getElementById("content-frame");
                    iframe.src = link.href;
                });
            });
        });

        // Mở trang User Profile khi load trang
        window.addEventListener('load', function() {
            const overviewLink = document.querySelector('a[data-target="overview"]');
            if (overviewLink) {
                overviewLink.click();
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Chart.js sẽ được tải trong các trang con (Tongquan.php, v.v.)
        // Xóa code Chart.js ở đây vì canvas không tồn tại
    </script>
</body>
</html>