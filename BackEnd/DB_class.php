<?php
require_once("DB_business.php");

// Hàm hiển thị dữ liệu từ bảng dưới dạng bảng HTML
function show_DataBUS_as_Table($bus)
{
    echo "<table cellspacing='15'>";
    foreach ($bus->select_all() as $row) {
        echo "<tr>";
        foreach ($row as $col) {
            echo "<td>" . htmlspecialchars($col) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

// Lớp Sản phẩm
class SanPhamBUS extends DB_business
{
    function __construct()
    {
        $this->setTable("SanPham", "MaSP");
    }

    function capNhatTrangThai($trangthai, $id) {
        return $this->update_by_id(["TrangThai" => $trangthai], $id);
    }

    function themDanhGia($id) {
        $dsbl = $this->get_list("SELECT SoSao FROM danhgia WHERE MaSP = ?", [$id]);
        
        if (empty($dsbl)) return false;

        $tongSoSao = array_sum(array_column($dsbl, "SoSao"));
        $soDanhGia = count($dsbl);
        $soSaoTB = $tongSoSao / $soDanhGia;

        return $this->update_by_id([
            "SoDanhGia" => $soDanhGia,
            "SoSao" => $soSaoTB
        ], $id);
    }
}

// Lớp Người dùng
class NguoiDungBUS extends DB_business
{
    function __construct()
    {
        $this->setTable("NguoiDung", "MaND");
    }

    function add_new($data)
    {
        if ($this->get_row("SELECT * FROM NguoiDung WHERE Email = ?", [$data["Email"]])) {
            return false; // Email đã tồn tại
        }
        return parent::add_new($data);
    }
}

// Lớp Hóa đơn
class HoaDonBUS extends DB_business
{
    function __construct()
    {
        $this->setTable("HoaDon", "MaHD");
    }

    function getHoaDonCuaNguoiDung($mand) {
        return $this->get_list("SELECT * FROM HoaDon WHERE MaND = ?", [$mand]);
    }
}

// Lớp Chi tiết hóa đơn
class ChiTietHoaDonBUS extends DB_business
{
    protected $_key2;

    function __construct()
    {
        $this->setTable("ChiTietHoaDon", "MaHD");
        $this->_key2 = "MaSP";
    }

    function delete_by_2id($id, $id2)
    {
        return $this->remove($this->_table_name, "MaHD = ? AND MaSP = ?", [$id, $id2]);
    }

    function update_by_2id($data, $id, $id2)
    {
        return $this->update($this->_table_name, $data, "MaHD = ? AND MaSP = ?", [$id, $id2]);
    }
}
?>
