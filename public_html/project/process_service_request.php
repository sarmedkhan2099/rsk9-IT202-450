<?php
include 'index.php';

$customer_id = $_POST['customer_id'];
$service_date = $_POST['service_date'];
$service_type = $_POST['service_type'];
$cost = $_POST['cost'];

$check_customer = "SELECT * FROM Customers WHERE CustomerID = ?";
$stmt = $conn->prepare($check_customer);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $insert_service = "INSERT INTO ServiceRecords (CustomerID, DateOfService, TypeOfService, Cost) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_service);
    $stmt->bind_param("issd", $customer_id, $service_date, $service_type, $cost);

    if ($stmt->execute()) {
        echo "<h2>Service request successfully added to the database!</h2>";
        echo "<p>Details:</p>";
        echo "<ul>
                <li>Customer ID: $customer_id</li>
                <li>Service Date: $service_date</li>
                <li>Type of Service: $service_type</li>
                <li>Cost: $$cost</li>
              </ul>";
        echo "<a href='dashboard.php'>Go back to Dashboard</a>";
    } else {
        echo "<h2>Error adding service request.</h2>";
    }
} else {
    echo "<h2>Error: Customer does not exist. Please create a customer record first.</h2>";
    echo "<a href='create_customer.php'>Create New Customer</a>";
}

$conn->close();
?>
