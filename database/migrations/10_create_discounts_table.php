<?php

class CreateDiscountsTable
{
    public function up($conn)
    {
        $sql = "CREATE TABLE IF NOT EXISTS discounts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            book_id INT NOT NULL,
            discount_percentage INT NOT NULL,
            start_date DATE,
            end_date DATE,
            FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
        )";

        $conn->exec($sql);
    }
}
