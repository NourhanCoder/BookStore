<?php

namespace App\Controllers;

require_once 'app/database/Database.php';

use App\Database\Database;
use PDO;

class CheckoutController {
    private $pdo;
    private $errors = [];

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function processCheckout() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user_id = $_SESSION['user_id'] ?? null;
            $total_price = $_POST['total_price'] ?? 0;
            
            if (!$user_id) {
                $this->errors[] = "يجب تسجيل الدخول قبل إتمام الطلب.";
            }

            if ($total_price <= 0) {
                $this->errors[] = "إجمالي السعر غير صالح.";
            }

            if (empty($_SESSION['cart'])) {
                $this->errors[] = "السلة فارغة.";
            }

            if (empty($this->errors)) {
                try {
                    $this->pdo->beginTransaction();
                    
                    $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
                    $stmt->execute([$user_id, $total_price]);
                    $order_id = $this->pdo->lastInsertId();

                    foreach ($_SESSION['cart'] as $item) {
                        $stmt = $this->pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                        $stmt->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);
                    }

                    $this->pdo->commit();
                    unset($_SESSION['cart']);
                    $_SESSION['success_message'] = "تم إتمام الطلب بنجاح!";
                    header("Location: index.php?page=checkout");
                    exit();
                } catch (\PDOException $e) {
                    $this->pdo->rollBack();
                    $this->errors[] = "حدث خطأ أثناء إتمام الطلب.";
                }
            }
            return $this->errors;
        }
        return [];
    }
}

$checkoutController = new CheckoutController();
$checkoutController->processCheckout();
?>

