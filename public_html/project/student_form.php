<?php
// Start session for managing session variables
session_start();

// Function to connect to the database
function connectDatabase() {
    $servername = "sql1.njit.edu";
    $username = "rsk9";
    $password = "441482Rk19$";
    $dbname = "rsk9";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Function to check if a student ID exists
function checkStudentID($student_id, $conn) {
    $sql = "SELECT ID FROM Student WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();
    return $exists;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = intval($_POST['student_id']);

    // Connect to database and check for student ID
    $conn = connectDatabase();
    if (checkStudentID($student_id, $conn)) {
        $_SESSION['stID'] = $student_id; // Store ID in session
        header("Location: student_info.php"); // Redirect to next page
        exit();
    } else {
        echo "<script>alert('Student ID not found.');</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Lookup</title>
</head>
<body>
    <form method="POST" action="student_form.php">
        <label for="student_id">Enter Student ID:</label>
        <input type="number" id="student_id" name="student_id" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
