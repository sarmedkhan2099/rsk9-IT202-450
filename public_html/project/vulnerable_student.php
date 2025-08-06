<?php
session_start();
include 'db_connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentName = $_POST['studentName'];

    $sql = "SELECT * FROM Student WHERE Name = '$studentName'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Major</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['ID']}</td><td>{$row['Name']}</td><td>{$row['Major']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<script>alert('Student not found');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Student</title>
</head>
<body>
    <h2>Enter Student Name</h2>
    <form method="post" action="">
        <label for="studentName">Student Name:</label>
        <input type="text" id="studentName" name="studentName" required>
        <button type="submit">Search</button>
    </form>
</body>
</html>
