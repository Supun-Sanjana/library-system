<?php
/**
 * Logout endpoint.
 *
 * Clears the user's session, sets a success flash message,
 * and redirects to the homepage.
 */
require_once __DIR__ . '/includes/auth.php';
session_unset();
session_destroy();
session_start();
flash('success', "You've been logged out.");
header('Location: index.php');
exit;
