<?php
require_once 'app/controllers/ShopController.php';
include 'includes/header.php';
include 'includes/nav.php';

$shopController = new ShopController();
$categories = ['كتب عربية', 'كتب إنجليزية']; 
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المتجر</title>
</head>
<body>
    <?php foreach ($categories as $category): ?>
        <?php $books = $shopController->getBooksByCategory($category); ?>
        <h2>الكتب <?= htmlspecialchars($category) ?></h2>
        <?php if (!empty($books)): ?>
            <ul>
                <?php foreach ($books as $book): ?>
                    <li>
                        <?= htmlspecialchars($book['title']) ?>
                        <form action="controllers/FavouriteController.php" method="POST">
                            <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                            <button type="submit">إضافة إلى المفضلة</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>لا توجد كتب متاحة في هذه الفئة.</p>
        <?php endif; ?>
    <?php endforeach; ?>
</body>
</html>

<?php include 'includes/footer.php'; ?>