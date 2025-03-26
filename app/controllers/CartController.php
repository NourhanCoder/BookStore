<?php

namespace App\Controllers;

use App\Interfaces\CartInterface;
use App\Database\Database;
use PDO;

class CartController implements CartInterface
{
    private $pdo;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

      
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function addItem($id, $name, $price, $image, $quantity = 1)
    {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id) {
                $item['qty'] += $quantity;
                // Save to database if user is logged in
                if (isset($_SESSION['user_id'])) {
                    $this->updateCartItemInDatabase($id, $item['qty']);
                }
                return;
            }
        }
        
        $_SESSION['cart'][] = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'qty' => $quantity
        ];

        if (isset($_SESSION['user_id'])) {
            $this->addCartItemToDatabase($id, $quantity);
        }
    }

    private function addCartItemToDatabase($book_id, $quantity)
    {
        try {
        
            $stmt = $this->pdo->prepare("SELECT id, quantity FROM cart_items WHERE user_id = ? AND book_id = ?");
            $stmt->execute([$_SESSION['user_id'], $book_id]);
            $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingItem) {
                
                $newQuantity = $existingItem['quantity'] + $quantity;
                $stmt = $this->pdo->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
                $stmt->execute([$newQuantity, $existingItem['id']]);
            } else {
                // Insert new item if it doesn't exist
                $stmt = $this->pdo->prepare("INSERT INTO cart_items (user_id, book_id, quantity) VALUES (?, ?, ?)");
                $stmt->execute([$_SESSION['user_id'], $book_id, $quantity]);
            }
        } catch (\PDOException $e) {
            error_log("Error adding item to cart: " . $e->getMessage());
        }
    }

    private function updateCartItemInDatabase($book_id, $quantity)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE cart_items SET quantity = ? WHERE user_id = ? AND book_id = ?");
            $stmt->execute([$quantity, $_SESSION['user_id'], $book_id]);
        } catch (\PDOException $e) {
            error_log("Error updating cart item: " . $e->getMessage());
        }
    }

    public function updateQty($id, $qty)
    {
        if ($qty < 1) {
            $this->removeItem($id);
            return;
        }

        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id) {
                $item['qty'] = $qty;
                // Update database if user is logged in
                if (isset($_SESSION['user_id'])) {
                    $this->updateCartItemInDatabase($id, $qty);
                }
                return;
            }
        }
    }

    public function removeItem($id)
    {
        $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use($id) {
            return $item['id'] != $id;
        });

        
        if (isset($_SESSION['user_id'])) {
            try {
                $stmt = $this->pdo->prepare("DELETE FROM cart_items WHERE user_id = ? AND book_id = ?");
                $stmt->execute([$_SESSION['user_id'], $id]);
            } catch (\PDOException $e) {
                error_log("Error removing cart item: " . $e->getMessage());
            }
        }
    }

    public function getItems()
    {
   
       
        if (isset($_SESSION['user_id'])) {
            $this->syncCartWithDatabase();
        }
        return $_SESSION['cart'];
    }

    private function syncCartWithDatabase()
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT ci.book_id, ci.quantity, b.title as name, b.price, b.image 
                FROM cart_items ci 
                JOIN books b ON ci.book_id = b.id 
                WHERE ci.user_id = ?
            ");
            $stmt->execute([$_SESSION['user_id']]);
            $dbItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $_SESSION['cart'] = array_map(function($item) {
                return [
                    'id' => $item['book_id'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'image' => $item['image'],
                    'qty' => $item['quantity']
                ];
            }, $dbItems);
        } catch (\PDOException $e) {
            error_log("Error syncing cart with database: " . $e->getMessage());
        }
    }

    public function clearCart()
    {
        $_SESSION['cart'] = [];
        
        if (isset($_SESSION['user_id'])) {
            try {
                $stmt = $this->pdo->prepare("DELETE FROM cart_items WHERE user_id = ?");
                $stmt->execute([$_SESSION['user_id']]);
            } catch (\PDOException $e) {
                error_log("Error clearing cart: " . $e->getMessage());
            }
        }
    }
}