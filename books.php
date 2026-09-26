<?php
/**
 * Book catalog page.
 *
 * Displays all books available in the library with optional search by title/author
 * and filtering by category. Requires the user to be logged in.
 */
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';

require_login();

$q        = trim($_GET['q'] ?? '');
$category = trim($_GET['category'] ?? '');

$categories = $pdo->query('SELECT DISTINCT category FROM books ORDER BY category')->fetchAll(PDO::FETCH_COLUMN);

$sql = 'SELECT * FROM books WHERE 1=1';
$params = [];

if ($q !== '') {
    $sql .= ' AND (title LIKE ? OR author LIKE ?)';
    $params[] = "%$q%";
    $params[] = "%$q%";
}
if ($category !== '') {
    $sql .= ' AND category = ?';
    $params[] = $category;
}
$sql .= ' ORDER BY title';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$books = $stmt->fetchAll();

$pageTitle = 'Catalog';
require __DIR__ . '/includes/header.php';
?>

<section class="max-w-6xl mx-auto px-6 pt-16 pb-8 animate-[fade-in_0.5s_ease-out]">
  <h1 class="font-serif text-5xl text-ink mb-3 tracking-tight">Catalog</h1>
  <p class="text-ink/60 mb-10 text-lg font-medium">
    <?= count($books) ?> book<?= count($books) === 1 ? '' : 's' ?>
    <?= ($q !== '' || $category !== '') ? 'matching your search' : 'on the shelves' ?>
  </p>

  <form method="GET" class="flex flex-col sm:flex-row gap-4 mb-12">
    <div class="flex-1 relative">
      <svg class="absolute left-4 top-3.5 w-5 h-5 text-ink/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
      </svg>
      <input type="text" name="q" value="<?= e($q) ?>" placeholder="Search by title or author"
        class="modern-input w-full rounded-xl border border-ink/10 pl-11 pr-4 py-3 text-ink placeholder:text-ink/40 focus:outline-none focus:ring-2 focus:ring-brass/40 focus:border-brass">
    </div>
    <select name="category" onchange="this.form.submit()"
      class="modern-input rounded-xl border border-ink/10 px-5 py-3 text-ink focus:outline-none focus:ring-2 focus:ring-brass/40 focus:border-brass appearance-none bg-no-repeat bg-[right_1rem_center] bg-[length:1em] cursor-pointer"
      style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%231c1b1f%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E');">
      <option value="">All categories</option>
      <?php foreach ($categories as $cat): ?>
        <option value="<?= e($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>><?= e($cat) ?></option>
      <?php endforeach; ?>
    </select>
    <button type="submit" class="px-8 py-3 rounded-xl bg-ink text-parchment font-semibold hover:bg-ink/90 hover:shadow-soft hover:-translate-y-0.5 transition-all">
      Search
    </button>
    <?php if ($q !== '' || $category !== ''): ?>
      <a href="books.php" class="px-6 py-3 rounded-xl border border-ink/10 text-ink/70 font-medium hover:text-ink hover:border-ink/30 hover:bg-ink/5 transition-all text-center flex items-center justify-center">
        Clear
      </a>
    <?php endif; ?>
  </form>

  <?php if (empty($books)): ?>
    <div class="text-center py-32 text-ink/50 animate-[fade-in_0.6s_ease-out_0.2s_both]">
      <svg class="w-16 h-16 mx-auto text-ink/20 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
      </svg>
      <p class="font-serif text-2xl text-ink/70 mb-2">No books match that search.</p>
      <p class="text-lg">Try a different title, author, or category.</p>
    </div>
  <?php else: ?>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 pb-24">
      <?php foreach ($books as $i => $book):
        $isAvailable = $book['borrowed_by'] === null;
        $isMine      = !$isAvailable && (int)$book['borrowed_by'] === (int)current_user_id();
        $delay = 0.2 + ($i * 0.05);
      ?>
        <div class="catalog-card p-7 flex flex-col justify-between animate-[fade-in_0.6s_ease-out_both]" style="animation-delay: <?= $delay ?>s;">
          <div>
            <div class="flex items-start gap-5">
              <div class="w-16 h-24 rounded-lg shrink-0 shadow-soft border border-ink/5 relative overflow-hidden" style="background:<?= e($book['cover_color']) ?>">
                 <div class="absolute inset-0 bg-gradient-to-tr from-black/10 to-transparent"></div>
              </div>
              <div class="min-w-0 pt-1">
                <h3 class="font-serif text-xl text-ink leading-tight mb-1 truncate" title="<?= e($book['title']) ?>"><?= e($book['title']) ?></h3>
                <p class="text-sm text-ink/70 font-medium"><?= e($book['author']) ?></p>
                <span class="inline-block mt-3 text-xs px-2.5 py-1 rounded-full bg-parchment border border-ink/10 text-ink/70 font-medium shadow-sm"><?= e($book['category']) ?></span>
              </div>
            </div>

            <p class="text-sm text-ink/65 mt-6 leading-relaxed line-clamp-3"><?= e($book['description']) ?></p>
          </div>

          <div class="mt-6 pt-5 border-t border-ink/5">
            <?php if ($isAvailable): ?>
              <form method="POST" action="actions/borrow.php">
                <input type="hidden" name="book_id" value="<?= (int)$book['id'] ?>">
                <button type="submit" class="w-full py-2.5 rounded-xl bg-forest text-white text-sm font-semibold hover:bg-forest/90 hover:shadow-md transition-all">
                  Request to borrow
                </button>
              </form>
            <?php elseif ($isMine): ?>
              <a href="my_books.php" class="block text-center w-full py-2.5 rounded-xl bg-brass/10 text-brass border border-brass/20 text-sm font-semibold hover:bg-brass/20 transition-all">
                On your desk — due <?= date('M j', strtotime($book['due_date'])) ?>
              </a>
            <?php else: ?>
              <div class="w-full py-2.5 rounded-xl bg-ink/5 text-ink/40 text-sm font-semibold text-center border border-ink/5">
                Currently borrowed
              </div>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
