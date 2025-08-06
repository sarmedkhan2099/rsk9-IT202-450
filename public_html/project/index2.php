<?php
$servername = "sql1.njit.edu";
$username = "rsk9";
$password = "441482Rk19$";
$dbname = "rsk9";
$con = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else
 {
echo "CONNECTED ";
}
?>