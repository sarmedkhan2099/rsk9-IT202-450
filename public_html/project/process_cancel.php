<?php
include 'index.php';

$appointment_id = $_POST['appointment_id'];

$check_appointment = "SELECT * FROM ServiceRecords WHERE ServiceID = ?";
$stmt = $conn->prepare($check_appointment);
$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $delete_appointment = "DELETE FROM ServiceRecords WHERE ServiceID = ?";
    $stmt = $conn->prepare($delete_appointment);
    $stmt->bind_param("i", $appointment_id);
    
    if ($stmt->execute()) {
        echo "<h2>Service appointment with ID: $appointment_id has been successfully canceled.</h2>";
    } else {
        echo "<h2>Error: Unable to cancel the service appointment. Please try again.</h2>";
    }
} else {
    echo "<h2>Error: No service appointment found with ID: $appointment_id.</h2>";
}
$stmt->close();
$conn->close();
?>
