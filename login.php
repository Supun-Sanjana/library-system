<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';

if (is_logged_in()) {
    header('Location: books.php');
    exit;
}

$errors = [];
$old = ['email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $old = ['email' => $email];

    if ($email === '')    $errors['email'] = 'Email is required.';
    if ($password === '') $errors['password'] = 'Password is required.';

    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT id, name, password FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            // Deliberately vague about which field was wrong — don't reveal whether the email exists.
            $errors['form'] = 'That email or password is incorrect.';
        } else {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header('Location: books.php');
            exit;
        }
    }
}

$pageTitle = 'Log in';
require __DIR__ . '/includes/header.php';
?>

<section class="max-w-md mx-auto px-6 py-24 animate-[fade-in_0.5s_ease-out]">
  <div class="text-center mb-10">
    <h1 class="font-serif text-4xl text-ink mb-3 tracking-tight">Welcome back</h1>
    <p class="text-ink/65 font-medium">Log in to see the catalog and your books.</p>
  </div>

  <form method="POST" novalidate class="space-y-6 catalog-card p-8 bg-white/70">

    <?php if (isset($errors['form'])): ?>
      <div class="rounded-xl bg-rust/5 border border-rust/20 text-rust text-sm font-medium px-4 py-3 flex items-center gap-2">
        <svg class="w-5 h-5 opacity-80 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <?= e($errors['form']) ?>
      </div>
    <?php endif; ?>

    <div>
      <label class="block text-sm font-semibold text-ink/80 mb-2" for="email">Email</label>
      <input type="text" id="email" name="email" value="<?= e($old['email']) ?>"
        class="modern-input w-full rounded-xl border px-4 py-3 text-ink focus:outline-none focus:ring-2 focus:ring-brass/40
          <?= isset($errors['email']) ? 'border-rust focus:border-rust' : 'border-ink/10 focus:border-brass' ?>">
      <?php if (isset($errors['email'])): ?><p class="text-rust text-sm font-medium mt-1.5"><?= e($errors['email']) ?></p><?php endif; ?>
    </div>

    <div>
      <label class="block text-sm font-semibold text-ink/80 mb-2" for="password">Password</label>
      <input type="password" id="password" name="password"
        class="modern-input w-full rounded-xl border px-4 py-3 text-ink focus:outline-none focus:ring-2 focus:ring-brass/40
          <?= isset($errors['password']) ? 'border-rust focus:border-rust' : 'border-ink/10 focus:border-brass' ?>">
      <?php if (isset($errors['password'])): ?><p class="text-rust text-sm font-medium mt-1.5"><?= e($errors['password']) ?></p><?php endif; ?>
    </div>

    <button type="submit" class="w-full py-3.5 rounded-xl bg-ink text-parchment font-semibold hover:bg-ink/90 hover:shadow-soft hover:-translate-y-0.5 transition-all mt-4">
      Log in
    </button>

    <div class="pt-4 border-t border-ink/5 mt-6">
      <p class="text-center text-sm font-medium text-ink/60">
        New here? <a href="signup.php" class="text-brass hover:text-brass/80 hover:underline underline-offset-4 transition-all">Create an account</a>
      </p>
    </div>
  </form>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
