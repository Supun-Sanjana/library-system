<?php
/**
 * Return book endpoint.
 *
 * Handles POST requests to return a specific book.
 * Requires the user to be logged in and to be the current borrower of the book.
 * Updates the database to mark the book as available (clears borrowed_by and due_date).
 */
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../my_books.php');
    exit;
}

$bookId = (int)($_POST['book_id'] ?? 0);
$stmt = $pdo->prepare('SELECT id, title, borrowed_by FROM books WHERE id = ?');
$stmt->execute([$bookId]);
$book = $stmt->fetch();

if (!$book) {
    flash('error', 'That book could not be found.');
} elseif ((int)$book['borrowed_by'] !== (int)current_user_id()) {
    flash('error', 'That book is not currently on your desk.');
} else {
    $update = $pdo->prepare('UPDATE books SET borrowed_by = NULL, due_date = NULL WHERE id = ?');
    $update->execute([$bookId]);
    flash('success', 'Thanks — "' . $book['title'] . '" has been returned.');
}

header('Location: ../my_books.php');
exit;
