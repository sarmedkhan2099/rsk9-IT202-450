<?php
$servername = "sql1.njit.edu";
$username = "rsk9";
$password = "441482Rk19$";
$dbname = "rsk9";

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT password FROM users WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();

    if ($hashedPassword && password_verify($password, $hashedPassword)) {
        echo "Valid user.";
    } else {
        echo "Invalid name or password.";
    }

    $stmt->close();
}

$con->close();
?>