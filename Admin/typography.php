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

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="icon" type="image/x-icon" href="../assets/imgs/logo-tab.png">

	<title>Admin_ProTech</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="./assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="./assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="./assets/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="../../../assets/fonts/fontawesome-free-6.6.0-web/fontawesome-free-6.6.0-web/css/all.min.css">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="./assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="blue" data-image="./assets/img/sidebar-5.jpg">
    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="#" class="simple-text">
                    Admin_ProTech
                </a>
            </div>

            <ul class="nav">
                <li>
                    <a href="../Admin/dashboard.php">
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="../Admin/user.php">
                        <i class="pe-7s-user"></i>
                        <p>User Profile</p>
                    </a>
                </li>
                <li>
                    <a href="../Admin/table.php">
                        <i class="pe-7s-note2"></i>
                        <p>Table List</p>
                    </a>
                </li>
                <li class="active">
                    <a href="../Admin/typography.php">
                        <i class="pe-7s-news-paper"></i>
                        <p>Order</p>
                    </a>
                </li>
                <li>
                    <a href="../Admin/maps.php">
                        <i class="pe-7s-map-marker"></i>
                        <p>Maps</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>
    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Orders</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-dashboard"></i>
                            </a>
                        </li>
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-globe"></i>
                                    <b class="caret"></b>
                                    <span class="notification">5</span>
                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Notification 1</a></li>
                                <li><a href="#">Notification 2</a></li>
                                <li><a href="#">Notification 3</a></li>
                                <li><a href="#">Notification 4</a></li>
                                <li><a href="#">Another notification</a></li>
                              </ul>
                        </li>
                        <li>
                           <a href="">
                                <i class="fa fa-search"></i>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                           <a href="">
                               Account
                            </a>
                        </li>
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    Dropdown
                                    <b class="caret"></b>
                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                              </ul>
                        </li>
                        <li>
                            <a href="#">
                                Log out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                      <div class="tile">
                        <div class="tile-body">
                          <div class="row element-button">
                            <!-- <div class="col-sm-2">
              
                              <a class="btn btn-add btn-sm" href="./add-productList.php" title="Thêm"><i class="fas fa-plus"></i>
                                Tạo mới đơn hàng</a>
                            </div>
                            <div class="col-sm-2">
                              <a class="btn btn-delete btn-sm nhap-tu-file" type="button" title="Nhập" onclick="myFunction(this)"><i
                                  class="fas fa-file-upload"></i> Tải từ file</a>
                            </div>
               -->
                            <div class="col-sm-2">
                              <a class="btn btn-delete btn-sm print-file" type="button" title="In" onclick="myApp.printTable()"><i
                                  class="fas fa-print"></i> In dữ liệu</a>
                            </div>
                            <div class="col-sm-2">
                              <a class="btn btn-delete btn-sm print-file js-textareacopybtn" type="button" title="Sao chép"><i
                                  class="fas fa-copy"></i> Sao chép</a>
                            </div>
              
                            <div class="col-sm-2">
                              <a class="btn btn-excel btn-sm" href="" title="In"><i class="fas fa-file-excel"></i> Xuất Excel</a>
                            </div>
                            <div class="col-sm-2">
                              <a class="btn btn-delete btn-sm pdf-file" type="button" title="In" onclick="myFunction(this)"><i
                                  class="fas fa-file-pdf"></i> Xuất PDF</a>
                            </div>
                            <div class="col-sm-2">
                              <a class="btn btn-delete btn-sm" type="button" title="Xóa" onclick="myFunction(this)"><i
                                  class="fas fa-trash-alt"></i> Xóa tất cả </a>
                            </div>
                          </div>
                          <div class="filters">
                            <div class="filter">
                              <label for="filterStatus">Lọc theo trạng thái:</label>
                              <select id="filterStatus">
                                <option value="Tất cả">Tất cả</option>
                                <option value="Hoàn thành">Hoàn thành</option>
                                <option value="Chờ thanh toán">Chờ thanh toán</option>
                                <option value="Đang giao hàng">Đang giao hàng</option>
                                <option value="Đã hủy">Đã hủy</option>
                              </select>
                            </div>
                            <div class="filter">
                              <label for="startDate">Từ ngày:</label>
                              <input type="date" id="startDate">
                              <label for="endDate">Đến ngày:</label>
                              <input type="date" id="endDate">
                              <button id="filterDateBtn">Lọc</button>
                            </div>
                          </div>
                           
                          <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                              <tr>
                                <th width="10"><input type="checkbox" id="all"></th>
                                <th>ID đơn hàng</th>
                                <th>Khách hàng</th>
                                <th>Đơn hàng</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                                <th>Tình trạng</th>
                                <th>Tính năng</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td data-date="2024-11-15" width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>MD0837</td>
                                <td>Triệu Thanh Phú</td>
                                <td>Iphone 14 Promax</td>
                                <td>2</td>
                                <td>9.400.000 đ</td>
                                <td><span class="badge bg-success">Hoàn thành</span></td>
                                <td>
                                    <button class="btn view">Xem</button>
                                </td>
                              <tr>
                                <td data-date="2024-04-18" width="10" ><input type="checkbox" name="check1" value="1"></td>
                                <td>MĐ8265</td>
                                <td>Nguyễn Thị Ngọc Cẩm</td>
                                <td>iMac 14s</td>
                                <td>1</td>
                                <td>3.800.000 đ</td>                 
                                <td><span class="badge bg-success">Hoàn thành</span></td>
                                <td>
                                    <button class="btn view">Xem</button>
                                </td>
                              <tr>
                                <td data-date="2024-07-23" width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>MT9835</td>
                                <td>Đặng Văn Vinh</td>
                                <td>Galaxy Zlip 7</td>
                                <td>3 </td>
                                <td>40.650.000 đ</td>
                                <td><span class="badge bg-success">Hoàn thành</span></td>
                                <td>
                                    <button class="btn view">Xem</button>
                                </td>
                              <tr>
                                <td data-date="2024-05-19" width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>ER3835</td>
                                <td>Nguyễn Thị Mỹ Yến</td>
                                <td>Đồng hồ thông minh</td>
                                <td>1 </td>
                                <td>16.770.000 đ</td>
                                <td><span class="badge bg-info">Chờ thanh toán</span></td>
                                <td>
                                    <button class="btn view">Xem</button>
                                </td>
                              <tr>
                                <td data-date="2024-05-19" width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>ER3835</td>
                                <td>Nguyễn Thị Mỹ Yến</td>
                                <td>Đồng hồ thông minh</td>
                                <td>1 </td>
                                <td>16.770.000 đ</td>
                                <td><span class="badge bg-info">Chờ thanh toán</span></td>
                                <td>
                                    <button class="btn view">Xem</button>
                                </td>
                              <tr>
                                <td data-date="2024-09-20" width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>QY8723</td>
                                <td>Ngô Thái An</td>
                                <td>AirPod Pro2 </td>
                                <td>1 </td>
                                <td>14.500.000 đ</td>
                                <td><span class="badge bg-danger">Đã hủy</span></td>
                                <td>
                                    <button class="btn view">Xem</button>
                                </td>

                                <tr class="no-product-row" style="display:none">
                                  <td colspan="7" class="text-center">Không tìm thấy sản phẩm</td>
                              </tr>

                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="#">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Company
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Portfolio
                            </a>
                        </li>
                        <li>
                            <a href="#">
                               Blog
                            </a>
                        </li>
                    </ul>
                </nav>
                <p class="copyright pull-right">
                    &copy; 2024 - Bản quyền thuộc về Công ty <a href="#">ProTech</a>
                </p>
        </footer>


    </div>
