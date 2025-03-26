<?php
namespace App\Models;
require_once __DIR__. '/../database/Database.php';

use App\Database\Database;
use PDO;

class User {
    private $db;
    private $conn;

    public function __construct() {
       
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    
    public function emailExists($email) {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }

   
    public function register($name, $email, $password, $confirm_password) {
        if ($password !== $confirm_password) {
            $_SESSION['message'] = " كلمة المرور غير متطابقة!";
            $_SESSION['message_type'] = "danger"; 
            return false;
        }

        if ($this->emailExists($email)) {
            $_SESSION['message'] = " البريد الإلكتروني مسجل مسبقًا.";
            $_SESSION['message_type'] = "warning"; 
            return false;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (first_name, email, password) VALUES (?, ?, ?)");

        if ($stmt->execute([$name, $email, $hashed_password])) {
            $_SESSION['message'] = " تم التسجيل بنجاح! يمكنك تسجيل الدخول الآن.";
            $_SESSION['message_type'] = "success"; 
            return true;
        } else {
            $_SESSION['message'] = " حدث خطأ أثناء التسجيل.";
            $_SESSION['message_type'] = "danger"; 
            return false;
        }
    }

    
    public function login($email, $password, $remember) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'];

            if ($remember) {
                setcookie("user_email", $email, time() + (86400 * 30), "/");
            }

            $_SESSION['message'] = " تم تسجيل الدخول بنجاح!";
            $_SESSION['message_type'] = "success"; 
            return true;
        } else {
            $_SESSION['message'] = " البريد أو كلمة المرور غير صحيحة.";
            $_SESSION['message_type'] = "danger"; 
            return false;
        }
    }
}
?>
