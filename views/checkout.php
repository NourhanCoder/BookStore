<?php

require_once 'app/database/Database.php'; 
use App\Database\Database;

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if (empty($cart)) {
    header('Location: index.php?page=shop');
    exit();
}

$total = 0;
$savings = 0;
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إتمام الطلب</title>
    <link rel="stylesheet" href="public/assets/css/main.min.css">
</head>
<body>
    <main>
        <section class="section-container my-5 py-5 d-lg-flex">
            <div class="checkout__form-cont w-50 px-3 mb-5">
                <h4>الفاتورة</h4>
                <form class="checkout__form" action="index.php?page=order_success" method="POST">
                    <div class="d-flex gap-3 mb-3">
                        <div class="w-50">
                            <label for="first-name">الاسم الأول <span class="required">*</span></label>
                            <input class="form__input" type="text" id="first-name" name="first_name" required>
                        </div>
                        <div class="w-50">
                            <label for="last-name">الاسم الأخير <span class="required">*</span></label>
                            <input class="form__input" type="text" id="last-name" name="last_name" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="city">المدينة / المحافظة<span class="required">*</span></label>
                        <select class="form__input bg-transparent" id="city" name="city" required>
                            <option value="القاهرة">القاهرة</option>
                            <option value="الإسكندرية">الإسكندرية</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="address">العنوان بالكامل ( المنطقة -الشارع - رقم المنزل)<span class="required">*</span></label>
                        <input class="form__input" placeholder="رقم المنزل او الشارع / الحي" type="text" id="address" name="address" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone">رقم الهاتف<span class="required">*</span></label>
                        <input class="form__input" type="text" id="phone" name="phone" required>
                    </div>

                    <div class="mb-3">
                        <label for="email">البريد الإلكتروني (اختياري)</label>
                        <input class="form__input" type="email" id="email" name="email">
                    </div>

                    <div class="mb-3">
                        <h2>معلومات اضافية</h2>
                        <label for="notes">ملاحظات الطلب (اختياري)</label>
                        <textarea class="form__input" placeholder="ملاحظات حول الطلب, مثال: ملحوظة خاصة بتسليم الطلب." id="notes" name="notes"></textarea>
                    </div>

                    <input type="hidden" name="total_price" value="<?= $total ?>">
                    <button type="submit" class="primary-button w-100 py-2">تأكيد الطلب</button>
                </form>
            </div>

            <div class="checkout__order-details-cont w-50 px-3">
                <h4>طلبك</h4>
                <div>
                    <table class="w-100 checkout__table">
                        <thead>
                            <tr class="border-0">
                                <th>المنتج</th>
                                <th>المجموع</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart as $item): 
                                $itemTotal = (isset($item['qty']) ? $item['qty'] : 1) * $item['price'];
                                $total += $itemTotal;
                                
                                if (isset($item['old_price'])) {
                                    $savings += ($item['old_price'] - $item['price']) * (isset($item['qty']) ? $item['qty'] : 1);
                                }
                            ?>
                            <tr>
                                <td><?= $item['name'] ?> × <?= isset($item['qty']) ? $item['qty'] : 1 ?></td>
                                <td>
                                    <div class="product__price text-center d-flex gap-2 flex-wrap">
                                        <?php if (isset($item['old_price'])): ?>
                                            <span class="product__price product__price--old">
                                                <?= number_format($item['old_price'], 2) ?> جنيه
                                            </span>
                                        <?php endif; ?>
                                        <span class="product__price">
                                            <?= number_format($item['price'], 2) ?> جنيه
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <tr>
                                <th>المجموع</th>
                                <td class="fw-bolder"><?= number_format($total, 2) ?> جنيه</td>
                            </tr>
                            <?php if ($savings > 0): ?>
                            <tr class="bg-green">
                                <th>قمت بتوفير</th>
                                <td class="fw-bolder"><?= number_format($savings, 2) ?> جنيه</td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <th>الإجمالي</th>
                                <td class="fw-bolder"><?= number_format($total, 2) ?> جنيه</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="checkout__payment py-3 px-4 mb-3">
                    <p class="m-0 fw-bolder">الدفع نقدا عند الاستلام</p>
                </div>

                <p>الدفع عند التسليم مباشرة.</p>
            </div>
        </section>
    </main>

    <style>
        .required {
            color: red;
        }
        .checkout__table {
            border-collapse: collapse;
        }
        .checkout__table th,
        .checkout__table td {
            padding: 15px;
            border: 1px solid #ddd;
        }
        .bg-green {
            background-color: #e8f5e9;
        }
        .form__input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 5px;
        }
        .checkout__payment {
            background-color: #f5f5f5;
            border-radius: 4px;
        }
    </style>
</body>
</html>
