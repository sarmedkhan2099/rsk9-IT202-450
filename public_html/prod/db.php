<?php
$host = "sql1.njit.edu";
$dbname = "rsk9";           // Your UCID
$username = "rsk9";         // Your UCID
$password = "441482Rk19$";  // Your MySQL password from NJIT

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
