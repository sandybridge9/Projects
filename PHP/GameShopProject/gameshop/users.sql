-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018 m. Lap 04 d. 19:46
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gameshop`
--

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `user_level` int(20) NOT NULL,
  `vardas` varchar(40) NOT NULL,
  `pavarde` varchar(40) NOT NULL,
  `gimimo_data` datetime NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sukurta duomenų kopija lentelei `users`
--

INSERT INTO `users` (`id`, `user_level`, `vardas`, `pavarde`, `gimimo_data`, `username`, `password`, `email`) VALUES
(1, 2, 'adminasas', 'adminavicius', '2018-11-01 00:00:00', 'admin', 'admin', 'admin@gmail.com'),
(2, 1, 'antanas', 'batas', '2018-11-08 00:00:00', 'antis', 'antis', 'ant@pant.lt'),
(3, 1, 'jonas', 'ponas', '2018-11-07 00:00:00', 'jonpon', 'jonpon', 'jonpon123@gmail.com'),
(4, 1, 'data', 'data', '2018-11-12 00:00:00', 'data', 'data', 'data'),
(5, 3, 'medis', 'bedis', '2018-11-13 00:00:00', 'medis', 'medis', 'medis@berzas.lt');

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
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
