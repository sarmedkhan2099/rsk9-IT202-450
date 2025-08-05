<?php
// UCID: YOUR_UCID
// Date: 2025-07-28
// Description: Fetch and insert Studio Ghibli API films into DB

$db = require(__DIR__ . "/db.php"); // db.php should return a PDO object

function fetchGhibliFilms()
{
    $url = "https://ghibliapi.vercel.app/films";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

function insertFilm($film, $db)
{
    $ghibli_id = $film['id'] ?? null;
    $title = $film['title'] ?? null;
    $description = $film['description'] ?? null;
    $release_year = substr($film['release_date'] ?? '', 0, 4);

    if (!$ghibli_id || !$title) return;

    $stmt = $db->prepare("SELECT id FROM films WHERE ghibli_id = :ghibli_id");
    $stmt->execute([":ghibli_id" => $ghibli_id]);
    if ($stmt->fetch()) return;

    $stmt = $db->prepare("INSERT INTO films (ghibli_id, title, description, release_year, is_api) VALUES (:ghibli_id, :title, :description, :release_year, true)");
    $stmt->execute([
        ":ghibli_id" => $ghibli_id,
        ":title" => $title,
        ":description" => $description,
        ":release_year" => $release_year
    ]);
}

$films = fetchGhibliFilms();
foreach ($films as $film) {
    insertFilm($film, $db);
}

echo "Studio Ghibli films imported successfully.";
