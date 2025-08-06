<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $studentName = trim($_POST['studentName']); 
    if (!empty($studentName)) {
        $sql = "SELECT ID, Name, Major FROM students WHERE Name = ?";
        $stmt = $con->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $studentName);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<table border='1'>";
                echo "<tr><th>ID</th><th>Name</th><th>Major</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . htmlspecialchars($row['ID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Major']) . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<script>alert('Student not found');</script>";
            }
            $stmt->close();
        } else {
            echo "Error preparing query: " . $con->error;
        }
    } else {
        echo "<script>alert('Please enter a valid student name');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
