<?php
$host = 'sql1.njit.edu';
$username = 'rsk9'; 
$password = '441482Rk19$'; 
$database = 'rsk9';

$con = new mysqli($host, $username, $password, $database);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
