<?php
/**
 * Landing page.
 *
 * Displays a welcome message, features, and a preview of recently added books.
 * Accessible to both logged-in and guest users.
 */
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';

// Pull a handful of books for the "on the shelf" preview — no login required to look.
$stmt = $pdo->query("SELECT title, author, category, cover_color FROM books ORDER BY created_at DESC LIMIT 8");
$preview = $stmt->fetchAll();

$pageTitle = 'Home';
require __DIR__ . '/includes/header.php';
?>

<section class="max-w-6xl mx-auto px-6 pt-24 pb-16 grid md:grid-cols-2 gap-16 items-center relative">
  <!-- Decorative background elements -->
  <div class="absolute top-0 left-10 w-96 h-96 bg-brass/10 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-pulse" style="animation-duration: 8s;"></div>
  
  <div class="relative z-10 animate-[fade-in_0.6s_ease-out]">
    <h1 class="font-serif text-6xl md:text-7xl leading-[1.1] text-ink tracking-tight">
      A quiet place<br>
      <span class="text-brass/90 italic">to keep your books.</span>
    </h1>
    <p class="mt-8 text-ink/75 text-lg md:text-xl max-w-md leading-relaxed font-medium">
      Browse the catalog, borrow what you need, and see what's already
      on your desk — no fines, no fuss.
    </p>
    <div class="mt-10 flex flex-wrap items-center gap-5">
      <?php if (is_logged_in()): ?>
        <a href="books.php" class="px-8 py-4 rounded-full bg-ink text-parchment font-semibold hover:bg-ink/90 hover:shadow-elegant hover:-translate-y-1 transition-all duration-300">
          Browse the catalog
        </a>
      <?php else: ?>
        <a href="signup.php" class="px-8 py-4 rounded-full bg-ink text-parchment font-semibold hover:bg-ink/90 hover:shadow-elegant hover:-translate-y-1 transition-all duration-300">
          Create an account
        </a>
        <a href="login.php" class="px-6 py-4 rounded-full text-ink font-semibold border border-ink/10 hover:border-ink/30 hover:bg-ink/5 transition-all duration-300">
          I already have one
        </a>
      <?php endif; ?>
    </div>
  </div>

  <div class="shelf justify-center md:justify-end animate-[fade-in_0.8s_ease-out_0.2s_both] relative z-10">
    <?php
      // A little variety in spine height/width so the shelf doesn't look uniform.
      $widths  = [48, 40, 54, 36, 46, 42, 38, 50];
      $heights = [290, 250, 310, 220, 270, 240, 260, 280];
      foreach ($preview as $i => $book):
        $w = $widths[$i % count($widths)];
        $h = $heights[$i % count($heights)];
    ?>
      <div class="spine" style="width:<?= $w ?>px; height:<?= $h ?>px; background:<?= e($book['cover_color']) ?>;" title="<?= e($book['title']) ?>">
        <span><?= e($book['title']) ?></span>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="max-w-6xl mx-auto px-6 py-20 grid sm:grid-cols-3 gap-8">
  <div>
    <h3 class="font-serif text-xl text-ink mb-2">Look through the catalog</h3>
    <p class="text-ink/60 text-sm leading-relaxed">Search and filter by category to find what's available right now.</p>
  </div>
  <div>
    <h3 class="font-serif text-xl text-ink mb-2">Borrow with one click</h3>
    <p class="text-ink/60 text-sm leading-relaxed">Request a book and it's set aside for you, with a due date two weeks out.</p>
  </div>
  <div>
    <h3 class="font-serif text-xl text-ink mb-2">Keep track of your desk</h3>
    <p class="text-ink/60 text-sm leading-relaxed">"My Books" shows everything you're holding, and when it's due back.</p>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
