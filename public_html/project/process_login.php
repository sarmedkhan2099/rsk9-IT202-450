<?php
include 'index.php';

$name = $_POST['name'];
$password = $_POST['password'];
$id = $_POST['id'];
$email = isset($_POST['include_email']) ? $_POST['email'] : null;

$query = "SELECT * FROM Plumbers WHERE FirstName = ? AND Password = ? AND PlumberID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $name, $password, $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: dashboard.php");
} else {
    echo "Invalid login credentials.";
}
?>