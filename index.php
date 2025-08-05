<?php
// UCID: YOUR_UCID
// index.php - Required for Heroku PHP detection

session_start();
$user = $_SESSION["user"] ?? null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome to the Film App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h1 class="mb-4">Studio Ghibli Film App</h1>

    <?php if ($user): ?>
        <p class="alert alert-success">Welcome, <?= htmlspecialchars($user["username"]) ?>!</p>
        <a href="dashboard.php" class="btn btn-primary">Go to Dashboard</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    <?php else: ?>
        <p class="alert alert-info">Please login or register to begin.</p>
        <a href="login.php" class="btn btn-primary">Login</a>
        <a href="register.php" class="btn btn-secondary">Register</a>
    <?php endif; ?>
</body>
</html>
