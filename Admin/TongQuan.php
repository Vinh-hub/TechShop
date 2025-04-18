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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
        }


        .container {
            padding: 20px;
        }

        .welcome {
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .stat-card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-card h3 {
            margin: 0;
            font-size: 1.2rem;
        }

        .stat-card p {
            margin: 10px 0 0;
            color: #666;
        }

        .charts {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .chart-card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .chart-title {
            margin-bottom: 15px;
            font-size: 1rem;
            color: #333;
        }

        canvas {
            width: 100%;
            height: auto;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card" style="background-color: #e4e9ff;">
                <h3>Tổng Doanh Thu</h3>
                <p>3.900.000.000đ<br>↑ 10% So với quý trước</p>
            </div>
            <div class="stat-card" style="background-color: #ccefff;">
                <h3>Người mua hàng quý này</h3>
                <p>52142 người<br>↑ 5.6% So với quý trước</p>
            </div>
            <div class="stat-card" style="background-color: #ffccdf;">
                <h3>Thời gian mua sắm</h3>
                <p>2365h<br>↑ 7.02% So với quý trước</p>
            </div>
            <div class="stat-card" style="background-color: #d9ffcc;">
                <h3>Lượt mua mới</h3>
                <p>854 lượt<br>↑ 9.9% So với quý trước</p>
            </div>
        </div>

        <div class="charts">
            <div class="chart-card">
                <div class="chart-title">Thống kê 30 ngày gần nhất</div>
                <canvas id="chart1"></canvas>
            </div>
            <div class="chart-card">
                <div class="chart-title">Danh mục bán chạy nhất</div>
                <canvas id="chart2"></canvas>
            </div>
            <div class="chart-card">
                <div class="chart-title">Sản phẩm bán chạy và ế nhất</div>
                <canvas id="chart3"></canvas>
            </div>
        </div>
    </div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Danh Sách Bán Chạy Nhất</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            margin: 20px auto;
            width: 90%;
            max-width: 1200px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
            cursor: pointer;
        }

        a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        .container-1 {
            margin: 20px auto;
            width: 90%;
            max-width: 1200px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
            cursor: pointer;
        }

        a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        .note{
            margin-left: 15px;
        }
    </style>
</head>
<body>
    <div class="container-1">
        <h2 style="text-align: center; padding: 20px 0;">Top Sản Phẩm Bán Chạy Nhất</h2>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã SP</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Số Lượng Bán Ra</th>
                    <th>Giá (VNĐ)</th>
                    <th>Tổng Tiền (VNĐ)</th>
                    <th>Xem Chi Tiết</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>SP001</td>
                    <td>Iphone 14 ProMax</td>
                    <td>750</td>
                    <td>20.000.000</td>
                    <td>1.500.000.000</td>
                    <td><a href="#" onclick="viewDetails('SP001')">Xem Chi Tiết</a></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>SP002</td>
                    <td>Samsung Galaxy J7</td>
                    <td>550</td>
                    <td>18.000.000</td>
                    <td>1.157.500.000</td>
                    <td><a href="#" onclick="viewDetails('SP002')">Xem Chi Tiết</a></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>SP003</td>
                    <td>Laptop Dell Presion</td>
                    <td>450</td>
                    <td>15.000.000</td>
                    <td>990.000.000</td>
                    <td><a href="#" onclick="viewDetails('SP003')">Xem Chi Tiết</a></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>SP004</td>
                    <td>Hyperx Cloud 2</td>
                    <td>400</td>
                    <td>17.200.000</td>
                    <td>860.000.000</td>
                    <td><a href="#" onclick="viewDetails('SP004')">Xem Chi Tiết</a></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>SP005</td>
                    <td>Apple Watch SE</td>
                    <td>300</td>
                    <td>1.000.000</td>
                    <td>300.000.000</td>
                    <td><a href="#" onclick="viewDetails('SP005')">Xem Chi Tiết</a></td>
                </tr>

            </tbody>
        </table>
        <div class="note">
        <p><b> Tổng doanh thu:</b> 3.900.000.000đ</p>
        <p><b> Mặt hàng bán chạy nhất:</b> Iphone 14 ProMax</p>
        <p><b> Mặt hàng bán ế nhất: </b> Apple Watch SE</p>
        </div>
    </div>

    <div class="container-1">
        <h2 style="text-align: center; padding: 20px 0;">Top Khách Hàng Có Doanh Thu Cao Nhất</h2>
        <table>
            <thead>
                <tr>
                    <th>Tên Khách hàng</th>
                    <th> Doanh Thu</th>
                    <th>Xem Chi Tiết</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nguyễn Văn A</td>
                    <td>139.000.0000</td>
                    <td><a href="#" onclick="viewDetails('SP001')">Xem Chi Tiết</a></td>
                </tr>
                <tr>
                    <td>Đoàn Ngọc Xuân Trang</td>
                    <td>32.000.0000</td>
                    <td><a href="#" onclick="viewDetails('SP001')">Xem Chi Tiết</a></td>
                </tr>
                <tr>
                    <td>Lê Anh Thư</td>
                    <td>30.000.0000</td>
                    <td><a href="#" onclick="viewDetails('SP003')">Xem Chi Tiết</a></td>
                </tr>
                <tr>
                    <td>Nguyễn Thị Ngọc</td>
                    <td>24.000.0000</td>
                    <td><a href="#" onclick="viewDetails('SP004')">Xem Chi Tiết</a></td>
                </tr>
                <tr>
                    <td>Lâm Trí Vĩnh</td>
                    <td>20.000.0000</td>
                    <td><a href="#" onclick="viewDetails('SP005')">Xem Chi Tiết</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx1 = document.getElementById('chart1').getContext('2d');
        const ctx2 = document.getElementById('chart2').getContext('2d');
        const ctx3 = document.getElementById('chart3').getContext('2d');

        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: ['Điện thoại', 'Laptop', 'Đồng hồ', 'Tai nghe'],
                datasets: [{
                    data: [60, 20, 5, 15],
                    backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745']
                }]
            }
        });

        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: [1, 2, 3, 4, 5],
                datasets: [
                    {label: 'Điện thoại', data: [100, 200, 300, 500, 600], borderColor: '#007bff'},
                    {label: 'Laptop', data: [50, 150, 250, 350, 450], borderColor: '#28a745'}
                ]
            }
        });

        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: [1, 2, 3, 4, 5],
                datasets: [
                    {label: 'Iphone 14 ProMax', data: [50, 100, 150, 200, 250], backgroundColor: '#ffc107'},
                    {label: 'Apple Watch SE', data: [20, 40, 60, 80, 100], backgroundColor: '#dc3545'}
                ]
            }
        });

        function viewDetails(productCode) {
            // Chuyển hướng sang trang chi tiết sản phẩm
            window.location.href = `ChitietDonhang.php`;
        }
    </script>
</body>
</html>