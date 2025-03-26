<?php

//require_once './vendor/autoload.php';

use App\Controllers\SingleProductController;

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("لم يتم تحديد المنتج");
}

$controller = new SingleProductController();
$product = $controller->getProductById($_GET['id']);

if (!$product) {
    die("المنتج غير موجود");
}


$originalPrice = $product['price'];
$discountPercentage = isset($product['discount_percentage']) ? $product['discount_percentage'] : 0;
$discountedPrice = $originalPrice - ($originalPrice * ($discountPercentage / 100));
$offerEndDate = isset($product['discount_end_date']) ? $product['discount_end_date'] : null;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['title']); ?></title>
    <link rel="stylesheet" href="public/assets/css/vendors/bootstrap.rtl.min.css" />
    <link rel="stylesheet" href="public/assets/css/main.min.css" />
    <script src="public/assets/js/jquery.min.js"></script>
    <style>
        .single-product {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            background: #fff;
            text-align: center;
        }

        .single-product__img {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 450px;
            /* تحديد ارتفاع مناسب للصورة */
            overflow: hidden;
        }

        .single-product__img img {
            width: auto;
            height: 100%;
            max-height: 450px;
            object-fit: contain;
            /* ✅ يجعل الصورة تظهر كاملة بدون قص */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .single-product__details {
            margin-top: 20px;
        }

        .product__title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .product__author {
            font-size: 18px;
            font-weight: bold;
            color: #777;
            margin-bottom: 5px;
        }

        .product__price {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 15px;
        }

        .product__price--old {
            text-decoration: line-through;
            color: red;
            font-size: 20px;
            margin-right: 10px;
        }

        .offer-end {
            font-size: 16px;
            color: #d9534f;
            font-weight: bold;
            margin-top: 5px;
        }

        .product__description {
            font-size: 18px;
            /* ✅ تكبير حجم الخط */
            font-weight: bold;
            /* ✅ جعله عريضًا */
            color: #333;
            /* ✅ لون واضح */
            text-align: center;
            /* ✅ جعل النص في المنتصف */
            line-height: 1.8;
            /* ✅ تحسين المسافات بين الأسطر */
            margin: 20px auto;
            /* ✅ إضافة تباعد علوي وسفلي */
            max-width: 80%;
            /* ✅ جعل النص لا يمتد على كامل الصفحة */
        }


        .btn-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 20px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-primary {
            background-color: #28a745;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #218838;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <main>
        <section class="single-product">
            <div class="single-product__img">
                <img src="public/assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
            </div>

            <h2><?php echo htmlspecialchars($product['title']); ?></h2>
            <p class="product__author text-muted"><?php echo htmlspecialchars($product['author']); ?></p>

            <div class="product__price">
                <?php if ($discountPercentage > 0): ?>
                    <span class="product__price--old"><?php echo number_format($originalPrice, 2); ?> جنيه</span>
                    <span><?php echo number_format($discountedPrice, 2); ?> جنيه</span>
                    <p class="offer-end">ينتهي العرض في: <?php echo htmlspecialchars($offerEndDate); ?></p>
                <?php else: ?>
                    <span><?php echo number_format($originalPrice, 2); ?> جنيه</span>
                <?php endif; ?>
            </div>

            <p class="product__description"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>

            <div class="btn-container">
            <form action="index.php?page=cart&action=add" method="POST">
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="name" value="<?php echo htmlspecialchars($product['title']); ?>">
                    <input type="hidden" name="price" value="<?php echo $discountedPrice; ?>">
                    <input type="hidden" name="image" value="public/assets/images/<?php echo htmlspecialchars($product['image']); ?>">
                    <button type="submit" class="btn btn-primary">🛒 إضافة إلى السلة</button>
                </form>

                <form action="index.php?page=add-favourite" method="POST">
                    <input type="hidden" name="book_id" value="<?php echo $product['id']; ?>">
                    <button type="submit" class="btn btn-danger">❤ إضافة للمفضلة</button>
                </form>

        </section>
    </main>
</body>

</html>

<footer class="footer text-white">
    <div class="footer__upper">
        <div class="section-container row">
            <div class="col-md-6 col-lg-3 mb-5 mb-lg-0">
                <div class="footer__logo">
                    <img class="w-100" src="public/assets/images/logo.png" alt="">
                </div>
                <p class="my-3 text-gray">شركتنا هي أكبر شركة متخصصة لبيع الكتب أونلاين وتوصيلها حتي المنزل.</p>
                <div class="footer__social d-flex gap-3">
                    <a href=""><i class="fa-brands fa-facebook fa-2x text-white"></i></a>
                    <a href=""><i class="fa-brands fa-instagram fa-2x text-white"></i></a>
                    <a href=""><i class="fa-brands fa-tiktok fa-2x text-white"></i></a>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 px-md-4 mb-5 mb-lg-0">
                <div class="footer__list-title fw-bolder mb-1">عن Coding arabic</div>
                <div class="footer__list list-unstyled p-0">
                    <li><a class="footer__link text-decoration-none d-inline-block text-gray py-1" href="about.php">من نحن</a></li>
                    <li><a class="footer__link text-decoration-none d-inline-block text-gray py-1" href="contact.php">تواصل معنا</a></li>
                    <li><a class="footer__link text-decoration-none d-inline-block text-gray py-1" href="privacy-policy.php">سياسة الخصوصية</a></li>
                    <li><a class="footer__link text-decoration-none d-inline-block text-gray py-1" href="refund-policy.php">سياسة الاستبدال و الاسترجاع</a></li>
                    <li><a class="footer__link text-decoration-none d-inline-block text-gray py-1" href="track-order.php">تتبع طلبك</a></li>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 px-md-4 mb-5 mb-lg-0">
                <div class="footer__list-title fw-bolder mb-1">فروعنا</div>
                <div class="footer__list">
                    <div class="d-flex gap-3 mb-3">
                        <div class="fs-5"><i class="fa-solid fa-location-dot"></i></div>
                        <div class="text-gray">فرع طنطا: ش بطرس مع سعيد امام المركز الطبى - طنطا.</div>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="fs-5"><i class="fa-solid fa-location-dot"></i></div>
                        <div class="text-gray">فرع اسكندرية: ش جمال عبد الناصر - تحت كوبرى 45 - ميامى.</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-5 mb-lg-0">
                <div>
                    <div class="footer__list-title fw-bolder mb-1">تحتاج مساعدة ؟</div>
                    <div class="d-flex gap-3 mb-3">
                        <div class="fs-5"><i class="fa-solid fa-envelope"></i></div>
                        <div class="text-gray">coding.arabic@gmail.com</div>
                    </div>
                </div>
                <div>
                    <div class="footer__list-title fw-bolder mb-3">اشترك في نشرتنا</div>
                    <form class="footer__form position-relative">
                        <input class="footer__email-input w-100 bg-transparent border border-white py-2 px-3 rounded-2 text-white pe-5" placeholder="البريد الالكتروني">
                        <button class="footer__submit mx-3 position-absolute top-50 translate-middle-y end-0 bg-transparent border-0 text-white d-flex align-items-center"><i class="fa-solid fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__bottom text-center p-3 section-container">جميع الحقوق محفوظة Eraasoft 2023</div>
</footer>
<script src="public/assets/js/vendors/all.min.js"></script>
<script src="public/assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="public/assets/js/vendors/jquery-3.7.0.js"></script>
<script src="public/assets/js/vendors/owl.carousel.min.js"></script>
<script src="public/assets/js/app.js"></script>
</body>

</html>