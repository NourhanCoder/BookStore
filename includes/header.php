<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : null ?></title>

    <link rel="icon" type="image/png" href="public/assets/images/logo.png">
    <link rel="stylesheet" href="public/assets/css/vendors/all.min.css">
    <link rel="stylesheet" href="public/assets/css/vendors/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="public/assets/css/vendors/owl.carousel.min.css">
    <link rel="stylesheet" href="public/assets/css/vendors/owl.theme.default.min.css">
    <link rel="stylesheet" href="public/assets/css/main.min.css">
    
</head>
<body>
    <div>
        <div class="header-container fixed-top border-bottom">
            <header>
                <div class="section-container d-flex justify-content-between">
                    <div class="header__email d-flex gap-2 align-items-center">
                        <i class="fa-regular fa-envelope"></i>
                        coding.arabic@gmail.com
                    </div>
                    <div class="header__info d-none d-lg-block">
                        شحن مجاني للطلبات 💥 عند الشراء ب 699ج او اكثر
                    </div>
                    <div class="header__branches d-flex gap-2 align-items-center">
                        <a class="text-white text-decoration-none" href="index.php?page=branches">
                            <i class="fa-solid fa-location-dot"></i>
                            فروعنا
                        </a>
                    </div>
                </div>
            </header>