<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';

if (is_logged_in()) {
    header('Location: books.php');
    exit;
}

$errors = [];
$old = ['name' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name            = trim($_POST['name'] ?? '');
    $email           = trim($_POST['email'] ?? '');
    $password        = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $old = ['name' => $name, 'email' => $email];

    if ($name === '') {
        $errors['name'] = 'Full name is required.';
    }

    if ($email === '') {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter a valid email address.';
    }

    if ($password === '') {
        $errors['password'] = 'Password is required.';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters.';
    }

    if ($confirmPassword === '') {
        $errors['confirm_password'] = 'Please confirm your password.';
    } elseif ($password !== $confirmPassword) {
        $errors['confirm_password'] = 'Passwords do not match.';
    }

    // Only hit the database once the basic shape of the input is valid.
    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors['email'] = 'An account with this email already exists.';
        }
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
        $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);

        flash('success', 'Account created. You can log in now.');
        header('Location: login.php');
        exit;
    }
}

$pageTitle = 'Sign up';
require __DIR__ . '/includes/header.php';
?>

<section class="max-w-md mx-auto px-6 py-20 animate-[fade-in_0.5s_ease-out]">
  <div class="text-center mb-10">
    <h1 class="font-serif text-4xl text-ink mb-3 tracking-tight">Create an account</h1>
    <p class="text-ink/65 font-medium">It takes a minute, and you can start borrowing right away.</p>
  </div>

  <form method="POST" novalidate class="space-y-6 catalog-card p-8 bg-white/70">

    <div>
      <label class="block text-sm font-semibold text-ink/80 mb-2" for="name">Full name</label>
      <input type="text" id="name" name="name" value="<?= e($old['name']) ?>"
        class="modern-input w-full rounded-xl border px-4 py-3 text-ink focus:outline-none focus:ring-2 focus:ring-brass/40
          <?= isset($errors['name']) ? 'border-rust focus:border-rust' : 'border-ink/10 focus:border-brass' ?>">
      <?php if (isset($errors['name'])): ?><p class="text-rust text-sm font-medium mt-1.5"><?= e($errors['name']) ?></p><?php endif; ?>
    </div>

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

    <div>
      <label class="block text-sm font-semibold text-ink/80 mb-2" for="confirm_password">Confirm password</label>
      <input type="password" id="confirm_password" name="confirm_password"
        class="modern-input w-full rounded-xl border px-4 py-3 text-ink focus:outline-none focus:ring-2 focus:ring-brass/40
          <?= isset($errors['confirm_password']) ? 'border-rust focus:border-rust' : 'border-ink/10 focus:border-brass' ?>">
      <?php if (isset($errors['confirm_password'])): ?><p class="text-rust text-sm font-medium mt-1.5"><?= e($errors['confirm_password']) ?></p><?php endif; ?>
    </div>

    <button type="submit" class="w-full py-3.5 rounded-xl bg-ink text-parchment font-semibold hover:bg-ink/90 hover:shadow-soft hover:-translate-y-0.5 transition-all mt-4">
      Create account
    </button>

    <div class="pt-4 border-t border-ink/5 mt-6">
      <p class="text-center text-sm font-medium text-ink/60">
        Already have an account? <a href="login.php" class="text-brass hover:text-brass/80 hover:underline underline-offset-4 transition-all">Log in</a>
      </p>
    </div>
  </form>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
