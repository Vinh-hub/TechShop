<?php
// Kiểm tra xem 'action' có tồn tại trong URL không, nếu không thì mặc định là 'index'
if (isset($_GET['action'])) {
    $tam = $_GET['action'];
} else {
    $tam = 'TongQuan';
}

// Xác định file cần include dựa trên giá trị của $tam
if ($tam == 'profile') {
    include("./Admin/user.php");
} elseif ($tam == 'users') {
    include("./Admin/Quanlinguoidung.php");
} elseif ($tam == 'orders') {
    include("./Admin/Quanlidonhang.php");
} elseif ($tam == 'products') {
    include("./Admin/Quanlisanpham.php");
} else {
    include("./Admin/TongQuan.php"); // Mặc định là trang chủ
}
?>
