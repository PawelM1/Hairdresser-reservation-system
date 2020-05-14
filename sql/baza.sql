-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 14 Maj 2020, 19:42
-- Wersja serwera: 10.4.10-MariaDB
-- Wersja PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `barber`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `name` varchar(60) COLLATE utf8_bin NOT NULL,
  `surname` varchar(60) COLLATE utf8_bin NOT NULL,
  `phone_number` varchar(12) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `client`
--

INSERT INTO `client` (`id`, `name`, `surname`, `phone_number`) VALUES
(1, 'Jan', 'Kowalski', '480480480'),
(2, 'Tomek', 'Nowak', '123456789'),
(44, 'jasdjn', 'dsfsdf', '83247'),
(45, 'asdasd', 'asdasd', '124'),
(46, 'Adrian', 'Puchacki', '1234'),
(47, 'Jarosław', 'Psikuta', '1234'),
(48, 'Tytus', 'Bomba', '132'),
(55, 'Michael', 'Jordan', '3123');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `haircut`
--

CREATE TABLE `haircut` (
  `id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_bin NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `haircut`
--

INSERT INTO `haircut` (`id`, `name`, `price`) VALUES
(1, 'Maszynką', 30),
(2, 'Klasyczne', 40),
(3, 'Broda', 20),
(4, 'Klasyczne + broda', 50);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `hours_open`
--

CREATE TABLE `hours_open` (
  `id` int(11) NOT NULL,
  `Hour` varchar(5) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `hours_open`
--

INSERT INTO `hours_open` (`id`, `Hour`) VALUES
(1, '8:00'),
(2, '9:00'),
(4, '10:00'),
(5, '11:00'),
(6, '12:00'),
(7, '13:00'),
(8, '14:00'),
(9, '15:00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `haircut_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `hour_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `reservation`
--

INSERT INTO `reservation` (`id`, `client_id`, `haircut_id`, `date`, `hour_id`) VALUES
(1, 1, 1, '2020-05-15', 1),
(2, 2, 3, '2020-05-12', 2),
(44, 46, 4, '2020-05-21', 1),
(45, 47, 4, '2020-05-21', 6),
(46, 48, 4, '2020-05-21', 8),
(52, 55, 2, '2020-05-14', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nick` varchar(32) COLLATE utf8_bin NOT NULL,
  `password` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `nick`, `password`) VALUES
(1, 'Barber', 'a3b1cfa968f65818e3fa4fc7d89f5c45421811e272388ff25637c533ad085ccecbc3302d05a4200b7ca2b104bd4fdd7fcd1eb905934e147308868565453b7ba5');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `haircut`
--
ALTER TABLE `haircut`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `hours_open`
--
ALTER TABLE `hours_open`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `haircut_id` (`haircut_id`),
  ADD KEY `hour_id` (`hour_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla tabel zrzutów
--

--
-- AUTO_INCREMENT dla tabeli `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT dla tabeli `haircut`
--
ALTER TABLE `haircut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `hours_open`
--
ALTER TABLE `hours_open`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`haircut_id`) REFERENCES `haircut` (`id`),
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`hour_id`) REFERENCES `hours_open` (`id`);

DELIMITER $$
--
-- Zdarzenia
--
CREATE DEFINER=`root`@`localhost` EVENT `Delete_reservation` ON SCHEDULE EVERY 24 HOUR STARTS '2020-05-10 22:33:42' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM reservation WHERE to_date < NOW()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
