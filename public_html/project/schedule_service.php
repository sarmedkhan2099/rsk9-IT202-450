<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Schedule Service</title>
    <link rel="stylesheet" href="SQLStyle.css">
</head>
<body>
    <h1>Schedule Service</h1>
    <form action="process_schedule.php" method="post">
    <input type="text" name="customer_id" placeholder="Customer ID" required>
    <input type="datetime-local" name="service_date" required>
    <input type="text" name="service_type" placeholder="Type of Service" required>
    <button type="submit">Schedule</button>
</form>
</body>
</html>
