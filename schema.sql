-- Base MySQL du projet (XAMPP / phpMyAdmin)
CREATE DATABASE IF NOT EXISTS l2BD CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE l2BD;

CREATE TABLE IF NOT EXISTS Students (
    id      INT AUTO_INCREMENT PRIMARY KEY,
    name    VARCHAR(100) NOT NULL,
    cin     VARCHAR(20)  NOT NULL,
    email   VARCHAR(150) NOT NULL,
    image   VARCHAR(255),
    address TEXT
);

-- Données de démonstration
INSERT INTO Students (name, cin, email, image, address) VALUES
('Amira Gharbi',   '09876543', 'amira.gharbi@example.com',   '', 'Tunis'),
('Youssef Jebali', '11223344', 'youssef.jebali@example.com', '', 'Sfax'),
('Sara Maalej',    '55667788', 'sara.maalej@example.com',    '', 'Sousse');
