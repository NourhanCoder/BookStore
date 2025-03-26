<?php
require_once __DIR__ . '/../app/database/Database.php';
require_once __DIR__ . '/../app/controllers/OrderController.php';

use App\Controllers\OrderController;

// Check if user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$orderId = $_GET['id'] ?? null;

if (!$orderId) {
    header('Location: /orders.php');
    exit();
}

$orderController = new OrderController();
$orderItems = $orderController->getOrderDetails($orderId, $userId);

if (empty($orderItems)) {
    header('Location: /orders.php');
    exit();
}

$order = [
    'id' => $orderItems[0]['order_id'],
    'total_price' => $orderItems[0]['total_price'],
    'status' => $orderItems[0]['status'],
    'created_at' => $orderItems[0]['created_at']
];


?>

<section class="section-container">
    <p>تم تقديم الطلب #<?= $order['id'] ?> في <?= date('Y-m-d', strtotime($order['created_at'])) ?> وهو الآن بحالة <?= $order['status'] === 'pending' ? 'قيد التنفيذ' : ($order['status'] === 'completed' ? 'مكتمل' : 'ملغي') ?></p>

    <section>
    <h2 style="margin-top: 80px;">تفاصيل الطلب</h2>

        <table class="success__table w-100 mb-5">
            <thead>
                <tr class="border-0 bg-main text-white">
                    <th>المنتج</th>
                    <th class="d-none d-md-table-cell">الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderItems as $item): ?>
                    <tr>
                        <td>
                            <div>
                                <a href="/book.php?id=<?= $item['book_id'] ?>"><?= $item['book_title'] ?></a> x <?= $item['quantity'] ?>
                            </div>
                        </td>
                        <td>
                            <?= number_format($item['price_at_purchase'] * $item['quantity'], 2) ?> جنيه
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <th>الإجمالي:</th>
                    <td class="fw-bold"><?= number_format($order['total_price'], 2) ?> جنيه </td>
                </tr>
            </tbody>
        </table>
    </section>
</section>


<?php include 'includes/footer.php'; ?>
