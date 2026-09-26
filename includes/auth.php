<?php
/**
 * Authentication and utility functions.
 *
 * Provides session management, user authentication checks,
 * one-time flash messages, and HTML escaping.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Get the currently logged-in user's ID.
 *
 * @return int|null The user ID if logged in, null otherwise.
 */
function current_user_id() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get the currently logged-in user's name.
 *
 * @return string|null The user name if logged in, null otherwise.
 */
function current_user_name() {
    return $_SESSION['user_name'] ?? null;
}

/**
 * Check if a user is currently logged in.
 *
 * @return bool True if a user is logged in, false otherwise.
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Require a user to be logged in to access the current page.
 * Redirects to the login page with an error flash message if not logged in.
 *
 * @return void
 */
function require_login() {
    if (!is_logged_in()) {
        flash('error', 'Please log in to continue.');
        header('Location: login.php');
        exit;
    }
}

/**
 * Set a one-time flash message to be displayed on the next page load.
 *
 * @param string $type The type of message (e.g., 'error', 'success').
 * @param string $message The message content.
 * @return void
 */
function flash($type, $message) {
    $_SESSION['flash'][$type][] = $message;
}

/**
 * Retrieve and clear all pending flash messages.
 *
 * @return array An associative array of flash messages grouped by type.
 */
function get_flashes() {
    $flashes = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $flashes;
}

/**
 * Safely escape a value for HTML output to prevent XSS.
 *
 * @param string|null $value The value to escape.
 * @return string The escaped HTML string.
 */
function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
