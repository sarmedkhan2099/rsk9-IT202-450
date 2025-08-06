<?php
include 'index.php';

if (isset($_POST['schedule'])) {
    $customerID = $_POST['customerID'];
    $serviceDate = $_POST['serviceDate'];
    $serviceTime = $_POST['serviceTime'];
    $appointmentID = rand(10000, 99999);

    $query = "SELECT * FROM customers WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $customerID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $insertQuery = "
            INSERT INTO appointments (customer_id, service_date, service_time, appointment_id)
            VALUES (?, ?, ?, ?)
        ";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("issi", $customerID, $serviceDate, $serviceTime, $appointmentID);

        if ($stmt->execute()) {
            echo "<script>alert('Appointment Scheduled Successfully. ID: $appointmentID');</script>";
        } else {
            echo "<script>alert('Error scheduling appointment');</script>";
        }
    } else {
        echo "<script>alert('Customer does not exist');</script>";
    }
}
?>
<form action="schedule_appointment.php" method="post">
    <input type="number" name="customerID" placeholder="Customer ID" required>
    <input type="date" name="serviceDate" required>
    <input type="time" name="serviceTime" required>
    <button type="submit" name="schedule">Schedule Appointment</button>
</form>
