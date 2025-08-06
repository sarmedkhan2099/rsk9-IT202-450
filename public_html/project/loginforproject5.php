<?php
include 'auth.php';

$servername = "sql1.njit.edu";
$username = "rsk9";
$password = "441482Rk19$";
$dbname = "rsk9";

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($userId, $hashedPassword);
    $stmt->fetch();

    if ($hashedPassword && password_verify($password, $hashedPassword)) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        echo "Login successful!";
    } else {
        echo "Invalid username or password.";
    }

    $stmt->close();
}

$con->close();
?>