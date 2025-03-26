<?php

require_once 'app/controllers/OrderController.php';

use App\Controllers\OrderController;


if (!isset($_SESSION['user_id']) || !isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $_SESSION['error'] = "يجب تسجيل الدخول وإضافة عناصر للسلة لإتمام الطلب.";
    header("Location: index.php?page=cart");
    exit();
}

$userId = $_SESSION['user_id'];
$cart = $_SESSION['cart'];


$items = [];
$totalPrice = 0;

foreach ($cart as $bookId => $item) {
    $items[] = [
        'book_id' => $bookId,
        'quantity' => $item['qty'],
        'price' => $item['price']
    ];
    $totalPrice += $item['price'] * $item['qty'];
}
$orderController = new OrderController();
$orderId = $orderController->createOrder($userId, $items, $totalPrice);
//die("createOrder function is running!");


if ($orderId) {
   
    unset($_SESSION['cart']);
    
    $_SESSION['success_message'] = "تم إنشاء الطلب بنجاح! رقم الطلب: #" . $orderId;
    header("Location: index.php?page=order_success");
    exit();
} else {
    $_SESSION['error'] = "حدث خطأ أثناء إنشاء الطلب. يرجى المحاولة مرة أخرى.";
    header("Location: index.php?page=checkout");
    exit();
}
