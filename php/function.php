<?php
session_start();

function addHeader(){
    echo'
    <header class="header">
            <div class="grid wide">
                <div class="row header_navbar">
                    <div class="header_navbar-search">
                        <div class="header_width-search">
                            <a href="./index.htm" class="header_logo">
                                <img class="header_logo-img " src="./assets/imgs/logo.png" alt="ProTech-logo" width="96" height="40">
                            </a>
                        </div> 
                        <div class="header_navbar-search">
                            <div class="header_search">

                                <i class="header_search-icon fa-solid fa-magnifying-glass "></i>
                                <input type="text" class="header_search-input " placeholder ="Nhập thông tin để tìm kiếm sản phẩm ">
                                <button type="button" class="header_search-button"> Tìm kiếm </button>  
                                   
                                <div class="header_navbar-search-history">
                                    <div class="header_navbar-search-history-heading">
                                         Lịch sử tìm kiếm 
                                         
                                    </div>

                                    <ul class="header_navbar-search-history-list">
                                        <li class="header_navbar-search-history-item">
                                            <a href="#"> 
                                                <i class="header_search-icon fa-solid fa-clock-rotate-left"></i>
                                                Iphone 14 promax 
                                                
                                            </a>
                                        </li>

                                        <li class="header_navbar-search-history-item">
                                            <a href="#"> 
                                                <i class="header_search-icon fa-solid fa-clock-rotate-left"></i>
                                                AirPod Pro 2 
                                                
                                            </a>
                                        </li>

                                        <li class="header_navbar-search-history-item">
                                            <a href="#"> 
                                                <i class="header_search-icon fa-solid fa-clock-rotate-left"></i>
                                                Laptop Dell Precision 
                                            </a>
                                           
                                        </li>
 
                                        
                                    </ul>
                                </div>
                                
                            </div>
                        </div>
                        <ul class="header_navbar-list">
                            <li class="header_navbar-item">
    
                            <a href="./index.htm" class="header_navbar-icon-link">
                                <i class="fa-solid fa-house"></i>
                            </a>
    
                            <a href="./index.htm" class="header_navbar-icon-link header_navbar-link--strong">
                                Trang chủ
                            </a>
                        </li>
    
                       
    
                        <li class="header_navbar-item">
                            <a href="./Template/Information.htm" class="header_navbar-item-link">
                                <a href="#" class="header_navbar-icon-link" id="account-icon-link">
                                    <i class="fa-regular fa-face-smile-wink"></i>
                                </a>
                                <a href="#" class="header_navbar-icon-link header_navbar-link--strong" id="account-link">
                                    Tài khoản
                                </a>
                            </a>
                        </li>

                        <li class="header_navbar-item header_navbar-item-no-pointer">
                            <a href="#" class="header_navbar-icon-link header_navbar-icon-link--separate">
                                Liên hệ
                                <i class="fa-brands fa-facebook"></i>
                                <i class="fa-brands fa-instagram "></i>
                            </a>
                            
                        </li>
                        
                        <li class="header_navbar-item">
                           
                                <!-- <div class="header_cart-wrap">  -->

                                    <a href="./Template/Cart.htm" class="header_navbar-icon-link">
                                        <i class="header_navbar-icon-cart fa-solid fa-cart-shopping"></i> <span id="cart-count">2</span> 
                                    </a>
                            
                                 
                            <!-- <div class="header_cart-list header_cart-list-no-cart">
                                <img class=" header_cart-no-cart-img" src="./assets/imgs/cart-empty.png">
                                <span class="header_cart-no-cart-msg"> Giỏ hàng đang trống </span>


                            </div>
                        </div> -->
                            
                        </li>
                        
                        
                        </ul>                     
                    </div>
                    <div class="header_navbar-item-mobile">
                        <a href="./Template/Cart.htm" class="header_navbar-icon-link">
                            <i class="header_navbar-icon-cart fa-solid fa-cart-shopping"></i> 
                        </a>
                    </div> 
                </div>
            </div>

            <div class="header_navbar-discount">
                <ul class="header_navbar-discount-list">

                    <li class="header_navbar-discount-item">
                    <a href="#" class=" header_navbar-dis-link header_navbar-dis-link--strong">
                        Cam kết
                    </a>
                    </li>


                    <li class="header_navbar-discount-item " >
                    <a href="#" class="header_navbar-dis-link ">
                        <i class="header_navbar-dis-icon fa-solid fa-award"></i>                            
                        100% hàng thật  
                    </a>
                    </li>


                    <li class="header_navbar-discount-item" >   
                    <a href="#" class="header_navbar-dis-link">
                        <i class="header_navbar-dis-icon fa-solid fa-circle-check"></i>
                        Chính hãng 
                    </a>
                    </li>


                    <li class="header_navbar-discount-item" >
                    <a href="#" class="header_navbar-dis-link ">
                        <i class="header_navbar-dis-icon fa-solid fa-tags"></i>
                        Giá ưu đãi
                    </a>
                    </li>

                     
                    <li class="header_navbar-discount-item" >  
                    <a href="#" class="header_navbar-dis-link">
                        <i class="header_navbar-dis-icon fa-solid fa-rotate"></i> 
                         30 ngày đổi trả
                    </a>
                    </li>


                    <li class="header_navbar-discount-item" >
                    <a href="#" class="header_navbar-dis-link">
                         <i class="header_navbar-dis-icon fa-solid fa-truck-fast"></i>
                        Giao nhanh trong 2h
                    </a>
                    </li>

                </ul>
    
            </div>
        </header>';
}

