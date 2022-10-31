-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 03 jun 2021 om 12:10
-- Serverversie: 10.4.11-MariaDB
-- PHP-versie: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `books`
--

CREATE TABLE `books` (
  `id` int(6) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `series` varchar(100) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `owner` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `series`, `filename`, `owner`) VALUES
(10, 'Finality', 'Bob', 'Dawnlands', 'chea.png', 'Tjitze'),
(28, 'Tralala', 'Ben', '', '', 'Frolicsome'),
(30, 'Finality Fun', 'Johnerson', 'Dawnlands NEXT', '56a34f1b0LoH8.png', 'Frolicsome'),
(35, 'Finality to earth', 'Ben', 'Dawnlands', '', 'Frolicsome'),
(36, 'Finality to earth', 'Ben', 'Dawnlands', '', 'Frolicsome'),
(37, 'Finality to earth', 'Ben', 'Dawnlands', '', 'Frolicsome'),
(38, 'Finality Final days', 'Ben', 'Dawnlands', '', 'Frolicsome'),
(39, 'Finality Beach days', 'Shirakome', 'Dawnlands', '', 'Frolicsome'),
(40, 'Finality Happy Night', 'Bob', 'Dawnlands', '', 'Frolicsome'),
(41, 'Finality', 'Johnerson', 'Dawnlands', '', 'Frolicsome'),
(42, 'Finality First Days', 'Shirakome', 'Dawnlands', '', 'Frolicsome'),
(44, 'Arifureta2', 'Hajime', 'Arifureta', 'Chea.png', 'Frolicsome');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `password_reset_request`
--

CREATE TABLE `password_reset_request` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `date_requested` datetime NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `pdoposts`
--

CREATE TABLE `pdoposts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `author`, `is_published`, `created_at`) VALUES
(1, 'Post One', 'This is post one.', 'Tjitze', 1, '2020-05-25 14:14:39'),
(2, 'Post Two', 'This is post two.', 'Ben', 1, '2020-05-25 14:14:39');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `pwdreset`
--

CREATE TABLE `pwdreset` (
  `pwdResetId` int(11) NOT NULL,
  `pwdResetEmail` text NOT NULL,
  `pwdResetSelector` text NOT NULL,
  `pwdResetToken` longtext NOT NULL,
  `pwdResetExpires` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `join_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `join_date`) VALUES
(10, 'demodemo', '$2y$10$2TTbWRwHQ5JRqscZG2I4F.BmrB7wxdjv49zjQ14k3.Bh8Hc1MzBxi', 'demodemo@example.com', '2020-09-09 08:18:11'),
(11, 'Kees', '$2y$10$WltitOD3JSOJDqBIxApEGuh6P79hxCFFUnGyPvGHAprXc6WLqPhYi', 'Kees@example.com', '2020-12-02 14:08:34'),
(13, 'Frolicsome', '$2y$10$1Ge6W8eb.zlav7OpIzO6Nu04/oTIrfQxQfoiYsfm3sKx3xkjgIc6.', 'frolicsomequipster@gmail.com', '2021-01-11 13:33:56'),
(16, 'Tudorlor', '$2y$10$Ynog9wE1gU91q/YO7HqvJOF5Yba4V/1LbHD02vlosh6AWXQAKiIFG', 'Sleutel@gmail.com', '2021-04-07 09:59:21');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `password_reset_request`
--
ALTER TABLE `password_reset_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `pdoposts`
--
ALTER TABLE `pdoposts`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `pwdreset`
--
ALTER TABLE `pwdreset`
  ADD PRIMARY KEY (`pwdResetId`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `books`
--
ALTER TABLE `books`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT voor een tabel `password_reset_request`
--
ALTER TABLE `password_reset_request`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT voor een tabel `pdoposts`
--
ALTER TABLE `pdoposts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `pwdreset`
--
ALTER TABLE `pwdreset`
  MODIFY `pwdResetId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
