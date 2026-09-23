<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function current_user_id() {
    return $_SESSION['user_id'] ?? null;
}

function current_user_name() {
    return $_SESSION['user_name'] ?? null;
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function require_login() {
    if (!is_logged_in()) {
        flash('error', 'Please log in to continue.');
        header('Location: login.php');
        exit;
    }
}

// One-time flash messages, shown once then cleared.
function flash($type, $message) {
    $_SESSION['flash'][$type][] = $message;
}

function get_flashes() {
    $flashes = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $flashes;
}

function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
