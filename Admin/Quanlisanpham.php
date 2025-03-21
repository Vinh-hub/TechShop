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
<body>

    <header>
        <h1 style="color:black">Quản lý sản phẩm</h1>
        <div class="search-bar">
            <input type="text" placeholder="Nhập tên sản phẩm">
            <button>+ Thêm sản phẩm</button>
        </div>
    </header>
    
    <div class="image-grid">
        <div class="image-item">
            <img src="../assets/imgs/samsunggalaxy.jpg" alt="Nike Air Force">
            <h3>SamSung Galaxy S23 Ultra</h3>
            <p class="price">2,500,000 đ</p> <!-- Giá sản phẩm -->
            <div class="buttons">
                <button class="edit">Sửa</button>
                <button class="delete">Xóa</button>
            </div>
        </div>
        <div class="image-item">
            <img src="../assets/imgs/iphone-15-removebg-preview.png" alt="Nike SFB">
            <h3>Iphone 15 ProMax</h3>
            <p class="price">3,000,000 đ</p> <!-- Giá sản phẩm -->
            <div class="buttons">
                <button class="edit">Sửa</button>
                <button class="delete">Xóa</button>
            </div>
        </div>
        <div class="image-item">
            <img src="../assets/imgs/LaptopHP.webp" alt="Adidas Campus">
            <h3>Laptop HP </h3>
            <p class="price">2,200,000 đ</p> <!-- Giá sản phẩm -->
            <div class="buttons">
                <button class="edit">Sửa</button>
                <button class="delete">Xóa</button>
            </div>
        </div>
        <div class="image-item">
            <img src="../assets/imgs/iMac.webp" alt="Nike Blazer">
            <h3>iMac</h3>
            <p class="price">2,800,000 đ</p> <!-- Giá sản phẩm -->
            <div class="buttons">
                <button class="edit">Sửa</button>
                <button class="delete">Xóa</button>
            </div>
        </div>
        <div class="image-item">
            <img src="../assets/imgs/samsung-galaxy-a34-5g-dual-sim-awesome-silver-128gb-and-6gb-ram-sm-a346b-ds-removebg-preview.png" alt="Adidas UltraBoost">
            <h3>Samsung Galaxy</h3>
            <p class="price">3,200,000 đ</p> <!-- Giá sản phẩm -->
            <div class="buttons">
                <button class="edit">Sửa</button>
                <button class="delete">Xóa</button>
            </div>
        </div>
        <div class="image-item">
            <img src="../assets/imgs/Tecno-camon-20-pro-5g-ghana-removebg-preview.png" alt="Nike Dunk Low">
            <h3>Tecno Pova 6</h3>
            <p class="price">2,900,000 đ</p> <!-- Giá sản phẩm -->
            <div class="buttons">
                <button class="edit">Sửa</button>
                <button class="delete">Xóa</button>
            </div>
        </div>
        <div class="image-item">
            <img src="../assets/imgs/samsung-galaxy-a34-5g-dual-sim-awesome-silver-128gb-and-6gb-ram-sm-a346b-ds-removebg-preview.png" alt="Adidas NMD">
            <h3>Samsung Galaxy J3</h3>
            <p class="price">3,500,000 đ</p> <!-- Giá sản phẩm -->
            <div class="buttons">
                <button class="edit">Sửa</button>
                <button class="delete">Xóa</button>
            </div>
        </div>
        <div class="image-item">
            <img src="../assets/imgs/airpod-removebg-preview.png" alt="Nike Air Max">
            <h3>AirPod Pro</h3>
            <p class="price">3,800,000 đ</p> <!-- Giá sản phẩm -->
            <div class="buttons">
                <button class="edit">Sửa</button>
                <button class="delete">Xóa</button>
            </div>
        </div>
        <div class="image-item">
            <img src="../assets/imgs/10th_gen._CB606154559_-removebg-preview.png" alt="Adidas Gazelle">
            <h3>Apple iPad</h3>
            <p class="price">2,600,000 đ</p> <!-- Giá sản phẩm -->
            <div class="buttons">
                <button class="edit">Sửa</button>
                <button class="delete">Xóa</button>
            </div>
        </div>
    </div>
    <script>
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

    </script>
</body>
</phpl>
