-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2024 at 04:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kca`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `fullname` varchar(50) NOT NULL,
  `Id` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `dob` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`fullname`, `Id`, `email`, `dob`, `gender`, `phone`, `password`) VALUES
('Daryl', '12345', 'daryllui@gmail.com', '2022-10-10', 'male', '0769556090', '$2y$10$JphIosq31GzYpAUbArbMVu05njKVc/lysROXmpFdFEUFxHSLQAhei');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`name`, `email`, `message`) VALUES
('Klovert Soye ', 'klovertsoye@gmail.com', 'muskla\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `fuel_type` varchar(100) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `order_id` int(100) NOT NULL,
  `id` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `truckid` varchar(100) NOT NULL,
  `driversname` varchar(100) NOT NULL,
  `driverphone` varchar(100) NOT NULL,
  `truckname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`fullname`, `email`, `location`, `fuel_type`, `quantity`, `date`, `payment_method`, `order_id`, `id`, `phone`, `status`, `truckid`, `driversname`, `driverphone`, `truckname`) VALUES
('klovert soye', 'klovertsoye@gmail.com', 'mombasa', 'petrol', '20', '2024-10-10', 'credit_card', 8, '40148514', '0757834831', 'Cancelled', 'KDD980U', '', '', ''),
('klovert soye', 'klovertsoye@gmail.com', 'Hola', 'diesel', '29', '2024-12-12', 'paypal', 9, '40148514', '0757834831', 'Processing', 'KCV790C', '', '', ''),
('klovert soye', 'klovertsoye@gmail.com', 'nairobi', 'kerosene', '10', '2024-12-12', 'paypal', 10, '40148514', '0757834831', 'Completed', 'KDY220D', '', '', ''),
('klovert soye', 'klovertsoye@gmail.com', 'naivasha', 'petrol', '200', '2024-12-15', 'credit_card', 11, '40148514', '0757834831', 'Shipped', '', '', '', ''),
('klovert soye', 'klovertsoye@gmail.com', 'naivasha', 'petrol', '200', '2024-12-15', 'credit_card', 12, '40148514', '0757834831', 'Completed', '', '', '', ''),
('KelvinMukoya', 'kelvinodongo@gmail.com', 'naivasha', 'petrol', '70', '0204-07-30', 'credit_card', 13, '55656568', '0794070263', 'Processing', 'KCV790C', '', '', ''),
('klovert soye', 'klovertsoye@gmail.com', 'naivasha', 'diesel', '300', '2024-11-25', 'mobile_money', 14, '40148514', '0757834831', 'Processing', 'KDB997V', '', '', ''),
('klovert soye', 'klovertsoye@gmail.com', 'Nakuru', 'diesel', '200', '2024-08-08', 'credit_card', 15, '40148514', '0757834831', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `fullname` varchar(100) NOT NULL,
  `Id` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `dob` varchar(100) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`fullname`, `Id`, `email`, `dob`, `gender`, `phone`, `password`) VALUES
('klovert Gwiyo', '40148514', 'klovertsoye@gmail.com', '2009-03-03', 'male', '0757834831', '$2y$10$PAbwV8ar1i9UkrouKXby..Ofp7.TIi3a80WhVOruy0KxES/7IGqu6'),
('fortune clark', '40737373', 'fourclark@gmail.com', '2002-10-10', 'male', '070613310', '$2y$10$cqkG0vdIAGMCQvSbw0F8v.46tDlMTy3IIwCJ0hnduLGj3J0NOJ5Ka'),
('nahashon', '4903830', 'nahashongichuru73@gmail.com', '2024-11-08', 'male', '073553789', '$2y$10$lUzcO3SlVWk69s3XkZ3EtuJHbaDhbzI2/WmojjmNZ0L5C9VAiY.8W'),
('Kelvin Mukoya', '55656568', 'kelvinodongo@gmail.com', '2004-12-19', 'male', '0794070263', '$2y$10$4MeRJJVDyNXAsnqPz7U1POiZOyha421SFI2b7Oa/.C9OWOucWNggC');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `ticket` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`fullname`, `email`, `phone`, `ticket`) VALUES
('klovert Soye', 'klovertsoyegmail.com', '0714764649', 'football');

-- --------------------------------------------------------

--
-- Table structure for table `trucks`
--

CREATE TABLE `trucks` (
  `truckname` varchar(100) NOT NULL,
  `truckid` varchar(100) NOT NULL,
  `driversname` varchar(100) NOT NULL,
  `capacity` varchar(100) NOT NULL,
  `driverphone` varchar(100) NOT NULL,
  `depot` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trucks`
--

INSERT INTO `trucks` (`truckname`, `truckid`, `driversname`, `capacity`, `driverphone`, `depot`) VALUES
('MAN', 'KDC370U', 'Peter Karanja', '1000', '0763579800', 'Kiganjo'),
('scania', 'KDD980U', 'Said Seyyid', '2000', '075780540', 'industrial area'),
('IVECO', 'KCV790C', 'Kimani Mwangi', '2000', '0768950635', 'industrial area'),
('FORD', 'KCU456G', 'Neil Kirimi', '200', '0701897484', 'Kipevu'),
('Mitsubishi FUSO', 'KDB997V', 'Suleiman Hassan', '2000', '0110234580', 'Kipevu'),
('Isuzu', 'KCS345T', 'Samson Barasa', '2000', '07692580734', 'industrial area'),
('VOLVO', 'KDY220D', 'Mark Ruto', '2000', '078064064', 'Kipevu'),
('VOLVO', 'KDY220D', 'Mark Ruto', '2000', '078064064', 'Kipevu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `dob` (`dob`),
  ADD UNIQUE KEY `Id number` (`Id`),
  ADD KEY `dob_2` (`dob`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`fullname`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
