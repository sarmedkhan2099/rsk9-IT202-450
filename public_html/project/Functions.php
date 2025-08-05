<?php
// Date: 2025-07-28
// Description: Helper functions for session, roles, and user handling

function is_logged_in() {
    return isset($_SESSION["user"]);
}

function require_login() {
    if (!is_logged_in()) {
        header("Location: login.php");
        exit;
    }
}

function has_role($role) {
    return isset($_SESSION["roles"]) && in_array($role, $_SESSION["roles"]);
}

function flash($msg) {
    $_SESSION["flash"] = $msg;
}

function get_flash() {
    if (isset($_SESSION["flash"])) {
        $msg = $_SESSION["flash"];
        unset($_SESSION["flash"]);
        return $msg;
    }
    return "";
}
