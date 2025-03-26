<?php

require_once 'app/controllers/HomeController.php';
require_once 'app/controllers/AccountController.php';
require_once 'app/controllers/AccountDetailsController.php';
require_once 'app/controllers/SingleProductController.php';
include 'app/controllers/FavouriteController.php';
require_once  'app/controllers/ContactController.php';
require_once 'app/controllers/ShopController.php';

require_once 'app/controllers/AboutController.php';

require_once 'app/controllers/LogoutController.php';

require_once 'app/models/User.php';
require_once 'app/database/Database.php';
//require_once 'views/process_order.php';


$page = isset($_GET['page']) ? $_GET['page'] : "home";

switch ($page) {
    case 'home':
        include "./views/home.php";
        break;
    case 'register':
    case 'login':
        include "./views/Acount.php";
        break;

    case 'single-product':
        include './views/single-product.php';
        break;
    case 'favourites':
        include "./views/favourites.php";
        break;
    case 'add-favourite':
        $favouriteController = new FavouriteController();
        $favouriteController->addToFavourite();
        break;
    case 'remove-favourite':
        $favouriteController = new FavouriteController();
        $favouriteController->removeFromFavourite($_SESSION['user_id'], $_POST['book_id']);
        break;


    case 'account_details':
        include "views/account_datails.php";
        break;
    case 'all_books':
        require_once 'views/all-books.php';
        break;
    case 'arabic_books':
        require_once 'views/arabic_books.php';
        break;
    case 'english_books':
        require_once 'views/english_books.php';
        break;

    case 'contact':
        include "./views/contact.php";
        break;
    case 'order_success':
        include "./views/order_success.php";
        break;
    case 'orders':
        include "./views/orders.php";
        break;
    case 'order_details':
        include "./views/order-details.php";
        break;
    case 'about':
        include "./views/about.php";
        break;
    case 'branches':
        include "./views/branches.php";
        break;
    case 'cart':
        include "./views/cart.php";
        break;
    case 'checkout':
        include "./views/checkout.php";
        break;
    case 'logout':
        include "./views/logout.php";
        break;
    case 'search_results':
        include "./views/search_results.php";
        break;
}
