<?php
session_start();
require_once '../includes/db.php'; 
require_once '../includes/functions.php';

$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $errors[] = "Username or email is already taken.";
        }
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $email, $hashed_password])) {
            $success = "Account created successfully! You can now login.";
            $username = $email = '';
        } else {
            $errors[] = "Database error. Please try again.";
            error_log("DB Insert Error: " . json_encode($stmt->errorInfo()));
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Register</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 400px; margin: auto; }
    label { display: block; margin-top: 1em; }
    input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 8px; }
    .error { color: red; }
    .success { color: green; }
    button { margin-top: 1em; padding: 10px; width: 100%; }
  </style>
  <script>
    function validate() {
      const username = document.forms["registerForm"]["username"].value.trim();
      const email = document.forms["registerForm"]["email"].value.trim();
      const password = document.forms["registerForm"]["password"].value;
      const confirm = document.forms["registerForm"]["confirm_password"].value;

      if (username === "") {
        alert("Username is required.");
        return false;
      }
      if (email === "") {
        alert("Email is required.");
        return false;
      }
      // Simple email regex
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        alert("Please enter a valid email address.");
        return false;
      }
      if (password === "") {
        alert("Password is required.");
        return false;
      }
      if (password !== confirm) {
        alert("Passwords do not match.");
        return false;
      }
      return true;
    }
  </script>
</head>
<body>

  <h2>Register</h2>

  <?php if ($errors): ?>
    <div class="error">
      <ul>
      <?php foreach ($errors as $error): ?>
        <li><?= htmlspecialchars($error) ?></li>
      <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <form name="registerForm" method="POST" action="" onsubmit="return validate();">
    <label for="username">Username *</label>
    <input type="text" name="username" id="username" required
           value="<?= htmlspecialchars($username) ?>">

    <label for="email">Email *</label>
    <input type="email" name="email" id="email" required
           value="<?= htmlspecialchars($email) ?>">

    <label for="password">Password *</label>
    <input type="password" name="password" id="password" required>

    <label for="confirm_password">Confirm Password *</label>
    <input type="password" name="confirm_password" id="confirm_password" required>

    <button type="submit">Register</button>
  </form>

</body>
</html>
