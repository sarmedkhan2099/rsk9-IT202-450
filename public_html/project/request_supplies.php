<?php
include 'index.php';

if (isset($_POST['request'])) {
    $serviceID = $_POST['serviceID'];
    $supplies = $_POST['supplies'];

    $query = "SELECT * FROM appointments WHERE appointment_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $serviceID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $insertQuery = "
            INSERT INTO supplies (appointment_id, supplies_needed)
            VALUES (?, ?)
        ";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("is", $serviceID, $supplies);

        if ($stmt->execute()) {
            echo "<script>alert('Supplies Requested Successfully');</script>";
        } else {
            echo "<script>alert('Error requesting supplies');</script>";
        }
    } else {
        echo "<script>alert('Service ID not found');</script>";
    }
}
?>
<form action="request_supplies.php" method="post">
    <input type="number" name="serviceID" placeholder="Service ID" required>
    <input type="text" name="supplies" placeholder="Supplies Needed" required>
    <button type="submit" name="request">Request Supplies</button>
</form>
