<?php
require_once "../BackEnd/DB_driver.php";

// Tạo đối tượng DB_driver và kết nối
$db = new DB_driver();
$db->connect();

// Truy vấn tất cả sản phẩm từ bảng sanpham
$sql = "SELECT * FROM sanpham";
$products = $db->get_list($sql);
?>

<!DOCTYPE phpl>
<phpl lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <style>
       * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f4f4;
    color: #333;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
}

header {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    /* background-color: #333; */
    color: #fff;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
}

header h1 {
    font-size: 28px;
    font-weight: bold;
    color: #fff;
    margin-right: 20px;
}

.search-bar {
    display: flex;
    gap: 10px;
}

.search-bar input {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 25px;
    width: 300px;
    color: #333;
}

.search-bar button {
    padding: 10px 20px;
    background-color: #3498db;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
}

.image-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    width: 100%;
    max-width: 900px;
}

.image-item {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 8px;
    text-align: center;
    padding: 15px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    position: relative;
}

.image-item img {
    width: 100%;
    height: 230px;
    border-radius: 8px;
}

.image-item h3 {
    margin-top: 10px;
    font-size: 18px;
    font-weight: bold;
    color: #333;
}

.buttons {
    margin-top: 15px;
    display: flex;
    justify-content: center;
    gap: 10px;
}

.buttons button {
    padding: 5px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    text-align: center;
    font-weight: bold;
}

.buttons .edit {
    background-color: #3498db;
    color: white;
}
.buttons .delete {
    background-color: #e74c3c;
    color: white;
}
.image-item .price {
    font-size: 18px;
    font-weight: bold;
    color: #e74c3c;
    margin-top: 10px;
}
button:hover {
    opacity: 0.8;
}


    </style>
</head>
<?php
if (isset($_SESSION['message'])) {
    echo '<p style="color: green; text-align: center;">' . $_SESSION['message'] . '</p>';
    unset($_SESSION['message']);
}
?>
<body>

    <header>
        <h1 style="color:black">Quản lý sản phẩm</h1>
        <div class="search-bar">
            <input type="text" placeholder="Nhập tên sản phẩm">
            <button>+ Thêm sản phẩm</button>
        </div>
    </header>
    
    <div class="image-grid">
    <?php
        if (!empty($products)) {
            foreach ($products as $row) {
                echo '<div class="image-item">';
                echo '<img src="' . $row['HinhAnh'] . '" alt="' . $row['TenSP'] . '">';
                echo '<h3>' . $row['TenSP'] . '</h3>';
                echo '<p class="price">' . number_format($row['DonGia'], 0, ',', '.') . ' đ</p>';
                echo '<div class="buttons">';
                echo '<button class="edit" data-id="' . $row['MaSP'] . '">Sửa</button>';
                echo '<button class="delete" data-id="' . $row['MaSP'] . '">Xóa</button>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>Chưa có sản phẩm nào.</p>';
        }

        // Ngắt kết nối
        $db->dis_connect();
        ?>
    </div>
    <!-- <script>
        // JavaScript function để reload trang khi nhấn Enter
        window.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[type="text"]');
            
            // Thêm sự kiện 'keydown' để phát hiện khi người dùng nhấn Enter
            searchInput.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {  // Kiểm tra nếu phím Enter được nhấn
                    location.reload();  // Tải lại trang
                }
            });
        });
    
    // Chọn nút theo selector
document.querySelector('button').addEventListener('click', function() {
    // URL bạn muốn chuyển đến
    window.location.href = 'add-productList.php'; // Thay 'https://example.com' bằng URL của bạn
});

// //Sửa và xóa sản phẩm
document.addEventListener('DOMContentLoaded', function() {
    // Lắng nghe sự kiện click vào tất cả các nút "Sửa"
    const editButtons = document.querySelectorAll('.edit');
    editButtons.forEach(function(editButton) {
        editButton.addEventListener('click', function() {
            // Chuyển hướng đến trang suaThongtinSanpham.php
            window.location.href = 'suaThongtinSanpham.php';
        });
    });

    // Lắng nghe sự kiện click vào tất cả các nút "Xóa"
    const deleteButtons = document.querySelectorAll('.delete');
    deleteButtons.forEach(function(deleteButton) {
        deleteButton.addEventListener('click', function() {
            // Hiển thị hộp thoại xác nhận xóa
            const isConfirmed = confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');

            if (isConfirmed) {
                // Nếu người dùng xác nhận xóa, hiển thị thông báo và thực hiện xóa
                alert('Sản phẩm đã được xóa thành công.');

                // Bạn có thể thay đổi hoặc thêm mã xử lý xóa ở đây (ví dụ: gửi yêu cầu xóa qua API hoặc chuyển hướng)
            } else {
                // Nếu người dùng không xác nhận xóa
                alert('Sản phẩm không bị xóa.');
            }
        });
    });
});

    </script> -->
    <script>
        // Chuyển hướng khi nhấn nút "Thêm sản phẩm"
        document.querySelector('.search-bar button').addEventListener('click', function() {
            window.location.href = 'add-productList.php';
        });

        // Reload trang khi nhấn Enter trong ô tìm kiếm
        document.querySelector('.search-bar input').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                location.reload();
            }
        });

        // Xử lý nút Sửa và Xóa
        document.addEventListener('DOMContentLoaded', function() {
            // Nút Sửa
            document.querySelectorAll('.edit').forEach(function(button) {
                button.addEventListener('click', function() {
                    const maSP = this.getAttribute('data-id');
                    window.location.href = `suaThongtinSanpham.php?maSP=${maSP}`;
                });
            });

            // Nút Xóa
            document.querySelectorAll('.delete').forEach(function(button) {
                button.addEventListener('click', function() {
                    const maSP = this.getAttribute('data-id');
                    if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
                        window.location.href = `delete-product.php?maSP=${maSP}`;
                    }
                });
            });
        });
    </script>
</body>
</phpl>
