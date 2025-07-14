<?php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

session_start();
require_login();

$apiUrl = 'https://rapidapi.com/yoginoit39/api/all-books-api';

try {
    // Fetch JSON data from API
    $json = file_get_contents($apiUrl);
    if (!$json) {
        throw new Exception('Failed to fetch API data.');
    }

    // Decode JSON to associative array
    $apiData = json_decode($json, true);
    if (!is_array($apiData)) {
        throw new Exception('API response is invalid.');
    }

    $inserted = 0;
    $updated = 0;

    foreach ($apiData as $stock) {
        // Map API fields to your DB columns
        $symbol = $stock['symbol'] ?? '';
        $company = $stock['companyName'] ?? '';
        $price = $stock['latestPrice'] ?? 0;
        $apiIdentifier = $stock['id'] ?? null; // Unique ID from API

        if (!$symbol || !$company || !$apiIdentifier) {
            continue; // Skip incomplete records
        }

        // Check if this stock already exists by API identifier
        $stmt = $pdo->prepare("SELECT id, price FROM stocks WHERE api_identifier = ?");
        $stmt->execute([$apiIdentifier]);
        $existing = $stmt->fetch();

        if ($existing) {
            // Update if price or company has changed
            if ($existing['price'] != $price) {
                $updateStmt = $pdo->prepare("UPDATE stocks SET symbol = ?, company = ?, price = ?, modified = NOW() WHERE id = ?");
                $updateStmt->execute([$symbol, $company, $price, $existing['id']]);
                $updated++;
            }
        } else {
            // Insert new stock record
            $insertStmt = $pdo->prepare("INSERT INTO stocks (symbol, company, price, is_api, api_identifier, created, modified) VALUES (?, ?, ?, 1, ?, NOW(), NOW())");
            $insertStmt->execute([$symbol, $company, $price, $apiIdentifier]);
            $inserted++;
        }
    }

    echo json_encode([
        'status' => 'success',
        'message' => "API data processed: $inserted inserted, $updated updated."
    ]);
} catch (Exception $e) {
    error_log('API Fetch Error: ' . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to process API data.'
    ]);
}
?>