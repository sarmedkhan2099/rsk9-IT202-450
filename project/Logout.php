<?php
// UCID: YOUR_UCID
// Date: 2025-07-28
// Description: Logout and destroy session

session_start();
session_unset();
session_destroy();

session_start();
$_SESSION["flash"] = "You have been successfully logged out.";
header("Location: login.php");
exit;