</div>

<script>
// Đánh dấu trạng thái đơn hàng
function markOrderStatus() {
  const checkboxes = document.querySelectorAll("tbody input[type='checkbox']");
  checkboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", function () {
      const row = this.closest("tr");
      row.style.backgroundColor = this.checked ? "#e0f7fa" : ""; // Đánh dấu hoặc bỏ đánh dấu
    });
  });
}

// Lọc đơn hàng theo ngày
function filterByDate() {
  const startDate = document.getElementById("startDate").value;
  const endDate = document.getElementById("endDate").value;
  const rows = document.querySelectorAll("tbody tr");

  if (!startDate || !endDate) {
    alert("Vui lòng chọn Từ ngày và Đến ngày!");
    return;
  }

  const start = new Date(startDate);
  const end = new Date(endDate);

  let hasMatch = false; // Kiểm tra nếu có kết quả phù hợp

  rows.forEach((row) => {
    const orderDate = new Date(row.querySelector("td[data-date]").dataset.date);
    if (orderDate >= start && orderDate <= end) {
      row.style.display = ""; // Hiển thị
      hasMatch = true;
    } else {
      row.style.display = "none"; // Ẩn
    }
  });

  const noProductRow = document.querySelector(".no-product-row");
  noProductRow.style.display = hasMatch ? "none" : ""; // Hiển thị dòng thông báo nếu không có kết quả
}

