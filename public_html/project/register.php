<?php
// UCID: yourUCID | Date: 2025-07-06
// File: public/register.php
// Purpose: User registration with HTML, JS, PHP validation, password hashing, sticky form

session_start();
require_once '../includes/db.php';

$errors = [];
$username = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs for sticky form
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // PHP validation
    if (!$username) {
        $errors[] = "Username is required.";
    }
    if (!$email) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email format is invalid.";
    }
    if (!$password) {
        $errors[] = "Password is required.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Check if username or email already exists
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $errors[] = "Username or email is already taken.";
        }
    }

    // Insert user if no errors
    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, created, modified) VALUES (?, ?, ?, NOW(), NOW())");
        if ($stmt->execute([$username, $email, $hash])) {
            $_SESSION['success'] = "Registration successful. You can now log in.";
            header("Location: login.php");
            exit;
        } else {
            $errors[] = "Something went wrong. Please try again.";
            error_log("Register insert failed for $username/$email");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Register</title>
<link rel="stylesheet" href="../assets/styles.css" />
<script>
function validate() {
    const username = document.forms["registerForm"]["username"].value.trim();
    const email = document.forms["registerForm"]["email"].value.trim();
    const password = document.forms["registerForm"]["password"].value;
    const confirm = document.forms["registerForm"]["confirm_password"].value;
    let errors = [];

    if (!username) errors.push("Username is required.");
    if (!email) errors.push("Email is required.");
    else {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!re.test(email)) errors.push("Email format is invalid.");
    }
    if (!password) errors.push("Password is required.");
    if (password !== confirm) errors.push("Passwords do not match.");

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
    <h2>Register</h2>
    <?php if (!empty($errors)): ?>
    <div class="alert error">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <form name="registerForm" method="POST" onsubmit="return validate();">
        <label for="username">Username</label>
        <input
            type="text"
            id="username"
            name="username"
            required
            value="<?= htmlspecialchars($username) ?>"
            pattern="^[a-zA-Z0-9_]{3,20}$"
            title="3-20 characters: letters, numbers, underscore only"
        />

        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            required
            value="<?= htmlspecialchars($email) ?>"
        />

        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            required
            minlength="6"
            title="At least 6 characters"
        />

        <label for="confirm_password">Confirm Password</label>
        <input
            type="password"
            id="confirm_password"
            name="confirm_password"
            required
            minlength="6"
        />

        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
</div>
</body>
</html>
