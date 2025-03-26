<?php
require_once __DIR__ . '/../models/Favourite.php';
//require_once _DIR_ . '/../database/Database.php';

use App\Database\Database;

class FavouriteController
{
    private $favouriteModel;
    private $db;

    public function __construct()
    {
        $this->favouriteModel = new Favourite();
        $database = new Database();
        $this->db = $database->getConnection();
    }

   
    public function getUserFavourites($user_id)
    {
        return $this->favouriteModel->getUserFavourites($user_id);
    }

   
    public function addToFavourite()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            if ($this->isAjaxRequest()) {
                echo json_encode(['success' => false, 'message' => 'يجب تسجيل الدخول أولاً']);
                return;
            }
            $_SESSION['error'] = "يجب تسجيل الدخول أولاً";
            header("Location: index.php?page=login");
            exit();
        }

        if (!isset($_POST['book_id'])) {
            if ($this->isAjaxRequest()) {
                echo json_encode(['success' => false, 'message' => 'لم يتم تحديد الكتاب']);
                return;
            }
            $_SESSION['error'] = "لم يتم تحديد الكتاب";
            header("Location: index.php?page=shop");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $bookId = $_POST['book_id'];

        // Check if book is already in favorites
        $stmt = $this->db->prepare("SELECT * FROM favorites WHERE user_id = ? AND book_id = ?");
        $stmt->execute([$userId, $bookId]);
        
        if ($stmt->rowCount() > 0) {
            if ($this->isAjaxRequest()) {
                echo json_encode(['success' => false, 'message' => 'الكتاب موجود بالفعل في المفضلة']);
                return;
            }
            $_SESSION['error'] = "الكتاب موجود بالفعل في المفضلة";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }

        // Add to favorites
        $stmt = $this->db->prepare("INSERT INTO favorites (user_id, book_id) VALUES (?, ?)");
        $success = $stmt->execute([$userId, $bookId]);

        if ($success) {
            if ($this->isAjaxRequest()) {
                echo json_encode(['success' => true, 'message' => 'تم إضافة الكتاب للمفضلة بنجاح']);
                return;
            }
            $_SESSION['success'] = "تم إضافة الكتاب للمفضلة بنجاح";
        } else {
            if ($this->isAjaxRequest()) {
                echo json_encode(['success' => false, 'message' => 'حدث خطأ أثناء إضافة الكتاب للمفضلة']);
                return;
            }
            $_SESSION['error'] = "حدث خطأ أثناء إضافة الكتاب للمفضلة";
        }

        if (!$this->isAjaxRequest()) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    private function isAjaxRequest() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public function removeFromFavourite($user_id, $book_id)
    {
        if (!$user_id) {
            $_SESSION['error'] = " يجب تسجيل الدخول أولاً!";
            header("Location: index.php?page=login");
            exit();
        }

        $message = $this->favouriteModel->removeFromFavourite($user_id, $book_id);
        $_SESSION['message'] = $message;
        header("Location: index.php?page=favourites");
        exit();
        
    }
}