<?php
// UCID: yourUCID | Date: 2025-07-06
// File: includes/db.php
// Purpose: Database connection with PDO

$host = 'localhost';
$db   = 'auth_system';
$user = 'dbuser';
$pass = 'dbpassword';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Use real prepared statements
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    error_log("DB Connection failed: " . $e->getMessage());
    // Show friendly message on production
    exit('Sorry, a database error occurred.');
}
