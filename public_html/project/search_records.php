<?php
include 'db_connection.php';

$query = "SELECT plumbers.first_name AS plumber_first, plumbers.last_name AS plumber_last, 
          customers.first_name AS customer_first, customers.last_name AS customer_last, 
          service_records.date_of_service, service_records.type_of_service, service_records.cost, 
          supplies.supply_name, supplies.received_date 
          FROM plumbers 
          JOIN service_records ON plumbers.plumber_id = service_records.plumber_id 
          JOIN customers ON service_records.customer_id = customers.customer_id 
          LEFT JOIN supplies ON service_records.service_id = supplies.service_id";

$result = $con->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Plumber: " . $row['plumber_first'] . " " . $row['plumber_last'] . "<br>";
        echo "Customer: " . $row['customer_first'] . " " . $row['customer_last'] . "<br>";
        echo "Service Date: " . $row['date_of_service'] . "<br>";
        echo "Service Type: " . $row['type_of_service'] . "<br>";
        echo "Cost: $" . $row['cost'] . "<br>";
        echo "Supplies: " . $row['supply_name'] . "<br>";
        echo "Received: " . $row['received_date'] . "<br><hr>";
    }
} else {
    echo "No records found.";
}
?>
