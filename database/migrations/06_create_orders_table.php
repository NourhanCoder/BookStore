<?php

class CreateOrdersTable
{
    public function up($conn)
    {
        $sql = "CREATE TABLE IF NOT EXISTS orders (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            total_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            status ENUM('pending', 'completed', 'canceled') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )";
        $conn->exec($sql);
    }
}
