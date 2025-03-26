<?php
require_once __DIR__ . '/../database/Database.php';

use App\Database\Database;

class AccountDetailsController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getUserDetails() {
        $user_id = $_SESSION['user_id'] ?? 1;

        $pdo = $this->db->getConnection();
        $stmt = $pdo->prepare("SELECT first_name, last_name, display_name, email FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUserDetails($data) {
        $user_id = $_SESSION['user_id'] ?? 1;
        $pdo = $this->db->getConnection();

        
        $first_name = htmlspecialchars(trim($data['first_name']));
        $last_name = htmlspecialchars(trim($data['last_name']));
        $display_name = htmlspecialchars(trim($data['display_name']));
        $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);

        if (!$email) {
            $_SESSION['message'] = " البريد الإلكتروني غير صالح!";
            $_SESSION['message_type'] = "danger";
            header("Location:index.php?page=account_details");
            exit();
        }

       
        $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, display_name = ?, email = ? WHERE id = ?");
        if ($stmt->execute([$first_name, $last_name, $display_name, $email, $user_id])) {
            $_SESSION['message'] = " تم تعديل بيانات الحساب بنجاح!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = " حدث خطأ أثناء التعديل!";
            $_SESSION['message_type'] = "danger";
        }

        header("Location:index.php?page=account_details");
        exit();
    }

    public function changePassword($data) {
        $user_id = $_SESSION['user_id'] ?? 1;
        $pdo = $this->db->getConnection();

        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!password_verify($data['current_password'], $user['password'])) {
            $_SESSION['message'] = " كلمة المرور الحالية غير صحيحة!";
            $_SESSION['message_type'] = "danger";
            header("Location:index.php?page=account_details");
            exit();
        }

        if ($data['new_password'] !== $data['confirm_password']) {
            $_SESSION['message'] = " كلمتا المرور غير متطابقتين!";
            $_SESSION['message_type'] = "warning";
            header("Location:index.php?page=account_details");
            exit();
        }

        $new_password_hashed = password_hash($data['new_password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        if ($stmt->execute([$new_password_hashed, $user_id])) {
            $_SESSION['message'] = " تم تغيير كلمة المرور بنجاح!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = " حدث خطأ أثناء تغيير كلمة المرور!";
            $_SESSION['message_type'] = "danger";
        }

        header("Location:index.php?page=account_details");
        exit();
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new AccountDetailsController();

    if (isset($_POST['update'])) {
        $controller->updateUserDetails($_POST);
    } elseif (isset($_POST['change_password'])) {
        $controller->changePassword($_POST);
    }
}
?>
