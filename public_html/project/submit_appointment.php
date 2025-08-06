<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
    $date = $_POST['date'];
    $type = $_POST['type'];
    $cost = $_POST['cost'];
    $service_id = rand(1000, 9999);

    $query = "INSERT INTO service_records (service_id, customer_id, plumber_id, date_of_service, type_of_service, cost) 
              VALUES ('$service_id', '$customer_id', 1, '$date', '$type', '$cost')"; // Replace plumber_id=1 dynamically

    if ($con->query($query)) {
        echo "Service scheduled successfully. Service ID: $service_id";
    } else {
        echo "Error: " . $con->error;
    }
}
?>
