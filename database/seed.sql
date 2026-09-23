-- Sample catalog. Run after schema.sql. Safe to re-run (clears books first).
USE library_system;

DELETE FROM books;

INSERT INTO books (title, author, category, cover_color, description) VALUES
('The Silent Patient', 'Alex Michaelides', 'Fiction', '#8C3B2E', 'A psychotherapist becomes obsessed with treating a woman who refuses to speak after allegedly murdering her husband.'),
('Sapiens', 'Yuval Noah Harari', 'Non-Fiction', '#3F5D4E', 'A sweeping look at how Homo sapiens came to dominate the world, from cognitive revolution to the modern age.'),
('Clean Code', 'Robert C. Martin', 'Technology', '#1B2430', 'A handbook of agile software craftsmanship, teaching principles for writing readable, maintainable code.'),
('The Hobbit', 'J.R.R. Tolkien', 'Fantasy', '#A9773F', 'Bilbo Baggins is swept into an epic quest to reclaim a dwarven kingdom from the dragon Smaug.'),
('Atomic Habits', 'James Clear', 'Self-Help', '#5B4636', 'A practical guide to building good habits and breaking bad ones through small, consistent changes.'),
('Cosmos', 'Carl Sagan', 'Science', '#2F5C6E', 'A journey through the universe exploring the origins of life, the cosmos, and our place within it.'),
('Pride and Prejudice', 'Jane Austen', 'Classic', '#6B3F52', 'Elizabeth Bennet navigates issues of manners, upbringing, and marriage in Georgian-era England.'),
('The Pragmatic Programmer', 'David Thomas & Andrew Hunt', 'Technology', '#1B2430', 'Timeless advice for becoming a more effective and adaptable software developer.'),
('Educated', 'Tara Westover', 'Memoir', '#7A5230', 'A woman raised in a survivalist family in rural Idaho pursues an education that takes her to Cambridge.'),
('Dune', 'Frank Herbert', 'Sci-Fi', '#8C3B2E', 'On the desert planet Arrakis, a young heir becomes embroiled in a war over the most valuable substance in the universe.'),
('The Design of Everyday Things', 'Don Norman', 'Design', '#A9773F', 'A guide to human-centered design, explaining why some products satisfy customers while others frustrate them.'),
('Circe', 'Madeline Miller', 'Fantasy', '#3F5D4E', 'The story of the witch Circe, banished to a deserted island where she hones her powers and crosses paths with famous myths.');
