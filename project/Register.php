<?php
// Date: 2025-07-28
// Description: Registration form with full validation and hashing

session_start();
require_once "db.php";
require_once "functions.php";

$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if (!$username || !$email || !$password || !$confirm) {
        flash("All fields are required.");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        flash("Invalid email format.");
    } elseif ($password !== $confirm) {
        flash("Passwords do not match.");
    } else {
        $check = $pdo->prepare("SELECT id FROM users WHERE email = :email OR username = :username");
        $check->execute(['email' => $email, 'username' => $username]);
        if ($check->fetch()) {
            flash("Email or username already taken.");
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, created, modified) VALUES (:username, :email, :password, NOW(), NOW())");
            $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hash]);
            flash("Registration successful. You can now login.");
            header("Location: login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <script>
    function validate() {
        const u = document.forms["regForm"]["username"].value;
        const e = document.forms["regForm"]["email"].value;
        const p = document.forms["regForm"]["password"].value;
        const c = document.forms["regForm"]["confirm"].value;
        if (!u || !e || !p || !c) {
            alert("All fields are required.");
            return false;
        }
        if (p !== c) {
            alert("Passwords do not match.");
            return false;
        }
        return true;
    }
    </script>
</head>
<body>
<h2>Register</h2>
<p style="color:red;">
    <?php echo get_flash(); ?>
</p>
<form name="regForm" method="POST" onsubmit="return validate();">
    <label for="username">Username:</label>
    <input type="text" name="username" required value="<?php echo htmlspecialchars($username) ?>"><br>
    <label for="email">Email:</label>
    <input type="email" name="email" required value="<?php echo htmlspecialchars($email) ?>"><br>
    <label for="password">Password:</label>
    <input type="password" name="password" required><br>
    <label for="confirm">Confirm Password:</label>
    <input type="password" name="confirm" required><br>
    <button type="submit">Register</button>
</form>
<p><a href="login.php">Back to Login</a></p>
</body>
</html>