function addCTN__cate(){
    echo'
    <div class="col l-2 m-0 c-0">
                        <nav class="container__category">
                            <span class="header__category">Danh mục</span>
                            <ul class="category__list">
                                <li class="category__item">
                                    <a href="./Template/Category/Dien-thoai.htm" class="category__item-link">
                                        <img src="./assets/imgs/phonne-24x24.png" alt="" class="category__item-icon">
                                        Điện thoại
                                    </a>
                                </li>
                                <li class="category__item">
                                    <a href="./Template/Category/Dien-thoai.htm" class="category__item-link">
                                        <img src="./assets/imgs/laptop-24x24.png" alt="" class="category__item-icon">
                                        Laptop
                                    </a>
                                </li>
                                <li class="category__item">
                                    <a href="./Template/Category/Dien-thoai.htm" class="category__item-link">
                                    <img src="./assets/imgs/smartwatch-24x24.png" alt="" class="category__item-icon">
                                        Smartwatch
                                    </a>
                                </li>
                                <li class="category__item">
                                    <a href="./Template/Category/Dien-thoai.htm" class="category__item-link">
                                    <img src="./assets/imgs/phu-kien-24x24.png" alt="" class="category__item-icon">
                                    Phụ kiện
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <nav class="container__category">
                            <span class="header__category">Tiện ích</span>
                            <ul class="category__list">
                                <li class="category__item">
                                    <a href="./Template/Category/Dien-thoai.htm" class="category__item-link">
                                        <img src="./assets/imgs/voucher.png" alt="" class="category__item-icon">
                                        Voucher
                                    </a>
                                </li>
                                <li class="category__item">
                                    <a href="./Template/Category/Dien-thoai.htm" class="category__item-link">
                                        <img src="./assets/imgs/tien-ich-24x24.png" alt="" class="category__item-icon">
                                        Đóng tiền, nap thẻ  
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>';
}

