<?php
session_start();

include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentID = $_POST['studentID'];

    $sql = "SELECT ID FROM Student WHERE ID = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $studentID);
    $stmt->execute();

    $stmt->bind_result($resultID);
    if ($stmt->fetch()) {
        $_SESSION['stID'] = $resultID;

        header("Location: student_info.php");
        exit();
    } else {
        echo "<script>alert('Student ID not found');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Student</title>
</head>
<body>
    <h2>Enter Student ID</h2>
    <form method="post" action="">
        <label for="studentID">Student ID:</label>
        <input type="text" id="studentID" name="studentID" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
