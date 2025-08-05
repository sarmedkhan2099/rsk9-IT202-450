<?php
// db.php

$host = 'localhost';
$dbname = 'your_database_name';
$user = 'your_username';
$pass = 'your_password';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // In production, don't show errors directly
    die("Database connection failed: " . $e->getMessage());
}
