<?php
session_start();
require_once "../../BackEnd/DB_driver.php";
require_once "../../php/function.php";

$db = new DB_driver();
$db->connect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTech - Điện thoại chính hãng</title>
    <link rel="icon" type="image/x-icon" href="../../assets/imgs/logo-tab.png">
    <link rel="stylesheet" href="../../assets/css/base.css">
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link rel="stylesheet" href="../../assets/css/grid.css">
    <link rel="stylesheet" href="../../assets/css/responsive.css">
    <link rel="stylesheet" href="../../assets/fonts/fontawesome-free-6.6.0-web/fontawesome-free-6.6.0-web/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="web6713">
        <div class="header_first"></div>
        <?php addHeader('../../'); ?>
        <section class="container">
            <div class="grid wide">
                <div class="row">
                    <?php addCTN__cate('../../'); ?>
                    <div class="col l-10 m-12 c-12">
                        <header class="row container__menu title_menu">
                            <span class="title">Đóng tiền, nạp thẻ</span>
                        </header>
                        <article class="row protech container__product">
                            <div class="product-list">
                            <h1 style="font-size: 2.0rem; margin:auto auto;">Coming Soon</h1>
                            </div>
                        </article>
                        <ul class="pagination-list pagination-list-top">
                            <!-- <?php
                            if ($page > 1) {
                                echo '<li class="pagination-item"><a href="?page=' . ($page - 1) . '" class="pagination-number-link"><i class="pagination-icon fa-solid fa-chevron-left"></i></a></li>';
                            }
                            for ($i = 1; $i <= $totalPages; $i++) {
                                echo '<li class="pagination-item' . ($i == $page ? ' pagination-item--active' : '') . '"><a href="?page=' . $i . '" class="pagination-number-link">' . $i . '</a></li>';
                            }
                            if ($page < $totalPages) {
                                echo '<li class="pagination-item"><a href="?page=' . ($page + 1) . '" class="pagination-number-link"><i class="pagination-icon fa-solid fa-chevron-right"></i></a></li>';
                            }
                            ?> -->
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <?php addFooter('../../'); ?>
    </div>
</body>
</html>