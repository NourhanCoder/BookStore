<?php
require_once 'app/database/Database.php';

use App\Database\Database;



class ShopController {
    private $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function getBooksByCategory($categoryName) {
        $query = "SELECT books.* FROM books 
                  JOIN categories ON books.category_id = categories.id 
                  WHERE categories.name = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$categoryName]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllBooks() {
        $stmt = $this->pdo->query("SELECT * FROM books");
        return $stmt->fetchAll();
    }
    
    
    

    public function addToFavourites($userId, $bookId) {
        $stmt = $this->pdo->prepare("INSERT INTO favorites (user_id, book_id) VALUES (?, ?)");
        return $stmt->execute([$userId, $bookId]);
    }
}
