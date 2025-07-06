<?php

function isLoggedIn() {
    return isset($_SESSION['user']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php?message=You must log in first");
        exit;
    }
}

function hasRole($roleName) {
    if (!isset($_SESSION['roles'])) {
        return false;
    }
    return in_array($roleName, $_SESSION['roles']);
}

function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validateUsername($username) {
    return preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username);
}

function validatePassword($password) {
    return strlen($password) >= 8;
}

function showError($message) {
    echo "<p class='error'>" . htmlspecialchars($message) . "</p>";
}

function showSuccess($message) {
    echo "<p class='success'>" . htmlspecialchars($message) . "</p>";
}
