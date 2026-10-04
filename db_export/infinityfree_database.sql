-- IT0049 POS TFA4 - InfinityFree phpMyAdmin Import
-- Target Database: if0_43084784_tfa4
-- Note: Do NOT include CREATE DATABASE or USE statements, as InfinityFree restricts these permissions.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Table structure for table `customers`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `full_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20),
    `created_at` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Seed data for table `customers`
-- --------------------------------------------------------

INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`, `created_at`) VALUES
(1, 'Leila Hassan', 'leila.hassan@example.com', '+20 10 1234 5678', '2026-09-01 08:30:00'),
(2, 'Hiroshi Tanaka', 'hiroshi.tanaka@example.com', '+81 90 2345 6789', '2026-09-02 09:15:00'),
(3, 'Priya Sharma', 'priya.sharma@example.com', '+91 98765 43210', '2026-09-03 10:45:00'),
(4, 'Amina Okafor', 'amina.okafor@example.com', '+234 803 456 7890', '2026-09-04 11:20:00'),
(5, 'Mateo Garcia', 'mateo.garcia@example.com', '+52 55 1234 5678', '2026-09-05 14:00:00'),
(6, 'Mei Lin Chen', 'meilin.chen@example.com', '+65 8123 4567', '2026-09-06 16:30:00');

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `full_name` VARCHAR(100) NOT NULL,
    `avatar` VARCHAR(255) NULL,
    `created_at` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Seed data for table `users`
-- --------------------------------------------------------

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `avatar`, `created_at`) VALUES
(1, 'leila.hassan', '$2y$12$JHnCjP8guQgimkl8ewVYr.yvx2/JMQFod57TUubFNheqa7EWAB6ay', 'Leila Hassan', NULL, '2026-08-15 08:00:00'),
(2, 'hiroshi.tanaka', '$2y$12$Q4n2SZdZoyGy55Hhg8ZF2Ou4nIDiFCVjqYP66MhmRDNacPuJO3ZT.', 'Hiroshi Tanaka', NULL, '2026-08-16 09:00:00'),
(3, 'priya.sharma', '$2y$12$Yp66hl/cp5PAWH0Z850nzOIKR/a1nu09Jpeo9SPQb9beDBIE8Ll6S', 'Priya Sharma', NULL, '2026-08-17 10:00:00'),
(4, 'amina.okafor', '$2y$12$MuolmmG/1a3wMMn6bmq5zOwueS9wWMSmq51zfPO2/7nN.zZ40Na.u', 'Amina Okafor', NULL, '2026-08-18 11:00:00'),
(5, 'mateo.garcia', '$2y$12$NgyKocUvP30gSB0vqrZy/uZ9lbTqG0pKv1Y8ACWMJ.j0GejmzWZTS', 'Mateo Garcia', NULL, '2026-08-19 13:00:00'),
(6, 'meilin.chen', '$2y$12$3Y/bskHZj9cDiT8Ng2y/XOAdRVztOQ7rUbz9ZY.Y1B.1nN5f.Ks.i', 'Mei Lin Chen', NULL, '2026-08-20 15:00:00');

COMMIT;
