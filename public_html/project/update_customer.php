<?php
include 'index.php';

if (isset($_POST['update'])) {
    $customerID = $_POST['customerID'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $query = "UPDATE customers SET address = ?, phone = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $address, $phone, $customerID);

    if ($stmt->execute()) {
        echo "<script>alert('Customer Updated Successfully');</script>";
    } else {
        echo "<script>alert('Error updating customer');</script>";
    }
}
?>
<form action="update_customer.php" method="post">
    <input type="number" name="customerID" placeholder="Customer ID" required>
    <input type="text" name="address" placeholder="New Address">
    <input type="text" name="phone" placeholder="New Phone Number">
    <button type="submit" name="update">Update Customer</button>
</form>
