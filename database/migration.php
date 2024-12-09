<?php
include 'connection.php';

$queries = [
    "CREATE TABLE IF NOT EXISTS accounts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL UNIQUE,
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
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (author_id) REFERENCES accounts(id) ON DELETE CASCADE
    )",
    "CREATE TABLE IF NOT EXISTS comments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        blog_id INT NOT NULL,
        author_id INT NOT NULL,
        comment TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (blog_id) REFERENCES blog(id) ON DELETE CASCADE,
        FOREIGN KEY (author_id) REFERENCES accounts(id) ON DELETE CASCADE
    )"
];

foreach ($queries as $query) {
    if ($conn->query($query)) {
        echo "Table created successfully\n";
    } else {
        echo "Error creating table: " . $conn->error . "\n";
    }
}

$stmt = $conn->prepare("INSERT INTO accounts (username, password, is_admin) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE is_admin = true");
$username = 'admin';
$password = password_hash('admin123', PASSWORD_DEFAULT);
$is_admin = true;
$stmt->bind_param('ssi', $username, $password, $is_admin);
if ($stmt->execute()) {
    echo "Successfully make first user as admin\n
    username: admin<br>
    password: admin123<br>";
} else {
    echo "Error making first user as admin: " . $stmt->error . "\n";
}

$stmt->close();
$conn->close();