function addContainer(){
    echo'
    <div class="col l-10 m-12 c-12">
                        <header class="row container__menu title_menu">

                            <a class="title_menu-thumail-link" href="#">
                                <img src="./assets/imgs/thumail.png" alt="" class="title_menu-thumail">
                            </a>
                        </header>
                        <article class="row protech container__product">
                            <div class="Sale">
                                <i class="Sale-icon fa-solid fa-thumbs-up"></i>
                                <span class="Sale-text">TOP DEAL</span>
                            </div>
                            <div class="product-list">
                                <div class="col l-2 m-3 c-6 product-item">
                                    <a href="./Template/chi-tiet-sp/dien-thoai/ip15.htm" class="product-item-link">
                                        <div class="product-item-group">
                                            <div class="product-item__mark-favourite">
                                            </div>
                                            <div class="product-item-img"
                                                style="background-image: url(https://cdn.tgdd.vn/Products/Images/42/329149/iphone-16-pro-max-sa-mac-thumb-600x600.jpg);">
                                            </div>
                                            <div class="product-item-info">
                                                <div class="product-item-name">
                                                    <div class="item-name__group">
                                                        <h3 id="item-name"> Điện thoại iPhone 16 Pro Max 256GB</h3>
                                                    </div>
                                                    <div class="item-name-deal">
                                                        <!-- <span class="name-main-deal-type">Mua Kèm Deal Sốc</span>
                                                        <span class="name-main-deal-type">Rẻ Vô Địch</span> -->
                                                        <!-- <div class="name-main-sales-percent" style="color: rgb(246, 145, 19);">
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                                <span class="name-main__sales-percent-main">30%</span>
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="rotate(180) translate(-3 -15)" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                            </div> -->
                                                    </div>
                                                </div>
                                                <strong class="product-price">
                                                    <span class="price-current">34.990.000₫ </span>
                                                    <span class="price-and-discount">
                                                        <label class="price-old black">
                                                            39.990.000₫
                                                        </label>
                                                            <small class="price-present">-12%</small>
                                                    </span>
                                                </strong>
                                                <div class="buy__now gutter">
                                                    <span> Mua ngay</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col l-2 m-3 c-6 product-item">
                                    <a href="./Template/chi-tiet-sp/dien-thoai/ip15.htm" class="product-item-link">
                                        <div class="product-item-group">
                                            <div class="product-item__mark-favourite">
                                            </div>
                                            <div class="product-item-img"
                                                style="background-image: url(https://cdn.tgdd.vn/Products/Images/42/249948/samsung-galaxy-s23-ultra-green-thumbnew-600x600.jpg);">
                                            </div>
                                            <div class="product-item-info">
                                                <div class="product-item-name">
                                                    <div class="item-name__group">
                                                        <h3 id="item-name">Điện thoại Samsung Galaxy S23 Ultra 5G 8GB/256GB</h3>
                                                    </div>
                                                    <div class="item-name-deal">
                                                        <!-- <span class="name-main-deal-type">Mua Kèm Deal Sốc</span>
                                                        <span class="name-main-deal-type">Rẻ Vô Địch</span> -->
                                                        <!-- <div class="name-main-sales-percent" style="color: rgb(246, 145, 19);">
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                                <span class="name-main__sales-percent-main">30%</span>
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="rotate(180) translate(-3 -15)" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                            </div> -->
                                                    </div>
                                                </div>
                                                <strong class="product-price">
                                                    <span class="price-current">21.490.000₫ </span>
                                                    <span class="price-and-discount">
                                                        <label class="price-old black">
                                                            24.990.000₫
                                                        </label>
                                                            <small class="price-present">-14%</small>
                                                    </span>
                                                </strong>
                                                <div class="buy__now gutter">
                                                    <span> Mua ngay</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col l-2 m-3 c-6 product-item">
                                    <a href="./Template/chi-tiet-sp/dien-thoai/ip15.htm" class="product-item-link">
                                        <div class="product-item-group">
                                            <div class="product-item__mark-favourite">
                                            </div>
                                            <div class="product-item-img"
                                                style="background-image: url(https://cdn.tgdd.vn/Products/Images/5698/320977/imac-24-inch-2023-4-5k-m3-16gb-070524-015603-600x600.jpg);">
                                            </div>
                                            <div class="product-item-info">
                                                <div class="product-item-name">
                                                    <div class="item-name__group">
                                                        <h3 id="item-name">iMac 24 inch 4.5K M3 16GB/256GB</h3>
                                                    </div>
                                                    <div class="item-name-deal">
                                                        <!-- <span class="name-main-deal-type">Mua Kèm Deal Sốc</span>
                                                        <span class="name-main-deal-type">Rẻ Vô Địch</span> -->
                                                        <!-- <div class="name-main-sales-percent" style="color: rgb(246, 145, 19);">
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                                <span class="name-main__sales-percent-main">30%</span>
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="rotate(180) translate(-3 -15)" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                            </div> -->
                                                    </div>
                                                </div>
                                                <strong class="product-price">
                                                    <span class="price-current">29.990.000₫ </span>
                                                    <span class="price-and-discount">
                                                        <label class="price-old black">
                                                            41.990.000₫
                                                        </label>
                                                            <small class="price-present">-28%</small>
                                                    </span>
                                                </strong>
                                                <div class="buy__now gutter">
                                                    <span> Mua ngay</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col l-2 m-3 c-6 product-item">
                                    <a href="./Template/chi-tiet-sp/dien-thoai/ip15.htm" class="product-item-link">
                                        <div class="product-item-group">
                                            <div class="product-item__mark-favourite">
                                            </div>
                                            <div class="product-item-img"
                                                style="background-image: url(https://cdn.tgdd.vn/Products/Images/44/302532/hp-15s-fq5162tu-i5-7c134pa-thumb-600x600.jpg);">
                                            </div>
                                            <div class="product-item-info">
                                                <div class="product-item-name">
                                                    <div class="item-name__group">
                                                        <h3 id="item-name">Laptop HP 15s fq5162TU i5 1235U/8GB/512GB/Win11</h3>
                                                    </div>
                                                    <div class="item-name-deal">
                                                        <!-- <span class="name-main-deal-type">Mua Kèm Deal Sốc</span>
                                                        <span class="name-main-deal-type">Rẻ Vô Địch</span> -->
                                                        <!-- <div class="name-main-sales-percent" style="color: rgb(246, 145, 19);">
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                                <span class="name-main__sales-percent-main">30%</span>
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="rotate(180) translate(-3 -15)" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                            </div> -->
                                                    </div>
                                                </div>
                                                <strong class="product-price">
                                                    <span class="price-current">14.990.000₫ </span>
                                                    <span class="price-and-discount">
                                                        <label class="price-old black">
                                                            18.890.000₫
                                                        </label>
                                                            <small class="price-present">-20%</small>
                                                    </span>
                                                </strong>
                                                <div class="buy__now gutter">
                                                    <span> Mua ngay</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col l-2 m-3 c-6 product-item">
                                    <a href="./Template/chi-tiet-sp/dien-thoai/ip15.htm" class="product-item-link">
                                        <div class="product-item-group">
                                            <div class="product-item__mark-favourite">
                                            </div>
                                            <div class="product-item-img"
                                                style="background-image: url(https://cdn.tgdd.vn/Products/Images/7077/315596/befit-watch-ultra-day-silicone-tb-600x600.jpg);">
                                            </div>
                                            <div class="product-item-info">
                                                <div class="product-item-name">
                                                    <div class="item-name__group">
                                                        <h3 id="item-name">Đồng hồ thông minh BeFit Watch Ultra 52.6mm</h3>
                                                    </div>
                                                    <div class="item-name-deal">
                                                        <!-- <span class="name-main-deal-type">Mua Kèm Deal Sốc</span>
                                                        <span class="name-main-deal-type">Rẻ Vô Địch</span> -->
                                                        <!-- <div class="name-main-sales-percent" style="color: rgb(246, 145, 19);">
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                                <span class="name-main__sales-percent-main">30%</span>
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="rotate(180) translate(-3 -15)" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                            </div> -->
                                                    </div>
                                                </div>
                                                <strong class="product-price">
                                                    <span class="price-current">1.090.000₫ </span>
                                                    <span class="price-and-discount">
                                                        <label class="price-old black">
                                                            1.490.000₫
                                                        </label>
                                                            <small class="price-present">-26%</small>
                                                    </span>
                                                </strong>
                                                <div class="buy__now gutter">
                                                    <span> Mua ngay</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col l-2 m-3 c-6 product-item">
                                    <a href="./Template/chi-tiet-sp/dien-thoai/ip15.htm" class="product-item-link">
                                        <div class="product-item-group">
                                            <div class="product-item__mark-favourite">
                                            </div>
                                            <div class="product-item-img"
                                                style="background-image: url(https://cdn.tgdd.vn/Products/Images/54/310123/tai-nghe-bluetooth-true-wireless-havit-tw967-thumb-5-600x600.jpg);">
                                            </div>
                                            <div class="product-item-info">
                                                <div class="product-item-name">
                                                    <div class="item-name__group">
                                                        <h3 id="item-name">Tai nghe Bluetooth True Wireless HAVIT TW967</h3>
                                                    </div>
                                                    <div class="item-name-deal">
                                                        <!-- <span class="name-main-deal-type">Mua Kèm Deal Sốc</span>
                                                        <span class="name-main-deal-type">Rẻ Vô Địch</span> -->
                                                        <!-- <div class="name-main-sales-percent" style="color: rgb(246, 145, 19);">
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                                <span class="name-main__sales-percent-main">30%</span>
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="rotate(180) translate(-3 -15)" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                            </div> -->
                                                    </div>
                                                </div>
                                                <strong class="product-price">
                                                    <span class="price-current">250.000₫ </span>
                                                    <span class="price-and-discount">
                                                        <label class="price-old black">
                                                            450.000₫
                                                        </label>
                                                            <small class="price-present">-44%</small>
                                                    </span>
                                                </strong>
                                                <div class="buy__now gutter">
                                                    <span> Mua ngay</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </article>
                        <div class="Sale">
                            <span class="Sale-suggest">Gợi ý hôm nay</span>
                        </div>
                        <article class="row protech container__product gutter" >
                            <div class="product-list gutter">
                                <div class="col l-2 m-3 c-6 product-item">
                                    <a href="./Template/chi-tiet-sp/dien-thoai/ip15.htm" class="product-item-link">
                                        <div class="product-item-group">
                                            <div class="product-item__mark-favourite">
                                            </div>
                                            <div class="product-item-img"
                                                style="background-image: url(https://cdn.tgdd.vn/Products/Images/522/325501/ipad-air-11-inch-m2-wifi-blue-thumb-600x600.jpg);">
                                            </div>
                                            <div class="product-item-info">
                                                <div class="product-item-name">
                                                    <div class="item-name__group">
                                                        <h3 id="item-name">Máy tính bảng iPad Air 6 M2 11 inch WiFi 128GB</h3>
                                                    </div>
                                                    <div class="item-name-deal">
                                                        <!-- <span class="name-main-deal-type">Mua Kèm Deal Sốc</span>
                                                        <span class="name-main-deal-type">Rẻ Vô Địch</span> -->
                                                        <!-- <div class="name-main-sales-percent" style="color: rgb(246, 145, 19);">
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                                <span class="name-main__sales-percent-main">30%</span>
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="rotate(180) translate(-3 -15)" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                            </div> -->
                                                    </div>
                                                </div>
                                                <strong class="product-price">
                                                    <span class="price-current">16.990.000₫ </span>
                                                </strong>
                                                <div class="buy__now">
                                                    <span> Mua ngay</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col l-2 m-3 c-6 product-item">
                                    <a href="./Template/chi-tiet-sp/dien-thoai/ip15.htm" class="product-item-link">
                                        <div class="product-item-group">
                                            <div class="product-item__mark-favourite">
                                            </div>
                                            <div class="product-item-img"
                                                style="background-image: url(https://cdn.tgdd.vn/Products/Images/5698/325157/asus-s500se-i5-513500008w-thumb-1-600x600.jpg);">
                                            </div>
                                            <div class="product-item-info">
                                                <div class="product-item-name">
                                                    <div class="item-name__group">
                                                        <h3 id="item-name">ASUS S500SE i5 13500/8GB/512GB/Bàn Phím/Chuột/Win11</h3>
                                                    </div>
                                                    <div class="item-name-deal">
                                                        <!-- <span class="name-main-deal-type">Mua Kèm Deal Sốc</span>
                                                        <span class="name-main-deal-type">Rẻ Vô Địch</span> -->
                                                        <!-- <div class="name-main-sales-percent" style="color: rgb(246, 145, 19);">
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                                <span class="name-main__sales-percent-main">30%</span>
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="rotate(180) translate(-3 -15)" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                            </div> -->
                                                    </div>
                                                </div>
                                                <strong class="product-price">
                                                    <span class="price-current">13.690.000₫ </span>
                                                    <span class="price-and-discount">
                                                        <label class="price-old black">
                                                            15.190.000₫
                                                        </label>
                                                            <small class="price-present">-9%</small>
                                                    </span>
                                                </strong>
                                                <div class="buy__now">
                                                    <span> Mua ngay</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col l-2 m-3 c-6 product-item">
                                    <a href="./Template/chi-tiet-sp/dien-thoai/ip15.htm" class="product-item-link">
                                        <div class="product-item-group">
                                            <div class="product-item__mark-favourite">
                                            </div>
                                            <div class="product-item-img"
                                                style="background-image: url(https://cdn.tgdd.vn/Products/Images/42/329149/iphone-16-pro-max-sa-mac-thumb-600x600.jpg);">
                                            </div>
                                            <div class="product-item-info">
                                                <div class="product-item-name">
                                                    <div class="item-name__group">
                                                        <h3 id="item-name">Điện thoại iPhone 16 Pro 128GB</h3>
                                                    </div>
                                                    <div class="item-name-deal">
                                                        <!-- <span class="name-main-deal-type">Mua Kèm Deal Sốc</span>
                                                        <span class="name-main-deal-type">Rẻ Vô Địch</span> -->
                                                        <!-- <div class="name-main-sales-percent" style="color: rgb(246, 145, 19);">
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                                <span class="name-main__sales-percent-main">30%</span>
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="rotate(180) translate(-3 -15)" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                            </div> -->
                                                    </div>
                                                </div>
                                                <strong class="product-price">
                                                    <span class="price-current">28.990.000₫ </span>
                                                </strong>
                                                <div class="buy__now">
                                                    <span> Mua ngay</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col l-2 m-3 c-6 product-item">
                                    <a href="./Template/chi-tiet-sp/dien-thoai/ip15.htm" class="product-item-link">
                                        <div class="product-item-group">
                                            <div class="product-item__mark-favourite">
                                            </div>
                                            <div class="product-item-img"
                                                style="background-image: url(https://cdn.tgdd.vn/Products/Images/44/323580/hp-victus-16-s0140ax-r7-9q987pa-thumb-600x600.jpg);">
                                            </div>
                                            <div class="product-item-info">
                                                <div class="product-item-name">
                                                    <div class="item-name__group">
                                                        <h3 id="item-name">Laptop HP Gaming VICTUS 16 s0140AX R7 7840HS/32GB/512GB/6GB RTX4050/144Hz/Win11</h3>
                                                    </div>
                                                    <div class="item-name-deal">
                                                        <!-- <span class="name-main-deal-type">Mua Kèm Deal Sốc</span>
                                                        <span class="name-main-deal-type">Rẻ Vô Địch</span> -->
                                                        <!-- <div class="name-main-sales-percent" style="color: rgb(246, 145, 19);">
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                                <span class="name-main__sales-percent-main">30%</span>
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="rotate(180) translate(-3 -15)" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                            </div> -->
                                                    </div>
                                                </div>
                                                <strong class="product-price">
                                                    <span class="price-current">31.890.000₫ </span>
                                                    <span class="price-and-discount">
                                                        <label class="price-old black">
                                                            35.890.000₫
                                                        </label>
                                                            <small class="price-present">-11%</small>
                                                    </span>
                                                </strong>
                                                <div class="buy__now">
                                                    <span> Mua ngay</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col l-2 m-3 c-6 product-item">
                                    <a href="./Template/chi-tiet-sp/dien-thoai/ip15.htm" class="product-item-link">
                                        <div class="product-item-group">
                                            <div class="product-item__mark-favourite">
                                            </div>
                                            <div class="product-item-img"
                                                style="background-image: url(https://cdn.tgdd.vn/Products/Images/86/229571/chuot-bluetooth-silent-rapoo-m500-thumb-7-600x600.jpg);">
                                            </div>
                                            <div class="product-item-info">
                                                <div class="product-item-name">
                                                    <div class="item-name__group">
                                                        <h3 id="item-name">Chuột Bluetooth Silent Rapoo M500</h3>
                                                    </div>
                                                    <div class="item-name-deal">
                                                        <!-- <span class="name-main-deal-type">Mua Kèm Deal Sốc</span>
                                                        <span class="name-main-deal-type">Rẻ Vô Địch</span> -->
                                                        <!-- <div class="name-main-sales-percent" style="color: rgb(246, 145, 19);">
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                                <span class="name-main__sales-percent-main">30%</span>
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="rotate(180) translate(-3 -15)" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                            </div> -->
                                                    </div>
                                                </div>
                                                <strong class="product-price">
                                                    <span class="price-current">270.000₫ </span>
                                                    <span class="price-and-discount">
                                                        <label class="price-old black">
                                                            400.000₫
                                                        </label>
                                                            <small class="price-present">-32%</small>
                                                    </span>
                                                </strong>
                                                <div class="buy__now">
                                                    <span> Mua ngay</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col l-2 m-3 c-6 product-item">
                                    <a href="./Template/chi-tiet-sp/dien-thoai/ip15.htm" class="product-item-link">
                                        <div class="product-item-group">
                                            <div class="product-item__mark-favourite">
                                            </div>
                                            <div class="product-item-img"
                                                style="background-image: url(https://cdn.tgdd.vn/Products/Images/4547/314634/ban-phim-co-co-day-dareu-ek75-thumb-600x600.jpg);">
                                            </div>
                                            <div class="product-item-info">
                                                <div class="product-item-name">
                                                    <div class="item-name__group">
                                                        <h3 id="item-name">Bàn Phím Cơ Có Dây DareU EK75</h3>
                                                    </div>
                                                    <div class="item-name-deal">
                                                        <!-- <span class="name-main-deal-type">Mua Kèm Deal Sốc</span>
                                                        <span class="name-main-deal-type">Rẻ Vô Địch</span> -->
                                                        <!-- <div class="name-main-sales-percent" style="color: rgb(246, 145, 19);">
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                                <span class="name-main__sales-percent-main">30%</span>
                                                                <svg class="name-main__sales-percent-border" style="color: rgb(246, 145, 19);" viewBox="-0.5 -0.5 4 16">
                                                                    <path d="M4 0h-3q-1 0 -1 1a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3v0.333a1.2 1.5 0 0 1 0 3q0 1 1 1h3" stroke-width="1" transform="rotate(180) translate(-3 -15)" stroke="currentColor" fill="#f69113">
                                                                    </path>
                                                                </svg>
                                                            </div> -->
                                                    </div>
                                                </div>
                                                <strong class="product-price">
                                                    <span class="price-current">565.000₫ </span>
                                                    <span class="price-and-discount">
                                                        <label class="price-old black">
                                                            790.000₫
                                                        </label>
                                                            <small class="price-present">-28%</small>
                                                    </span>
                                                </strong>
                                                <div class="buy__now">
                                                    <span> Mua ngay</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </article>
                        <span class="none-pagination">Không còn sản phẩm!!</span>
                        <ul class="pagination-list pagination-list-top">
                            <li class="pagination-item">
                                <a href="#" class="pagination-number-link">
                                    <i class=" pagination-icon fa-solid fa-chevron-left"></i>
                                </a>
                            </li>
                            <li class="pagination-item pagination-item--active">
                                <a href="#" class="pagination-number-link">1</a>
                            </li>
                            <li class="pagination-item">
                                <a href="./Template/Category/ca.htm" class="pagination-number-link">2</a>
                            </li>
                            <li class="pagination-item">
                                <a href="./Template/Category/ca.htm" class="pagination-number-link">3</a>
                            </li>
                            <li class="pagination-item">
                                <a href="./Template/Category/ca.htm" class="pagination-number-link">4</a>
                            </li>
                            <li class="pagination-item">
                                <a href="./Template/Category/ca.htm" class="pagination-number-link">5</a>
                            </li>
                            <li class="pagination-item">
                                <a href="./Template/Category/ca.htm" class="pagination-number-link">...</a>
                            </li>
                            <li class="pagination-item">
                                <a href="./Template/Category/ca.htm" class="pagination-number-link">10</a>
                            </li>
                            <li class="pagination-item">
                                <a href="./Template/Category/ca.htm" class="pagination-number-link">
                                    <i class=" pagination-icon fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </div';
}

