<?php

require_once __DIR__ . '/../models/User.php';
//session_start(); 

use App\Models\User;

$user = new User();


if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($user->register($name, $email, $password, $confirm_password)) {
        $_SESSION['success'] = "تم التسجيل بنجاح! يمكنك الآن تسجيل الدخول."; 
        header("Location: index.php?page=login"); 
        exit();
    } else {
        $_SESSION['error'] = "فشل التسجيل! تأكد من صحة البيانات.";
        header("Location: index.php?page=register");
        exit();
    }
}


if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    if ($user->login($email, $password, $remember)) {
        $_SESSION['success'] = "تم تسجيل الدخول بنجاح!";
        header("Location: index.php?page=home"); 
        exit();
    } else {
        $_SESSION['error'] = "البريد الإلكتروني أو كلمة المرور غير صحيحة!";
        header("Location: index.php?page=login");
        exit();
    }
}
?>












