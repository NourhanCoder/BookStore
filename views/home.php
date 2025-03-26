<?php
require_once __DIR__ . '/../app/controllers/HomeController.php';

$homeController = new HomeController();
$sliderBooks = $homeController->index(); 
$discountedBooks = $homeController->getDiscountedBooks();
$newestBooks = $homeController->getNewestBooks();
$offerEndTime = $homeController->getClosestOfferEndTime();
$bestSellingBooks = $homeController->getBestSellingBooks();
?>
<!-- Page Content Start -->
<main class="pt-4">

  <!-- Hero Section Start -->
  <?php if (!isset($sliderBooks) || empty($sliderBooks)): ?>
    <p>لا توجد كتب في السلايدر حاليًا.</p>
  <?php else: ?>
    <section class="section-container hero">
      <div class="custom-slider">
        <?php
      
        $chunkedBooks = array_chunk($sliderBooks, 2);
        foreach ($chunkedBooks as $books): ?>
          <div class="slide">
            <div class="book book-left">
              <img src="public/assets/images/<?php echo htmlspecialchars($books[0]['image']); ?>" alt="<?php echo htmlspecialchars($books[0]['title']); ?>">
            </div>
            <div class="new-arrival">وصل حديثًا</div>
            <div class="book book-right">
              <?php if (isset($books[1])): ?>
                <img src="public/assets/images/<?php echo htmlspecialchars($books[1]['image']); ?>" alt="<?php echo htmlspecialchars($books[1]['title']); ?>">
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <style>
      .custom-slider {
        display: flex;
        overflow: hidden;
        width: 100%;
        max-width: 1200px;
        margin: auto;
        position: relative;
      }

      .slide {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        min-width: 100%;
        /* تأكد من أن كل سلايد يأخذ العرض الكامل */
        min-height: 300px;
        transition: transform 0.5s ease-in-out;
        flex-shrink: 0;
        /* منع السلايدات من الانكماش */
        border: 2px solid #ddd;
        /* إضافة بوردر */
        border-radius: 15px;
        /* زوايا مدورة */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* إضافة ظل */
        background-color: #f9f9f9;
        /* لون خلفية للسلايد */
        padding: 20px;
        /* إضافة مسافة داخلية */
      }

      .book {
        width: 30%;
        /* زيادة حجم الكتب */
        max-width: 200px;
        /* حجم أكبر للكتب */
        margin: 0 10px;
        /* إضافة مسافة بين الكتب */
      }

      .book img {
        width: 100%;
        height: auto;
        border-radius: 10px;
        border: 2px solid #ccc;
        /* إضافة بوردر للكتب */
      }

      .new-arrival {
        font-size: 30px;
        font-weight: bold;
        text-align: center;
        margin: 0 20px;
        white-space: nowrap;
        color: #333;
        /* لون النص */
      }
    </style>

    <script>
      let index = 0;
      const slides = document.querySelectorAll('.slide');
      const totalSlides = slides.length;

      function showSlides() {
        // إخفاء جميع السلايدات
        slides.forEach((slide) => {
          slide.style.display = 'none';
        });

        // عرض السلايد الحالي
        slides[index].style.display = 'flex';

        // الانتقال إلى السلايد التالي
        index = (index + 1) % totalSlides;
      }

      // عرض السلايد الأول مباشرة
      showSlides();

      // تحريك السلايدات كل 3 ثوانٍ
      setInterval(showSlides, 3000);
    </script>
  <?php endif; ?>
</main>
<!-- Hero Section End -->

<!-- Offer Section Start -->
<section class="section-container mb-5 mt-3">
  <div class="offer d-flex align-items-center justify-content-between rounded-3 p-3 text-white">
    <div class="offer__title fw-bolder">عروض اليوم</div>
    <div id="offer-timer" class="offer__time d-flex gap-2 fs-6">
      <div class="d-flex flex-column align-items-center">
        <span id="hours" class="fw-bolder">00</span>
        <div>ساعات</div>
      </div>:
      <div class="d-flex flex-column align-items-center">
        <span id="minutes" class="fw-bolder">00</span>
        <div>دقائق</div>
      </div>:
      <div class="d-flex flex-column align-items-center">
        <span id="seconds" class="fw-bolder">00</span>
        <div>ثواني</div>
      </div>
    </div>
  </div>
