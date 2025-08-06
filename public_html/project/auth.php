<?php
session_start();

function isAuthenticated() {
    return isset($_SESSION['user_id']);
}

function getUsername() {
    return $_SESSION['username'] ?? null;
}
?>
