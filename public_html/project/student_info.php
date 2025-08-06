<?php
session_start();

if (!isset($_SESSION['stID'])) {
    header("Location: form.php");
    exit();
}

include 'db_connection.php';

$studentID = $_SESSION['stID'];

$sql = "SELECT Student.Name, Student.ID, Student.Major, Transcript.Course, Transcript.Grade
        FROM Student
        JOIN Transcript ON Student.ID = Transcript.ID
        WHERE Student.ID = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $studentID);
$stmt->execute();

$stmt->bind_result($name, $id, $major, $course, $grade);
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
        <?php
        while ($stmt->fetch()): ?>
            <tr>
                <td><?php echo htmlspecialchars($name); ?></td>
                <td><?php echo htmlspecialchars($id); ?></td>
                <td><?php echo htmlspecialchars($major); ?></td>
                <td><?php echo htmlspecialchars($course); ?></td>
                <td><?php echo htmlspecialchars($grade); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <form action="form.php" method="get">
        <button type="submit">Home/Back</button>
    </form>
</body>
</html>

<?php
$stmt->close();
$con->close();
?>
