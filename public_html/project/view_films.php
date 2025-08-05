<?php
// Date: 2025-07-28
// Description: View single film details by id

require_once "db.php";
require_once "auth.php";

if (!is_logged_in()) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    $_SESSION['flash'] = "Invalid film ID.";
    header("Location: list_films.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM films WHERE id = ?");
$stmt->execute([$id]);
$film = $stmt->fetch();

if (!$film) {
    $_SESSION['flash'] = "Film not found.";
    header("Location: list_films.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Film</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h1><?= htmlspecialchars($film['title']) ?></h1>
    <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($film['description'])) ?></p>
    <p><strong>Director:</strong> <?= htmlspecialchars($film['director']) ?></p>
    <p><strong>Producer:</strong> <?= htmlspecialchars($film['producer']) ?></p>
    <p><strong>Release Year:</strong> <?= htmlspecialchars($film['release_date']) ?></p>
    <p><strong>Rotten Tomatoes Score:</strong> <?= htmlspecialchars($film['rt_score']) ?></p>
    <p><strong>Created:</strong> <?= htmlspecialchars($film['created']) ?></p>
    <p><strong>Modified:</strong> <?= htmlspecialchars($film['modified']) ?></p>

    <a href="edit_film.php?id=<?= $film['id'] ?>" class="btn btn-primary">Edit</a>
    <a href="delete_film.php?id=<?= $film['id'] ?>" class="btn btn-danger">Delete</a>
    <a href="list_films.php" class="btn btn-secondary">Back to List</a>
  </div>
</body>
</html>
