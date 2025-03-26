<?php
session_start();
use Database\DatabaseManager;
use Database\MigrationManager;

require_once "./vendor/autoload.php";

DatabaseManager::initialize();
MigrationManager::runMigrations();

require_once "./routes/web.php"; 

require_once "./includes/header.php";

require_once "./includes/nav.php";


//require_once "./includes/footer.php"; 

?>

