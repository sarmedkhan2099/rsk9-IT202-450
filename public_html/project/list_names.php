<?php
$servername = "sql1.njit.edu";
$username = "rsk9";
$password = "441482Rk19$";
$dbname = "rsk9";

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$sql = "SELECT name FROM users ORDER BY name ASC";
$result = $con->query($sql);

$names = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $names[] = $row['name'];
    }
}

echo json_encode($names);

$con->close();
?>