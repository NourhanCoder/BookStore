<?php

class CreateContactsTable
{
    public function up($conn)
    {
        $sql = "CREATE TABLE IF NOT EXISTS contacts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            phone VARCHAR(20) NOT NULL,
            email VARCHAR(255) NOT NULL,
            reason ENUM('استفسار','استبدال','استرجاع','استعجال اوردر', 'شكوى', 'اقتراح', 'أخرى') NOT NULL,
            message TEXT NOT NULL,
            is_read TINYINT(1) DEFAULT 0, 
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $conn->exec($sql);
    }
}
