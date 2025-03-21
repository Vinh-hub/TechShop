<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Đơn Hàng</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container">
        <h1>Chi Tiết Mua Hàng</h1>

        <div class="order-info">
            <h2>Thông Tin Đơn Hàng</h2>
            <table>
                <tr>
                    <th>Mã Đơn Hàng</th>
                    <td>#123456789</td>
                </tr>
                <tr>
                    <th>Phương Thức Vận Chuyển</th>
                    <td>Giao hàng nhanh</td>
                </tr>
                <tr>
                    <th>Trạng Thái Hàng</th>
                    <td>Đã giao thành công</td>
                </tr>
            </table>
        </div>

        <div class="customer-info">
            <h2>Thông Tin Khách Hàng</h2>
            <table>
                <tr>
                    <th>Tên Khách Hàng</th>
                    <td>Nguyễn Văn A</td>
                </tr>
                <tr>
                    <th>Địa Chỉ</th>
                    <td>Hà Nội, Việt Nam</td>
                </tr>
                <tr>
                    <th>SĐT</th>
                    <td>0912345678</td>
                </tr>
            </table>
        </div>

        <div class="order-details">
            <h2>Chi Tiết Sản Phẩm</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tên Sản Phẩm</th>
                        <th>Danh mục</th>
                        <th>Số Lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Điện thoại Samsung</td>
                        <th>Điện Thoại</th>
                        <td>2</td>
                        <td>5,000,000 VNĐ</td>
                        <td>10,000,000 VNĐ</td>
                    </tr>
                    <tr>
                        <td>Laptop Dell</td>
                        <th>Laptop</th>
                        <td>1</td>
                        <td>20,000,000 VNĐ</td>
                        <td>20,000,000 VNĐ</td>
                    </tr>
                    <tr>
                        <td>Iphone 14 Promax</td>
                        <th>Điện Thoại</th>
                        <td>1</td>
                        <td>20,000,000 VNĐ</td>
                        <td>20,000,000 VNĐ</td>
                    </tr>
                    <tr>
                        <td>Airpod Pro2</td>
                        <th>Tai Nghe</th>
                        <td>1</td>
                        <td>20,000,000 VNĐ</td>
                        <td>20,000,000 VNĐ</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="order-total">
            <h2>Tổng Cộng Đơn Hàng</h2>
            <table>
                <tr>
                    <th>Tổng Cộng</th>
                    <td>70,000,000 VNĐ</td>
                </tr>
            </table>
        </div>

    </div>
<style>
    /* Cài đặt kiểu chữ và bố cục chung */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
}

.container {
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    max-width: 1000px;
    margin: 0 auto;
}

h1 {
    text-align: center;
    color: #333;
}

/* Thông tin đơn hàng */
.order-info,
.customer-info,
.order-details,
.order-total {
    margin-top: 30px;
}

.order-info h2, .customer-info h2, .order-details h2, .order-total h2 {
    font-size: 24px;
    color: #333;
    border-bottom: 2px solid #000;
    padding-bottom: 5px;
    margin-bottom: 15px;
}

/* Cải thiện bảng */
table {
    width: 100%;
    border-collapse: collapse;
}

table th,
table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table th {
    font-weight: bold;
}

/* Tổng cộng đơn hàng */
.order-total {
    text-align: right;
}

.order-total th {
    font-size: 18px;
}

.order-total td {
    font-size: 18px;
    font-weight: bold;
}

</style>
</body>
</html>
