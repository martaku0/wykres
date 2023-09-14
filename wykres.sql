-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 14 Wrz 2023, 12:49
-- Wersja serwera: 10.4.20-MariaDB
-- Wersja PHP: 7.4.22

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
(3, '36.3', 3);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
