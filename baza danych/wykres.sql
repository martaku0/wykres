-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 26 Wrz 2023, 10:27
-- Wersja serwera: 10.4.17-MariaDB
-- Wersja PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `wykres`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pomiary`
--

CREATE TABLE `pomiary` (
  `id` int(11) NOT NULL,
  `pomiar` varchar(255) DEFAULT NULL,
  `dzien` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `pomiary`
--

INSERT INTO `pomiary` (`id`, `pomiar`, `dzien`) VALUES
(1, '36.4', 1),
(2, '36.35', 2),
(3, '36.3', 3),
(4, '36.3', 4),
(5, '36.4', 5),
(6, '36.37', 6),
(7, '36.25', 7),
(8, '36.4', 9),
(9, '36.31', 10),
(10, '36.2', 11),
(11, '36.7', 12),
(12, '36.1', 13),
(13, '36.62', 14),
(14, '36.63', 15),
(15, '36.75', 16),
(16, '36.6', 17),
(17, '36.75', 18),
(18, '36.8', 19),
(19, 'brak', 20),
(20, 'choroba', 21),
(21, 'choroba', 22),
(22, 'brak', 23),
(23, 'brak', 24),
(24, 'brak', 25),
(25, '36.5', 26),
(26, '36.6', 27),
(27, '36.6', 28);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `pomiary`
--
ALTER TABLE `pomiary`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dzien` (`dzien`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `pomiary`
--
ALTER TABLE `pomiary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
