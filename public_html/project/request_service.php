<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request Service</title>
    <link rel="stylesheet" href="SQLStyle.css">
</head>
<body>
    <h1>Request a Service</h1>
    <form action="process_service_request.php" method="post">
        <label for="customer_id">Customer ID:</label>
        <input type="text" name="customer_id" id="customer_id" required><br>

        <label for="service_date">Service Date:</label>
        <input type="date" name="service_date" id="service_date" required><br>

        <label for="service_type">Type of Service:</label>
        <input type="text" name="service_type" id="service_type" required><br>

        <label for="cost">Cost:</label>
        <input type="number" step="0.01" name="cost" id="cost" required><br>

        <button type="submit">Submit Request</button>
    </form>
</body>
</html>
