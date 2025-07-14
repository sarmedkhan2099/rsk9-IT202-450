<?php
// UCID: yourUCID | Date: 2025-07-06
// File: public/profile.php
// Purpose: Display and update user profile with validation and sticky form

require_once '../includes/auth.php';
require_once '../includes/db.php';

checkLogin();

$user = $_SESSION['user'];
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validate username and email
    if (!$username) {
        $errors[] = "Username is required.";
    }
    if (!$email) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email format is invalid.";
    }

    // Check if username/email changed and is unique
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?");
        $stmt->execute([$username, $email, $user['id']]);
        if ($stmt->fetch()) {
            $errors[] = "Username or email is already taken by another user.";
        }
    }

    // Password change logic
    if ($current_password || $new_password || $confirm_password) {
        if (!$current_password) {
            $errors[] = "Current password is required to change password.";
        } else {
            // Fetch current password hash
            $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->execute([$user['id']]);
            $db_user = $stmt->fetch();
            if (!$db_user || !password_verify($current_password, $db_user['password'])) {
                $errors[] = "Current password is incorrect.";
            }
        }

        if ($new_password !== $confirm_password) {
            $errors[] = "New password and confirm password do not match.";
        }

        if ($new_password && strlen($new_password) < 6) {
            $errors[] = "New password must be at least 6 characters.";
        }
    }

    // Update user info if no errors
    if (empty($errors)) {
        if ($new_password) {
            $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $updateSQL = "UPDATE users SET username = ?, email = ?, password = ?, modified = NOW() WHERE id = ?";
            $params = [$username, $email, $new_hash, $user['id']];
        } else {
            $updateSQL = "UPDATE users SET username = ?, email = ?, modified = NOW() WHERE id = ?";
            $params = [$username, $email, $user['id']];
        }

        $stmt = $pdo->prepare($updateSQL);
        if ($stmt->execute($params)) {
            $_SESSION['user']['username'] = $username;
            $_SESSION['user']['email'] = $email;
            $success = "Profile updated successfully.";
        } else {
            $errors[] = "Failed to update profile.";
            error_log("Profile update failed for user ID " . $user['id']);
        }
    }
} else {
    $username = $user['username'];
    $email = $user['email'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Your Profile</title>
<link rel="stylesheet" href="../assets/styles.css" />
<script>
function validateProfile() {
    const username = document.forms["profileForm"]["username"].value.trim();
    const email = document.forms["profileForm"]["email"].value.trim();
    const currentPassword = document.forms["profileForm"]["current_password"].value;
    const newPassword = document.forms["profileForm"]["new_password"].value;
    const confirmPassword = document.forms["profileForm"]["confirm_password"].value;
    let errors = [];

    if (!username) errors.push("Username is required.");
    if (!email) errors.push("Email is required.");
    else {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!re.test(email)) errors.push("Email format is invalid.");
    }

    if (currentPassword || newPassword || confirmPassword) {
        if (!currentPassword) errors.push("Current password is required to change password.");
        if (newPassword !== confirmPassword) errors.push("New password and confirm password must match.");
        if (newPassword && newPassword.length < 6) errors.push("New password must be at least 6 characters.");
    }

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
    <h2>Your Profile</h2>

    <?php if ($success): ?>
        <div class="alert success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if ($errors): ?>
        <div class="alert error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form name="profileForm" method="POST" onsubmit="return validateProfile();">
        <label for="username">Username</label>
        <input
            type="text"
            id="username"
            name="username"
            required
            pattern="^[a-zA-Z0-9_]{3,20}$"
            title="3-20 characters: letters, numbers, underscore only"
            value="<?= htmlspecialchars($username) ?>"
        />

        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            required
            value="<?= htmlspecialchars($email) ?>"
        />

        <h3>Change Password</h3>
        <label for="current_password">Current Password</label>
        <input type="password" id="current_password" name="current_password" />

        <label for="new_password">New Password</label>
        <input type="password" id="new_password" name="new_password" minlength="6" />

        <label for="confirm_password">Confirm New Password</label>
        <input type="password" id="confirm_password" name="confirm_password" minlength="6" />

        <button type="submit">Update Profile</button>
    </form>
</div>
</body>
</html>
