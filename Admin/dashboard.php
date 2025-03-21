
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Thêm Font Awesome -->

    <link href="./assets/css/Dashboard.css" rel="stylesheet"> 

</head>
<body>
    <header>
        <div class="container">
            <div class="admin-box-icon" id="adminIcon">
        <i class="fa-regular fa-user"></i><!-- Biểu tượng Admin -->
            </div>
            
            <!-- Hộp tài khoản Admin -->
            <div class="admin-box" id="adminBox">
                <ul>
                    <p> Tên tài khoản ProTech </p>
                    <li><a href="#" onclick="changePassword()">Change Password</a></li>
                    <li><a href="../index.php" onclick="logout()">Logout</a></li>


                </ul>
            </div>
            <div class="welcome">ProTech</div>
        <nav>
            <ul>
                    <li><a href="./Tongquan.php" class="nav-link" target="content-frame" data-target="profile">Tổng quan</a></li>
                    <li><a href="./user.php" class="nav-link" target="content-frame" data-target="profile">User Profile</a></li>
                    <li><a href="Quanlidonhang.php" class="nav-link" target="content-frame" data-target="orders">Quản lí đơn hàng</a></li>
                    <li><a href="Quanlinguoidung.php" class="nav-link" target="content-frame" data-target="users">Quản lí người dùng</a></li>
                    <li><a href="Quanlisanpham.php" class="nav-link" target="content-frame" data-target="products">Quản lí sản phẩm</a></li>
                
            </ul>
        </nav>
        </style>
        <!-- Iframe to load external content -->
        <iframe id="content-frame" name="content-frame" style="width:100%; height: 500px; border: none; margin-top: 30px;"></iframe>

        <div id="Tongquan" class="info-section">
        </div>

        <div id="profile" class="info-section">
           
        </div>
        <div id="orders" class="info-section">
    
        </div>
        <div id="users" class="info-section">
           
        </div>
        <div id="products" class="info-section">
           
        </div>
    </div>
    <footer class="end__heading-end">
        <div class="end__heading-end-information-group">
            <span class="end__heading-end-information end__heading-end-information-name"><b>CÔNG TY PROTECH</b></span>
            <span class="end__heading-end-information">© 2024 - Bản quyền thuộc về Công ty ProTech</span>
    </div>
</footer>
</header>
    <script>
       //ĐÓNG MỞ BOX ADMIN 
    document.addEventListener("DOMContentLoaded", function() {
    var adminIcon = document.getElementById('adminIcon');
    var adminBox = document.getElementById('adminBox');

    // Mở/đóng hộp Admin khi nhấn vào biểu tượng
    adminIcon.addEventListener('click', function(event) {
        event.stopPropagation(); // Ngăn chặn sự kiện click lan truyền

        // Hiển thị hộp admin tại vị trí của biểu tượng
        var rect = adminIcon.getBoundingClientRect(); // Lấy vị trí của biểu tượng
        var top = rect.bottom + window.scrollY; // Vị trí phía dưới của biểu tượng
        var left = rect.left + window.scrollX; // Vị trí bên trái của biểu tượng

        adminBox.style.top = top + 'px';  // Cập nhật vị trí top
        adminBox.style.left = left + 'px'; // Cập nhật vị trí left

        // Tạo hiệu ứng hiển thị/ẩn hộp Admin
        adminBox.style.display = (adminBox.style.display === 'block') ? 'none' : 'block';
    });
});

// Hàm hiển thị thông báo khi nhấn vào "Change Password"
function changePassword() {
    alert("Bạn đã thay đổi mật khẩu.");
}

// Hàm hiển thị thông báo khi nhấn vào "Logout"
function logout() {
    alert("Bạn đã đăng xuất khỏi hệ thống.");
}


    </script>

<!-- HIỂN THỊ CÁC LIST-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    // Lấy tất cả các liên kết trong menu
    const navLinks = document.querySelectorAll("nav ul li a");

    // Lặp qua tất cả các liên kết và thêm sự kiện click
    navLinks.forEach(link => {
        link.addEventListener("click", function(event) {
            event.preventDefault(); // Ngăn việc tải lại trang

            // Loại bỏ lớp 'active' khỏi tất cả các liên kết
            navLinks.forEach(link => {
                link.classList.remove("active");
            });

            // Thêm lớp 'active' vào liên kết đã được nhấn
            link.classList.add("active");

            // Lấy giá trị của 'data-target' để xác định phần nội dung tương ứng
            const target = link.getAttribute("data-target");

            // Ẩn tất cả các phần nội dung
            document.querySelectorAll(".info-section").forEach(section => {
                section.classList.remove("active");
            });

            // Hiển thị phần nội dung tương ứng
            document.getElementById(target).classList.add("active");

            // Cập nhật nội dung trong iframe nếu cần
            const iframe = document.getElementById("content-frame");
            iframe.src = link.href; // Chuyển đến trang mới trong iframe
        });
    });
});
//Underline
function setActive(link) {
    // Remove the 'active' class from all links
    const links = document.querySelectorAll('.nav-link');
    links.forEach(link => link.classList.remove('active'));
    
    // Add the 'active' class to the clicked link
    link.classList.add('active');
}

// Mở trang Tổng quan khi load trang
window.addEventListener('load', function() {
            // Khi trang được tải xong, tự động click vào trang "Tổng quan"
            var overviewLink = document.querySelector('a[data-target="profile"]');
            if (overviewLink) {
                overviewLink.click();
            }
        });
  
   </script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx1 = document.getElementById('chart1').getContext('2d');
    const ctx2 = document.getElementById('chart2').getContext('2d');
    const ctx3 = document.getElementById('chart3').getContext('2d');

    new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: ['Data1', 'Data2', 'Data3', 'Data4'],
            datasets: [{
                data: [25, 25, 25, 25],
                backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745']
            }]
        }
    });

    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: [1, 2, 3, 4, 5],
            datasets: [
                {label: 'Desktop', data: [100, 200, 300, 400, 500], borderColor: '#007bff'},
                {label: 'Mobile', data: [50, 150, 250, 350, 450], borderColor: '#28a745'}
            ]
        }
    });

    new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: [1, 2, 3, 4, 5],
            datasets: [
                {label: 'Data1', data: [50, 100, 150, 200, 250], backgroundColor: '#ffc107'},
                {label: 'Data2', data: [20, 40, 60, 80, 100], backgroundColor: '#dc3545'}
            ]
        }
    });
</script>
</body>
</html>
