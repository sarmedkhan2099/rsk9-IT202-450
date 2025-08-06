<?php
include 'index.php';

if (isset($_POST['cancel'])) {
    $appointmentID = $_POST['appointmentID'];

    $query = "DELETE FROM appointments WHERE appointment_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $appointmentID);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo "<script>alert('Appointment Canceled Successfully');</script>";
    } else {
        echo "<script>alert('Appointment Not Found');</script>";
    }
}
?>
<form action="cancel_appointment.php" method="post">
    <input type="number" name="appointmentID" placeholder="Appointment ID" required>
    <button type="submit" name="cancel">Cancel Appointment</button>
</form>
