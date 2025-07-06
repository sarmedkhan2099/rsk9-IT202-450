<?php
// UCID: yourUCID | Date: 2025-07-06
// File: public/login.php
// Purpose: User login with validation and session creation

session_start();
require_once '../includes/db.php';

$errors = [];
$loginId = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginId = trim($_POST['login_id'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$loginId) {
        $errors[] = "Please enter your username or email.";
    }
    if (!$password) {
        $errors[] = "Please enter your password.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$loginId, $loginId]);
        $user = $stmt->fetch();

        if (!$user) {
            $errors[] = "No account found with that username or email.";
        } elseif (!password_verify($password, $user['password'])) {
            $errors[] = "Incorrect password. Please try again.";
        } else {
            // Set session
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email']
            ];

            // Load roles
            $roleStmt = $pdo->prepare(
                "SELECT r.name FROM roles r
                 JOIN user_roles ur ON r.id = ur.role_id
                 WHERE ur.user_id = ? AND ur.is_active = 1"
            );
            $roleStmt->execute([$user['id']]);
            $_SESSION['roles'] = $roleStmt->fetchAll(PDO::FETCH_COLUMN);

            header("Location: dashboard.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Login</title>
<link rel="stylesheet" href="../assets/styles.css" />
<script>
function validateLogin() {
    const loginId = document.forms["loginForm"]["login_id"].value.trim();
    const password = document.forms["loginForm"]["password"].value;
    let errors = [];

    if (!loginId) errors.push("Username or email is required.");
    if (!password) errors.push("Password is required.");

    if (errors.length > 0) {
        alert(errors.join("\n"));
        return false;
    }
    return true;
}
</script>
</head>
<body>
<div class="container">
    <h2>Login</h2>

    <?php if (!empty($errors)): ?>
    <div class="alert error">
        <ul>
            <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
    <div class="alert success"><?= htmlspecialchars($_SESSION['success']) ?></div>
    <?php unset($_SESSION['success']); endif; ?>

    <form name="loginForm" method="POST" onsubmit="return validateLogin();">
        <label for="login_id">Username or Email</label>
        <input
            type="text"
            id="login_id"
            name="login_id"
            required
            value="<?= htmlspecialchars($loginId) ?>"
        />

        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            required
        />

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a>.</p>
</div>
</body>
</html>
