<?php
require_once __DIR__ . '/../app/controllers/FavouriteController.php';

session_start();

// التأكد من أن المستخدم مسجل الدخول
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "❌ يجب تسجيل الدخول أولاً!";
    header("Location: index.php?page=login");
    exit();
}

// إنشاء كائن الكنترولر
$favouriteController = new FavouriteController();

// جلب قائمة الكتب المفضلة لهذا المستخدم
$user_id = $_SESSION['user_id'];
$favBooks = $favouriteController->getUserFavourites($user_id);
?>

<main>
    <div class="page-top d-flex justify-content-center align-items-center flex-column text-center">
        <div class="page-top__overlay"></div>
        <div class="position-relative">
            <div class="page-top__title mb-3">
                <h2>المفضلة</h2>
            </div>
            <div class="page-top__breadcrumb">
                <a class="text-gray" href="index.php?page=home">الرئيسية</a> /
                <span class="text-gray">المفضلة</span>
            </div>
        </div>
    </div>

    <div class="my-5 py-5">
        <section class="section-container favourites">
            <table class="w-100">
                <thead>
                    <tr>
                        <th class="d-none d-md-table-cell"></th>
                        <th class="d-none d-md-table-cell"></th>
                        <th class="d-none d-md-table-cell">الاسم</th>
                        <th class="d-none d-md-table-cell">السعر</th>
                        <th class="d-none d-md-table-cell">تاريخ الإضافة</th>
                        <th class="d-none d-md-table-cell">المخزون</th>
                        <th class="d-table-cell d-md-none">المنتج</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php if (!empty($favBooks)): ?>
                        <?php foreach ($favBooks as $book): ?>
                            <tr>
                                <!-- زر الحذف -->
                                <td class="d-block d-md-table-cell">
                                    <form method="POST" action="index.php?page=remove-favourite">
                                        <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                                        <button type="submit" class="favourites__remove m-auto">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </form>
                                </td>
                                
                                <!-- صورة الكتاب -->
                                <td class="d-block d-md-table-cell favourites__img">
                                    <img src="public/assets/images/<?= $book['image'] ?>" alt="<?= $book['title'] ?>" />
                                </td>

                                <!-- اسم الكتاب -->
                                <td class="d-block d-md-table-cell">
                                    <a href="index.php?page=single-product&id=<?= $book['id'] ?>"><?= $book['title'] ?></a>
                                </td>

                                <!-- السعر -->
                                <td class="d-block d-md-table-cell">
                                    <?php if (!empty($book['old_price'])): ?>
                                        <span class="product_price product_price--old"><?= $book['old_price'] ?> جنيه</span>
                                    <?php endif; ?>
                                    <span class="product__price"><?= $book['price'] ?> جنيه</span>
                                </td>

                                <!-- تاريخ الإضافة -->
                                <td class="d-block d-md-table-cell"><?= date("F j, Y", strtotime($book['created_at'])) ?></td>

                                <!-- المخزون -->
                                <td class="d-block d-md-table-cell">
                                    <?php if ($book['stock'] > 0): ?>
                                        <span class="me-2"><i class="fa-solid fa-check"></i></span>
                                        <span class="d-inline-block d-md-none d-lg-inline-block">متوفر بالمخزون</span>
                                    <?php else: ?>
                                        <span class="text-danger">غير متوفر</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">لا توجد كتب في المفضلة.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>
</main>
<?php include 'includes/footer.php'; ?>





