<?php

namespace App\Controllers;

require_once __DIR__ . '/../database/Database.php';

use App\Database\Database;
use PDO;

class SearchController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function search($query) {
        try {
            $query = '%' . trim($query) . '%';
            
            // Debug: Print the search query
            error_log("Searching for: " . $query);
            
            // First try exact book title match
            $sql = "SELECT * FROM books WHERE title LIKE :query";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam(':query', $query);
            $stmt->execute();
            $exactTitleMatches = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Debug: Print number of title matches
            error_log("Title matches found: " . count($exactTitleMatches));
            
            if (!empty($exactTitleMatches)) {
                return [
                    'type' => 'exact_title',
                    'results' => $exactTitleMatches
                ];
            }
            
            // If no exact title match, try author search
            $sql = "SELECT * FROM books WHERE author LIKE :query";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam(':query', $query);
            $stmt->execute();
            $authorMatches = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Debug: Print number of author matches
            error_log("Author matches found: " . count($authorMatches));
            
            if (!empty($authorMatches)) {
                return [
                    'type' => 'author',
                    'results' => $authorMatches
                ];
            }
            
            // If no matches found, return empty results
            return [
                'type' => 'no_results',
                'results' => []
            ];
        } catch (\PDOException $e) {
            error_log("Search error: " . $e->getMessage());
            error_log("SQL State: " . $e->getCode());
            return [
                'type' => 'error',
                'message' => 'حدث خطأ أثناء البحث',
                'results' => []
            ];
        }
    }
} 