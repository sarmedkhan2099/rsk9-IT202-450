<?php
// Date: 2025-07-28
// Description: Login page with username/email and password

session_start();
require_once "db.php";
require_once "functions.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $identifier = trim($_POST["identifier"] ?? "");
    $password = $_POST["password"] ?? "";

    if (!$identifier || !$password) {
        flash("Please fill out all fields.");
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :id OR email = :id");
        $stmt->execute(['id' => $identifier]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION["user"] = $user;
            $_SESSION["roles"] = [];

            $role_stmt = $pdo->prepare("SELECT r.name FROM roles r JOIN user_roles ur ON r.id = ur.role_id WHERE ur.user_id = :uid AND ur.is_active = 1");
            $role_stmt->execute(["uid" => $user["id"]]);
            $_SESSION["roles"] = array_column($role_stmt->fetchAll(), "name");

            header("Location: dashboard.php");
            exit;
        } else {
            flash("Invalid username/email or password.");
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <script>
    function validate() {
        const id = document.forms["loginForm"]["identifier"].value;
        const pw = document.forms["loginForm"]["password"].value;
        if (!id || !pw) {
            alert("All fields are required.");
            return false;
        }
        return true;
    }
    </script>
</head>
<body>
<h2>Login</h2>
<p style="color:red;">
    <?php echo get_flash(); ?>
</p>
<form name="loginForm" method="POST" onsubmit="return validate();">
    <label for="identifier">Username or Email:</label>
    <input type="text" name="identifier" required value="<?php echo htmlspecialchars($_POST['identifier'] ?? '') ?>"><br>
    <label for="password">Password:</label>
    <input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>
<p><a href="register.php">Register</a></p>
</body>
</html>
