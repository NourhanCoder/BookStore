<?php
use Database\DatabaseManager;
require_once __DIR__ . '/../../database/DatabaseManager.php';

class Book {
    private $db;

    public function __construct() {
        $this->db = DatabaseManager::getConnection();
    }
    public function getSliderBooks($limit = 4): array {
        $stmt = $this->db->prepare("SELECT * FROM books ORDER BY id DESC LIMIT :limit");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $books ?: [];
    }

    public function getDiscountedBooks($limit = 4): array {
        $stmt = $this->db->prepare("
            SELECT books.*, MAX(discounts.discount_percentage) as discount_percentage
            FROM books
            LEFT JOIN discounts ON books.id = discounts.book_id
            WHERE discounts.discount_percentage > 0 
            AND (discounts.end_date IS NULL OR discounts.end_date >= CURDATE())
            GROUP BY books.id
            ORDER BY books.id DESC 
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getNewestBooks($limit = 4): array {
        $stmt = $this->db->prepare("
            SELECT books.*, discounts.discount_percentage 
            FROM books
            LEFT JOIN discounts ON books.id = discounts.book_id
            ORDER BY books.id DESC 
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getClosestOfferEndTime() {
        $stmt = $this->db->prepare("
            SELECT MIN(end_date) AS closest_end_date 
            FROM discounts 
            WHERE end_date IS NOT NULL AND end_date >= CURDATE()
        ");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['closest_end_date'] ?? null; 
    }

    public function getBestSellingBooks($limit = 4): array {
        $stmt = $this->db->prepare("
            SELECT books.*, SUM(order_items.quantity) AS total_sales
            FROM books
            JOIN order_items ON books.id = order_items.book_id
            GROUP BY books.id
            ORDER BY total_sales DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
    
    public function createBook($data) {
        $stmt = $this->db->prepare("
            INSERT INTO books (title, author, price, image) 
            VALUES (:title, :author, :price, :image)
        ");
        return $stmt->execute([
            ':title'  => $data['title'],
            ':author' => $data['author'],
            ':price'  => $data['price'],
            ':image'  => $data['image']
        ]);
    }
    
    
    

    }
    
    // public function getSliderBooks($limit = 8) {
    //     $stmt = $this->db->prepare("SELECT * FROM books ORDER BY id DESC LIMIT ?");
    //     $stmt->bindParam(1, $limit, PDO::PARAM_INT);
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }



