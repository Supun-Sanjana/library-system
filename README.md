# The Reading Room — Library Management System

PHP (PDO) + MySQL, styled with Tailwind CSS (CDN). Built for XAMPP.

## Setup

1. Copy this whole `library-system` folder into your XAMPP `htdocs` directory, e.g.
   `C:\xampp\htdocs\library-system\` (Windows) or `/Applications/XAMPP/htdocs/library-system/` (Mac).
2. Start **Apache** and **MySQL** in the XAMPP control panel.
3. Open `http://localhost/phpmyadmin`, click **Import**, and run `database/schema.sql`.
   This creates the `library_system` database with the `users` and `books` tables.
4. Import `database/seed.sql` the same way to load 12 sample books.
5. Visit `http://localhost/library-system/` in your browser.
6. Sign up for an account, then log in — you'll land in the catalog.

## Default DB connection (config/db.php)

- Host: `localhost`
- Database: `library_system`
- User: `root`
- Password: *(empty)*

This matches a default XAMPP MySQL install. If your MySQL has a root password set,
update `config/db.php`.

## Project structure

```
library-system/
  config/db.php          PDO connection
  includes/auth.php       session, validation, flash-message helpers
  includes/header.php     nav bar + Tailwind/font setup, shared on every page
  includes/footer.php     shared footer
  css/custom.css          book-spine hero + catalog-card styling
  actions/borrow.php      POST handler: borrow a book
  actions/return.php      POST handler: return a book
  index.php               landing page
  signup.php               registration, per-field validation
  login.php                 authentication
  books.php                catalog: search, filter by category, borrow
  my_books.php               books currently borrowed by the logged-in user
  database/schema.sql      users + books tables
  database/seed.sql        12 sample books
```

## How borrowing works

Borrowing/returning is tracked directly on the `books` row (`borrowed_by`, `due_date`) —
there's no separate loans table, since each book can only be checked out by one person
at a time. Borrowing sets a due date 14 days out; returning clears both fields, which is
what makes the book available to borrow again.

## Managing the catalog

There's no admin page. Add, edit, or remove books directly in `phpMyAdmin` on the
`books` table, or edit and re-run `database/seed.sql`.
