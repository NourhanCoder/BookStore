<?php
require_once __DIR__ . '/../app/controllers/ShopController.php';

$shopController = new ShopController();
$arabicBooks = $shopController->getBooksByCategory('كتب إنجليزية');
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الكتب العربية</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        h2 {
            margin: 20px 0;
            color: #333;
        }
        .books-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 40px auto 20px; /* تم إضافة هامش علوي */
        }
        .book-card {
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .book-card img {
            max-width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }
        .book-title {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
        }
        .book-author {
            color: #777;
            font-size: 14px;
        }
        .book-price {
            font-size: 16px;
            color: #e67e22;
            margin: 5px 0;
        }
        .book-description {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
        }
        .view-button {
            background: #3498db;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }
        .view-button:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <h2>الكتب العربية</h2>
    <div class="books-container">
        <?php foreach ($arabicBooks as $book): ?>
            <div class="book-card">
                <img src="public/assets/images/<?= htmlspecialchars($book['image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
                <div class="book-title"><?= htmlspecialchars($book['title']) ?></div>
                <div class="book-author">المؤلف: <?= htmlspecialchars($book['author']) ?></div>
                <div class="book-price">السعر: <?= htmlspecialchars($book['price']) ?>$</div>
                <div class="book-description"><?= htmlspecialchars(substr($book['description'], 0, 100)) ?>...</div>
                
                
                <a href="index.php?page=single-product&id=<?= $book['id'] ?>" class="view-button">📖 عرض الكتاب</a>

                <form action="index.php?page=add-favourite" method="POST">
                    <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                    <button type="submit" class="btn btn-danger">❤ إضافة للمفضلة</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>

<?php include 'includes/footer.php'; ?>