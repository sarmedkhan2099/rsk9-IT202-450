<?php
// Date: 2025-07-28
// Description: Create film page - manual or API entry

require_once "db.php";
session_start();

function is_post() {
    return $_SERVER["REQUEST_METHOD"] === "POST";
}

function validate($data) {
    $errors = [];
    if (empty($data["title"])) {
        $errors[] = "Title is required.";
    }
    if (!empty($data["release_year"]) && !preg_match("/^[0-9]{4}\$/", $data["release_year"])) {
        $errors[] = "Release year must be a 4-digit year.";
    }
    return $errors;
}

$title = $description = $release_year = "";
$is_api = 0;

if (is_post()) {
    $title = $_POST["title"] ?? "";
    $description = $_POST["description"] ?? "";
    $release_year = $_POST["release_year"] ?? null;
    $is_api = isset($_POST["is_api"]) ? 1 : 0;

    $errors = validate($_POST);

    if (empty($errors)) {
        $stmt = $db->prepare("INSERT INTO films (title, description, release_year, is_api) VALUES (?, ?, ?, ?)");
        try {
            $stmt->execute([$title, $description, $release_year, $is_api]);
            $_SESSION["flash"] = "Film successfully added.";
            header("Location: list_films.php");
            exit;
        } catch (Exception $e) {
            error_log("Create Error: " . $e->getMessage());
            $errors[] = "Something went wrong while adding the film.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Film</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h2>Add New Film</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" novalidate onsubmit="return validate();">
        <div class="mb-3">
            <label class="form-label">Title*</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($title) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($description) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Release Year</label>
            <input type="number" name="release_year" class="form-control" min="1900" max="2099" value="<?= htmlspecialchars($release_year) ?>">
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_api" value="1" id="is_api" <?= $is_api ? 'checked' : '' ?>>
            <label class="form-check-label" for="is_api">Is API</label>
        </div>
        <button type="submit" class="btn btn-success">Create</button>
        <a href="list_films.php" class="btn btn-secondary">Cancel</a>
    </form>

    <script>
        function validate() {
            const title = document.querySelector('[name="title"]').value;
            if (!title.trim()) {
                alert("Title is required.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
