-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2024 at 01:01 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Table structure for table `centers`
--

CREATE TABLE `centers` (
  `id` int(11) NOT NULL,
  `center_name` varchar(32) NOT NULL,
  `address` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `centers`
--

INSERT INTO `centers` (`id`, `center_name`, `address`) VALUES
(1, 'Centro Sacile', 'via Bellavia, 33'),
(2, 'Pordenone', 'Viale Dante, 3'),
(3, 'Milano', 'via Bruttavia, 66');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `type` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `maker` varchar(64) NOT NULL,
  `center` int(11) NOT NULL,
  `ci` int(16) NOT NULL,
  `state` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `type`, `item_name`, `maker`, `center`, `ci`, `state`) VALUES
(1, 'Tablet', 'Tablet Note 20', 'Xiaomi', 1, 114302, 'rented'),
(2, 'Computer', 'Mac M1 2023', 'Apple', 2, 253955, 'rented'),
(4, 'Smartwatch', 'Mi Band 7', 'Xiaomi', 2, 573853, 'rented'),
(5, 'Tablet', 'iPad X', 'Apple', 2, 365946, 'rented'),
(6, 'Tablet', 'erTablet X 2024', 'erProduttore', 1, 674866, 'rented'),
(7, 'Smartphone', 'P33 2021', 'Huawei', 3, 999333, 'rented'),
(8, 'Smartwatch', 'Galaxy Watch 4', 'Samsung', 1, 123456, 'rented'),
(9, 'Tablet', 'iPad Air 2023', 'Apple', 3, 654321, 'rented'),
(10, 'Computer', 'COMPUTERONE', 'Dell', 1, 2147483647, 'rented'),
(13, 'Smartphone', 'iPhone 15', 'Apple', 1, 2147483647, 'rented'),
(15, 'Laptop', 'ThinkPad X1 Carbon', 'Lenovo', 1, 112233, 'rented'),
(16, 'Smartphone', 'Galaxy S22', 'Samsung', 1, 445566, 'rented'),
(17, 'Headphones', 'QuietComfort 35', 'Bose', 1, 778899, 'available'),
(18, 'Camera', 'EOS R5', 'Canon', 1, 101112, 'rented');

-- --------------------------------------------------------

--
-- Table structure for table `rents`
--

CREATE TABLE `rents` (
  `rent_id` int(11) NOT NULL,
  `date` datetime(6) NOT NULL,
  `item` int(11) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rents`
--

INSERT INTO `rents` (`rent_id`, `date`, `item`, `user`) VALUES
(1, '2024-03-09 00:00:00.000000', 1, 1),
(2, '2024-03-09 00:00:00.000000', 2, 2),
(4, '2024-03-06 15:12:10.000000', 7, 2),
(5, '2024-03-14 10:00:00.000000', 8, 3),
(6, '2024-03-15 11:00:00.000000', 9, 3),
(7, '0000-00-00 00:00:00.000000', 4, 1),
(8, '0000-00-00 00:00:00.000000', 5, 1),
(9, '0000-00-00 00:00:00.000000', 6, 1),
(10, '0000-00-00 00:00:00.000000', 10, 1),
(11, '0000-00-00 00:00:00.000000', 18, 1),
(12, '0000-00-00 00:00:00.000000', 13, 1),
(13, '0000-00-00 00:00:00.000000', 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `n_rents` int(16) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `n_rents`) VALUES
(1, 'xbaffo', 'xbaffo@gmail.com', '6e6bc4e49dd477ebc98ef4046c067b5f', 0),
(2, 'piazza', 'piazza@gmail.com', '4558aac7b93717f32323b02d2db1f28b', 0),
(3, 'luca', 'luca@luca.luca', 'ff377aff39a9345a9cca803fb5c5c081', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `centers`
--
ALTER TABLE `centers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `center` (`center`) USING BTREE;

--
-- Indexes for table `rents`
--
ALTER TABLE `rents`
  ADD PRIMARY KEY (`rent_id`),
  ADD KEY `item` (`item`),
  ADD KEY `user` (`user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `centers`
--
ALTER TABLE `centers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `rents`
--
ALTER TABLE `rents`
  MODIFY `rent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `center_id` FOREIGN KEY (`center`) REFERENCES `centers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rents`
--
ALTER TABLE `rents`
  ADD CONSTRAINT `item_id` FOREIGN KEY (`item`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
