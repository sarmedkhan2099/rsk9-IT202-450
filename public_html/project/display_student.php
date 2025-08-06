<?php
// Start the session
session_start();

// Check if the student ID is set in the session
if (!isset($_SESSION['stID'])) {
    // Redirect back to the search page if no ID is found in session
    header("Location: search_student.php");
    exit();
}

// Database connection
$con = new mysqli("localhost", "username", "password", "database_name");

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Get the student ID from session
$studentID = $_SESSION['stID'];

// Prepare and execute the SQL query
$sql = "SELECT Student.Name, Student.ID, Student.Major, Transcript.Course, Transcript.Grade
        FROM Student
        JOIN Transcript ON Student.ID = Transcript.ID
        WHERE Student.ID = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $studentID);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Information</title>
</head>
<body>
    <h2>Student Information</h2>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>ID</th>
            <th>Major</th>
            <th>Course</th>
            <th>Grade</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['Name']); ?></td>
                <td><?php echo htmlspecialchars($row['ID']); ?></td>
                <td><?php echo htmlspecialchars($row['Major']); ?></td>
                <td><?php echo htmlspecialchars($row['Course']); ?></td>
                <td><?php echo htmlspecialchars($row['Grade']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <form action="search_student.php" method="get">
        <button type="submit">Home/Back</button>
    </form>
</body>
</html>
