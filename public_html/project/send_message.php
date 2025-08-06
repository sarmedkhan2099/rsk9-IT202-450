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
    $message = $_POST['message'];

    $stmt = $con->prepare("SELECT id FROM users WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($userId);
    $stmt->fetch();

    if ($userId) {
        $stmt->close();

        $stmt = $con->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
        $stmt->bind_param("is", $userId, $message);

        if ($stmt->execute()) {
            echo "Message sent!";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "User not found.";
    }

    $stmt->close();
}

$con->close();
?>