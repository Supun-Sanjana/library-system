-- Library Management System — schema
-- 2 tables: users, books. A book can be borrowed by at most one user at a time
-- (borrowed_by / due_date live directly on the books row — no separate loans table).

CREATE DATABASE IF NOT EXISTS library_system CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE library_system;

CREATE TABLE IF NOT EXISTS users (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    name          VARCHAR(100)  NOT NULL,
    email         VARCHAR(150)  NOT NULL,
    password      VARCHAR(255)  NOT NULL,
    created_at    TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS books (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    title         VARCHAR(150)  NOT NULL,
    author        VARCHAR(120)  NOT NULL,
    category      VARCHAR(60)   NOT NULL,
    cover_color   VARCHAR(7)    NOT NULL DEFAULT '#A9773F',
    description   TEXT          NULL,
    borrowed_by   INT           NULL,
    due_date      DATE          NULL,
    created_at    TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_books_borrowed_by FOREIGN KEY (borrowed_by)
        REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
