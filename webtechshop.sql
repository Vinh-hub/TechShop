-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 18, 2025 lúc 11:06 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webtechshop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiethoadon`
--

ALTER TABLE `chitiethoadon` (
  `MaHD` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `DonGia` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhgia`
--

ALTER TABLE `danhgia` (
  `MaSP` int(11) NOT NULL,
  `MaND` varchar(10) NOT NULL,
  `SoSao` int(11) NOT NULL,
  `BinhLuan` varchar(255) NOT NULL,
  `NgayLap` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhgia`
--

INSERT INTO `danhgia` (`MaSP`, `MaND`, `SoSao`, `BinhLuan`, `NgayLap`) VALUES
(2, '2', 4, 'Giảm giá 500k , quá gắt <3', '2019-05-16 19:31:48'),
(2, '4', 3, 'aaa sơn cmn tùng <3', '2019-05-16 19:48:46'),
(4, '2', 4, 'Hoàng trần đẹp trai', '2019-05-16 19:28:13'),
(4, '2', 1, 'Chưa tốt! cần cải thiện nhiều', '2019-05-16 19:29:30'),
(4, '4', 4, 'đẹp', '2019-05-16 19:47:56'),
(15, '4', 4, 'mua vài chục cái về cho con cháu chọi nhau chơi :v', '2019-05-16 19:52:14'),
(44, '4', 5, 'wow, giá rẻ cấu hình ngon đây rồi <3', '2019-05-16 19:38:03'),
(44, '4', 3, 'Ram có 1GB tiếc quá', '2019-05-16 19:49:20'),
(46, '2', 4, 'Đỏ may mắn <3', '2019-05-16 19:32:58'),
(46, '4', 2, 'Pin khá tệ ', '2019-05-16 19:49:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

ALTER TABLE `giohang` (
  `MaGH` int(11) NOT NULL,
  `MaND` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SoLuong` int(11) DEFAULT 1,
  `NgayThem` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `giohang`
--

INSERT INTO `giohang` (`MaGH`, `MaND`, `MaSP`, `SoLuong`, `NgayThem`) VALUES
(3, 1, 1, 1, '2025-04-11 13:06:55'),
(5, 1, 9, 1, '2025-04-11 13:11:58'),
(6, 1, 12, 1, '2025-04-11 14:12:26');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadon`
--

ALTER TABLE `hoadon` (
  `MaHD` int(11) NOT NULL,
  `MaND` int(11) NOT NULL,
  `NgayLap` datetime NOT NULL,
  `NguoiNhan` varchar(50) NOT NULL,
  `SDT` varchar(20) NOT NULL,
  `DiaChi` varchar(100) NOT NULL,
  `PhuongThucTT` varchar(20) NOT NULL,
  `TongTien` float NOT NULL,
  `TrangThai` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

ALTER TABLE `khachhang` (
  `MaKH` int(11) NOT NULL,
  `MaND` int(11) NOT NULL,
  `HoTen` varchar(100) DEFAULT NULL,
  `Nickname` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `SDT` varchar(15) DEFAULT NULL,
  `NgaySinh` date DEFAULT NULL,
  `GioiTinh` enum('Nam','Nu','Khac') DEFAULT 'Nam',
  `DiaChi` varchar(255) DEFAULT NULL,
  `QuocTich` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`MaKH`, `MaND`, `HoTen`, `Nickname`, `Email`, `SDT`, `NgaySinh`, `GioiTinh`, `DiaChi`, `QuocTich`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, 'Nam', NULL, NULL),
(2, 2, NULL, NULL, NULL, NULL, NULL, 'Nam', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khuyenmai`
--

ALTER TABLE `khuyenmai` (
  `MaKM` int(11) NOT NULL,
  `TenKM` varchar(100) NOT NULL,
  `LoaiKM` varchar(20) NOT NULL,
  `GiaTriKM` float NOT NULL,
  `NgayBD` datetime NOT NULL,
  `NgayKT` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `khuyenmai`
--

INSERT INTO `khuyenmai` (`MaKM`, `TenKM`, `LoaiKM`, `GiaTriKM`, `NgayBD`, `NgayKT`) VALUES
(1, 'Không khuyến mãi', 'Nothing', 0, '2025-04-08 00:00:00', '2027-04-17 00:00:00'),
(2, 'Giảm giá', 'GiamGia', 500000, '2025-05-01 00:00:00', '2027-05-31 00:00:00'),
(3, 'Giá rẻ online', 'GiaReOnline', 650000, '2025-05-01 00:00:00', '2026-05-31 00:00:00'),
(4, 'Trả góp', 'TraGop', 0, '2025-05-01 00:00:00', '2030-05-31 00:00:00'),
(5, 'Mới ra mắt', 'MoiRaMat', 0, '2025-05-01 00:00:00', '2026-05-31 00:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisanpham`
--

ALTER TABLE `loaisanpham` (
  `MaLSP` int(11) NOT NULL,
  `TenLSP` varchar(70) NOT NULL,
  `HinhAnh` varchar(200) NOT NULL,
  `Mota` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `loaisanpham`
--

INSERT INTO `loaisanpham` (`MaLSP`, `TenLSP`, `HinhAnh`, `Mota`) VALUES
(1, 'Điện Thoại', '/assets/imgs/1743157117_phonne-24x24.png', 'Các sản phẩm điện thoại'),
(2, 'Laptop', '/assets/imgs/1743157105_laptop-24x24.png', 'Các sản phẩm Laptop'),
(3, 'Phụ kiện', '/assets/imgs/1743156776_phu-kien-24x24.png', 'Các sản phẩm đồng hồ thông minh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

ALTER TABLE `nguoidung` (
  `MaND` int(11) NOT NULL,
  `TaiKhoan` varchar(100) NOT NULL,
  `MatKhau` varchar(100) NOT NULL,
  `DiaChi` varchar(200) NOT NULL,
  `MaQuyen` int(11) NOT NULL,
  `TrangThai` int(11) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `PreviousMaQuyen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`MaND`, `TaiKhoan`, `MatKhau`, `DiaChi`, `MaQuyen`, `TrangThai`, `Email`, `PreviousMaQuyen`) VALUES
(1, 'vinhvinh', '$2y$10$JmMUE8MC0ywX0W1SSPkYSesmmyc3eScnLxRkH5wmHgPltJkwlOOty', 'ẻdftghjkljhugyttxdf', 1, 1, 'vinhtrilam.20005@gmail.com', NULL),
(2, 'admin', '$2y$10$/t0ItiLCFOYhDWk9Xmi6x.7C/bqEcHqnJHSMBmPm/Ty2rq8mThqzK', 'long hoa, phu tan, an giang', 3, 1, 'vinhtrilam.2005@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

ALTER TABLE `sanpham` (
  `MaLSP` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `TenSP` varchar(70) NOT NULL,
  `DonGia` int(11) NOT NULL,
  `Mau` varchar(50) NOT NULL,
  `DungLuong` varchar(50) NOT NULL,
  `HinhAnh` varchar(200) NOT NULL,
  `MaKM` int(11) NOT NULL,
  `MoTa` mediumtext DEFAULT NULL,
  `SoLuong` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `TrangThai` int(11) NOT NULL,
  `PhanTramGiam` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`MaLSP`, `MaSP`, `TenSP`, `DonGia`, `Mau`, `DungLuong`, `HinhAnh`, `MaKM`, `MoTa`, `SoLuong`, `TrangThai`, `PhanTramGiam`) VALUES
(1, 1, 'Iphone 15', 20000000, 'Đen', '128', '/assets/imgs/iphone-15-removebg-preview.png', 0, 'iPhone 15 128GB được trang bị màn hình Dynamic Island kích thước 6.1 inch với công nghệ hiển thị Super Retina XDR màn lại trải nghiệm hình ảnh vượt trội. Điện thoại với mặt lưng kính nhám chống bám mồ hôi cùng 5 phiên bản màu sắc lựa chọn: Hồng, Vàng, Xanh lá, Xanh dương và đen. Camera trên iPhone 15 series cũng được nâng cấp lên cảm biến 48MP cùng tính năng chụp zoom quang học tới 2x. Cùng với thiết kế cổng sạc thay đổi từ lightning sang USB-C vô cùng ấn tượng.', 1, 1, 9),
(1, 9, 'Samsung Galaxy A54 5G', 1234432, 'Đen', '128', '/assets/imgs/samsung-galaxy-a34-5g-dual-sim-awesome-silver-128gb-and-6gb-ram-sm-a346b-ds-removebg-preview.png', 0, 'ccccccccccccccccccccccccccccc', 4, 1, NULL),
(2, 10, 'Microsoft Surface Laptop 7 Core Ultra 7', 27999000, 'Đen', '512', '/assets/imgs/Microsoft-Surface-Laptop-7-Core-Ultra-7.jpg', 0, 'Khung máy bằng nhôm CNC cao cấp – Khung máy bằng nhôm cao cấp của máy tính xách tay Zephyrus G16 OLED tạo nên sự cân bằng giữa độ bền và tính thanh lịch.  \r\n\r\nSIÊU MỎNG VÀ SIÊU NHẸ – Thoải mái di động mà không phải đánh đổi với khung máy siêu mỏng 0,59” chỉ nặng 4,08 pound.  \r\n\r\nĐỊNH NGHĨA LẠI VỀ CHƠI GAME – Tối đa hóa tiềm năng sáng tạo và chơi game với Windows 11 Pro và GPU máy tính xách tay NVIDIA® GeForce RTX™ 4060 với NVIDIA Advanced Optimus™. \r\n\r\nHIỆU SUẤT NHỜ AI – Tăng tốc quy trình làm việc của bạn với Bộ xử lý AMD Ryzen™ AI 9 HX 370 mới nhất với hơn 45 TOP AMD Ryzen AI và sức mạnh của Bộ xử lý thần kinh (NPU).  \r\n\r\nĐA NHIỆM VỤ DỄ DÀNG – Đa nhiệm nhanh chóng với RAM LPDDR5X 32GB và SSD PCIe Gen 4.0 1TB.  \r\n\r\nMÀN HÌNH OLED ROG NEBULA với NVIDIA® G-SYNC – Nâng cao trải nghiệm hình ảnh của bạn với Màn hình OLED ROG Nebula, có thời gian phản hồi nhanh 0,2ms, độ phân giải 2,5K và NVIDIA G-SYNC.  \r\n\r\nLÀM MÁT THÔNG MINH ROG – Luôn mát mẻ dưới áp lực với hệ thống làm mát thông minh ROG sử dụng kim loại lỏng giúp giảm nhiệt độ CPU tới 13 độ, Quạt Arc Flow thế hệ thứ 2, v.v. \r\n\r\nPC GAME PASS – Nhận thẻ miễn phí 90 ngày và truy cập hơn 100 trò chơi chất lượng cao. Với các trò chơi được thêm vào liên tục, luôn có điều gì đó mới để chơi', 7, 1, 10),
(1, 12, 'Samsung Galaxy S25 Ultra 512GB', 33990000, 'Đen', '512', '/assets/imgs/dien-thoai-samsung-galaxy-s25-ultra_3__3.jpg', 0, '- Chuẩn IP68 trên Samsung S25 Ultra 5G – Chống nước, chống bụi, thiết kế cao cấp, sang trọng.\r\n- Âm thanh Dolby Atmos, loa kép AKG. Trải nghiệm âm thanh sống động, chân thực.\r\n- Màn hình S25 Ultra Dynamic AMOLED 2X 6.9 inch, 120Hz. Hiển thị sắc nét, mượt mà, tiết kiệm pin.\r\n- Camera 200MP + Zoom 100X. Cảm biến lớn, chụp thiếu sáng tốt, zoom xa chi tiết', 5, 1, 15),
(3, 13, 'Tai nghe Bluetooth Apple AirPods 4 | Chính hãng Apple Việt Nam', 3490000, 'Đen', '', '/assets/imgs/apple-airpods-4-thumb.jpg', 0, '- Chip H2 nổi bật, mạnh mẽ được tích hợp trong Airpod 4 giúp trải nghiệm âm thanh của bạn mượt mà hơn.\r\n- Công nghệ Bluetooth 5.3 mang đến kết nối ổn định, mượt mà, tiêu thụ năng lượng thấp, giúp bạn tiết kiệm pin đáng kể.\r\n- Khả năng chống nước đạt chuẩn IP54 mang lại cảm giác thoải mái khi sử dụng tai nghe ngoài trời mà không lo bụi bẩn, hoặc mồ hôi.\r\n- Thời gian sử dụng ấn tượng với dung lượng pin cao, hộp sạc dùng được 30h và tại nghe dùng được 5h', 0, 1, 6),
(1, 14, 'Iphone 15', 20000000, 'Đen', '128', '/assets/imgs/iphone-15-removebg-preview.png', 0, 'iPhone 15 128GB được trang bị màn hình Dynamic Island kích thước 6.1 inch với công nghệ hiển thị Super Retina XDR màn lại trải nghiệm hình ảnh vượt trội. Điện thoại với mặt lưng kính nhám chống bám mồ hôi cùng 5 phiên bản màu sắc lựa chọn: Hồng, Vàng, Xanh lá, Xanh dương và đen. Camera trên iPhone 15 series cũng được nâng cấp lên cảm biến 48MP cùng tính năng chụp zoom quang học tới 2x. Cùng với thiết kế cổng sạc thay đổi từ lightning sang USB-C vô cùng ấn tượng.', 1, 1, 9),
(1, 15, 'Samsung Galaxy A54 5G', 1234432, 'Đen', '128', '/assets/imgs/samsung-galaxy-a34-5g-dual-sim-awesome-silver-128gb-and-6gb-ram-sm-a346b-ds-removebg-preview.png', 0, 'ccccccccccccccccccccccccccccc', 4, 1, NULL),
(1, 16, 'Iphone 15', 20000000, 'Đen', '128', '/assets/imgs/iphone-15-removebg-preview.png', 0, 'iPhone 15 128GB được trang bị màn hình Dynamic Island kích thước 6.1 inch với công nghệ hiển thị Super Retina XDR màn lại trải nghiệm hình ảnh vượt trội. Điện thoại với mặt lưng kính nhám chống bám mồ hôi cùng 5 phiên bản màu sắc lựa chọn: Hồng, Vàng, Xanh lá, Xanh dương và đen. Camera trên iPhone 15 series cũng được nâng cấp lên cảm biến 48MP cùng tính năng chụp zoom quang học tới 2x. Cùng với thiết kế cổng sạc thay đổi từ lightning sang USB-C vô cùng ấn tượng.', 1, 1, 9),
(1, 17, 'Iphone 15', 20000000, 'Đen', '128', '/assets/imgs/iphone-15-removebg-preview.png', 0, 'iPhone 15 128GB được trang bị màn hình Dynamic Island kích thước 6.1 inch với công nghệ hiển thị Super Retina XDR màn lại trải nghiệm hình ảnh vượt trội. Điện thoại với mặt lưng kính nhám chống bám mồ hôi cùng 5 phiên bản màu sắc lựa chọn: Hồng, Vàng, Xanh lá, Xanh dương và đen. Camera trên iPhone 15 series cũng được nâng cấp lên cảm biến 48MP cùng tính năng chụp zoom quang học tới 2x. Cùng với thiết kế cổng sạc thay đổi từ lightning sang USB-C vô cùng ấn tượng.', 1, 1, 9),
(1, 18, 'Iphone 15', 20000000, 'Đen', '128', '/assets/imgs/iphone-15-removebg-preview.png', 0, 'iPhone 15 128GB được trang bị màn hình Dynamic Island kích thước 6.1 inch với công nghệ hiển thị Super Retina XDR màn lại trải nghiệm hình ảnh vượt trội. Điện thoại với mặt lưng kính nhám chống bám mồ hôi cùng 5 phiên bản màu sắc lựa chọn: Hồng, Vàng, Xanh lá, Xanh dương và đen. Camera trên iPhone 15 series cũng được nâng cấp lên cảm biến 48MP cùng tính năng chụp zoom quang học tới 2x. Cùng với thiết kế cổng sạc thay đổi từ lightning sang USB-C vô cùng ấn tượng.', 1, 1, 9),
(1, 19, 'Iphone 15', 20000000, 'Đen', '128', '/assets/imgs/iphone-15-removebg-preview.png', 0, 'iPhone 15 128GB được trang bị màn hình Dynamic Island kích thước 6.1 inch với công nghệ hiển thị Super Retina XDR màn lại trải nghiệm hình ảnh vượt trội. Điện thoại với mặt lưng kính nhám chống bám mồ hôi cùng 5 phiên bản màu sắc lựa chọn: Hồng, Vàng, Xanh lá, Xanh dương và đen. Camera trên iPhone 15 series cũng được nâng cấp lên cảm biến 48MP cùng tính năng chụp zoom quang học tới 2x. Cùng với thiết kế cổng sạc thay đổi từ lightning sang USB-C vô cùng ấn tượng.', 1, 1, 9),
(1, 20, 'Iphone 15', 20000000, 'Đen', '128', '/assets/imgs/iphone-15-removebg-preview.png', 0, 'iPhone 15 128GB được trang bị màn hình Dynamic Island kích thước 6.1 inch với công nghệ hiển thị Super Retina XDR màn lại trải nghiệm hình ảnh vượt trội. Điện thoại với mặt lưng kính nhám chống bám mồ hôi cùng 5 phiên bản màu sắc lựa chọn: Hồng, Vàng, Xanh lá, Xanh dương và đen. Camera trên iPhone 15 series cũng được nâng cấp lên cảm biến 48MP cùng tính năng chụp zoom quang học tới 2x. Cùng với thiết kế cổng sạc thay đổi từ lightning sang USB-C vô cùng ấn tượng.', 1, 1, 9),
(1, 21, 'Iphone 15', 20000000, 'Đen', '128', '/assets/imgs/iphone-15-removebg-preview.png', 0, 'iPhone 15 128GB được trang bị màn hình Dynamic Island kích thước 6.1 inch với công nghệ hiển thị Super Retina XDR màn lại trải nghiệm hình ảnh vượt trội. Điện thoại với mặt lưng kính nhám chống bám mồ hôi cùng 5 phiên bản màu sắc lựa chọn: Hồng, Vàng, Xanh lá, Xanh dương và đen. Camera trên iPhone 15 series cũng được nâng cấp lên cảm biến 48MP cùng tính năng chụp zoom quang học tới 2x. Cùng với thiết kế cổng sạc thay đổi từ lightning sang USB-C vô cùng ấn tượng.', 1, 1, 9),
(1, 22, 'Iphone 15', 20000000, 'Đen', '128', '/assets/imgs/iphone-15-removebg-preview.png', 0, 'iPhone 15 128GB được trang bị màn hình Dynamic Island kích thước 6.1 inch với công nghệ hiển thị Super Retina XDR màn lại trải nghiệm hình ảnh vượt trội. Điện thoại với mặt lưng kính nhám chống bám mồ hôi cùng 5 phiên bản màu sắc lựa chọn: Hồng, Vàng, Xanh lá, Xanh dương và đen. Camera trên iPhone 15 series cũng được nâng cấp lên cảm biến 48MP cùng tính năng chụp zoom quang học tới 2x. Cùng với thiết kế cổng sạc thay đổi từ lightning sang USB-C vô cùng ấn tượng.', 1, 1, 9),
(2, 23, 'Microsoft Surface Laptop 7 Core Ultra 7', 27999000, 'Đen', '512', '/assets/imgs/Microsoft-Surface-Laptop-7-Core-Ultra-7.jpg', 0, 'Khung máy bằng nhôm CNC cao cấp – Khung máy bằng nhôm cao cấp của máy tính xách tay Zephyrus G16 OLED tạo nên sự cân bằng giữa độ bền và tính thanh lịch.  \r\n\r\nSIÊU MỎNG VÀ SIÊU NHẸ – Thoải mái di động mà không phải đánh đổi với khung máy siêu mỏng 0,59” chỉ nặng 4,08 pound.  \r\n\r\nĐỊNH NGHĨA LẠI VỀ CHƠI GAME – Tối đa hóa tiềm năng sáng tạo và chơi game với Windows 11 Pro và GPU máy tính xách tay NVIDIA® GeForce RTX™ 4060 với NVIDIA Advanced Optimus™. \r\n\r\nHIỆU SUẤT NHỜ AI – Tăng tốc quy trình làm việc của bạn với Bộ xử lý AMD Ryzen™ AI 9 HX 370 mới nhất với hơn 45 TOP AMD Ryzen AI và sức mạnh của Bộ xử lý thần kinh (NPU).  \r\n\r\nĐA NHIỆM VỤ DỄ DÀNG – Đa nhiệm nhanh chóng với RAM LPDDR5X 32GB và SSD PCIe Gen 4.0 1TB.  \r\n\r\nMÀN HÌNH OLED ROG NEBULA với NVIDIA® G-SYNC – Nâng cao trải nghiệm hình ảnh của bạn với Màn hình OLED ROG Nebula, có thời gian phản hồi nhanh 0,2ms, độ phân giải 2,5K và NVIDIA G-SYNC.  \r\n\r\nLÀM MÁT THÔNG MINH ROG – Luôn mát mẻ dưới áp lực với hệ thống làm mát thông minh ROG sử dụng kim loại lỏng giúp giảm nhiệt độ CPU tới 13 độ, Quạt Arc Flow thế hệ thứ 2, v.v. \r\n\r\nPC GAME PASS – Nhận thẻ miễn phí 90 ngày và truy cập hơn 100 trò chơi chất lượng cao. Với các trò chơi được thêm vào liên tục, luôn có điều gì đó mới để chơi', 7, 1, 10),
(2, 24, 'Microsoft Surface Laptop 7 Core Ultra 7', 27999000, 'Đen', '512', '/assets/imgs/Microsoft-Surface-Laptop-7-Core-Ultra-7.jpg', 0, 'Khung máy bằng nhôm CNC cao cấp – Khung máy bằng nhôm cao cấp của máy tính xách tay Zephyrus G16 OLED tạo nên sự cân bằng giữa độ bền và tính thanh lịch.  \r\n\r\nSIÊU MỎNG VÀ SIÊU NHẸ – Thoải mái di động mà không phải đánh đổi với khung máy siêu mỏng 0,59” chỉ nặng 4,08 pound.  \r\n\r\nĐỊNH NGHĨA LẠI VỀ CHƠI GAME – Tối đa hóa tiềm năng sáng tạo và chơi game với Windows 11 Pro và GPU máy tính xách tay NVIDIA® GeForce RTX™ 4060 với NVIDIA Advanced Optimus™. \r\n\r\nHIỆU SUẤT NHỜ AI – Tăng tốc quy trình làm việc của bạn với Bộ xử lý AMD Ryzen™ AI 9 HX 370 mới nhất với hơn 45 TOP AMD Ryzen AI và sức mạnh của Bộ xử lý thần kinh (NPU).  \r\n\r\nĐA NHIỆM VỤ DỄ DÀNG – Đa nhiệm nhanh chóng với RAM LPDDR5X 32GB và SSD PCIe Gen 4.0 1TB.  \r\n\r\nMÀN HÌNH OLED ROG NEBULA với NVIDIA® G-SYNC – Nâng cao trải nghiệm hình ảnh của bạn với Màn hình OLED ROG Nebula, có thời gian phản hồi nhanh 0,2ms, độ phân giải 2,5K và NVIDIA G-SYNC.  \r\n\r\nLÀM MÁT THÔNG MINH ROG – Luôn mát mẻ dưới áp lực với hệ thống làm mát thông minh ROG sử dụng kim loại lỏng giúp giảm nhiệt độ CPU tới 13 độ, Quạt Arc Flow thế hệ thứ 2, v.v. \r\n\r\nPC GAME PASS – Nhận thẻ miễn phí 90 ngày và truy cập hơn 100 trò chơi chất lượng cao. Với các trò chơi được thêm vào liên tục, luôn có điều gì đó mới để chơi', 7, 1, 10),
(2, 25, 'Microsoft Surface Laptop 7 Core Ultra 7', 27999000, 'Đen', '512', '/assets/imgs/Microsoft-Surface-Laptop-7-Core-Ultra-7.jpg', 0, 'Khung máy bằng nhôm CNC cao cấp – Khung máy bằng nhôm cao cấp của máy tính xách tay Zephyrus G16 OLED tạo nên sự cân bằng giữa độ bền và tính thanh lịch.  \r\n\r\nSIÊU MỎNG VÀ SIÊU NHẸ – Thoải mái di động mà không phải đánh đổi với khung máy siêu mỏng 0,59” chỉ nặng 4,08 pound.  \r\n\r\nĐỊNH NGHĨA LẠI VỀ CHƠI GAME – Tối đa hóa tiềm năng sáng tạo và chơi game với Windows 11 Pro và GPU máy tính xách tay NVIDIA® GeForce RTX™ 4060 với NVIDIA Advanced Optimus™. \r\n\r\nHIỆU SUẤT NHỜ AI – Tăng tốc quy trình làm việc của bạn với Bộ xử lý AMD Ryzen™ AI 9 HX 370 mới nhất với hơn 45 TOP AMD Ryzen AI và sức mạnh của Bộ xử lý thần kinh (NPU).  \r\n\r\nĐA NHIỆM VỤ DỄ DÀNG – Đa nhiệm nhanh chóng với RAM LPDDR5X 32GB và SSD PCIe Gen 4.0 1TB.  \r\n\r\nMÀN HÌNH OLED ROG NEBULA với NVIDIA® G-SYNC – Nâng cao trải nghiệm hình ảnh của bạn với Màn hình OLED ROG Nebula, có thời gian phản hồi nhanh 0,2ms, độ phân giải 2,5K và NVIDIA G-SYNC.  \r\n\r\nLÀM MÁT THÔNG MINH ROG – Luôn mát mẻ dưới áp lực với hệ thống làm mát thông minh ROG sử dụng kim loại lỏng giúp giảm nhiệt độ CPU tới 13 độ, Quạt Arc Flow thế hệ thứ 2, v.v. \r\n\r\nPC GAME PASS – Nhận thẻ miễn phí 90 ngày và truy cập hơn 100 trò chơi chất lượng cao. Với các trò chơi được thêm vào liên tục, luôn có điều gì đó mới để chơi', 7, 1, 10),
(2, 26, 'Microsoft Surface Laptop 7 Core Ultra 7', 27999000, 'Đen', '512', '/assets/imgs/Microsoft-Surface-Laptop-7-Core-Ultra-7.jpg', 0, 'Khung máy bằng nhôm CNC cao cấp – Khung máy bằng nhôm cao cấp của máy tính xách tay Zephyrus G16 OLED tạo nên sự cân bằng giữa độ bền và tính thanh lịch.  \r\n\r\nSIÊU MỎNG VÀ SIÊU NHẸ – Thoải mái di động mà không phải đánh đổi với khung máy siêu mỏng 0,59” chỉ nặng 4,08 pound.  \r\n\r\nĐỊNH NGHĨA LẠI VỀ CHƠI GAME – Tối đa hóa tiềm năng sáng tạo và chơi game với Windows 11 Pro và GPU máy tính xách tay NVIDIA® GeForce RTX™ 4060 với NVIDIA Advanced Optimus™. \r\n\r\nHIỆU SUẤT NHỜ AI – Tăng tốc quy trình làm việc của bạn với Bộ xử lý AMD Ryzen™ AI 9 HX 370 mới nhất với hơn 45 TOP AMD Ryzen AI và sức mạnh của Bộ xử lý thần kinh (NPU).  \r\n\r\nĐA NHIỆM VỤ DỄ DÀNG – Đa nhiệm nhanh chóng với RAM LPDDR5X 32GB và SSD PCIe Gen 4.0 1TB.  \r\n\r\nMÀN HÌNH OLED ROG NEBULA với NVIDIA® G-SYNC – Nâng cao trải nghiệm hình ảnh của bạn với Màn hình OLED ROG Nebula, có thời gian phản hồi nhanh 0,2ms, độ phân giải 2,5K và NVIDIA G-SYNC.  \r\n\r\nLÀM MÁT THÔNG MINH ROG – Luôn mát mẻ dưới áp lực với hệ thống làm mát thông minh ROG sử dụng kim loại lỏng giúp giảm nhiệt độ CPU tới 13 độ, Quạt Arc Flow thế hệ thứ 2, v.v. \r\n\r\nPC GAME PASS – Nhận thẻ miễn phí 90 ngày và truy cập hơn 100 trò chơi chất lượng cao. Với các trò chơi được thêm vào liên tục, luôn có điều gì đó mới để chơi', 7, 1, 10),
(3, 27, 'Tai nghe Bluetooth Apple AirPods 4 | Chính hãng Apple Việt Nam', 3490000, 'Đen', '', '/assets/imgs/apple-airpods-4-thumb.jpg', 0, '- Chip H2 nổi bật, mạnh mẽ được tích hợp trong Airpod 4 giúp trải nghiệm âm thanh của bạn mượt mà hơn.\r\n- Công nghệ Bluetooth 5.3 mang đến kết nối ổn định, mượt mà, tiêu thụ năng lượng thấp, giúp bạn tiết kiệm pin đáng kể.\r\n- Khả năng chống nước đạt chuẩn IP54 mang lại cảm giác thoải mái khi sử dụng tai nghe ngoài trời mà không lo bụi bẩn, hoặc mồ hôi.\r\n- Thời gian sử dụng ấn tượng với dung lượng pin cao, hộp sạc dùng được 30h và tại nghe dùng được 5h', 0, 1, 6),
(2, 28, 'Microsoft Surface Laptop 7 Core Ultra 7', 27999000, 'Đen', '512', '/assets/imgs/Microsoft-Surface-Laptop-7-Core-Ultra-7.jpg', 0, 'Khung máy bằng nhôm CNC cao cấp – Khung máy bằng nhôm cao cấp của máy tính xách tay Zephyrus G16 OLED tạo nên sự cân bằng giữa độ bền và tính thanh lịch.  \r\n\r\nSIÊU MỎNG VÀ SIÊU NHẸ – Thoải mái di động mà không phải đánh đổi với khung máy siêu mỏng 0,59” chỉ nặng 4,08 pound.  \r\n\r\nĐỊNH NGHĨA LẠI VỀ CHƠI GAME – Tối đa hóa tiềm năng sáng tạo và chơi game với Windows 11 Pro và GPU máy tính xách tay NVIDIA® GeForce RTX™ 4060 với NVIDIA Advanced Optimus™. \r\n\r\nHIỆU SUẤT NHỜ AI – Tăng tốc quy trình làm việc của bạn với Bộ xử lý AMD Ryzen™ AI 9 HX 370 mới nhất với hơn 45 TOP AMD Ryzen AI và sức mạnh của Bộ xử lý thần kinh (NPU).  \r\n\r\nĐA NHIỆM VỤ DỄ DÀNG – Đa nhiệm nhanh chóng với RAM LPDDR5X 32GB và SSD PCIe Gen 4.0 1TB.  \r\n\r\nMÀN HÌNH OLED ROG NEBULA với NVIDIA® G-SYNC – Nâng cao trải nghiệm hình ảnh của bạn với Màn hình OLED ROG Nebula, có thời gian phản hồi nhanh 0,2ms, độ phân giải 2,5K và NVIDIA G-SYNC.  \r\n\r\nLÀM MÁT THÔNG MINH ROG – Luôn mát mẻ dưới áp lực với hệ thống làm mát thông minh ROG sử dụng kim loại lỏng giúp giảm nhiệt độ CPU tới 13 độ, Quạt Arc Flow thế hệ thứ 2, v.v. \r\n\r\nPC GAME PASS – Nhận thẻ miễn phí 90 ngày và truy cập hơn 100 trò chơi chất lượng cao. Với các trò chơi được thêm vào liên tục, luôn có điều gì đó mới để chơi', 7, 1, 10),
(2, 29, 'Microsoft Surface Laptop 7 Core Ultra 7', 27999000, 'Đen', '512', '/assets/imgs/Microsoft-Surface-Laptop-7-Core-Ultra-7.jpg', 0, 'Khung máy bằng nhôm CNC cao cấp – Khung máy bằng nhôm cao cấp của máy tính xách tay Zephyrus G16 OLED tạo nên sự cân bằng giữa độ bền và tính thanh lịch.  \r\n\r\nSIÊU MỎNG VÀ SIÊU NHẸ – Thoải mái di động mà không phải đánh đổi với khung máy siêu mỏng 0,59” chỉ nặng 4,08 pound.  \r\n\r\nĐỊNH NGHĨA LẠI VỀ CHƠI GAME – Tối đa hóa tiềm năng sáng tạo và chơi game với Windows 11 Pro và GPU máy tính xách tay NVIDIA® GeForce RTX™ 4060 với NVIDIA Advanced Optimus™. \r\n\r\nHIỆU SUẤT NHỜ AI – Tăng tốc quy trình làm việc của bạn với Bộ xử lý AMD Ryzen™ AI 9 HX 370 mới nhất với hơn 45 TOP AMD Ryzen AI và sức mạnh của Bộ xử lý thần kinh (NPU).  \r\n\r\nĐA NHIỆM VỤ DỄ DÀNG – Đa nhiệm nhanh chóng với RAM LPDDR5X 32GB và SSD PCIe Gen 4.0 1TB.  \r\n\r\nMÀN HÌNH OLED ROG NEBULA với NVIDIA® G-SYNC – Nâng cao trải nghiệm hình ảnh của bạn với Màn hình OLED ROG Nebula, có thời gian phản hồi nhanh 0,2ms, độ phân giải 2,5K và NVIDIA G-SYNC.  \r\n\r\nLÀM MÁT THÔNG MINH ROG – Luôn mát mẻ dưới áp lực với hệ thống làm mát thông minh ROG sử dụng kim loại lỏng giúp giảm nhiệt độ CPU tới 13 độ, Quạt Arc Flow thế hệ thứ 2, v.v. \r\n\r\nPC GAME PASS – Nhận thẻ miễn phí 90 ngày và truy cập hơn 100 trò chơi chất lượng cao. Với các trò chơi được thêm vào liên tục, luôn có điều gì đó mới để chơi', 7, 1, 10),
(2, 30, 'Microsoft Surface Laptop 7 Core Ultra 7', 27999000, 'Đen', '512', '/assets/imgs/Microsoft-Surface-Laptop-7-Core-Ultra-7.jpg', 0, 'Khung máy bằng nhôm CNC cao cấp – Khung máy bằng nhôm cao cấp của máy tính xách tay Zephyrus G16 OLED tạo nên sự cân bằng giữa độ bền và tính thanh lịch.  \r\n\r\nSIÊU MỎNG VÀ SIÊU NHẸ – Thoải mái di động mà không phải đánh đổi với khung máy siêu mỏng 0,59” chỉ nặng 4,08 pound.  \r\n\r\nĐỊNH NGHĨA LẠI VỀ CHƠI GAME – Tối đa hóa tiềm năng sáng tạo và chơi game với Windows 11 Pro và GPU máy tính xách tay NVIDIA® GeForce RTX™ 4060 với NVIDIA Advanced Optimus™. \r\n\r\nHIỆU SUẤT NHỜ AI – Tăng tốc quy trình làm việc của bạn với Bộ xử lý AMD Ryzen™ AI 9 HX 370 mới nhất với hơn 45 TOP AMD Ryzen AI và sức mạnh của Bộ xử lý thần kinh (NPU).  \r\n\r\nĐA NHIỆM VỤ DỄ DÀNG – Đa nhiệm nhanh chóng với RAM LPDDR5X 32GB và SSD PCIe Gen 4.0 1TB.  \r\n\r\nMÀN HÌNH OLED ROG NEBULA với NVIDIA® G-SYNC – Nâng cao trải nghiệm hình ảnh của bạn với Màn hình OLED ROG Nebula, có thời gian phản hồi nhanh 0,2ms, độ phân giải 2,5K và NVIDIA G-SYNC.  \r\n\r\nLÀM MÁT THÔNG MINH ROG – Luôn mát mẻ dưới áp lực với hệ thống làm mát thông minh ROG sử dụng kim loại lỏng giúp giảm nhiệt độ CPU tới 13 độ, Quạt Arc Flow thế hệ thứ 2, v.v. \r\n\r\nPC GAME PASS – Nhận thẻ miễn phí 90 ngày và truy cập hơn 100 trò chơi chất lượng cao. Với các trò chơi được thêm vào liên tục, luôn có điều gì đó mới để chơi', 7, 1, 10),
(2, 31, 'Microsoft Surface Laptop 7 Core Ultra 7', 27999000, 'Đen', '512', '/assets/imgs/Microsoft-Surface-Laptop-7-Core-Ultra-7.jpg', 0, 'Khung máy bằng nhôm CNC cao cấp – Khung máy bằng nhôm cao cấp của máy tính xách tay Zephyrus G16 OLED tạo nên sự cân bằng giữa độ bền và tính thanh lịch.  \r\n\r\nSIÊU MỎNG VÀ SIÊU NHẸ – Thoải mái di động mà không phải đánh đổi với khung máy siêu mỏng 0,59” chỉ nặng 4,08 pound.  \r\n\r\nĐỊNH NGHĨA LẠI VỀ CHƠI GAME – Tối đa hóa tiềm năng sáng tạo và chơi game với Windows 11 Pro và GPU máy tính xách tay NVIDIA® GeForce RTX™ 4060 với NVIDIA Advanced Optimus™. \r\n\r\nHIỆU SUẤT NHỜ AI – Tăng tốc quy trình làm việc của bạn với Bộ xử lý AMD Ryzen™ AI 9 HX 370 mới nhất với hơn 45 TOP AMD Ryzen AI và sức mạnh của Bộ xử lý thần kinh (NPU).  \r\n\r\nĐA NHIỆM VỤ DỄ DÀNG – Đa nhiệm nhanh chóng với RAM LPDDR5X 32GB và SSD PCIe Gen 4.0 1TB.  \r\n\r\nMÀN HÌNH OLED ROG NEBULA với NVIDIA® G-SYNC – Nâng cao trải nghiệm hình ảnh của bạn với Màn hình OLED ROG Nebula, có thời gian phản hồi nhanh 0,2ms, độ phân giải 2,5K và NVIDIA G-SYNC.  \r\n\r\nLÀM MÁT THÔNG MINH ROG – Luôn mát mẻ dưới áp lực với hệ thống làm mát thông minh ROG sử dụng kim loại lỏng giúp giảm nhiệt độ CPU tới 13 độ, Quạt Arc Flow thế hệ thứ 2, v.v. \r\n\r\nPC GAME PASS – Nhận thẻ miễn phí 90 ngày và truy cập hơn 100 trò chơi chất lượng cao. Với các trò chơi được thêm vào liên tục, luôn có điều gì đó mới để chơi', 7, 1, 10),
(2, 32, 'Microsoft Surface Laptop 7 Core Ultra 7', 27999000, 'Đen', '512', '/assets/imgs/Microsoft-Surface-Laptop-7-Core-Ultra-7.jpg', 0, 'Khung máy bằng nhôm CNC cao cấp – Khung máy bằng nhôm cao cấp của máy tính xách tay Zephyrus G16 OLED tạo nên sự cân bằng giữa độ bền và tính thanh lịch.  \r\n\r\nSIÊU MỎNG VÀ SIÊU NHẸ – Thoải mái di động mà không phải đánh đổi với khung máy siêu mỏng 0,59” chỉ nặng 4,08 pound.  \r\n\r\nĐỊNH NGHĨA LẠI VỀ CHƠI GAME – Tối đa hóa tiềm năng sáng tạo và chơi game với Windows 11 Pro và GPU máy tính xách tay NVIDIA® GeForce RTX™ 4060 với NVIDIA Advanced Optimus™. \r\n\r\nHIỆU SUẤT NHỜ AI – Tăng tốc quy trình làm việc của bạn với Bộ xử lý AMD Ryzen™ AI 9 HX 370 mới nhất với hơn 45 TOP AMD Ryzen AI và sức mạnh của Bộ xử lý thần kinh (NPU).  \r\n\r\nĐA NHIỆM VỤ DỄ DÀNG – Đa nhiệm nhanh chóng với RAM LPDDR5X 32GB và SSD PCIe Gen 4.0 1TB.  \r\n\r\nMÀN HÌNH OLED ROG NEBULA với NVIDIA® G-SYNC – Nâng cao trải nghiệm hình ảnh của bạn với Màn hình OLED ROG Nebula, có thời gian phản hồi nhanh 0,2ms, độ phân giải 2,5K và NVIDIA G-SYNC.  \r\n\r\nLÀM MÁT THÔNG MINH ROG – Luôn mát mẻ dưới áp lực với hệ thống làm mát thông minh ROG sử dụng kim loại lỏng giúp giảm nhiệt độ CPU tới 13 độ, Quạt Arc Flow thế hệ thứ 2, v.v. \r\n\r\nPC GAME PASS – Nhận thẻ miễn phí 90 ngày và truy cập hơn 100 trò chơi chất lượng cao. Với các trò chơi được thêm vào liên tục, luôn có điều gì đó mới để chơi', 7, 1, 10),
(2, 33, 'Microsoft Surface Laptop 7 Core Ultra 7', 27999000, 'Đen', '512', '/assets/imgs/Microsoft-Surface-Laptop-7-Core-Ultra-7.jpg', 0, 'Khung máy bằng nhôm CNC cao cấp – Khung máy bằng nhôm cao cấp của máy tính xách tay Zephyrus G16 OLED tạo nên sự cân bằng giữa độ bền và tính thanh lịch.  \r\n\r\nSIÊU MỎNG VÀ SIÊU NHẸ – Thoải mái di động mà không phải đánh đổi với khung máy siêu mỏng 0,59” chỉ nặng 4,08 pound.  \r\n\r\nĐỊNH NGHĨA LẠI VỀ CHƠI GAME – Tối đa hóa tiềm năng sáng tạo và chơi game với Windows 11 Pro và GPU máy tính xách tay NVIDIA® GeForce RTX™ 4060 với NVIDIA Advanced Optimus™. \r\n\r\nHIỆU SUẤT NHỜ AI – Tăng tốc quy trình làm việc của bạn với Bộ xử lý AMD Ryzen™ AI 9 HX 370 mới nhất với hơn 45 TOP AMD Ryzen AI và sức mạnh của Bộ xử lý thần kinh (NPU).  \r\n\r\nĐA NHIỆM VỤ DỄ DÀNG – Đa nhiệm nhanh chóng với RAM LPDDR5X 32GB và SSD PCIe Gen 4.0 1TB.  \r\n\r\nMÀN HÌNH OLED ROG NEBULA với NVIDIA® G-SYNC – Nâng cao trải nghiệm hình ảnh của bạn với Màn hình OLED ROG Nebula, có thời gian phản hồi nhanh 0,2ms, độ phân giải 2,5K và NVIDIA G-SYNC.  \r\n\r\nLÀM MÁT THÔNG MINH ROG – Luôn mát mẻ dưới áp lực với hệ thống làm mát thông minh ROG sử dụng kim loại lỏng giúp giảm nhiệt độ CPU tới 13 độ, Quạt Arc Flow thế hệ thứ 2, v.v. \r\n\r\nPC GAME PASS – Nhận thẻ miễn phí 90 ngày và truy cập hơn 100 trò chơi chất lượng cao. Với các trò chơi được thêm vào liên tục, luôn có điều gì đó mới để chơi', 7, 1, 10),
(1, 34, 'Iphone 11111', 11111111, 'Đen', '6', '', 0, 'qưqertyu', 8, 1, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `search_history`
--

ALTER TABLE `search_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `keyword` varchar(255) NOT NULL,
  `search_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD PRIMARY KEY (`MaHD`,`MaSP`);

--
-- Chỉ mục cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD PRIMARY KEY (`MaSP`,`MaND`,`NgayLap`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`MaGH`),
  ADD KEY `MaND` (`MaND`),
  ADD KEY `MaSP` (`MaSP`);

--
-- Chỉ mục cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`MaHD`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MaKH`),
  ADD KEY `MaND` (`MaND`);

--
-- Chỉ mục cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  ADD PRIMARY KEY (`MaKM`);

--
-- Chỉ mục cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  ADD PRIMARY KEY (`MaLSP`);

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`MaND`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSP`);

--
-- Chỉ mục cho bảng `search_history`
--
ALTER TABLE `search_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `giohang`
--
ALTER TABLE `giohang`
  MODIFY `MaGH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `MaHD` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MaKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  MODIFY `MaKM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  MODIFY `MaLSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `MaND` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `MaSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `search_history`
--
ALTER TABLE `search_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `giohang_ibfk_1` FOREIGN KEY (`MaND`) REFERENCES `nguoidung` (`MaND`),
  ADD CONSTRAINT `giohang_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`);

--
-- Các ràng buộc cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD CONSTRAINT `khachhang_ibfk_1` FOREIGN KEY (`MaND`) REFERENCES `nguoidung` (`MaND`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
