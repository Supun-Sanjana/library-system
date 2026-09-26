-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2026 at 07:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `author` varchar(120) NOT NULL,
  `category` varchar(60) NOT NULL,
  `cover_color` varchar(7) NOT NULL DEFAULT '#A9773F',
  `description` text DEFAULT NULL,
  `borrowed_by` int(11) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `category`, `cover_color`, `description`, `borrowed_by`, `due_date`, `created_at`) VALUES
(1, 'The Silent Patient', 'Alex Michaelides', 'Fiction', '#8C3B2E', 'A psychotherapist becomes obsessed with treating a woman who refuses to speak after allegedly murdering her husband.', NULL, NULL, '2026-09-22 13:23:02'),
(2, 'Sapiens', 'Yuval Noah Harari', 'Non-Fiction', '#3F5D4E', 'A sweeping look at how Homo sapiens came to dominate the world, from cognitive revolution to the modern age.', NULL, NULL, '2026-09-22 13:23:02'),
(3, 'Clean Code', 'Robert C. Martin', 'Technology', '#1B2430', 'A handbook of agile software craftsmanship, teaching principles for writing readable, maintainable code.', NULL, NULL, '2026-09-22 13:23:02'),
(4, 'The Hobbit', 'J.R.R. Tolkien', 'Fantasy', '#A9773F', 'Bilbo Baggins is swept into an epic quest to reclaim a dwarven kingdom from the dragon Smaug.', NULL, NULL, '2026-09-22 13:23:02'),
(5, 'Atomic Habits', 'James Clear', 'Self-Help', '#5B4636', 'A practical guide to building good habits and breaking bad ones through small, consistent changes.', NULL, NULL, '2026-09-22 13:23:02'),
(6, 'Cosmos', 'Carl Sagan', 'Science', '#2F5C6E', 'A journey through the universe exploring the origins of life, the cosmos, and our place within it.', NULL, NULL, '2026-09-22 13:23:02'),
(7, 'Pride and Prejudice', 'Jane Austen', 'Classic', '#6B3F52', 'Elizabeth Bennet navigates issues of manners, upbringing, and marriage in Georgian-era England.', NULL, NULL, '2026-09-22 13:23:02'),
(8, 'The Pragmatic Programmer', 'David Thomas & Andrew Hunt', 'Technology', '#1B2430', 'Timeless advice for becoming a more effective and adaptable software developer.', NULL, NULL, '2026-09-22 13:23:02'),
(9, 'Educated', 'Tara Westover', 'Memoir', '#7A5230', 'A woman raised in a survivalist family in rural Idaho pursues an education that takes her to Cambridge.', NULL, NULL, '2026-09-22 13:23:02'),
(10, 'Dune', 'Frank Herbert', 'Sci-Fi', '#8C3B2E', 'On the desert planet Arrakis, a young heir becomes embroiled in a war over the most valuable substance in the universe.', 1, '2026-10-10', '2026-09-22 13:23:02'),
(11, 'The Design of Everyday Things', 'Don Norman', 'Design', '#A9773F', 'A guide to human-centered design, explaining why some products satisfy customers while others frustrate them.', NULL, NULL, '2026-09-22 13:23:02'),
(12, 'Circe', 'Madeline Miller', 'Fantasy', '#3F5D4E', 'The story of the witch Circe, banished to a deserted island where she hones her powers and crosses paths with famous myths.', NULL, NULL, '2026-09-22 13:23:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'test', 'test@gmail.com', '$2y$10$ycT2vmncEooOBLzSrfhXAe20J4cX/CRiCEwJRp322vSBExp.nuGNq', '2026-09-26 05:20:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_books_borrowed_by` (`borrowed_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_users_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_borrowed_by` FOREIGN KEY (`borrowed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
