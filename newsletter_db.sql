-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Värd: db
-- Tid vid skapande: 21 maj 2024 kl 08:27
-- Serverversion: 10.6.17-MariaDB-1:10.6.17+maria~ubu2004
-- PHP-version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `newsletter_db`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `generated_codes`
--

CREATE TABLE `generated_codes` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `code` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `generated_codes`
--

INSERT INTO `generated_codes` (`id`, `email`, `code`, `created_at`) VALUES
(1, '0', 565779, '2024-05-13 07:14:30'),
(2, '0', 909287, '2024-05-13 10:31:50');

-- --------------------------------------------------------

--
-- Tabellstruktur `newsletters`
--

CREATE TABLE `newsletters` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `owner` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `newsletters`
--

INSERT INTO `newsletters` (`id`, `name`, `description`, `owner`) VALUES
(1, 'Kamratposten!', 'För dig som undrar över livets stora frågor.', NULL),
(2, 'Ointressant Hemslöjd!', 'Tar dig med på en ovanlig resa genom världen av helt ordinära skapelser.', NULL),
(3, 'Värdelösa Växlar', 'Om tråkiga utgifter och punktering på vägen', NULL),
(4, 'En Fjäderfäs Funderingar!', 'Tar dig på en resa genom fågelsångens mystik och vardagsångest.', NULL),
(10, 'Fotografens Under', 'Om fotoljus och grejer', 27);

-- --------------------------------------------------------

--
-- Tabellstruktur `reset_password`
--

CREATE TABLE `reset_password` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `reset_password`
--

INSERT INTO `reset_password` (`id`, `user_id`, `code`) VALUES
(10, 23, '556984');

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(255) DEFAULT NULL,
  `role` enum('kund','prenumerant') NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `firstname`, `lastname`) VALUES
(21, 'rebecca@test.com', '$2y$10$57NA5BVn30RoyMvTB94mo.eNbpIxR5XKFEM1buBLlyi6n2YBJ4Cai', 'prenumerant', 'rebecca', 'rebecca'),
(23, 'rebeccahansson2016@gmail.com', '$2y$10$egsR7eARqZU1jviizQ/iS.Ri1X41sjDGunTdoLsy2zJm4m0qc1SgC', 'prenumerant', 'Rebecka', 'Hansson'),
(24, 'gurra@test.com', '$2y$10$rcvE.0rDMMENR9HZtW2kJ.bKJK2VwFub5u1NsgtDNFuigQgzAowKG', 'prenumerant', 'Gustavo', 'Fring'),
(25, 'biggan@test.com', '$2y$10$2BhaC4Qcmc6FOiSEdwMBqOIAqYFSuWa8ecZXA4ixeyZbGBCn1bSza', 'prenumerant', 'Birgitta', 'GöttÅLeva'),
(26, 'klara@test.com', '$2y$10$mbHgtAhSSXRDCtUdy9R7bedMbORIlvs.E3nglqJ1xh6J0XeeHsxwG', 'prenumerant', 'Klara', 'Klarsson'),
(27, 'hej@fotografrebeccahansson.com', '$2y$10$bUzM1pAbubvTGduW7WTuh.d9Q5CcMOVngttPm2mREBquYl.oc0tni', 'kund', 'Fotograf', 'Rebecca'),
(28, 'testy@test.com', '$2y$10$pxpxqArq5zJrZOa2k3B0tO2kHvYurB/3h5zvZhGB1/LxUq9grIpuO', 'prenumerant', 'Testy', 'Testysson');

-- --------------------------------------------------------

--
-- Tabellstruktur `user_subscriptions`
--

CREATE TABLE `user_subscriptions` (
  `id` int(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `newsletter_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `user_subscriptions`
--

INSERT INTO `user_subscriptions` (`id`, `user_id`, `newsletter_id`) VALUES
(20, 21, 1),
(21, 23, 1),
(22, 23, 2),
(23, 23, 3),
(24, 23, 4),
(25, 24, 4),
(26, 25, 2),
(27, 26, 3),
(28, 26, 1),
(29, 26, 10),
(32, 24, 10),
(33, 25, 10),
(34, 28, 3),
(35, 28, 2);

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `generated_codes`
--
ALTER TABLE `generated_codes`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_owner` (`owner`);

--
-- Index för tabell `reset_password`
--
ALTER TABLE `reset_password`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index för tabell `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `newsletter_id` (`newsletter_id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `generated_codes`
--
ALTER TABLE `generated_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT för tabell `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT för tabell `reset_password`
--
ALTER TABLE `reset_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT för tabell `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT för tabell `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `newsletters`
--
ALTER TABLE `newsletters`
  ADD CONSTRAINT `fk_owner` FOREIGN KEY (`owner`) REFERENCES `users` (`id`);

--
-- Restriktioner för tabell `reset_password`
--
ALTER TABLE `reset_password`
  ADD CONSTRAINT `reset_password_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Restriktioner för tabell `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  ADD CONSTRAINT `user_subscriptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_subscriptions_ibfk_2` FOREIGN KEY (`newsletter_id`) REFERENCES `newsletters` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
