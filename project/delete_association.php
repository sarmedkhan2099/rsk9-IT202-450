<?php
// FILE: delete_association.php
session_start();
require_once("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$entity_id = $_GET['entity_id'] ?? 0;

$sql = "DELETE FROM user_entity WHERE user_id = ? AND entity_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $entity_id);
$stmt->execute();

header("Location: user_associations.php");
exit;
?>
