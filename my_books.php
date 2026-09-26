<?php
/**
 * User's borrowed books page.
 *
 * Displays all books currently borrowed by the logged-in user,
 * along with their due dates and overdue status.
 * Requires the user to be logged in.
 */
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';

require_login();

$stmt = $pdo->prepare('SELECT * FROM books WHERE borrowed_by = ? ORDER BY due_date ASC');
$stmt->execute([current_user_id()]);
$books = $stmt->fetchAll();

$pageTitle = 'My Books';
require __DIR__ . '/includes/header.php';
?>

<section class="max-w-6xl mx-auto px-6 pt-16 pb-24 animate-[fade-in_0.5s_ease-out]">
  <h1 class="font-serif text-5xl text-ink mb-3 tracking-tight">My Books</h1>
  <p class="text-ink/60 mb-12 text-lg font-medium">Everything currently on your desk.</p>

  <?php if (empty($books)): ?>
    <div class="text-center py-32 text-ink/50 animate-[fade-in_0.6s_ease-out_0.2s_both]">
      <div class="w-16 h-16 mx-auto mb-4 bg-ink/5 rounded-2xl flex items-center justify-center">
        <svg class="w-8 h-8 text-ink/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
      </div>
      <p class="font-serif text-2xl text-ink/70 mb-2">Your desk is empty.</p>
      <p class="mb-8 text-lg">Borrow something from the catalog to see it here.</p>
      <a href="books.php" class="inline-block px-8 py-3.5 rounded-xl bg-ink text-parchment font-semibold hover:bg-ink/90 hover:-translate-y-0.5 hover:shadow-soft transition-all">
        Browse the catalog
      </a>
    </div>
  <?php else: ?>
    <div class="space-y-5">
      <?php foreach ($books as $i => $book):
        $daysLeft = (int)((strtotime($book['due_date']) - strtotime(date('Y-m-d'))) / 86400);
        $isOverdue = $daysLeft < 0;
        $delay = 0.1 + ($i * 0.05);
      ?>
        <div class="catalog-card p-5 flex flex-col md:flex-row md:items-center gap-6 animate-[fade-in_0.5s_ease-out_both]" style="animation-delay: <?= $delay ?>s;">
          <div class="flex items-center gap-5 flex-1 min-w-0">
            <div class="w-12 h-16 rounded-lg shrink-0 shadow-sm border border-ink/5 relative overflow-hidden" style="background:<?= e($book['cover_color']) ?>">
               <div class="absolute inset-0 bg-gradient-to-tr from-black/10 to-transparent"></div>
            </div>

            <div class="flex-1 min-w-0">
              <h3 class="font-serif text-xl text-ink truncate mb-0.5"><?= e($book['title']) ?></h3>
              <p class="text-sm text-ink/65 font-medium"><?= e($book['author']) ?> <span class="mx-1.5 opacity-50">•</span> <?= e($book['category']) ?></p>
            </div>
          </div>

          <div class="flex items-center justify-between md:justify-end gap-8 pt-4 md:pt-0 border-t border-ink/5 md:border-none">
            <div class="text-left md:text-right shrink-0">
              <p class="text-sm font-semibold <?= $isOverdue ? 'text-rust' : 'text-ink/80' ?>">
                <?= $isOverdue ? 'Overdue' : 'Due ' . date('M j, Y', strtotime($book['due_date'])) ?>
              </p>
              <p class="text-xs font-medium <?= $isOverdue ? 'text-rust/70' : 'text-ink/40' ?> mt-0.5">
                <?= $isOverdue ? abs($daysLeft) . ' day' . (abs($daysLeft) === 1 ? '' : 's') . ' past due' : $daysLeft . ' day' . ($daysLeft === 1 ? '' : 's') . ' left' ?>
              </p>
            </div>

            <form method="POST" action="actions/return.php" class="shrink-0">
              <input type="hidden" name="book_id" value="<?= (int)$book['id'] ?>">
              <button type="submit" class="px-6 py-2.5 rounded-xl border border-ink/10 text-sm font-semibold text-ink/70 hover:border-rust/30 hover:text-rust hover:bg-rust/5 transition-all">
                Return
              </button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
