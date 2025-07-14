<?php
// UCID: yourUCID | Date: 2025-07-06
// File: public/index.php
// Purpose: Landing page with redirect if user logged in

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Redirect logged-in users to dashboard
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Welcome to Auth System</title>
  <link rel="stylesheet" href="../assets/styles.css" />
</head>
<body>
  <div class="container">
    <h1>Welcome to the Auth System</h1>
    <p><a href="login.php">Login</a> or <a href="register.php">Register</a> to continue.</p>
  </div>
</body>
</html>
