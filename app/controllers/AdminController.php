<?php

require_once __DIR__ . '/../models/Book.php';

class AdminController {
    public function addBook($data) {
        $bookModel = new Book();
        return $bookModel->createBook($data); // استدعاء دالة إضافة الكتاب
    }

    // public function getAllBooks() {
    //     $bookModel = new Book();
    //     return $bookModel->getAllBooks(); // جلب كل الكتب من الداتا بيز
    // }
}
?>
