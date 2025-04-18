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
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

</head>
<body>

    <div class="container">
        <div class="profile-header">
            <div class="user-info">
                <h2>ProTech</h2>
                <p>Email: ProTech.@gmail.com</p>
                <p>Thành lập từ: January 2023</p>
            </div>
        </div>

        <div class="statistics">
            <div class="stat-card">
                <h4>Total Posts</h4>
                <p>120</p>
            </div>
            <div class="stat-card">
                <h4>Friends</h4>
                <p>89</p>
            </div>
            <div class="stat-card">
                <h4>Achievements</h4>
                <p>15 Badges</p>
            </div>
        </div>

        <div class="sections">
            <div class="section">
                <h3>Account Settings</h3>
                <ul>
                    <li><a href="#" class="btn">Change Password</a></li>
                    <li><a href="#" class="btn">Update Profile</a></li>
                </ul>
            </div>

            <div class="section">
                <h3>Hoạt động gần đây</h3>
                <ul>
                    <li>Đã cập nhật vào IP: 192.168.1.1</li>
                    <li>Đăng tải sản phẩm mới</li>
                    <li>Mua gói nâng cấp ứng dụng</li>
                </ul>
            </div>

            <div class="section">
                <h3> Địa chỉ</h3>
                <ul>
                    <li>234 An Dương Vương</li>
                    <li>Phường 3 Quận 5</li>
                    <li>Thành phố Hồ Chí Minh</li>
                </ul>
            </div>
        </div>
    </div>

    </div>
</div>


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
<script>
    // Chọn các nút Change Password và Update Profile
document.querySelector('a.btn[href="#"]:nth-of-type(1)').addEventListener('click', function(event) {
    event.preventDefault();
    alert('Đã thay đổi password');
});

document.querySelectorAll('a.btn[href="#"]')[1].addEventListener('click', function(event) {
    event.preventDefault();
    alert('Đã cập nhật Profile');
});
</script>
</html>
