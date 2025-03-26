<?php
namespace App\Controllers;

require_once 'app/database/Database.php';


use App\Database\Database;
use PDO;

class ContactController {
    private $pdo;
    private $errors = [];

    public function __construct() {
        $db = new Database(); 
        $this->pdo = $db->getConnection();
    }

    public function handleContactForm() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
            $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $reason = isset($_POST['reason']) ? trim($_POST['reason']) : '';
            $message = isset($_POST['message']) ? trim($_POST['message']) : '';

            // التحقق من صحة البيانات
            $this->validateForm($name, $phone, $email, $reason, $message);

            if (empty($this->errors)) {
                try {
                    $stmt = $this->pdo->prepare("INSERT INTO contacts (name, phone, email, reason, message) VALUES (?, ?, ?, ?, ?)");
                    if ($stmt->execute([$name, $phone, $email, $reason, $message])) {
                        $_SESSION['success_message'] = "تم إرسال رسالتك بنجاح!";
                        header("Location: index.php?page=contact");
                        exit();
                    }
                } catch (\PDOException $e) {
                    $this->errors[] = "حدث خطأ أثناء إرسال الرسالة. الرجاء المحاولة مرة أخرى.";
                }
            }

            return $this->errors;
        }
        return [];
    }

    private function validateForm($name, $phone, $email, $reason, $message) {
        // التحقق من الاسم
        if (empty($name)) {
            $this->errors[] = "الاسم مطلوب.";
        }

        // التحقق من رقم الهاتف
        if (empty($phone)) {
            $this->errors[] = "رقم الهاتف مطلوب.";
        } elseif (!preg_match("/^[0-9]{10,15}$/", $phone)) {
            $this->errors[] = "رقم الهاتف غير صحيح.";
        }

        
        if (empty($email)) {
            $this->errors[] = "البريد الإلكتروني مطلوب.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "البريد الإلكتروني غير صحيح.";
        }

        
        if (empty($reason)) {
            $this->errors[] = "يجب اختيار سبب التواصل.";
        }

        
        if (empty($message)) {
            $this->errors[] = "نص الرسالة مطلوب.";
        }
    }

    public function getErrors() {
        return $this->errors;
    }
}


$contactController = new ContactController();
$contactController->handleContactForm();
?>



