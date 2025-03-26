<?php

$branches = [
    [
        "name" => "الاسكندرية",
        "address" => "ش جمال عبد الناصر - تحت كوبرى 45 بجوار كوكى مان والاكاديميه ميامى - الاسكندرية.",
        "phone" => "01063888667",
        "location" => "ش جمال عبد الناصر - الاسكندرية."
    ],
    [
        "name" => "طنطا",
        "address" => "ش بطرس مع سعيد امام المركز الطبى - طنطا.",
        "phone" => "01063888667",
        "location" => "ش بطرس - طنطا."
    ],
    [
        "name" => "المحلة",
        "address" => "ش شكري الكواتلي مع ش عبد العزيز امام البنك الاهلي.",
        "phone" => "01063888667",
        "location" => "ش شكري الكواتلي - المحلة."
    ]
];
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فروعنا</title>
    <link rel="stylesheet" href="public/assets/css/vendors/all.min.css" />
    <link rel="stylesheet" href="public/assets/css/vendors/bootstrap.rtl.min.css" />
    <link rel="stylesheet" href="public/assets/css/vendors/owl.carousel.min.css" />
    <link rel="stylesheet" href="public/assets/css/vendors/owl.theme.default.min.css" />
    <link rel="stylesheet" href="public/assets/css/main.min.css" />
</head>
<body>
    <main>
        <section class="page-top d-flex justify-content-center align-items-center flex-column text-center">
            <div class="page-top__overlay"></div>
            <div class="position-relative">
                <div class="page-top__title mb-3">
                    <h2>فروعنا</h2>
                </div>
                <div class="page-top__breadcrumb">
                    <a class="text-gray" href="index.php">الرئيسية</a> /
                    <span class="text-gray">فروعنا</span>
                </div>
            </div>
        </section>
        <section class="branches section-container my-5 py-5">
            <div class="row">
                <?php foreach ($branches as $branch): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="branches__item h-100">
                            <h3>فرع: <?php echo $branch['name']; ?></h3>
                            <p><?php echo $branch['address']; ?></p>
                            <div class="branches__contact d-flex align-items-center gap-2 mb-3">
                                <div class="branches__icon">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                <div>
                                    <p class="mb-0 fw-bolder">اتصل بنا</p>
                                    <p class="mb-0"><?php echo $branch['phone']; ?></p>
                                </div>
                            </div>
                            <div class="branches__location d-flex align-items-center gap-2">
                                <div class="branches__icon">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div>
                                    <p class="mb-0 fw-bolder">زورنا في الفرع</p>
                                    <p class="mb-0"><?php echo $branch['location']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    <script src="public/assets/js/vendors/all.min.js"></script>
    <script src="public/assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="public/assets/js/vendors/jquery-3.7.0.js"></script>
    <script src="public/assets/js/vendors/owl.carousel.min.js"></script>
    <script src="public/assets/js/app.js"></script>
</body>
</html>
<?php include 'includes/footer.php';?>
