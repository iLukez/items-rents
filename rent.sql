-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 06, 2024 alle 01:04
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rent`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `centers`
--

CREATE TABLE `centers` (
  `id` int(11) NOT NULL,
  `center_name` varchar(32) NOT NULL,
  `address` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `centers`
--

INSERT INTO `centers` (`id`, `center_name`, `address`) VALUES
(1, 'Centro Sacile', 'via Bellavia, 33'),
(2, 'Pordenone', 'Viale Dante, 3'),
(3, 'Milano', 'via Bruttavia, 66');

-- --------------------------------------------------------

--
-- Struttura della tabella `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `type` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `maker` varchar(64) NOT NULL,
  `center` int(11) NOT NULL,
  `ci` int(16) NOT NULL,
  `state` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `items`
--

INSERT INTO `items` (`id`, `type`, `item_name`, `maker`, `center`, `ci`, `state`) VALUES
(1, 'Tablet', 'Tablet Note 20', 'Xiaomi', 1, 114302, 'rented'),
(2, 'Computer', 'Mac M1 2023', 'Apple', 2, 253955, 'rented'),
(4, 'Smartwatch', 'Mi Band 7', 'Xiaomi', 2, 573853, 'available'),
(5, 'Tablet', 'iPad X', 'Apple', 2, 365946, 'available'),
(6, 'Tablet', 'erTablet X 2024', 'erProduttore', 1, 674866, 'unavailable'),
(7, 'Smartphone', 'P33 2021', 'Huawei', 3, 999333, 'rented'),
(8, 'Smartwatch', 'Galaxy Watch 4', 'Samsung', 1, 123456, 'unavailable'),
(9, 'Tablet', 'iPad Air 2023', 'Apple', 3, 654321, 'available'),
(10, 'Computer', 'COMPUTERONE', 'Dell', 1, 743647, 'unavailable'),
(13, 'Smartphone', 'iPhone 15', 'Apple', 1, 214836, 'rented'),
(15, 'Laptop', 'ThinkPad X1 Carbon', 'Lenovo', 1, 112233, 'available'),
(16, 'Smartphone', 'Galaxy S22', 'Samsung', 1, 445566, 'rented'),
(17, 'Headphones', 'QuietComfort 35', 'Bose', 1, 778899, 'rented'),
(18, 'Camera', 'EOS R5', 'Canon', 1, 101112, 'unavailable'),
(19, 'Nuovo', 'Nuovo', 'Nuovo SRL', 1, 123456, 'unavailable'),
(20, 'Nuovo2', 'Nuovo2', 'Nuovo SRL', 3, 222222, 'available'),
(21, 'Oggetto', 'nonDispo', 'NonDispo SRL', 1, 856733, 'unavailable');

-- --------------------------------------------------------

--
-- Struttura della tabella `rents`
--

CREATE TABLE `rents` (
  `rent_id` int(11) NOT NULL,
  `date` datetime(6) NOT NULL,
  `item` int(11) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `rents`
--

INSERT INTO `rents` (`rent_id`, `date`, `item`, `user`) VALUES
(2, '2024-03-09 00:00:00.000000', 2, 2),
(4, '2024-03-06 15:12:10.000000', 7, 2),
(23, '0000-00-00 00:00:00.000000', 13, 1),
(25, '0000-00-00 00:00:00.000000', 17, 1),
(26, '0000-00-00 00:00:00.000000', 1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `type` varchar(16) NOT NULL DEFAULT 'user',
  `username` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `type`, `username`, `email`, `password`) VALUES
(1, 'user', 'xbaffo', 'xbaffo@gmail.com', '6e6bc4e49dd477ebc98ef4046c067b5f'),
(2, 'user', 'piazza', 'piazza@gmail.com', '4558aac7b93717f32323b02d2db1f28b'),
(3, 'user', 'luca', 'luca@luca.luca', 'ff377aff39a9345a9cca803fb5c5c081'),
(4, 'admin', 'admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `centers`
--
ALTER TABLE `centers`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `center` (`center`) USING BTREE;

--
-- Indici per le tabelle `rents`
--
ALTER TABLE `rents`
  ADD PRIMARY KEY (`rent_id`),
  ADD KEY `item` (`item`),
  ADD KEY `user` (`user`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `centers`
--
ALTER TABLE `centers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT per la tabella `rents`
--
ALTER TABLE `rents`
  MODIFY `rent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `center_id` FOREIGN KEY (`center`) REFERENCES `centers` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `rents`
--
ALTER TABLE `rents`
  ADD CONSTRAINT `item_id` FOREIGN KEY (`item`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