function addFooter(){
    echo'
     <footer class="end">
            <div class="grid wide">
                <div class="row row-end">
                    <div class="col l-2-4 m-4 c-6">
                        <h3 class="end__heading">CHĂM SÓC KHÁCH HÀNG</h3>
                        <ul class="end__heading-list">
                            <li class="end__heading-item">
                                <a href="#" class="end__heading-link">Trung Tâm Hỗ Trợ</a>
                            </li>
                            <li class="end__heading-item">
                                <a href="#" class="end__heading-link">Giao & Nhận Hàng</a>
                            </li>
                            <li class="end__heading-item">
                                <a href="#" class="end__heading-link">Hướng Dẫn Mua Hàng</a>
                            </li>
                            <li class="end__heading-item">
                                <a href="#" class="end__heading-link">Hướng Dẫn Trả Góp</a>
                            </li>
                            <li class="end__heading-item">
                                <a href="#" class="end__heading-link">Chính Sách Bảo Hành</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col l-2-4 m-4 c-6">
                        <h3 class="end__heading">VỀ PROTECH</h3>
                        <ul class="end__heading-list">
                            <li class="end__heading-item">
                                <a href="#" class="end__heading-link">Giới Thiệu Về ProTech</a>
                            </li>
                            <li class="end__heading-item">
                                <a href="#" class="end__heading-link">Quy Chế Hoạt Động</a>
                            </li>
                            <li class="end__heading-item">
                                <a href="#" class="end__heading-link">Tuyển Dụng</a>
                            </li>
                            <li class="end__heading-item">
                                <a href="#" class="end__heading-link">Điều Khoản</a>
                            </li>
                            <li class="end__heading-item">
                                <a href="#" class="end__heading-link">Chính Sách Bảo Mật</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col l-2-4 hide-on-mobile-table">
                        <h3 class="end__heading">THANH TOÁN</h3>
                        <ul class="end__pay-list">
                            <li class="end__pay-item">
                                <a href="#" class="end__pay-item-link"><img
                                        src="https://down-vn.img.susercontent.com/file/d4bbea4570b93bfd5fc652ca82a262a8"
                                        alt="logo"></a>
                            </li>
                            <li class="end__pay-item">
                                <a href="#" class="end__pay-item-link"><img
                                        src="https://down-vn.img.susercontent.com/file/38fd98e55806c3b2e4535c4e4a6c4c08"
                                        alt="logo"></a>
                            </li>
                        </ul>
                        <h3 class="end__heading">ĐƠN VỊ VẬN CHUYỂN</h3>
                        <ul class="end__deliver-list">
                            <li class="end__deliver-item">
                                <a href="#" class="end__deliver-item-link"><img
                                        src="https://down-vn.img.susercontent.com/file/59270fb2f3fbb7cbc92fca3877edde3f"
                                        alt="logo"></a>
                            </li>
                            <li class="end__deliver-item">
                                <a href="#" class="end__deliver-item-link"><img
                                        src="https://down-vn.img.susercontent.com/file/0d349e22ca8d4337d11c9b134cf9fe63"
                                        alt="logo"></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col l-2-4 m-4 c-6">
                        <h3 class="end__heading">THEO DÕI PROTECH</h3>
                        <ul class="end__heading-list">
                            <li class="end__heading-item">
                                <i class="end__heading-link-icon fa-brands fa-facebook"></i>
                                <a href="#" class="end__heading-link">
                                    Facebook
                                </a>
                            </li>
                            <li class="end__heading-item">
                                <i class="end__heading-link-icon fa-brands fa-square-instagram"></i>
                                <a href="#" class="end__heading-link">
                                    Instagram
                                </a>
                            </li>
                            <li class="end__heading-item">
                                <i class="end__heading-link-icon fa-brands fa-linkedin"></i>
                                <a href="#" class="end__heading-link">
                                    LinkedIn
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col l-2-4 m-8 c-6">
                        <h3 class="end__heading">THÔNG TIN LIÊN HỆ</h3>
                        <ul class="end__heading-list">
                            <li class="end__heading-item">
                                <p class="end__heading-p">Tổng đài hỗ trợ</p>
                                <a href="#" class="end__heading-link">1900-6713</a>
                            </li>
                            <li class="end__heading-item">
                                <p class="end__heading-p">Email CSKH</p>
                                <a href="#" class="end__heading-link">cskh@protech.vn</a>
                            </li>
                            <li class="end__heading-item">
                                <p class="end__heading-p">Hợp tác phát triển</p>
                                <a href="#" class="end__heading-link">hoptac@protech.vn</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="end__heading-more">
                    <span class="end__heading-law">© 2024 - Công ty ProTech | Verified by:</span>
                    <div class="end__certificate">
                        <a href="#" class="end-certificate-link">
                            <img src="./assets/imgs/BCT.png" alt="" class="end-certificate-img">
                        </a>
                        </a>
                        <a href="#" class="end-certificate-link">
                            <img src="https://img.lazcdn.com/g/tps/tfs/TB1jyJMv.H1gK0jSZSyXXXtlpXa-184-120.png" style="height: 60px;" alt="" class="end-certificate-img">
                        </a>
                        <a href="#" class="end-certificate-link">
                            <img src="./assets/imgs/NKVHG.png" alt="" class="end-certificate-img-HG">
                        </a>
                        <a href="#" class="end-certificate-link">
                            <img src="https://images.dmca.com/Badges/dmca-badge-w150-2x1-02.png?ID=73ee7811-7aa7-44d0-bb06-6c0df0da41d8" style="height: 60px;" alt="" class="end-certificate-img">
                        </a>
                    </div>
                </div>
            </div>
        </footer>
        <footer class="end__heading-end">
                <div class="end__heading-end-information-group">
                    <span class="end__heading-end-information end__heading-end-information-name"><b>CÔNG TY PROTECH</b></span>
                    <span class="end__heading-end-information">Địa chỉ: 273 Đ. An Dương Vương, Phường 3, Quận 5, Hồ Chí Minh, Vietnam</span>
                    <span class="end__heading-end-information">Chịu Trách Nhiệm Quản Lý Nội Dung: Thành Viên 6713</span>
                    <span class="end__heading-end-information">© 2024 - Bản quyền thuộc về Công ty ProTech</span>
            </div>
        </footer>';
}

?>