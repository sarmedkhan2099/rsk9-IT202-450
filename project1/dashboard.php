<?php
session_start();
require_once '../includes/auth.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php?msg=login_required");
    exit;
}

$user = $_SESSION['user'];
$roles = $_SESSION['roles'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 1rem; }
    nav { margin-bottom: 2rem; }
    .roles { list-style: none; padding: 0; }
    .roles li { background: #f0f0f0; margin: 0.3rem 0; padding: 0.5rem; }
  </style>
</head>
<body>
  <nav>
    <a href="logout.php">Logout</a>
  </nav>

  <h1>Welcome, <?= htmlspecialchars($user['username']) ?>!</h1>

  <p>Email: <?= htmlspecialchars($user['email']) ?></p>

  <h2>Your Roles</h2>
  <?php if (count($roles) > 0): ?>
    <ul class="roles">
      <?php foreach ($roles as $role): ?>
        <li><?= htmlspecialchars($role) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p>You have no assigned roles.</p>
  <?php endif; ?>
</body>
</html>
