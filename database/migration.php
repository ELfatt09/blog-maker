<?php
include 'connection.php';

$queries = [
    "CREATE TABLE IF NOT EXISTS accounts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        is_admin BOOLEAN DEFAULT false
    )",
    "CREATE TABLE IF NOT EXISTS blog (
        id INT AUTO_INCREMENT PRIMARY KEY,
        judul VARCHAR(510) NOT NULL,
        type VARCHAR(225) NOT NULL,
        header_img_path VARCHAR(255),
        isi TEXT NOT NULL,
        author_id INT NOT NULL,
        FOREIGN KEY (author_id) REFERENCES accounts(id),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
];

foreach ($queries as $query) {
    if ($conn->query($query)) {
        echo "Table created successfully\n";
    } else {
        echo "Error creating table: " . $conn->error . "\n";
    }
}
$query = "INSERT INTO accounts (username, password, is_admin) VALUES ('admin', '" . password_hash('admin123', PASSWORD_DEFAULT) . "', true) ON DUPLICATE KEY UPDATE is_admin = true";
if ($conn->query($query)) {
    echo "Successfully make first user as admin\n
    username: admin\n
    password: admin123\n";
} else {
    echo "Error making first user as admin: " . $conn->error . "\n";
}