</section>
<!-- Offer Section End -->

<script>
  // تحويل وقت العرض من PHP إلى JavaScript
  const offerEndTime = "<?php echo $offerEndTime; ?>"; // تاريخ انتهاء العرض

  if (offerEndTime) {
    const countDownDate = new Date(offerEndTime).getTime();

    const updateTimer = () => {
      const now = new Date().getTime();
      const distance = countDownDate - now;

      if (distance > 0) {
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("hours").innerText = hours.toString().padStart(2, "0");
        document.getElementById("minutes").innerText = minutes.toString().padStart(2, "0");
        document.getElementById("seconds").innerText = seconds.toString().padStart(2, "0");
      } else {
        document.getElementById("offer-timer").innerHTML = "<span>العرض انتهى</span>";
      }
    };

    setInterval(updateTimer, 1000);
  } else {
    document.getElementById("offer-timer").innerHTML = "<span>لا توجد عروض متاحة حاليًا</span>";
  }
</script>


<!-- Products Section Start -->
<section class="section-container mb-4">
  <div class="owl-carousel products__slider owl-theme">
    <?php if (!empty($discountedBooks)): ?>
      <?php foreach ($discountedBooks as $book): ?>
        <div class="products__item">
          <div class="product__header mb-3">
            <a href="index.php?page=single-product&id=<?php echo $book['id']; ?>">
              <div class="product__img-cont">
                <img class="product__img w-100 h-100 object-fit-cover" src="public/assets/images/<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
              </div>
            </a>
            <div class="product__sale position-absolute top-0 start-0 m-1 px-2 py-1 rounded-1 text-white">
              وفر <?php echo $book['discount_percentage']; ?>%
            </div>
            <div class="product__favourite position-absolute top-0 end-0 m-1 rounded-circle d-flex justify-content-center align-items-center bg-white">
              <i class="fa-regular fa-heart"></i>
            </div>
          </div>
          <div class="product__title text-center">
            <a class="text-black text-decoration-none" href="index.php?page=single-product&id=<?php echo $book['id']; ?>">
              <?php echo htmlspecialchars($book['title']); ?>
            </a>
          </div>
          <div class="product__author text-center">
            <?php echo htmlspecialchars($book['author']); ?>
          </div>
          <div class="product__price text-center d-flex gap-2 justify-content-center flex-wrap">
            <span class="product__price product__price--old">
              <?php echo number_format($book['price'], 2); ?> جنيه
            </span>
            <span class="product__price">
              <?php echo number_format($book['price'] - ($book['price'] * $book['discount_percentage'] / 100), 2); ?> جنيه
            </span>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center">لا توجد عروض متاحة حاليًا.</p>
    <?php endif; ?>
  </div>
</section>

<!-- Products Section End -->


<!-- Categories Section Start -->
<section class="section-container mb-5">
  <div class="categories row gx-4">
    <div class="col-md-6 p-2">
      <div class="p-4 border rounded-3">
        <img class="w-100" src="public/assets/images/category-1.png" alt="">
      </div>
    </div>
    <div class="col-md-6 p-2">
      <div class="p-4 border rounded-3">
        <img class="w-100" src="public/assets/images/category-2.png" alt="">
      </div>
    </div>
  </div>
</section>
<!-- Categories Section End -->

