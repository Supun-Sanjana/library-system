<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../books.php');
    exit;
}

$bookId = (int)($_POST['book_id'] ?? 0);
$stmt = $pdo->prepare('SELECT id, title, borrowed_by FROM books WHERE id = ?');
$stmt->execute([$bookId]);
$book = $stmt->fetch();

if (!$book) {
    flash('error', 'That book could not be found.');
} elseif ($book['borrowed_by'] !== null) {
    flash('error', 'Sorry — someone already borrowed "' . $book['title'] . '" first.');
} else {
    $dueDate = (new DateTime('+14 days'))->format('Y-m-d');
    $update = $pdo->prepare('UPDATE books SET borrowed_by = ?, due_date = ? WHERE id = ? AND borrowed_by IS NULL');
    $update->execute([current_user_id(), $dueDate, $bookId]);

    if ($update->rowCount() > 0) {
        flash('success', 'You borrowed "' . $book['title'] . '". Due back ' . date('M j, Y', strtotime($dueDate)) . '.');
    } else {
        // Someone else grabbed it in the moment between the SELECT and this UPDATE.
        flash('error', 'That book was just borrowed by someone else.');
    }
}

header('Location: ../books.php');
exit;
