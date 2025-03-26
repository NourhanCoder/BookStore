<?php
session_start();
require_once __DIR__ . '../database/db.php'; // الاتصال بقاعدة البيانات

$error = ""; // متغير لتخزين الأخطاء

if (isset($_SESSION['admin_id'])) {
    header("Location: addbook.php"); // لو الأدمن مسجل بالفعل، يتم توجيهه للوحة التحكم
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = " يرجى إدخال البريد الإلكتروني وكلمة المرور!";
    } else {
        $stmt = $conn->prepare("SELECT id, password FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id']; // تخزين الجلسة
            header("Location: addbook.php"); // تحويله للوحة التحكم
            exit;
        } else {
            $error = " البريد الإلكتروني أو كلمة المرور غير صحيحة!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول الأدمن</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg p-4 mx-auto" style="max-width: 400px;">
        <h2 class="text-center mb-4">🔐 تسجيل دخول الأدمن</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="login.php" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">📧 البريد الإلكتروني:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">🔑 كلمة المرور:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">🚀 تسجيل الدخول</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
