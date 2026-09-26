<?php
/**
 * Shared HTML header template.
 *
 * Includes the common <head> setup, Tailwind CSS configuration,
 * main navigation bar, and flash message display logic.
 */
require_once __DIR__ . '/auth.php';
$current = basename($_SERVER['SCRIPT_NAME']);
$pageTitle = $pageTitle ?? 'The Reading Room';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($pageTitle) ?> — The Reading Room</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,500&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/custom.css">
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          ink: '#1c1b1f',
          parchment: '#f7f5ef',
          card: '#ffffff',
          brass: '#b78c56',
          forest: '#2d4a3e',
          rust: '#9e4738',
          glass: 'rgba(255, 255, 255, 0.7)',
        },
        fontFamily: {
          serif: ['Fraunces', 'serif'],
          sans: ['Inter', 'sans-serif'],
        },
        boxShadow: {
          'soft': '0 4px 20px -2px rgba(28, 27, 31, 0.05), 0 0 3px rgba(28, 27, 31, 0.02)',
          'elegant': '0 10px 40px -10px rgba(28, 27, 31, 0.12), 0 1px 3px rgba(28, 27, 31, 0.05)',
        },
        backgroundImage: {
          'subtle-gradient': 'linear-gradient(to bottom, #fcfbf8, #f7f5ef)',
        },
        animation: {
          'fade-in': 'fadeIn 0.4s ease-out forwards',
        },
        keyframes: {
          fadeIn: {
            '0%': { opacity: '0', transform: 'translateY(-10px)' },
            '10%': { opacity: '0', transform: 'translateY(-10px)' },
            '100%': { opacity: '1', transform: 'translateY(0)' },
          }
        }
      }
    }
  }
</script>
</head>
<body class="bg-subtle-gradient text-ink font-sans antialiased min-h-screen selection:bg-brass/20 selection:text-ink">

<header class="sticky top-0 z-50 bg-parchment/70 backdrop-blur-xl border-b border-ink/5 transition-all">
  <div class="max-w-6xl mx-auto px-6 flex items-center justify-between h-16">
    <a href="index.php" class="font-serif text-xl tracking-tight flex items-center gap-2 text-ink hover:opacity-80 transition-opacity">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" class="text-brass shrink-0 drop-shadow-sm">
        <path d="M4 4.5C4 3.67 4.67 3 5.5 3H12V21H5.5C4.67 21 4 20.33 4 19.5V4.5Z" fill="currentColor" opacity="0.85"/>
        <path d="M12 3H18.5C19.33 3 20 3.67 20 4.5V19.5C20 20.33 19.33 21 18.5 21H12V3Z" fill="currentColor" opacity="0.5"/>
      </svg>
      The Reading Room
    </a>
    <nav class="flex items-center gap-1 text-sm font-medium">
      <a href="index.php" class="px-3 py-2 rounded-full transition-all duration-200 <?= $current==='index.php' ? 'text-brass bg-brass/10' : 'hover:text-brass hover:bg-ink/5' ?>">Home</a>
      <?php if (is_logged_in()): ?>
        <a href="books.php" class="px-3 py-2 rounded-full transition-all duration-200 <?= $current==='books.php' ? 'text-brass bg-brass/10' : 'hover:text-brass hover:bg-ink/5' ?>">Catalog</a>
        <a href="my_books.php" class="px-3 py-2 rounded-full transition-all duration-200 <?= $current==='my_books.php' ? 'text-brass bg-brass/10' : 'hover:text-brass hover:bg-ink/5' ?>">My Books</a>
        <span class="w-px h-5 bg-ink/10 mx-2"></span>
        <span class="px-3 py-2 text-ink/60">Hi, <?= e(current_user_name()) ?></span>
        <a href="logout.php" class="px-4 py-2 rounded-full border border-ink/10 hover:border-ink/30 hover:bg-ink/5 transition-all duration-200 ml-1">Log out</a>
      <?php else: ?>
        <a href="login.php" class="px-3 py-2 rounded-full transition-all duration-200 <?= $current==='login.php' ? 'text-brass bg-brass/10' : 'hover:text-brass hover:bg-ink/5' ?>">Log in</a>
        <a href="signup.php" class="ml-2 px-5 py-2 rounded-full bg-ink text-parchment font-medium hover:bg-ink/90 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">Sign up</a>
      <?php endif; ?>
    </nav>
  </div>
</header>

<?php $flashes = get_flashes(); ?>
<?php if (!empty($flashes)): ?>
  <div class="max-w-6xl mx-auto px-6 mt-6 space-y-3 relative z-40">
    <?php foreach ($flashes as $type => $messages): foreach ($messages as $msg): ?>
      <div class="rounded-xl px-5 py-4 text-sm font-medium shadow-soft border backdrop-blur-md flex items-center gap-3 animate-[fade-in_0.3s_ease-out]
        <?= $type === 'error'
            ? 'bg-rust/5 border-rust/20 text-rust'
            : 'bg-forest/5 border-forest/20 text-forest' ?>">
        <?php if ($type === 'error'): ?>
          <svg class="w-5 h-5 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        <?php else: ?>
          <svg class="w-5 h-5 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        <?php endif; ?>
        <?= e($msg) ?>
      </div>
    <?php endforeach; endforeach; ?>
  </div>
<?php endif; ?>
