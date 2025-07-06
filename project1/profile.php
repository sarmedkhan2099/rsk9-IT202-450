<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php?msg=login_required");
    exit;
}

$userId = $_SESSION['user']['id'];
$errors = [];
$success = "";

$stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?");
        $stmt->execute([$username, $email, $userId]);
        if ($stmt->fetch()) {
            $errors[] = "Username or Email is already taken.";
        }
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        if ($stmt->execute([$username, $email, $userId])) {
            $success = "Profile updated successfully.";
            $_SESSION['user']['username'] = $username;
            $_SESSION['user']['email'] = $email;
            $user['username'] = $username;
            $user['email'] = $email;
        } else {
            $errors[] = "Failed to update profile. Try again.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Profile</title>
  <link rel="stylesheet" href="assets/styles.css" />
  <script>
    function validateProfile() {
      const username = document.forms["profileForm"]["username"].value.trim();
      const email = document.forms["profileForm"]["email"].value.trim();
      if (!username) {
        alert("Username is required.");
        return false;
      }
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(email)) {
        alert("Enter a valid email address.");
        return false;
      }
      return true;
    }
  </script>
</head>
<body>
  <h2>Your Profile</h2>

  <?php if ($success): ?>
    <p class="success"><?= htmlspecialchars($success) ?></p>
  <?php endif; ?>

  <?php if ($errors): ?>
    <div class="error">
      <ul>
        <?php foreach ($errors as $error): ?>
          <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form name="profileForm" method="POST" action="" onsubmit="return validateProfile();">
    <label>Username:</label>
    <input type="text" name="username" required value="<?= htmlspecialchars($user['username']) ?>">

    <label>Email:</label>
    <input type="email" name="email" required value="<?= htmlspecialchars($user['email']) ?>">

    <button type="submit">Update Profile</button>
  </form>

  <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
