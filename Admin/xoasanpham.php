<?php
require_once "../BackEnd/DB_driver.php";

$db = new DB_driver();
$db->connect();

if (isset($_GET['maSP'])) {
    $maSP = $_GET['maSP'];
    $db->remove('sanpham', 'MaSP = ?', [$maSP]);
    header("Location: Quanlisanpham.php");
    exit();
}

$db->dis_connect();
?>