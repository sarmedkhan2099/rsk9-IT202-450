<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: Dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Film Manager - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Welcome to the Data Management System</h1>
    <p>Please <a href="Login.php">Login</a> or <a href="Register.php">Register</a> to continue.</p>
</body>
</html>
