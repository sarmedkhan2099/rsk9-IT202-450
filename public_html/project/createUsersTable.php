<?php
include("db.php");

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
)";
if ($conn->query($sql)) {
    echo "Table created or already exists.";
} else {
    echo "Error: " . $conn->error;
}
?>
