<?php
$servername = "sql1.njit.edu";
$username = "rsk9";
$password = "441482Rk19$";
$dbname = "rsk9";

$con = mysqli_connect($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $messageId = $_POST['id'];
    $newMessage = $_POST['message'];

    $stmt = $con->prepare("UPDATE messages SET message = ?, edited = TRUE WHERE id = ?");
    $stmt->bind_param("si", $newMessage, $messageId);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo "Message updated!";
    } else {
        echo "Error: Could not update the message.";
    }

    $stmt->close();
}

$con->close();
?>