// Lọc đơn hàng theo trạng thái
function filterByStatus() {
  const status = document.getElementById("filterStatus").value;
  const rows = document.querySelectorAll("tbody tr");

  rows.forEach((row) => {
    const currentStatus = row.querySelector(".badge").textContent.trim();
    if (status === "Tất cả" || currentStatus === status) {
      row.style.display = ""; // Hiển thị
    } else {
      row.style.display = "none"; // Ẩn
    }
  });
}

// Hiển thị chi tiết đơn hàng
// function viewOrderDetails() {
//   const viewButtons = document.querySelectorAll(".btn.view");
//   viewButtons.forEach((button) => {
//     button.addEventListener("click", function () {
//       // Lấy hàng tương ứng (row) mà nút "Xem" được bấm
//       const row = this.closest("tr");

//       // Lấy thông tin chi tiết từ các ô trong hàng
//       const orderId = row.cells[1].textContent.trim();
//       const customerName = row.cells[2].textContent.trim();
//       const productName = row.cells[3].textContent.trim();
//       const quantity = row.cells[4].textContent.trim();
//       const totalAmount = row.cells[5].textContent.trim();
//       const orderStatus = row.cells[6].textContent.trim();

//       // Tạo URL với các tham số (query string) để chuyển dữ liệu sang trang chi tiết
//       const url = `chiTiet.php?id=${encodeURIComponent(orderId)}&customer=${encodeURIComponent(customerName)}&product=${encodeURIComponent(productName)}&quantity=${encodeURIComponent(quantity)}&total=${encodeURIComponent(totalAmount)}&status=${encodeURIComponent(orderStatus)}`;
//       // console.log(url);
//       // Chuyển hướng đến trang chiTiet.phpl với dữ liệu của đơn hàng
//       window.location.href = url;
//     });

//   });
// }
// // Chức năng xem chi tiết
// function viewOrderDetails() {
//   const viewButtons = document.querySelectorAll(".btn.view");
//   viewButtons.forEach((button) => {
//     button.addEventListener("click", function () {
//       // Lấy hàng tương ứng (row) mà nút "Xem" được bấm
//       const row = this.closest("tr");

//       // Lấy thông tin chi tiết từ các ô trong hàng
//         const customerName = row.cells[2].textContent.trim();
//         const productName = row.cells[3].textContent.trim();
//         const quantity = row.cells[4].textContent.trim();
//         const totalPrice = row.cells[5].textContent.trim();
//         const status = row.cells[6].textContent.trim();

//       // Tạo URL với các tham số (query string) để chuyển dữ liệu sang trang chi tiết
//       const url = `chiTiet.php?id=${encodeURIComponent(orderId)}&customer=${encodeURIComponent(customerName)}&product=${encodeURIComponent(productName)}&quantity=${encodeURIComponent(quantity)}&total=${encodeURIComponent(totalAmount)}&status=${encodeURIComponent(orderStatus)}`;
      
//       // Chuyển hướng đến trang chiTiet.phpl với dữ liệu của đơn hàng
//       window.location.href = url;
//     });
//   });
// }
// Lắng nghe sự kiện click trên các nút "Xem"
document.querySelectorAll('.view').forEach(button => {
    button.addEventListener('click', function () {
        const row = button.closest('tr');  // Lấy dòng chứa nút "Xem"
        const orderId = row.cells[1].textContent.trim();
        const customerName = row.cells[2].textContent.trim();
        const productName = row.cells[3].textContent.trim();
        const quantity = row.cells[4].textContent.trim();
        const totalPrice = row.cells[5].textContent.trim();
        const status = row.cells[6].textContent.trim();

        // Lưu thông tin vào sessionStorage
        sessionStorage.setItem('orderId', orderId);
        sessionStorage.setItem('customerName', customerName);
        sessionStorage.setItem('productName', productName);
        sessionStorage.setItem('quantity', quantity);
        sessionStorage.setItem('totalPrice', totalPrice);
        sessionStorage.setItem('status', status);

        // Chuyển hướng đến trang detail.phpl
        window.location.href = 'detail.php';
       

        
    });
});


