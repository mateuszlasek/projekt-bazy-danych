-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 01 Gru 2023, 04:04
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `db`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `color` varchar(50) NOT NULL,
  `availability` tinyint(1) NOT NULL,
  `images` varchar(255) NOT NULL,
  `opis` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `cars`
--

INSERT INTO `cars` (`id`, `brand`, `model`, `year`, `color`, `availability`, `images`, `opis`) VALUES
(1, 'Audi', 'Q2', 2022, 'Silver', 0, 'images/audiq2.jpg', 'Nowoczesny crossover z eleganckim designem i zaawansowaną technologią.'),
(2, 'Citroen', 'C3', 2022, 'Blue', 0, 'images/citroenc3.jpg', 'Kompaktowy hatchback z wygodnym wnętrzem i dynamicznym stylem.'),
(3, 'Fiat', '500', 2022, 'Red', 1, 'images/fiat500.jpg', 'Kultowy samochód miejski, charakteryzujący się unikalnym stylem i oszczędnym paliwem.'),
(4, 'Ford', 'Fiesta', 2022, 'Black', 1, 'images/fordfiesta.jpg', 'Dynamiczny hatchback z zaawansowaną technologią i oszczędnym silnikiem.'),
(5, 'Ford', 'Puma', 2022, 'White', 1, 'images/fordpuma.jpg', 'Nowoczesny crossover z sportowym charakterem i funkcjonalnym wnętrzem.'),
(6, 'Hyundai', 'i30', 2022, 'Gray', 1, 'images/hyundaii30.jpg', 'Przestronny hatchback z zaawansowanym wyposażeniem i oszczędnym silnikiem.'),
(7, 'Fiat', 'Multipla', 2022, 'Yellow', 1, 'images/multipla.jpg', 'Kompaktowy samochód rodzinny z nietypowym designem i przestronnym wnętrzem.'),
(8, 'Opel', 'Corsa', 2022, 'Green', 1, 'images/opelcorsa.jpg', 'Wydajny hatchback z nowoczesnymi rozwiązaniami i atrakcyjnym wyglądem.'),
(9, 'Opel', 'Crossland', 2022, 'Orange', 1, 'images/opelcrossland.jpg', 'Kompaktowy crossover z ergonomicznym wnętrzem i wszechstronną funkcjonalnością.'),
(10, 'Skoda', 'Fabia', 2022, 'Brown', 1, 'images/skodafabia.jpg', 'Praktyczny hatchback z wygodnymi rozwiązaniami i oszczędnym zużyciem paliwa.'),
(11, 'Toyota', 'Aygo', 2022, 'Purple', 1, 'images/toyotaaygo.jpg', 'Mały i zwinny samochód miejski z energicznym designem i ekonomicznym silnikiem.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rentals`
--

CREATE TABLE `rentals` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `car_id` int(11) DEFAULT NULL,
  `rental_date` date NOT NULL,
  `return_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `rentals`
--

INSERT INTO `rentals` (`id`, `client_id`, `car_id`, `rental_date`, `return_date`) VALUES
(1, 1, 1, '5655-06-05', '8987-07-06'),
(2, 1, 1, '1000-10-10', '7888-10-10'),
(3, 1, 1, '1111-11-11', '1111-11-11'),
(4, 1, 2, '0000-00-00', '6666-06-06');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `id_client` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `car_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `reviews`
--

INSERT INTO `reviews` (`id`, `id_client`, `name`, `car_id`, `rating`, `text`) VALUES
(1, 1, 'sebol123', 2, 3, '35355'),
(2, 1, 'sebol123', 2, 3, '35355'),
(3, 1, 'sebol123', 2, 3, '35355'),
(4, 1, 'sebol123', 2, 3, '35355'),
(5, 1, 'sebol123', 1, 4, '0'),
(6, 1, 'sebol123', 1, 4, '3'),
(7, 1, 'sebol123', 1, 3, '3231'),
(8, 1, 'sebol123', 5, 4, '2');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'sebol123', 'thenexispl@gmail.com', '$2y$10$qIGSOsMKnHNYnU8aXout..JxvIAgzDzod.1BdgYvl27Xg2RaXCziu', 'user');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indeksy dla tabeli `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `car_id` (`car_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `rentals`
--
ALTER TABLE `rentals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `rentals_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `rentals_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`);

--
-- Ograniczenia dla tabeli `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
