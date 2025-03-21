<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    
</head>
<body>

    <div class="container">
        <h1>Quản lý người dùng</h1>
       <!-- Ô tìm kiếm -->
       <div class="search-container">
        <input type="text" id="searchInput1" placeholder="Nhập tên để tìm kiếm" />
        <input type="text" id="searchInput2" placeholder="Nhập vai trò để tìm kiếm" />
    </div>
    
        <!-- Bảng quản lý người dùng -->
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên</th>
                    <th>SĐT</th>
                    <th>Vai trò</th>
                    <th>Email</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Nguyễn Văn Tiến</td>
                    <td>0912345678</td>
                    <th>Admin</th>
                    <td>a@example.com</td>
                    <td>
                        <button class="btn-block">Khóa</button>
                        <button class="btn-delete">Xóa</button>
                        <button class="btn-sua">Sửa</button>

                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Trần Thị Ngọc</td>
                    <td>0987654321</td>
                    <th>Khách hàng</th>
                    <td>b@example.com</td>
                    <td>
                        <button class="btn-block">Khóa</button>
                        <button class="btn-delete">Xóa</button>
                        <button class="btn-sua">Sửa</button>

                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Ngô Tuấn Tú</td>
                    <td>0933123456</td>
                    <th>Khách hàng</th>
                    <td>c@example.com</td>
                    <td>
                        <button class="btn-block">Khóa</button>
                        <button class="btn-delete">Xóa</button>
                        <button class="btn-sua">Sửa</button>

                    </td>
                </tr>

                <tr>
                    <td>4</td>
                    <td>Lê Văn Tuấn</td>
                    <td>0933123456</td>
                    <th>Quản trị viên</th>
                    <td>c@example.com</td>
                    <td>
                        <button class="btn-block">Khóa</button>
                        <button class="btn-delete">Xóa</button>
                        <button class="btn-sua">Sửa</button>
                    </td>
                </tr>
            </tbody>
        </table>
         <!-- Nút Thêm Người Dùng -->
         <button id="showAddFormBtn" >Thêm Người Dùng</button>
    </div>   
    <style>
    /* Thiết lập kiểu chữ chung và margin */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f7f8fa;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        color: #333;
    }
    
    /* Container chính */
    .container {
        width: 90%;
        margin: 40px auto;
        padding:10px 40px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    /* Tiêu đề chính */
    h1 {
        text-align: center;
        color: #333;
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 30px;
    }
    
    /* Bảng quản lý người dùng */
    table {
        width: 100%;
        border-collapse: collapse; /* Hợp nhất các đường viền lại thành một */
        background-color: #ffffff;
    }
    
    /* Tiêu đề các cột */
    th {
        padding: 16px 20px;
        text-align: center; /* Căn giữa nội dung trong tiêu đề */
        font-weight: 700;
        font-size: 16px;
        background-color: #f0f0f0;
        color: #333;
        border: 1px solid #ddd; /* Đặt đường viền giữa các cột */
    }
    
    /* Định dạng các ô dữ liệu */
    td {
        padding: 16px 20px;
        text-align: center; /* Căn giữa nội dung trong ô */
        font-size: 14px;
        color: #555;
        border: 1px solid #ddd; /* Đặt đường viền giữa các dòng */
        vertical-align: middle; /* Căn giữa nội dung theo chiều dọc */
    }
    
    /* Đảm bảo chiều rộng của cột */
    td, th {
        width: auto;
    }
    
    /* Dòng tr bảng khi di chuột qua */
    tr:nth-child(even) {
        background-color: #fafafa;
    }
    
    /* Dòng tr khi hover */
    tr:hover {
        background-color: #f1f1f1;
    }
    
    /* Các nút chức năng */
    button {
        padding: 8px 16px;
        font-size: 14px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    
    /* Nút Khóa người dùng */
    .btn-block {
        background-color: #e74c3c;
        color: white;
        border: 1px solid #e74c3c;
    }
    
    .btn-block:hover {
        background-color: #c0392b;
        border-color: #c0392b;
    }
    
    /* Nút Xóa người dùng */
    .btn-delete {
        background-color: #3498db;
        color: white;
        border: 1px solid #3498db;
    }
    
    .btn-delete:hover {
        background-color: #2980b9;
        border-color: #2980b9;
    }
    .btn-sua {
        background-color: #cca56a;
        color: white;
        border: 1px solid #cca56a;
    }
    
    .btn-sua:hover {
        background-color: #cca56a;
        border-color: #cca56a;
    }
    /* Trạng thái người dùng */
    .status {
        padding: 4px 10px;
        border-radius: 5px;
        font-weight: bold;
    }
    
    .status.active {
        background-color: #2ecc71;
        color: white;
        border: 1px solid #2ecc71;
    }
    
    .status.blocked {
        background-color: #e74c3c;
        color: white;
        border: 1px solid #e74c3c;
    }
    #showAddFormBtn {
    padding: 12px 20px;
    background-color: #3498db;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    display: block;
    margin: 20px auto;
}

#showAddFormBtn:hover {
    background-color: #2980b9;
}
.search-container {
    text-align: center;
    margin-bottom: 20px;
    display:flex;
    gap:50px;
    align-items: center;
    justify-content: center;
}

#searchInput1 {
    padding: 12px 20px;
    font-size: 16px;
    width: 30%;
    border: 1px solid #ddd;
    border-radius: 25px;
    outline: none;
    margin: 10px 0;
    transition: border-color 0.3s ease;
}

#searchInput1:focus {
    border-color: #3498db;
}
#searchInput2 {
    padding: 12px 20px;
    font-size: 16px;
    width: 30%;
    border: 1px solid #ddd;
    border-radius: 25px;
    outline: none;
    margin: 10px 0;
    transition: border-color 0.3s ease;
}

#searchInput2:focus {
    border-color: #3498db;
}
</style> 
    <script>
//Xóa và khóa người dùng
document.querySelector('.btn-block').addEventListener('click', function() {
            const confirmBlock = confirm('Bạn có chắc chắn muốn khóa không?');
            if (confirmBlock) {
                alert('Đã khóa thành công!');
            } else {
                alert('Hành động khóa đã bị hủy.');
            }
        });

        // Gắn sự kiện cho nút "Xóa"
document.querySelector('.btn-delete').addEventListener('click', function() {
            const confirmDelete = confirm('Bạn có chắc chắn muốn xóa không?');
            if (confirmDelete) {
                alert('Đã xóa thành công!');
            } else {
                alert('Hành động xóa đã bị hủy.');
            }
        });
// Thêm người dùng
document.getElementById('showAddFormBtn').addEventListener('click', function() {
    // Chuyển hướng đến trang "thong-tin-nguoi-dung.phpl"
    window.location.href = 'addNguoidung.php';
});
//Sửa thông tin
    document.addEventListener('DOMContentLoaded', function() {
        // Chọn tất cả các nút sửa
        const editButtons = document.querySelectorAll('.btn-sua');
        
        // Lặp qua tất cả các nút sửa và thêm sự kiện click
        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                // Chuyển hướng đến trang suaThongtinNguoidung.php
                window.location.href = 'suaThongtinNguoidung.php';
            });
        });
    });
    </script>
    
</body>
</html>



