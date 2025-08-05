<?php
include("db.php");

$username = "testuser";
$password = password_hash("Test123!", PASSWORD_DEFAULT); // hashed for security

$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);

if ($stmt->execute()) {
    echo "Fake user inserted successfully.";
} else {
    echo "Error: " . $stmt->error;
}
?>
