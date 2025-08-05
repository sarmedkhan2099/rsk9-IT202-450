<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
include("db.php");

$results = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = trim($_POST["search"]);

    $stmt = $conn->prepare("SELECT id, username FROM users WHERE username LIKE ?");
    $search_param = "%" . $search . "%";
    $stmt->bind_param("s", $search_param);

    if ($stmt->execute()) {
        $stmt->bind_result($id, $username);
        while ($stmt->fetch()) {
            $results[] = ["id" => $id, "username" => $username];
        }
    } else {
        echo "Query error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Search Account</title></head>
<body>
<h2>Search for a User</h2>
<form method="POST">
    <input type="text" name="search" placeholder="Enter username">
    <input type="submit" value="Search">
</form>

<?php if (!empty($results)): ?>
    <h3>Results:</h3>
    <ul>
        <?php foreach ($results as $row): ?>
            <li>ID: <?= htmlspecialchars($row["id"]) ?> - Username: <?= htmlspecialchars($row["username"]) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
</body>
</html>
