<?php
// UCID: YOUR_UCID
// Date: 2025-07-28
// Description: Dashboard landing page (protected)

session_start();
require_once "db.php";
require_once "functions.php";

function require_login() {
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
        exit();
    }
}
$user = $_SESSION["user"];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>
<p>You are logged in.</p>
<p><a href="profile.php">View Profile</a> | <a href="logout.php">Logout</a></p>
</body>
</html>
