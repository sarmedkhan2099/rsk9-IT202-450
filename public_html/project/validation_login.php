<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = $_POST['password'];
    $plumber_id = $_POST['plumber_id'];
    $validate_email = isset($_POST['validate_email']);
    $email = $validate_email ? $_POST['email'] : null;
    $option = $_POST['option'];

    $query = "SELECT * FROM plumbers WHERE first_name='$first_name' AND last_name='$last_name' AND plumber_id='$plumber_id' AND password='$password'";
    if ($validate_email) {
        $query .= " AND email='$email'";
    }

    $result = $con->query($query);

    if ($result->num_rows > 0) {
        switch ($option) {
            case "search":
                header("Location: search_records.php");
                break;
            case "schedule":
                header("Location: schedule_appointment.php");
                break;
            case "cancel":
                header("Location: cancel_appointment.php");
                break;
            case "supplies":
                header("Location: request_supplies.php");
                break;
            case "update":
                header("Location: update_customer.php");
                break;
            case "create":
                header("Location: create_customer.php");
                break;
        }
    } else {
        echo "Invalid login details.";
    }
}
?>
