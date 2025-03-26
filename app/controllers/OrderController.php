<?php
namespace App\Controllers;

use App\Database\Database;
use PDO;
use PDOException;


class OrderController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    
    public function getUserOrders($userId) {
        try {
            $query = "
                SELECT o.*, COUNT(oi.id) as item_count 
                FROM orders o 
                LEFT JOIN order_items oi ON o.id = oi.order_id 
                WHERE o.user_id = ? 
                GROUP BY o.id 
                ORDER BY o.created_at DESC
            ";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching user orders: " . $e->getMessage());
            return false;
        }
    }

    
    public function getOrderDetails($orderId, $userId) {
        try {
            $query = "
                SELECT o.*, oi.*, b.title as book_title, b.image as book_image
                FROM orders o 
                JOIN order_items oi ON o.id = oi.order_id 
                JOIN books b ON oi.book_id = b.id
                WHERE o.id = ? AND o.user_id = ?
            ";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute([$orderId, $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching order details: " . $e->getMessage());
            return false;
        }
    }

     
    public function createOrder($userId, $items, $totalPrice) {
        try {
            $this->db->beginTransaction();

            // Insert order
            $orderQuery = "INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'pending')";
            $stmt = $this->db->prepare($orderQuery);
            $stmt->execute([$userId, $totalPrice]);
            $orderId = $this->db->lastInsertId();

            // Insert order items
            $itemQuery = "INSERT INTO order_items (order_id, book_id, quantity, price_at_purchase) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($itemQuery);
            
            foreach ($items as $item) {
                $stmt->execute([
                    $orderId,
                    $item['book_id'],
                    $item['quantity'],
                    $item['price']
                ]);
            }

            $this->db->commit();
            return $orderId;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error creating order: " . $e->getMessage());
            return false;
        }
       // die("The function for saving orders is being executed!");

    }


    public function updateOrderStatus($orderId, $userId, $status) {
        try {
            $query = "UPDATE orders SET status = ? WHERE id = ? AND user_id = ?";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$status, $orderId, $userId]);
        } catch (PDOException $e) {
            error_log("Error updating order status: " . $e->getMessage());
            return false;
        }
    }

    
    public function cancelOrder($orderId, $userId) {
        return $this->updateOrderStatus($orderId, $userId, 'canceled');
    }

    public function getStatusInArabic($status) {
        $statusMap = [
            'pending' => 'قيد التنفيذ',
            'completed' => 'مكتمل',
            'canceled' => 'ملغي'
        ];
        return $statusMap[$status] ?? $status;
    }
}