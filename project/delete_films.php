<?php
// Date: 2025-07-28
// Description: Delete film by ID with confirmation

require_once "db.php";
session_start();

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    $_SESSION['flash'] = "Invalid ID.";
    header("Location: list_films.php");
    exit;
}

$stmt = $db->prepare("SELECT title FROM films WHERE id = ?");
$stmt->execute([$id]);
$film = $stmt->fetch();

if (!$film) {
    $_SESSION['flash'] = "Film not found.";
    header("Location: list_films.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare("DELETE FROM films WHERE id = ?");
    try {
        $stmt->execute([$id]);
        $_SESSION['flash'] = "Film deleted.";
        header("Location: list_films.php");
        exit;
    } catch (Exception $e) {
        error_log("Delete error: " . $e->getMessage());
        $_SESSION['flash'] = "Delete failed.";
        header("Location: list_films.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Film</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h2>Delete Film</h2>
    <p>Are you sure you want to delete "<strong><?= htmlspecialchars($film['title']) ?></strong>"?</p>
    <form method="post">
        <button type="submit" class="btn btn-danger">Yes, delete</button>
        <a href="view_film.php?id=<?= $id ?>" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
