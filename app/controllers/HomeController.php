<?php

require_once __DIR__ . '/../models/Book.php';



class HomeController {
    public function index() {
        $bookModel = new Book();
        
        return $bookModel->getSliderBooks(4); 
    }

    public function getDiscountedBooks() {
        $bookModel = new Book();
        return $bookModel->getDiscountedBooks(4); 
    }

    public function getNewestBooks() {
        $bookModel = new Book();
        return $bookModel->getNewestBooks(4);
    }

    public function getClosestOfferEndTime() {
        $bookModel = new Book();
        return $bookModel->getClosestOfferEndTime();
    }

    public function getBestSellingBooks() {
        $bookModel = new Book();
        return $bookModel->getBestSellingBooks(4);
    }
    

}