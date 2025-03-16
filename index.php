<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTech - Mua hàng Online giá rẻ</title>
    <link rel="icon" type="image/x-icon" href="./assets/imgs/logo-tab.png">
    <link rel="stylesheet" href="./normalize.css">
    <!-- assets -->
    <link rel="stylesheet" href="./assets/css/base.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/grid.css">
    <link rel="stylesheet" href="./assets/css/responsive.css">
    <!--fonts-->
    <link rel="stylesheet" href="./assets/fonts/fontawesome-free-6.6.0-web/fontawesome-free-6.6.0-web/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;800&display=swap" rel="stylesheet">

    <?php require_once "php/function.php" ?>

</head>
<body>
    <div class="web6713">
        <div class="header_first">
            <!-- <div class="grid">

            </div> -->
        </div>

        <?php addHeader(); ?>

        <section class="container">
            <div class="grid wide">
                <div class="row">
                    <?php 
                        addCTN__cate();
                        addContainer();
                     ?>
                </div>
            </div>
        </section>

        <?php addFooter(); ?>

    </div>
    <script src="js/dungchung.js"></script>

    <script src="js/cart.js"></script>

    <script src="js/trangchu.js"></script>
</body>
</html>
