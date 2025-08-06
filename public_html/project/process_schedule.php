<?php
include 'index.php';

$customer_id = $_POST['customer_id'];
$service_date = $_POST['service_date'];
$service_type = $_POST['service_type'];

$check_customer = "SELECT * FROM Customers WHERE CustomerID = ?";
$stmt = $conn->prepare($check_customer);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $appointment_id = rand(1000, 9999);
    $insert_service = "INSERT INTO ServiceRecords (CustomerID, DateOfService, TypeOfService) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_service);
    $stmt->bind_param("iss", $customer_id, $service_date, $service_type);
    if ($stmt->execute()) {
        echo "Service appointment scheduled with ID: $appointment_id";
    } else {
        echo "Error scheduling service.";
    }
} else {
    echo "Customer does not exist. Please create an account first.";
}
?>
