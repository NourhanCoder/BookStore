<?php
require_once __DIR__ . '/../app/controllers/FavouriteController.php';
require_once __DIR__ . '/../vendor/autoload.php';
use App\Controllers\CartController;
$cartNav = new CartController();
$cartItems = $cartNav->getItems();
$cartCount = count($cartItems);


$favouritesNav = new FavouriteController();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$favouritesCount = 0; 

if ($user_id !== null) {
    $favouritesItems = $favouritesNav->getUserFavourites($user_id);
    $favouritesCount = count($favouritesItems);
}
// $favouritesItems = $favouritesNav->getUserFavourites($user_id);
// $favouritesCount = count($favouritesItems);

?>

<nav class="nav">
    <div class="section-container w-100 d-flex align-items-center gap-4 h-100">
        <div class="nav__categories-btn align-items-center justify-content-center rounded-1 d-none d-lg-flex">
            <button class="border-0 bg-transparent" data-bs-toggle="offcanvas" data-bs-target="#nav__categories">
                <i class="fa-solid fa-align-center fa-rotate-180"></i>
            </button>
        </div>
        <div class="nav__logo">
            <a href="index.php">
                <img class="h-100" src="public/assets/images/logo.png" alt="Logo">
            </a>
        </div>
        <div class="nav__search w-100">
            <form action="index.php" method="GET" class="w-100 position-relative">
                <input type="hidden" name="page" value="search_results">
                <input class="nav__search-input w-100" type="search" name="query" placeholder="أبحث هنا عن أي شيء تريده..." 
                    value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>" required>
                <button type="submit" class="nav__search-icon border-0 bg-transparent">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>
        <ul class="nav__links gap-3 list-unstyled d-none d-lg-flex m-0"></ul>
        <?php if (isset($_SESSION['user_id'])): ?>

                <li class="nav__link nav__link-user">
                    <a class="d-flex align-items-center gap-2">
                        حسابي
                        <i class="fa-regular fa-user"></i>
                        <i class="fa-solid fa-chevron-down fa-2xs"></i>
                    </a>
                    <ul class="nav__user-list position-absolute p-0 list-unstyled bg-white">
                        <li class="nav__link nav__user-link"><a href="index.php?page=orders">الطلبات</a></li>
                        <li class="nav__link nav__user-link"><a href="index.php?page=account_details">تفاصيل الحساب</a></li>
                        <li class="nav__link nav__user-link"><a href="index.php?page=contact">تواصل معنا</a></li>
                        <li class="nav__link nav__user-link"><a href="index.php?page=about">من نحن</a></li>
                        <li class="nav__link nav__user-link"><a href="index.php?page=logout">تسجيل الخروج</a></li>
                    </ul>
                </li>
                <?php else: ?>
                <li class="nav__link">
                    <a class="d-flex align-items-center gap-2" href="index.php?page=login">
                        تسجيل الدخول
                        <i class="fa-regular fa-user"></i>
                    </a>
                </li>
                <?php endif; ?>

                 
            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
                <li class="nav__link">
                    <a class="d-flex align-items-center gap-2 text-danger" href="admin/addbook.php">
                        لوحة تحكم الأدمن
                        <i class="fa-solid fa-user-shield"></i>
                    </a>
                </li>
            <?php else: ?>
                <li class="nav__link">
                    <a class="d-flex align-items-center gap-2 text-danger" href="admin/login.php">
                        دخول الأدمن
                        <i class="fa-solid fa-lock"></i>
                    </a>
                </li>
            <?php endif; ?>
            <li class="nav__link">
    <a class="d-flex align-items-center gap-2" href="index.php?page=favourites">
        المفضلة
        <div class="position-relative">
            <i class="fa-regular fa-heart"></i>
            <?php if ($favouritesCount > 0): ?>
                <div class="nav__link-floating-icon"><?php echo $favouritesCount; ?></div>
            <?php endif; ?>
        </div>
    </a>
</li>

            <li class="nav__link">
                <a class="d-flex align-items-center gap-2" data-bs-toggle="offcanvas" data-bs-target="#nav__cart">
                    عربة التسوق
                    <div class="position-relative">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <div class="nav__link-floating-icon"><?php echo $cartCount; ?></div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="nav__categories offcanvas offcanvas-start px-4 py-2" tabindex="-1" id="nav__categories">
    <div class="nav__categories-header offcanvas-header justify-content-end">
        <button type="button" class="border-0 bg-transparent text-danger nav__close" data-bs-dismiss="offcanvas">
            <i class="fa-solid fa-x fa-1x fw-light"></i>
        </button>
    </div>
    <div class="nav__categories-body offcanvas-body pt-0">
        <div class="nav__side-logo mb-2">
            <img class="w-100" src="public/assets/images/logo.png" alt="Logo">
        </div>
        <ul class="nav__list list-unstyled">
            <li class="nav__link nav__side-link"><a href="index.php?page=all_books" class="py-3">جميع المنتجات</a></li>
            <li class="nav__link nav__side-link"><a href="index.php?page=arabic_books" class="py-3">كتب عربية</a></li>
            <li class="nav__link nav__side-link"><a href="index.php?page=english_books" class="py-3">كتب إنجليزية</a></li>
        </ul>
    </div>
</div>

<div class="nav__cart offcanvas offcanvas-end px-3 py-2" tabindex="-1" id="nav__cart">
    <div class="nav__categories-header offcanvas-header align-items-center">
        <h5>سلة التسوق</h5>
        <button type="button" class="border-0 bg-transparent text-danger nav__close" data-bs-dismiss="offcanvas">
            <i class="fa-solid fa-x fa-1x fw-light"></i>
        </button>
    </div>
    <div class="nav__categories-body offcanvas-body pt-4">
        <?php if (!empty($cartItems)): ?>
            <div class="cart-items">
                <?php foreach ($cartItems as $item): ?>
                    <div class="cart-item d-flex align-items-center gap-3 mb-3 pb-3 border-bottom">
                        <img src="public/assets/images/<?=$item['image']; ?>" alt="<?php echo $item['name']; ?>" style="width: 60px; height: 60px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h6 class="mb-1"><?php echo $item['name']; ?></h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-success"><?php echo $item['price']; ?> جنيه</span>
                                <span class="text-muted">الكمية: <?php echo $item['qty']; ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <div class="cart-total border-top pt-3 mb-3">
                    <div class="d-flex justify-content-between">
                        <strong>الإجمالي:</strong>
                        <strong class="text-success">
                            <?php
                            $total = 0;
                            foreach ($cartItems as $item) {
                                $total += $item['price'] * $item['qty'];
                            }
                            echo number_format($total, 2);
                            ?> جنيه
                        </strong>
                    </div>
                </div>
                <div>
                <a href="index.php?page=checkout" class="nav__cart-btn text-center text-white w-100 border-0 mb-3 py-2 px-3 bg-success text-decoration-none ">اتمام الطلب</a>
            
        <?php else: ?>
            <p>لا توجد منتجات في سلة المشتريات.</p>
        <?php endif; ?>
       
        <a  href="index.php?page=home" class="nav__cart-btn text-center w-100 py-2 px-3 bg-transparent" data-bs-dismiss="offcanvas ">تابع التسوق</a>
    </div>
</div>




        