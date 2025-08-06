<?php
include 'index.php';

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$phone = $_POST['phone'];

$query = "INSERT INTO CustomerInfo (FirstName, LastName, StreetAddress, City, State, ZipCode, PhoneNumber) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssssss", $first_name, $last_name, $address, $city, $state, $zip, $phone);

if ($stmt->execute()) {
    echo "Customer account created successfully.";
} else {
    echo "Error creating customer.";
}
?>
