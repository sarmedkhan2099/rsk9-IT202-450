<?php
// FILE: user_associations.php
session_start();
require_once("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$limit = max(1, min($limit, 100));

$sql = "SELECT ue.entity_id, f.title, f.description FROM user_entity ue JOIN films f ON ue.entity_id = f.id WHERE ue.user_id = ? LIMIT ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $limit);
$stmt->execute();
$result = $stmt->get_result();

$count_sql = "SELECT COUNT(*) FROM user_entity WHERE user_id = ?";
$count_stmt = $conn->prepare($count_sql);
$count_stmt->bind_param("i", $user_id);
$count_stmt->execute();
$count_result = $count_stmt->get_result()->fetch_row();
$total_count = $count_result[0];

echo "<h2>Associated Items</h2>";
echo "<p>Total Associated: $total_count</p>";
echo "<p>Showing: " . $result->num_rows . "</p>";

if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li><strong>{$row['title']}</strong> - {$row['description']} ";
        echo "<a href='view_film.php?id={$row['entity_id']}'>View</a> | ";
        echo "<a href='delete_association.php?entity_id={$row['entity_id']}'>Remove</a></li>";
    }
    echo "</ul>";
} else {
    echo "<p>No results available</p>";
}

echo "<form action='delete_all_user_associations.php' method='post'>";
echo "<input type='submit' value='Remove All Associations'>";
echo "</form>";
?>