<!-- Best Sales Section Start -->
<section class="section-container mb-5">
  <div class="products__header mb-4 d-flex align-items-center justify-content-between">
    <h4 class="m-0">الأكثر مبيعًا</h4>
    <button class="products__btn py-2 px-3 rounded-1">تسوق الآن</button>
  </div>
  <div class="owl-carousel products__slider owl-theme">
    <?php if (!empty($bestSellingBooks)): ?>
      <?php foreach ($bestSellingBooks as $book): ?>
        <div class="products__item">
          <div class="product__header mb-3">
            <a href="index.php?page=single-product&id=<?php echo $book['id']; ?>">
              <div class="product__img-cont">
                <img class="product__img w-100 h-100 object-fit-cover" 
                     src="public/assets/images/<?php echo htmlspecialchars($book['image']); ?>" 
                     alt="<?php echo htmlspecialchars($book['title']); ?>">
              </div>
            </a>
            <div class="product__sale position-absolute top-0 start-0 m-1 px-2 py-1 rounded-1 text-white">
              مبيعات: <?php echo $book['total_sales']; ?> نسخة
            </div>
          </div>
          <div class="product__title text-center">
            <a class="text-black text-decoration-none" href="index.php?page=single-product&id=<?php echo $book['id']; ?>">
              <?php echo htmlspecialchars($book['title']); ?>
            </a>
          </div>
          <div class="product__author text-center">
            <?php echo htmlspecialchars($book['author']); ?>
          </div>
          <div class="product__price text-center d-flex gap-2 justify-content-center flex-wrap">
            <span class="product__price">
              <?php echo number_format($book['price'], 2); ?> جنيه
            </span>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center">لا توجد كتب مباعة حاليًا.</p>
    <?php endif; ?>
  </div>
</section>
<!-- Best Sales Section End -->


<!-- Newest Section Start -->
<section class="section-container mb-5">
  <div class="products__header mb-4 d-flex align-items-center justify-content-between">
    <h4 class="m-0">وصل حديثا</h4>
    <button class="products__btn py-2 px-3 rounded-1">تسوق الآن</button>
  </div>
  <div class="owl-carousel products__slider owl-theme">
    <?php if (!empty($newestBooks)): ?>
      <?php foreach ($newestBooks as $book): ?>
        
        <div class="products__item">
          <div class="product__header mb-3">
            <a href="index.php?page=single-product&id=<?php echo $book['id']; ?>">
              <div class="product__img-cont">
                <img class="product__img w-100 h-100 object-fit-cover" src="public/assets/images/<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
              </div>
            </a>
            <?php if (!empty($book['discount_percentage'])): ?>
              <div class="product__sale position-absolute top-0 start-0 m-1 px-2 py-1 rounded-1 text-white">
                وفر <?php echo $book['discount_percentage']; ?>%
              </div>
            <?php endif; ?>
          </div>
          <div class="product__title text-center">
            <a class="text-black text-decoration-none" href="index.php?page=single-product&id=?php echo $book['id']; ?>">
              <?php echo htmlspecialchars($book['title']); ?>
            </a>
          </div>
          <div class="product__author text-center">
            <?php echo htmlspecialchars($book['author']); ?>
          </div>
          <div class="product__price text-center d-flex gap-2 justify-content-center flex-wrap">
            <?php if (!empty($book['discount_percentage'])): ?>
              <span class="product__price product__price--old">
                <?php echo number_format($book['price'], 2); ?> جنيه
              </span>
              <span class="product__price">
                <?php echo number_format($book['price'] - ($book['price'] * $book['discount_percentage'] / 100), 2); ?> جنيه
              </span>
            <?php else: ?>
              <span class="product__price">
                <?php echo number_format($book['price'], 2); ?> جنيه
              </span>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center">لا توجد كتب جديدة حاليا.</p>
    <?php endif; ?>
  </div>
</section>
<!-- Newest Section End -->

</main>
<!-- Page Content End -->



<script src="public/assets/js/vendors/all.min.js"></script> 
<script src = "public/assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="public/assets/js/vendors/jquery-3.7.0.js"></script>
<script src="public/assets/js/vendors/owl.carousel.min.js"></script>
<script src="public/assets/js/main.js"></script>
<script src="public/assets/js/app.js"></script>
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