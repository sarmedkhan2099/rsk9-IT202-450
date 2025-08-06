<?php
// Array of dog breeds
$dogBreeds = ["Labrador", "Beagle", "Bulldog", "Poodle", "German Shepherd", "Golden Retriever"];

// Get the query parameter from the request
$q = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : '';

// Validate input and perform search
if ($q !== '') {
    $matches = array_filter($dogBreeds, function ($breed) use ($q) {
        return stripos($breed, $q) !== false; // Case-insensitive match
    });

    if (!empty($matches)) {
        echo "<ul>";
        foreach ($matches as $match) {
            echo "<li>" . htmlspecialchars($match) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "No matching dog breeds found.";
    }
} else {
    echo "Enter a dog breed name.";
}
?>
