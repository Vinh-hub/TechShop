<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>

    <div class="container">
        <h1>Quản Lý Đơn Hàng</h1>

        <!-- Ô tìm kiếm -->
        <!-- Ô tìm kiếm -->
<div class="search-container">
    <input type="text" id="searchInput1" placeholder="Tìm kiếm theo thời gian hóa đơn" />
    <input type="text" id="searchInput2" placeholder="Tìm kiếm theo tình trạng đơn hàng" />
</div>


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
                <tr>
                    <td>1</td>
                    <td>DH001</td>
                    <td>Nguyễn Văn A</td>
                    <td>0912345678</td>
                    <td>2024-12-01</td>
                    <td>Đã giao thành công</td>
                    <td>Hà Nội</td>
                    <td>5</td>
                    <td>Giao nhanh</td>
                    <td>70.000.000đ</td>
                    <td><button class="details-btn">Xem chi tiết</button></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>DH002</td>
                    <td>Trần Thị B</td>
                    <td>0987654321</td>
                    <td>2024-12-02</td>
                    <td>Chưa xử lý</td>
                    <td>Hồ Chí Minh</td>
                    <td>4</td>
                    <td>Giao chậm</td>
                    <td>3.000.000đ</td>
                    <td><button class="details-btn">Xem chi tiết</button></td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>DH003</td>
                    <td>Trần Thị Bụt</td>
                    <td>0987654321</td>
                    <td>2024-12-02</td>
                    <td>Đã hủy</td>
                    <td>Hồ Chí Minh</td>
                    <td>1</td>
                    <td>Giao chậm</td>
                    <td>300.000đ</td>
                    <td><button class="details-btn">Xem chi tiết</button></td>
                </tr>

                <tr>
                    <td>4</td>
                    <td>DH004</td>
                    <td>Trần Thị Bảnh</td>
                    <td>0987654321</td>
                    <td>2024-12-07</td>
                    <td>Đã xác nhận</td>
                    <td>Hồ Chí Minh</td>
                    <td>2</td>
                    <td>Giao chậm</td>
                    <td>5.000.000đ</td>
                    <td><button class="details-btn">Xem chi tiết</button></td>
                </tr>

                <tr>
                    <td>5</td>
                    <td>DH005</td>
                    <td>Trần Thị Báo</td>
                    <td>0987654321</td>
                    <td>2024-12-03</td>
                    <td>Đã giao thành công</td>
                    <td>Hồ Chí Minh</td>
                    <td>3</td>
                    <td>Không ghi chú</td>
                    <td>10.000.000đ</td>
                    <td><button class="details-btn">Xem chi tiết</button></td>
                </tr>

                <tr>
                    <td>6</td>
                    <td>DH006</td>
                    <td>Trần Văn Bủn</td>
                    <td>0987654321</td>
                    <td>2024-12-20</td>
                    <td>Đã hủy</td>
                    <td>Hồ Chí Minh</td>
                    <td>1</td>
                    <td>Cẩn thận</td>
                    <td>1.000.000đ</td>
                    <td><button class="details-btn">Xem chi tiết</button></td>
                </tr>

                <tr>
                    <td>7</td>
                    <td>DH007</td>
                    <td>Trần Thị B</td>
                    <td>0987654321</td>
                    <td>2024-12-02</td>
                    <td>Chưa xử lý</td>
                    <td>Hồ Chí Minh</td>
                    <td>1</td>
                    <td>Giao nhanh</td>
                    <td>500.000đ</td>
                    <td><button class="details-btn">Xem chi tiết</button></td>
                </tr>
                <!-- Các dòng dữ liệu khác -->
            </tbody>
        </table>
    </div>

    <!-- <script src="script.js"></script> -->
    <script>
       // Lắng nghe sự kiện khi người dùng nhấn phím Enter
document.getElementById('searchInput1').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        // Lấy giá trị từ ô input
        let inputValue = document.getElementById('searchInput1').value.trim();
        
        // Kiểm tra nếu ô input có nội dung
        if (inputValue !== "") {
            // Tạo URL mới với tham số tìm kiếm
            let newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?search=' + encodeURIComponent(inputValue);
            
            // Chuyển hướng đến URL mới
            window.location.href = newUrl;  // Điều hướng đến trang với tham số tìm kiếm
        }
    }
});
document.getElementById('searchInput2').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        // Lấy giá trị từ ô input
        let inputValue = document.getElementById('searchInput2').value.trim();
        
        // Kiểm tra nếu ô input có nội dung
        if (inputValue !== "") {
            // Tạo URL mới với tham số tìm kiếm
            let newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?search=' + encodeURIComponent(inputValue);
            
            // Chuyển hướng đến URL mới
            window.location.href = newUrl;  // Điều hướng đến trang với tham số tìm kiếm
        }
    }
});
//  Xem chi tiết đơn hàng
// Đảm bảo tài liệu HTML đã được tải xong
document.addEventListener('DOMContentLoaded', function () {
    // Lấy tất cả các nút "Xem chi tiết"
    const detailsButtons = document.querySelectorAll('.details-btn');
    
    // Lặp qua tất cả các nút và thêm sự kiện click
    detailsButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Khi nhấn nút, chuyển hướng tới trang Chitietmuahang.phpl
            window.location.href = 'Chitietmuahang.php';
        });
    });
});

    </script>

</body>
</html>
