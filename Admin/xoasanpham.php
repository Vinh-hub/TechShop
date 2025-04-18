<?php
session_start();
require_once "../BackEnd/DB_driver.php";

// Kiểm tra đăng nhập admin
if (!isset($_SESSION['MaND'])) {
    header("Location: ../login.php");
    exit();
}
$db = new DB_driver();
$db->connect();
$user = $db->get_row("SELECT * FROM nguoidung WHERE MaND = ?", [$_SESSION['MaND']]);
if (!$user || (isset($user['MaQuyen']) && !in_array($user['MaQuyen'], [2, 3]))) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['maSP'])) {
    $maSP = $_GET['maSP'];
    $db->remove('sanpham', 'MaSP = ?', [$maSP]);
    header("Location: Quanlisanpham.php");
    exit();
}

$db->dis_connect();
?>