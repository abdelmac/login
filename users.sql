-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 22, 2024 at 04:20 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `utilisateurs`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(110) NOT NULL,
  `pseudo` text NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `mdp` text NOT NULL,
  `email` text NOT NULL,
  `token` varchar(400) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `nom`, `prenom`, `mdp`, `email`, `token`) VALUES
(1, 'zakiller', 'iller', 'zak', '$2y$10$3hVXsoOyMvTfnSR5KcZb4ehgzT6V6N36liUNnoT.9sTy1/cmmLTdW', 'zak@gmail.com', '1e9467e78a7736640d15506605253f6ee663700c11f9ec1af5db92069f8d184f'),
(2, 'mac', 'mac', 'mac', '$2y$10$dbPwpOAvlFs2K2/O3d4lBuE52CmJg9DvbpQBkL1Kn/3T.uxqg7C3e', 'mac@gmail.com', '33fd9db85096ea56d2f9f14194d0d0b6ff4c7b7a1dd9f46dd49da00839cb9003');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(110) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
