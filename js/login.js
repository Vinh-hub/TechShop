// Chuyển đổi giữa form đăng nhập và đăng ký
document.getElementById('showSignUp').addEventListener('click', function() {
    document.getElementById('loginSection').style.display = 'none';
    document.getElementById('signUpSection').style.display = 'block';
});

document.getElementById('showLogin').addEventListener('click', function() {
    document.getElementById('signUpSection').style.display = 'none';
    document.getElementById('loginSection').style.display = 'block';
});

// Hiển thị/ẩn mật khẩu
function daoTT() {
    const passwordInput = document.getElementById('mk');
    const eyeIcon = document.querySelector('.fa-eye');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}

// Xử lý đăng nhập
document.getElementById('btn--login').addEventListener('click', function(e) {
    e.preventDefault();

    const form = document.getElementById('loginForm');
    const formData = new FormData(form);
    formData.append('action', 'login');
    formData.append('isAdmin', document.getElementById('dnAdmin').classList.contains('active') ? 'true' : 'false');

    fetch('formNK.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect;
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi đăng nhập.');
    });
});

// Xử lý đăng ký
document.getElementById('btn--signup').addEventListener('click', function(e) {
    e.preventDefault();

    const form = document.getElementById('signupForm');
    const formData = new FormData(form);
    formData.append('action', 'signup');

    fetch('formNK.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            // Chuyển về form đăng nhập sau khi đăng ký thành công
            document.getElementById('signUpSection').style.display = 'none';
            document.getElementById('loginSection').style.display = 'block';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi đăng ký.');
    });
});

// Xử lý đăng nhập với tư cách admin
document.getElementById('dnAdmin').addEventListener('click', function(e) {
    e.preventDefault();
    this.classList.toggle('active');
    this.textContent = this.classList.contains('active') ? 'Đăng nhập với tư cách người dùng' : 'Đăng nhập với tư cách là Admin';
});     