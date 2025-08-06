<?php
// Start the session
session_start();

// Database connection
$con = new mysqli("localhost", "username", "password", "database_name");

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted student ID
    $studentID = $_POST['studentID'];

    // Prepare and execute the SQL query
    $sql = "SELECT * FROM Student WHERE ID = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $studentID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Student ID found, set session variable
        $_SESSION['stID'] = $studentID;

        // Redirect to the second script
        header("Location: display_student.php");
        exit();
    } else {
        // Student ID not found, show an alert
        echo "<script>alert('Student ID not found');</script>";
    }
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
