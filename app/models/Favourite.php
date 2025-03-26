<?php

use Database\DatabaseManager;
require_once __DIR__ . '/../../database/DatabaseManager.php';

class Favourite {
    private $db;

    public function __construct() {
        $this->db = DatabaseManager::getConnection();
       // var_dump($this->db); //  طباعة للتحقق من الاتصال بقاعدة البيانات
    }

    
    public function addToFavourite($user_id, $book_id) {
        try {
        
           
            $stmt = $this->db->prepare("SELECT id FROM favorites WHERE user_id = :user_id AND book_id = :book_id");
            $stmt->execute([':user_id' => $user_id, ':book_id' => $book_id]);

            if ($stmt->fetch()) {
                throw new Exception(" هذا الكتاب موجود بالفعل في المفضلة!");
            }

            
            $stmt = $this->db->prepare("INSERT INTO favorites (user_id, book_id) VALUES (:user_id, :book_id)");
            $stmt->execute([':user_id' => $user_id, ':book_id' => $book_id]);

            return " تم إضافة الكتاب إلى المفضلة بنجاح!";
        } catch (Exception $e) {
            return "error " . $e->getMessage();
        }
    }

   
    public function getUserFavourites($user_id) {
        try {
            $stmt = $this->db->prepare("
                SELECT books.* 
                FROM favorites 
                JOIN books ON favorites.book_id = books.id 
                WHERE favorites.user_id = :user_id
            ");
            $stmt->execute([':user_id' => $user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (Exception $e) {
            return " فشل في جلب الكتب المفضلة: " . $e->getMessage();
        }
    }

    public function removeFromFavourite($user_id, $book_id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM favorites WHERE user_id = :user_id AND book_id = :book_id");
            $stmt->execute([':user_id' => $user_id, ':book_id' => $book_id]);

            if ($stmt->rowCount() > 0) {
                return " تم حذف الكتاب من المفضلة!";
            } else {
                throw new Exception(" الكتاب غير موجود في المفضلة!");
            }
        } catch (Exception $e) {
            return "error " . $e->getMessage();
        }
    }
    
}