// Chức năng lọc theo ngày
document.getElementById('filterDateBtn').addEventListener('click', function() {
  const startDate = document.getElementById('startDate').value; // Ngày bắt đầu
  const endDate = document.getElementById('endDate').value; // Ngày kết thúc
  const rows = document.querySelectorAll("#sampleTable tbody tr"); // Lấy tất cả các dòng đơn hàng
  const noProductRow = document.querySelector(".no-product-row"); // Dòng thông báo không tìm thấy sản phẩm
  let productFound = false; // Biến kiểm tra xem có đơn hàng nào thỏa điều kiện không

  // Nếu người dùng đã chọn cả ngày bắt đầu và kết thúc
  if (startDate && endDate) {
    const startDateObj = new Date(startDate); // Chuyển đổi startDate thành đối tượng Date
    const endDateObj = new Date(endDate); // Chuyển đổi endDate thành đối tượng Date

    rows.forEach((row) => {
      const rowDate = row.getAttribute('data-date'); // Lấy ngày từ thuộc tính data-date của mỗi dòng
      const rowDateObj = new Date(rowDate); // Chuyển đổi ngày của dòng thành đối tượng Date

      // Kiểm tra xem ngày của đơn hàng có nằm trong khoảng ngày được chọn hay không
      if (rowDateObj >= startDateObj && rowDateObj <= endDateObj) {
        row.style.display = ""; // Hiển thị dòng nếu trong khoảng ngày
        productFound = true; // Đánh dấu là có sản phẩm
      } else {
        row.style.display = "none"; // Ẩn dòng nếu không trùng khớp ngày
      }
    });
  } else {
    // Nếu không có ngày bắt đầu hoặc ngày kết thúc, hiển thị tất cả các dòng
    rows.forEach((row) => {
      row.style.display = ""; // Hiển thị tất cả các dòng
    });
  }

  // Hiển thị hoặc ẩn dòng thông báo "Không tìm thấy sản phẩm"
  if (!productFound) {
    noProductRow.style.display = ""; // Hiển thị dòng không tìm thấy nếu không có đơn hàng nào thỏa điều kiện
  } else {
    noProductRow.style.display = "none"; // Ẩn dòng không tìm thấy nếu có ít nhất một đơn hàng thỏa điều kiện
  }
});

// Gọi chức năng xem chi tiết khi tải trang
viewOrderDetails();

// Sắp xếp các đơn hàng theo địa chỉ giao hàng
function sortOrdersByAddress() {
  const rows = Array.from(document.querySelectorAll("tbody tr"));
  rows.sort((a, b) => {
    const addressA = a.cells[2].textContent.trim().toLowerCase();
    const addressB = b.cells[2].textContent.trim().toLowerCase();
    return addressA.localeCompare(addressB);
  });

  const tbody = document.querySelector("tbody");
  rows.forEach((row) => tbody.appendChild(row));
}

// Hiển thị chi tiết đơn hàng
function viewOrderDetails() {
  const viewButtons = document.querySelectorAll(".btn.view");
  viewButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const row = this.closest("tr");
      const orderId = row.cells[1].textContent.trim();
      const customerName = row.cells[2].textContent.trim();
      const productName = row.cells[3].textContent.trim();
      const quantity = row.cells[4].textContent.trim();
      const totalPrice = row.cells[5].textContent.trim();
      const status = row.cells[6].textContent.trim();

      // Lưu vào sessionStorage
      sessionStorage.setItem("orderId", orderId);
      sessionStorage.setItem("customerName", customerName);
      sessionStorage.setItem("productName", productName);
      sessionStorage.setItem("quantity", quantity);
      sessionStorage.setItem("totalPrice", totalPrice);
      sessionStorage.setItem("status", status);

      // Chuyển hướng đến trang chi tiết
      window.location.href = "detail.php";
    });
  });
}

// Khởi tạo khi tải trang
document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("filterStatus").addEventListener("change", filterByStatus);
  document.getElementById("filterDateBtn").addEventListener("click", filterByDate);
  markOrderStatus();
  viewOrderDetails();
});

</script>
</body>

        <!--   Core JS Files   -->
    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>

</html>