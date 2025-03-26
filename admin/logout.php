<?php
session_start();
session_unset(); // إزالة جميع المتغيرات المسجلة في الجلسة
session_destroy(); // تدمير الجلسة بالكامل
header("Location: login.php"); // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول
exit;
?>
