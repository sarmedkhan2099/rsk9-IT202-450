<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cancel Service Appointment</title>
    <link rel="stylesheet" href="SQLStyle.css">
    <style>
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .form-container h1 {
            text-align: center;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-container button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-container button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Cancel Service Appointment</h1>
        <form action="process_cancel.php" method="post">
            <label for="appointment_id">Appointment ID:</label>
            <input type="text" name="appointment_id" id="appointment_id" placeholder="Enter Appointment ID" required>
            <button type="submit">Cancel Appointment</button>
        </form>
    </div>
</body>
</html>
