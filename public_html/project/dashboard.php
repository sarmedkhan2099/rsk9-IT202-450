<?php
// UCID: yourUCID | Date: 2025-07-06
// File: public/dashboard.php
// Purpose: User dashboard showing welcome message and roles; protected page

require_once '../includes/auth.php';
checkLogin();

$user = $_SESSION['user'];
$roles = $_SESSION['roles'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Dashboard</title>
<link rel="stylesheet" href="../assets/styles.css" />
</head>
<body>
<div class="container">
    <h1>Welcome, <?= htmlspecialchars($user['username']) ?>!</h1>

    <p>You are logged in with the following roles:</p>
    <?php if (!empty($roles)): ?>
        <ul>
            <?php foreach ($roles as $role): ?>
                <li><?= htmlspecialchars($role) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p><em>No roles assigned.</em></p>
    <?php endif; ?>

    <p><a href="profile.php">View/Edit Profile</a> | <a href="logout.php">Logout</a></p>
</div>
</body>
</html>
