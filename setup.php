<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

try {
    // Connect without database selected
    $pdo = new PDO("mysql:host=$host;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS fannet_db");
    echo "Database 'fannet_db' created or already exists.<br>";

    // Select database
    $pdo->exec("USE fannet_db");

    // Create users table
    $sqlUsers = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sqlUsers);
    echo "Table 'users' created or already exists.<br>";

    // Create login_attempts table
    $sqlAttempts = "CREATE TABLE IF NOT EXISTS login_attempts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        ip_address VARCHAR(45) NOT NULL,
        attempt_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        is_success BOOLEAN NOT NULL DEFAULT FALSE
    )";
    $pdo->exec($sqlAttempts);
    echo "Table 'login_attempts' created or already exists.<br>";

    echo "<br><strong>Setup completed successfully!</strong> You can now <a href='register.php'>Register</a> or <a href='login.php'>Login</a>.";

} catch (PDOException $e) {
    die("DB ERROR: " . $e->getMessage());
}
?>
