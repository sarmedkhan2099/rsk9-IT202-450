<?php
// UCID: yourUCID | Date: 2025-07-06
// File: includes/auth.php
// Purpose: Authentication and authorization helper functions

session_start();

/**
 * Check if user is logged in.
 * If not, redirect to login page with friendly message.
 */
function checkLogin() {
    if (!isset($_SESSION['user'])) {
        // Redirect with a friendly message
        $_SESSION['error_message'] = 'You need to be logged in to access that page.';
        header('Location: ../public/login.php');
        exit;
    }
}

/**
 * Check if logged-in user has the specified role.
 * Returns true if user has role, else redirects with friendly message.
 * 
 * @param string $role The role name to check for
 * @return bool
 */
function checkRole(string $role): bool {
    if (!isset($_SESSION['roles']) || !in_array($role, $_SESSION['roles'])) {
        $_SESSION['error_message'] = "You do not have permission to access that page.";
        header('Location: ../public/dashboard.php');
        exit;
    }
    return true;
}
