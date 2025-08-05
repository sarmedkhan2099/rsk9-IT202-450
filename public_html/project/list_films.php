<?php
// UCID: YOUR_UCID
// Date: 2025-07-28
// Description: List films with sorting, filtering, and links

require_once "db.php";
session_start();

// Check if logged in
if (!isset($_SESSION["user"])) {
    $_SESSION["flash"] = "You must be logged in to view this page.";
    header("Location: login.php");
    exit;
}

// Defaults
$limit = 10;
$order = "title";
$direction = "ASC";
$title = "";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET["limit"])) {
        $limit = (int) $_GET["limit"];
        if ($limit < 1) $limit = 1;
        if ($limit > 100) $limit = 100;
    }
    if (isset($_GET["order"])) {
        $allowed = ["title", "release_date", "rt_score"];
        if (in_array($_GET["order"], $allowed)) {
            $order = $_GET["order"];
        }
    }
    if (isset($_GET["direction"])) {
        if (in_array(strtoupper($_GET["direction"]), ["ASC", "DESC"])) {
            $direction = strtoupper($_GET["direction"]);
        }
    }
    if (!empty($_GET["title"])) {
        $title = trim($_GET["title"]);
    }
}

// Build SQL query
$sql = "SELECT * FROM films WHERE 1=1";
$params = [];

if ($title !== "") {
    $sql .= " AND title LIKE :title";
    $params[":title"] = "%$title%";
}

// Note: Using backticks to prevent SQL injection on order by column name is not sufficient,
// but since we validate against allowed list, it's safe to directly interpolate.
$sql .= " ORDER BY $order $direction LIMIT :limit";

$stmt = $db->prepare($sql);

// Bind parameters
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value, PDO::PARAM_STR);
}
$stmt->bindValue(":limit", $limit, PDO::PARAM_INT);

$stmt->execute();
$films = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Films List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="container py-4">
    <h1>Films</h1>

    <form method="get" class="row mb-3">
        <div class="col-md-3">
            <input type="text" name="title" class="form-control" placeholder="Title contains..." value="<?= htmlspecialchars($title) ?>">
        </div>
        <div class="col-md-2">
            <select name="order" class="form-select">
                <option value="title" <?= $order === "title" ? "selected" : "" ?>>Title</option>
                <option value="release_date" <?= $order === "release_date" ? "selected" : "" ?>>Release Date</option>
                <option value="rt_score" <?= $order === "rt_score" ? "selected" : "" ?>>RT Score</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="direction" class="form-select">
                <option value="ASC" <?= $direction === "ASC" ? "selected" : "" ?>>Ascending</option>
                <option value="DESC" <?= $direction === "DESC" ? "selected" : "" ?>>Descending</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" name="limit" min="1" max="100" class="form-control" value="<?= $limit ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <?php if (count($films) === 0): ?>
        <div class="alert alert-warning">No results found.</div>
    <?php else: ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Release Date</th>
                    <th>RT Score</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($films as $film): ?>
                    <tr>
                        <td><?= htmlspecialchars($film['title']) ?></td>
                        <td><?= htmlspecialchars($film['release_date']) ?></td>
                        <td><?= htmlspecialchars($film['rt_score']) ?></td>
                        <td>
                            <a href="view_film.php?id=<?= $film['id'] ?>" class="btn btn-sm btn-info">View</a>
                            <a href="edit_film.php?id=<?= $film['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete_film.php?id=<?= $film['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this film?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="create_film.php" class="btn btn-success">Add New Film</a>
</body>
</html>
