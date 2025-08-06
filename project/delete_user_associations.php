<?php
// FILE: delete_all_user_associations.php
session_start();
require_once("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "DELETE FROM user_entity WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

header("Location: user_associations.php");
exit;
?>
