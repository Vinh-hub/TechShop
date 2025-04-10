document.addEventListener('DOMContentLoaded', function () {
    // Lấy các phần tử DOM
    const signUpSection = document.getElementById('signUpSection');
    const loginSection = document.getElementById('loginSection');
    const btnSignUp = document.getElementById('showSignUp'); // Nút mở đăng ký
    const btnLogin = document.getElementById('btn--login'); // Nút đăng nhập
    const returnPage = document.getElementById('btn--returnlog'); // Nút trở lại
    const signUps = document.getElementById('btn--signup'); // Nút đăng ký
    const textSign = document.getElementById('inp-namesign'); // Tên đăng ký
    const textLogin = document.getElementById('inp-namelogin'); // Tên đăng nhập
    const passwordLogin = document.getElementById('mk'); // Mật khẩu đăng nhập
    const showLoginBtn = document.getElementById('showLogin'); // Nút chuyển sang trang đăng nhập
    const logoBtn = document.querySelector('.modal__img');

    logoBtn.addEventListener('click', function(){
        window.location.href = `../index.php`;
    })

    // Kiểm tra trạng thái đăng nhập khi tải trang
    let isLoggedIn = localStorage.getItem('isLoggedIn') === 'true'; 

    // Hàm mở modal đăng ký hoặc đăng nhập
    function openModal(sectionToShow) {
        if (sectionToShow === 'signUp') {
            signUpSection.style.display = 'block';
            loginSection.style.display = 'none';
        } else if (sectionToShow === 'login') {
            signUpSection.style.display = 'none';
            loginSection.style.display = 'block';
        }
    }

    // Xử lý sự kiện nút "Hiển thị đăng ký"
    if (btnSignUp) {
        btnSignUp.addEventListener('click', function() {
            openModal('signUp');
        });
    }

    // Xử lý sự kiện nút "Hiển thị đăng nhập"
    if (showLoginBtn) {
        showLoginBtn.addEventListener('click', function() {
            openModal('login');
        });
    }

    // Xử lý sự kiện nút "Đăng ký"
    if (signUps) {
        signUps.addEventListener('click', function () {
            isLoggedIn = true; // Cập nhật trạng thái đăng nhập
            localStorage.setItem('isLoggedIn', 'true'); // Lưu vào localStorage
            openModal('login'); // Chuyển sang màn hình đăng nhập
            textLogin.value = textSign.value; // Chuyển giá trị từ đăng ký sang đăng nhập
            alert("Đăng ký thành công!");
        });
    }

    // Xử lý sự kiện nút "Trở lại"
    if (returnPage) {
        returnPage.addEventListener('click', function () {
            if (signUpSection.style.display === 'block') {
                openModal('login');
            } else {
                openModal('signUp');
            }
        });
    }

    // const basePath = localStorage.getItem('basePath');
    // console.log(basePath);
    // Xử lý đăng nhập
    // if (btnLogin && textLogin && passwordLogin) {
    //     btnLogin.addEventListener('click', function () {
    //         const usernameInput = textLogin.value.trim();
    //         const passwordInput = passwordLogin.value.trim();

    //         if (usernameInput && passwordInput) {
    //             const user = users.find(u => u.username === usernameInput && u.password === passwordInput);
    //             if (user) {
    //                 alert("Đăng nhập thành công!");

    //                 // Điều hướng theo loại người dùng
    //                 if (usernameInput === "admin") {
    //                     window.location.href = `${basePath}Admin/dashboard.htm`; // Trang dành cho admin
    //                 } else {
    //                     window.location.href = `${basePath}index.htm`; // Trang dành cho user
    //                 }

    //                 localStorage.setItem('isLoggedIn', 'true'); // Lưu trạng thái đăng nhập
    //             } else {
    //                 alert("Tên đăng nhập hoặc mật khẩu không chính xác.");
    //             }
    //         } else {
    //             alert("Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu.");
    //         }
    //     });
    // } else {
    //     console.error("Không tìm thấy các phần tử cần thiết trong DOM.");
    // }

    if (btnLogin) {
        btnLogin.addEventListener('click', function () {
            // Luôn hiển thị thông báo đăng nhập thành công
            alert("Đăng nhập thành công!");
    
            // Điều hướng đến index.htm
            window.location.href = `../index.php`;
    
            // Lưu trạng thái đăng nhập
            localStorage.setItem('isLoggedIn', 'true');
        });
    } else {
        console.error("Không tìm thấy các phần tử cần thiết trong DOM.");
    }
    


    // Hàm hiển thị / ẩn mật khẩu
    window.daoTT = function () {
        if (passwordLogin) {
            passwordLogin.type = (passwordLogin.type === "password") ? "text" : "password";
        } else {
            console.error("Không tìm thấy phần tử mật khẩu với ID 'mk'.");
        }
    };
});
