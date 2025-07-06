<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Home</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
  <div class="container">
    <h1>Welcome</h1>
    <p><a href="login.php">Login</a> | <a href="register.php">Register</a></p>
  </div>
</body>
</html>
