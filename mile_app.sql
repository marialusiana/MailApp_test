-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 25, 2020 at 09:21 PM
-- Server version: 5.7.31-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mile_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `connote`
--

CREATE TABLE `connote` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `service` varchar(100) NOT NULL,
  `service_price` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `booking_code` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `state` varchar(100) NOT NULL,
  `state_id` int(11) NOT NULL,
  `zone_code_from` varchar(11) NOT NULL,
  `zone_code_to` varchar(11) NOT NULL,
  `surcharge_amount` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `actual_weight` int(11) NOT NULL,
  `chargeable_weight` int(11) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `organization_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `total_package` int(11) NOT NULL,
  `sla_day` int(11) NOT NULL,
  `pod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `connote`
--

INSERT INTO `connote` (`id`, `number`, `service`, `service_price`, `amount`, `code`, `booking_code`, `order_id`, `state`, `state_id`, `zone_code_from`, `zone_code_to`, `surcharge_amount`, `transaction_id`, `actual_weight`, `chargeable_weight`, `created_at`, `updated_at`, `organization_id`, `location_id`, `total_package`, `sla_day`, `pod`) VALUES
(1, 1, 'COD', 100, 10, 'ABC', 123, 1, 'state', 1, 'aa', 'aa', 10, 1, 1, 1, NULL, NULL, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` int(11) NOT NULL,
  `address_detail` text NOT NULL,
  `zip_code` varchar(100) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `location_id` varchar(100) NOT NULL,
  `name_sales` varchar(100) NOT NULL,
  `TOP` varchar(100) NOT NULL,
  `jenis_pelanggan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `address`, `email`, `phone`, `address_detail`, `zip_code`, `organization_id`, `location_id`, `name_sales`, `TOP`, `jenis_pelanggan`) VALUES
(1, 'Maria', 'Cirebon', 'maria.phey@gmail.com', 123123123, 'jln satria', 'aaa', 1, '1d', 'maria sales', '14 hari', 'B2B');

-- --------------------------------------------------------

--
-- Table structure for table `koli`
--

CREATE TABLE `koli` (
  `id` int(11) NOT NULL,
  `lenght` int(11) NOT NULL,
  `awb_url` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `chargeable_weight` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `surcharge` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `description` int(11) NOT NULL,
  `formula_id` int(11) NOT NULL,
  `connote_id` int(11) NOT NULL,
  `volume` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `custom_field` int(11) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `koli`
--

INSERT INTO `koli` (`id`, `lenght`, `awb_url`, `created_at`, `chargeable_weight`, `width`, `surcharge`, `height`, `updated_at`, `description`, `formula_id`, `connote_id`, `volume`, `weight`, `custom_field`, `code`) VALUES
(1, 1, 'asdsdsadasd', '2020-09-24 23:06:28', 1, 1, 1, 1, NULL, 1, 1, 1, 1, 1, 1, '1as'),
(2, 2, 'asd', '2020-09-24 23:07:01', 2, 2, 2, 2, NULL, 2, 2, 1, 2, 2, 2, 'asd');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `name`, `type`) VALUES
(1, 'Cirebon', 'type');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `additional_field` varchar(255) DEFAULT NULL,
  `payment_type` varchar(250) NOT NULL,
  `state` varchar(100) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `location_id` varchar(100) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_type_name` varchar(100) DEFAULT NULL,
  `cash_amount` int(11) NOT NULL,
  `cash_charge` int(11) NOT NULL,
  `customer_origin` int(11) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `customer_destination` int(11) NOT NULL,
  `catatan_tambahan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `amount`, `discount`, `additional_field`, `payment_type`, `state`, `code`, `order_id`, `location_id`, `organization_id`, `created_at`, `updated_at`, `payment_type_name`, `cash_amount`, `cash_charge`, `customer_origin`, `deleted_at`, `customer_destination`, `catatan_tambahan`) VALUES
(1, 1, 1, 'mmmmmmmmmmmsdadsads', '1', '1', '1', 1, '1d', 1, '2020-09-24 15:21:45', '2020-09-25 04:59:15', 'mariaaaaaa', 1, 1, 1, NULL, 1, NULL),
(2, 1, 1, 'mmmmmmmmmmm', '1', '1', '1', 1, '1', 1, '2020-09-25 05:23:19', '2020-09-25 05:23:19', 'maria', 1, 1, 1, NULL, 1, 'maria'),
(3, 1, 1, 'mmmmmmmmmmm', '1', '1', '1', 1, '1', 1, '2020-09-25 05:23:28', '2020-09-25 05:23:28', 'maria', 1, 1, 1, NULL, 1, 'maria'),
(4, 1, 1, 'maria maria maria', '1', '1', '1', 1, '1', 1, '2020-09-25 06:12:45', '2020-09-25 06:12:45', 'maria', 1, 1, 1, NULL, 1, 'maria');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `connote`
--
ALTER TABLE `connote`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `koli`
--
ALTER TABLE `koli`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
