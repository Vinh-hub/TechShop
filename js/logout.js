document.querySelector('.logout_button').addEventListener('click', function() {
    if (confirm('Bạn có chắc chắn muốn đăng xuất?')) {
        fetch('../php/logout.php', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '../index.php'; // Chuyển hướng về trang chủ sau khi đăng xuất
            } else {
                alert('Đăng xuất thất bại.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi đăng xuất.');
        });
    }
});