<?php
session_start(); 
require_once "../BackEnd/DB_driver.php";
require_once "../php/function.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTech - Điện thoại, SmartPhone chính hãng</title>
    <link rel="icon" type="image/x-icon" href="../assets/imgs/logo-tab.png">
    <link rel="stylesheet" href="../normalize.css">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/grid.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!--fonts-->
    <link rel="stylesheet" href="../assets/fonts/fontawesome-free-6.6.0-web/fontawesome-free-6.6.0-web/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="web6713">
        <div class="modal">
            <img src="../assets/imgs/logo_white_text.png" alt="" class="modal__img" >
            <div class="modal__body">
                <!-- dk -->
                        <section class="auht-form" id="signUpSection" style="display: none;">
                            <div class="auth-form__container">
                                <header class="auth-form__heaader">
                                    <h3 class="auth-form__header--heading">Đăng kí</h3>
                                    <span class="auth-form__header--switch-btn " id="showLogin">Đăng nhập</span>
                                </header>
                                <form class="auth-form__body">
                                    <div class="auth_form__body">
                                        <input type="text" class="auth-form__body__group--input" id="inp-namesign" placeholder="Tên đăng nhập/Email">                
                                    </div>
                                    <div class="auth_form__body__group">
                                        <input type="password" class="auth-form__body__group--input" placeholder="Mật khẩu">   
                                    </div>
                                    <div class="auth_form__body__group">
                                        <input type="password" class="auth-form__body__group--input" placeholder="Nhập lại mật khẩu">  
                                    </div>
                                    <div class="auth_form__body__group">
                                        <input type="text" class="auth-form__body__group--input" placeholder="Nhập địa chỉ">  
                                    </div>
                                </form>
                                <article class="auth-form__aside">
                                    <p class="auth-form__aside-policy">
                                        Bằng việc đăng kí, bạn đã đồng ý với ProTech về  
                                        <a href="#" class="auth-form__aside-policy--link">Điều khoản dịch vụ</a>
                                         &                                
                                         <a href="#" class="auth-form__aside-policy--link">Chính sách bảo mật</a>           
                                        </p>
                                </article>

                                    

                                <footer class="auth-form__controls">
                                    <button class="btn auth-form__controls-back">TRỞ LẠI</button>
                                    <button class="btn btn--primary" id="btn--signup">Đăng ký </button>
                                    

                                </footer>                   
                            </div>
                                <footer class="auth-form__socials">
                                    <a href="#" class="btn btn-size-s btn-color-face btn--with-icon">
                                        <i class="auth-form__socials-icon fa-brands fa-square-facebook"></i>
                                        Kết nối với Facebook
                                    </a>
                                    <a href="#" class="btn btn-size-s btn-color-gg btn--with-icon">
                                        <i class="auth-form__socials-icon fa-brands fa-google"></i>
                                        Kết nối với Google
                                    </a>                
                                </footer>
                        </section>
                <!-- dn -->
                        <section class="auht-form" id="loginSection" style="display: block;">
                            <div class="auth-form__container">
                                <header class="auth-form__heaader">
                                    <h3 class="auth-form__header--heading">Đăng nhập</h3>
                                    <span class="auth-form__header--switch-btn " id="showSignUp">Đăng ký</span>
                                </header>
                                <form class="auth-form__body">
                                    <div class="auth_form__body__group">
                                        <input type="text" class="auth-form__body__group--input" id="inp-namelogin" placeholder="Tên đăng nhập/Email">
                                    </div>
                                    <div class="auth_form__body__group">
                                        <input type="password" class="auth-form__body__group--input" id="mk" placeholder="Mật khẩu">
                                        <i class="fas fa-eye"  onclick="daoTT()" ></i>
                                    </div>
                                </form>
                                <article class="auth-form__aside">
                                    <p class="auth-form__aside-help">
                                       <a href="#" class="auth-form__aside-help-link ">Quên mật khẩu</a>
                                       <span class="auth-form__aside-help-link-separate"></span>
                                       <a href="#" class="auth-form__aside-help-link">Cần trơ giúp?</a>
                                       <span class="auth-form__aside-help-link-separate"></span>
                                       <a href="#" class="auth-form__aside-help-link" id="dnAdmin">Đăng nhập với tư cách là Admin</a>
                                    </p>
                                </article>
                                <footer class="auth-form__controls">
                                    <button class="btn auth-form__controls-back" id="btn--returnlog"> TRỞ LẠI</button>
                                    <button class="btn btn--primary" id="btn--login">Đăng nhập </button>
                                </footer>
                            </div>
                            <footer class="auth-form__socials">
                                <a href="#" class="btn btn-size-s btn-color-face btn--with-icon">
                                    <i class="auth-form__socials-icon fa-brands fa-square-facebook"></i>
                                    Kết nối với Facebook
                                </a>
                                <a href="#" class="btn btn-size-s btn-color-gg btn--with-icon">
                                    <i class="auth-form__socials-icon fa-brands fa-google"></i>
                                    Kết nối với Google
                                </a>
                            </footer>
                        </section>
            </div>
        </div>
        <?php addFooter('../'); ?>
    </div>
    <script src="../js/login.js"></script>
    <script>
        const btnAdmin = document.getElementById('dnAdmin');  
    // const basePath = localStorage.getItem('basePath');

        btnAdmin.addEventListener('click', ()=>{
        window.location.href = `../Category/formNKAdmin.htm`;
        });
    </script> 
   <!-- <script>
var signUpSection = document.getElementById('signUpSection');
var loginSection = document.getElementById('loginSection');
var btnSignUp = document.getElementById('showSignUp');
var btnLogin = document.getElementById('showLogin');
var returnpage = document.getElementById('btn--login');
var signUps = document.getElementById('btn--signup');
const textsign = document.getElementById('inp-namesign');
const textlogin = document.getElementById('inp-namelogin');

function openModal(sectionToShow) {
    if (sectionToShow === 'signUp') {
        signUpSection.style.display = 'block';    
        loginSection.style.display = 'none';
    } else if (sectionToShow === 'login') {
        signUpSection.style.display = 'none'; 
        loginSection.style.display = 'block';
    }
}

btnSignUp.addEventListener('click', function() {
    openModal('signUp');
});
btnLogin.addEventListener('click', function() {
    openModal('login');
});

signUps.addEventListener('click', function(){
    signUpSection.style.display = 'none'; 
    loginSection.style.display = 'block';
    textlogin.value = textsign.value;
});
returnpage.addEventListener('click', function(){
    alert('Đăng nhập thành công');
    window.location.href = '../../index.htm';

});
function daoTT() {
  let mk = document.getElementById("mk");
  mk.type = (mk.type === "password")? "text":"password";
} ;
 </script> -->
</body>
</html>