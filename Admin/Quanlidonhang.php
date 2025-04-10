<?php
require_once '../DB_driver.php';
$db = new DB_driver();
$db->connect();

$sql = "SELECT * FROM hoadon";
$orders = $db->get_list($sql);
?>

<!-- Trong phần <tbody> -->
<tbody>
    <?php foreach ($orders as $index => $order): ?>
        <tr>
            <td><?php echo $index + 1; ?></td>
            <td><?php echo htmlspecialchars($order['MaHD']); ?></td>
            <td><?php echo htmlspecialchars($order['NguoiNhan']); ?></td>
            <td><?php echo htmlspecialchars($order['SDT']); ?></td>
            <td><?php echo htmlspecialchars($order['NgayLap']); ?></td>
            <td><?php echo htmlspecialchars($order['TrangThai']); ?></td>
            <td><?php echo htmlspecialchars($order['DiaChi']); ?></td>
            <td><?php echo htmlspecialchars($order['SoLuong'] ?? ''); ?></td> <!-- Cần join với chitiethoadon để lấy số lượng -->
            <td><?php echo htmlspecialchars($order['GhiChu'] ?? ''); ?></td>
            <td><?php echo number_format($order['TongTien'], 0, ',', '.') . 'đ'; ?></td>
            <td><button class="details-btn">Xem chi tiết</button></td>
            <td>
                <select class="status-select" data-order-id="<?php echo htmlspecialchars($order['MaHD']); ?>">
                    <option value="">Chọn trạng thái</option>
                    <option value="Chưa xử lý">Chưa xử lý</option>
                    <option value="Đã xác nhận">Đã xác nhận</option>
                    <option value="Đã giao thành công">Đã giao thành công</option>
                    <option value="Đã hủy">Đã hủy</option>
                </select>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>