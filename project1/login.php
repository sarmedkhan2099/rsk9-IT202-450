<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

$loginId = $_POST['login_id'] ?? '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginId = trim($loginId);
    $password = $_POST['login_password'] ?? '';

    if (empty($loginId)) {
        $errors[] = "Username or Email is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$loginId, $loginId]);
        $user = $stmt->fetch();

        if (!$user) {
            $errors[] = "Account not found.";
        } elseif (!password_verify($password, $user['password'])) {
            $errors[] = "Incorrect password.";
        } else {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email']
            ];

            $rolesStmt = $pdo->prepare("SELECT r.name FROM roles r JOIN user_roles ur ON r.id = ur.role_id WHERE ur.user_id = ? AND ur.is_active = 1");
            $rolesStmt->execute([$user['id']]);
            $_SESSION['roles'] = $rolesStmt->fetchAll(PDO::FETCH_COLUMN);

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
  <title>Login</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 400px; margin: auto; }
    label { display: block; margin-top: 1em; }
    input[type="text"], input[type="password"] { width: 100%; padding: 8px; }
    .error { color: red; }
    .success { color: green; }
    button { margin-top: 1em; padding: 10px; width: 100%; }
  </style>
  <script>
    function validateLogin() {
      const loginId = document.forms["loginForm"]["login_id"].value.trim();
      const password = document.forms["loginForm"]["login_password"].value;

      if (loginId === "") {
        alert("Username or Email is required.");
        return false;
      }
      if (password === "") {
        alert("Password is required.");
        return false;
      }
      return true;
    }
  </script>
</head>
<body>

  <h2>Login</h2>

  <?php if (isset($_GET['logout'])): ?>
    <p class="success">You have successfully logged out.</p>
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

  <form name="loginForm" method="POST" action="" onsubmit="return validateLogin();">
    <label for="login_id">Username or Email *</label>
    <input type="text" name="login_id" id="login_id" required value="<?= htmlspecialchars($loginId) ?>">

    <label for="login_password">Password *</label>
    <input type="password" name="login_password" id="login_password" required>

    <button type="submit">Login</button>
  </form>

</body>
</html>
