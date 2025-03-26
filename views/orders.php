<?php
require_once 'app/controllers/OrderController.php';
//require_once 'views/process_order.php';

use App\Controllers\OrderController;

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "يجب تسجيل الدخول أولاً";
    header("Location: index.php?page=login");
    exit();
}

$orderController = new OrderController();
$user_orders = $orderController->getUserOrders($_SESSION['user_id']);
?>

<main>
    <section class="page-top d-flex justify-content-center align-items-center flex-column text-center">
        <div class="page-top__overlay"></div>
        <div class="position-relative">
            <div class="page-top__title mb-3">
                <h2>حسابي</h2>
            </div>
            <div class="page-top__breadcrumb">
                <a class="text-gray" href="index.php">الرئيسية</a> /
                <span class="text-gray">حسابي</span>
            </div>
        </div>
    </section>

    <section class="section-container profile my-3 my-md-5 py-5 d-md-flex gap-5">
        <div class="profile__right">
            <ul class="profile__tabs list-unstyled ps-3">
                
                <li class="profile__tab active">
                    <a class="py-2 px-3 text-black text-decoration-none" href="index.php?page=orders">الطلبات</a>
                </li>
                <li class="profile__tab">
                    <a class="py-2 px-3 text-black text-decoration-none" href="index.php?page=account_details">تفاصيل الحساب</a>
                </li>
                <li class="profile__tab">
                    <a class="py-2 px-3 text-black text-decoration-none" href="index.php?page=favourites">المفضلة</a>
                </li>
                <li class="profile__tab">
                    <a class="py-2 px-3 text-black text-decoration-none" href="index.php?page=logout">تسجيل الخروج</a>
                </li>
            </ul>
        </div>
        <div class="profile__left mt-4 mt-md-0 w-100">
            <div class="profile__tab-content orders active">
                <table class="orders__table w-100">
                    <thead>
                        <th>الطلب</th>
                        <th>التاريخ</th>
                        <th>الحالة</th>
                        <th>الإجمالي</th>
                        <th>إجراءات</th>
                    </thead>
                    <tbody>
                        <?php if (!empty($user_orders)) : ?>
                            <?php foreach ($user_orders as $order) : ?>
                                <tr>
                                    <td>#<?= htmlspecialchars($order['id']) ?></td>
                                    <td><?= htmlspecialchars($order['created_at']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $order['status'] === 'قيد المعالجة' ? 'warning' : 
                                            ($order['status'] === 'تم الشحن' ? 'info' : 
                                            ($order['status'] === 'تم التسليم' ? 'success' : 'secondary')) ?>">
                                            <?= htmlspecialchars($order['status']) ?>
                                        </span>
                                    </td>
                                    <td><?= number_format($order['total_price'], 2) ?> جنيه</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="index.php?page=order_details&id=<?= $order['id'] ?>">
                                            <i class="fas fa-eye"></i> عرض
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="text-center">لم يتم تنفيذ أي طلب بعد.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

