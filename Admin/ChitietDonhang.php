<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Mua Hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: #fff;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 15px;
            text-align: center;
        }
        th {
            background-color: #6da6e3;
            color: #fff;
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        button {
            padding: 5px 10px;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Danh Sách Đơn Hàng</h1>
    <table>
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Tên khách hàng</th>
                <th>SĐT khách hàng</th>
                <th>Ngày đặt</th>
                <th>Địa chỉ</th>
                <th>Ghi chú</th>
                <th>Xem chi tiết</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>SP001</td>
                <td>Trần Văn A</td>
                <td>0180847203</td>
                <td>10/12/2024</td>
                <td>Hà Nội</td>
                <td>Yêu cầu giao trong giờ hành chính</td>
                <td><button onclick="viewDetails('SP001')">Chi tiết</button></td>
            </tr>
            <tr>
                <td>SP002</td>
                <td>Lê Thị C</td>
                <td>0180847203</td>
                <td>09/03/2024</td>
                <td>Hà Nội</td>
                <td>Không cần gấp</td>
                <td><button onclick="viewDetails('SP002')">Chi tiết</button></td>
            </tr>
            <tr>
                <td>SP003</td>
                <td>Phạm Văn D</td>
                <td>0180847203</td>
                <td>23/08/2024</td>
                <td>Hải Phòng</td>
                <td>Yêu cầu giao trong ngày</td>
                <td><button onclick="viewDetails('SP003')">Chi tiết</button></td>
            </tr>
            <td>SP004</td>
                <td>Nguyễ Thị E</td>
                <td>01392390823</td>
                <td>30/09/2024</td>
                <td>Bến Tre</td>
                <td>Cẩn thận hàng dễ vỡ</td>
                <td><button onclick="viewDetails('SP004')">Chi tiết</button></td>
            </tr>
            <td>SP005</td>
                <td>Nguyễn Văn A</td>
                <td>01392390823</td>
                <td>19/05/2024</td>
                <td>Long An</td>
                <td>Giao hỏa tốc trong ngày</td>
                <td><button onclick="viewDetails('SP004')">Chi tiết</button></td>
            </tr>
        </tbody>
    </table>

    <script>
        function viewDetails(productId) {
            window.location.href = `Chitietmuahang.php`;
        }
        
    </script>
</body>
</html>
