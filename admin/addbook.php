
<?php
require_once __DIR__ . '../database/db.php';


session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php"); // تحويل غير المسجلين إلى صفحة تسجيل الدخول
    exit;
}
// require_once __DIR__ . '../includes/header.php';
// require_once __DIR__ . '../includes/nav.php';

$message = ""; // متغير لتخزين رسالة النجاح أو الخطأ

// جلب التصنيفات من قاعدة البيانات
$query = "SELECT id, name FROM categories"; 
$stmt = $conn->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// التحقق من إرسال البيانات
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $category_id = $_POST['category_id'] ?? '';
    $discount_percentage = $_POST['discount_percentage'] ?? 0;
    $start_date = $_POST['start_date'] ?? date('Y-m-d'); // إذا لم يتم تحديد تاريخ، يبدأ اليوم
    $end_date = $_POST['end_date'] ?? NULL; // تاريخ الانتهاء اختياري

    // التحقق من رفع الصورة
    if (!isset($_FILES['book_image']) || $_FILES['book_image']['error'] != UPLOAD_ERR_OK) {
        $message = "يرجى اختيار صورة!";
    } else {
        // رفع الصورة
        $image_name = time() . '_' . basename($_FILES['book_image']['name']);
        $image_tmp = $_FILES['book_image']['tmp_name'];
        $upload_dir = __DIR__ . "../../public/assets/images/";

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (!move_uploaded_file($image_tmp, $upload_dir . $image_name)) {
            $message = " فشل في رفع الصورة!";
        } else {
            // إدخال الكتاب في قاعدة البيانات
            try {
                $stmt = $conn->prepare("INSERT INTO books (title, author, description, price, stock, category_id, image, created_at) 
                                        VALUES (:title, :author, :description, :price, :stock, :category_id, :image, NOW())");
                $stmt->execute([
                    ':title' => $title,
                    ':author' => $author,
                    ':description' => $description,
                    ':price' => $price,
                    ':stock' => $stock,
                    ':category_id' => $category_id,
                    ':image' => $image_name
                ]);

                $book_id = $conn->lastInsertId(); // الحصول على معرف الكتاب الذي تمت إضافته
                
                // إذا كان هناك خصم، يتم إضافته في جدول الخصومات
                if ($discount_percentage > 0) {
                    $stmt = $conn->prepare("INSERT INTO discounts (book_id, discount_percentage, start_date, end_date) 
                                            VALUES (:book_id, :discount_percentage, :start_date, :end_date)");
                    $stmt->execute([
                        ':book_id' => $book_id,
                        ':discount_percentage' => $discount_percentage,
                        ':start_date' => $start_date,
                        ':end_date' => !empty($end_date) ? $end_date : NULL // إدخال NULL إذا لم يُحدد تاريخ انتهاء
                    ]);
                }

                $message = "✅ تم إضافة الكتاب بنجاح!";
            } catch (PDOException $e) {
                $message = "فشل في إضافة الكتاب: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة كتاب</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <di class="card shadow-lg p-4">
        <h2 class="text-center mb-4">📚 إضافة كتاب جديد</h2>

        <!-- عرض رسالة النجاح أو الخطأ -->
        <?php if (!empty($message)): ?>
            <div class="alert <?php echo (strpos($message, '✅') !== false) ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>

            <div class="mb-3">
                <label for="title" class="form-label">📖 عنوان الكتاب:</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="author" class="form-label">✍️ المؤلف:</label>
                <input type="text" name="author" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">📝 الوصف:</label>
                <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">💰 السعر:</label>
                <input type="number" name="price" class="form-control" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">📦 المخزون:</label>
                <input type="number" name="stock" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">📂 التصنيف:</label>
                <select name="category_id" class="form-select" required>
                    <option value="">اختر تصنيفًا</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- نسبة الخصم -->
            <div class="mb-3">
                <label for="discount_percentage" class="form-label">💲 نسبة الخصم (اختياري):</label>
                <input type="number" name="discount_percentage" class="form-control" step="1" min="0" max="100">
            </div>

            <!-- تاريخ بداية وانتهاء الخصم -->
            <div class="mb-3">
                <label for="start_date" class="form-label">📅 تاريخ بداية الخصم:</label>
                <input type="date" name="start_date" class="form-control">
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">📅 تاريخ انتهاء الخصم (اختياري):</label>
                <input type="date" name="end_date" class="form-control">
            </div>

            <!-- اختيار صورة من الجهاز -->
            <div class="mb-3">
                <label for="book_image" class="form-label">🖼️ رفع صورة الكتاب:</label>
                <input type="file" name="book_image" class="form-control" accept="image/*" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success w-100">➕ إضافة الكتاب</button>
                <a href="logout.php" class="btn btn-danger w-100">🚪 تسجيل الخروج</a>

            

        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>



