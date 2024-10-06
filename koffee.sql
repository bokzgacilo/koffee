-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 12, 2024 at 02:47 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koffee`
--

-- --------------------------------------------------------

--
-- Table structure for table `addons`
--

CREATE TABLE `addons` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addons`
--

INSERT INTO `addons` (`id`, `name`, `status`, `price`) VALUES
(0, 'Cream Cheese', 1, 10),
(0, 'Pearl', 1, 9),
(0, 'Crystals', 1, 9),
(0, 'Coffee Jelly', 1, 9),
(0, 'Crushed Orea', 1, 9),
(0, 'Whip Cream', 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

CREATE TABLE `category_list` (
  `id` int NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `name`, `description`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(3, 'Iced Coffee', 'Beverage', 1, 0, '2024-09-05 23:22:30', '2024-09-05 23:22:30'),
(4, 'Frappe (Cream Base)', 'Beverage', 1, 0, '2024-09-05 23:22:30', '2024-09-05 23:22:30'),
(5, 'Frappe (Coffee Base)', 'Beverage', 1, 0, '2024-09-05 23:22:30', '2024-09-05 23:22:30'),
(6, 'Milk Tea', 'Beverage', 1, 0, '2024-09-05 23:22:30', '2024-09-05 23:22:30'),
(7, 'Fruit Tea', 'Beverage', 1, 0, '2024-09-05 23:22:30', '2024-09-05 23:22:30'),
(8, 'Hot Drinks', 'Beverage', 1, 0, '2024-09-05 23:22:30', '2024-09-05 23:22:30');

-- --------------------------------------------------------

--
-- Table structure for table `product_list`
--

CREATE TABLE `product_list` (
  `id` int NOT NULL,
  `category_id` int NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `price` float(15,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`id`, `category_id`, `name`, `description`, `price`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(12, 3, 'Americano Small', '', 39.00, 1, 0, '2024-09-05 23:22:51', '2024-09-05 23:59:04'),
(13, 3, 'Cappuccino Small', 'Cappucino', 39.00, 1, 0, '2024-09-05 23:50:26', '2024-09-05 23:53:51'),
(14, 3, 'Caramel Small', 'caramell small', 39.00, 1, 0, '2024-09-05 23:50:57', '2024-09-05 23:54:03'),
(15, 3, 'Caramel Macchiato small', 'Caramel Macchiato Small', 39.00, 1, 0, '2024-09-05 23:52:48', '2024-09-06 01:24:00'),
(16, 3, 'Dark Choco Small', 'Dark Choco small', 39.00, 1, 0, '2024-09-05 23:53:15', '2024-09-05 23:54:12'),
(17, 3, 'Double Dutch small', 'Double Dutch Small', 39.00, 1, 0, '2024-09-05 23:53:44', '2024-09-06 01:24:00'),
(18, 3, 'Macchiato Small', 'Macchiato Small', 39.00, 1, 0, '2024-09-05 23:54:49', '2024-09-05 23:54:49'),
(19, 3, 'Mocha Small', 'Mocha Small', 39.00, 1, 0, '2024-09-05 23:58:12', '2024-09-05 23:58:12'),
(20, 3, 'Salted Caramel Small', 'Salted Caramel Small', 39.00, 1, 0, '2024-09-05 23:58:34', '2024-09-06 01:24:00'),
(22, 6, 'Black Forest Small', 'Black Forest Small', 39.00, 1, 0, '2024-09-05 23:59:26', '2024-09-05 23:59:26'),
(23, 6, 'Brown Sugar Small', 'Brown Sugar Small', 39.00, 1, 0, '2024-09-06 00:00:01', '2024-09-06 00:00:01'),
(24, 6, 'Cookies & Cream Small', 'Cookies & Cream Small', 39.00, 1, 0, '2024-09-06 00:00:38', '2024-09-06 00:00:38'),
(25, 6, 'Dark Choco Small MilkTea', 'Cookies & Cream Small', 39.00, 1, 0, '2024-09-06 00:01:51', '2024-09-06 00:01:51'),
(26, 3, 'Vanilla Small', 'Vanilla Small', 39.00, 1, 0, '2024-09-06 00:02:58', '2024-09-06 00:02:58'),
(27, 3, 'Double Dutch Small MilkTea', 'Double Dutch Small MilkTea', 39.00, 1, 0, '2024-09-06 00:03:36', '2024-09-06 01:24:00'),
(28, 6, 'Hazelnut Small', 'Hazelnut Small', 39.00, 1, 0, '2024-09-06 00:04:42', '2024-09-06 00:04:42'),
(29, 6, 'Hokaido Small', 'Hokaido Small', 39.00, 1, 0, '2024-09-06 00:05:00', '2024-09-06 01:24:00'),
(30, 6, 'Mango Cheese Cake Small', 'Mango Cheese Cake Small', 39.00, 1, 0, '2024-09-06 00:05:26', '2024-09-06 00:05:26'),
(31, 6, 'Matcha Small', 'Matcha Small', 39.00, 1, 0, '2024-09-06 00:05:48', '2024-09-06 01:24:00'),
(32, 6, 'Okinawa Small', 'Okinawa Small', 39.00, 1, 0, '2024-09-06 00:07:59', '2024-09-06 00:07:59'),
(33, 6, 'Red Velvet Small', 'Red Velvet Small', 39.00, 1, 0, '2024-09-06 00:08:56', '2024-09-06 00:08:56'),
(34, 6, 'Salted Caramel Small MilkTea', 'Salted Caramel Small MilkTea', 39.00, 1, 0, '2024-09-06 00:09:26', '2024-09-06 01:24:00'),
(35, 6, 'Strawberry Small', 'Strawberry Small', 39.00, 1, 0, '2024-09-06 00:09:58', '2024-09-06 00:09:58'),
(36, 6, 'Taro Small', 'Taro Small', 39.00, 1, 0, '2024-09-06 00:10:15', '2024-09-06 00:10:15'),
(37, 6, 'Winter Melon Small', 'Winter Melon Small', 39.00, 1, 0, '2024-09-06 00:10:33', '2024-09-06 00:10:33'),
(38, 4, 'Blueberry Small', 'Blueberry Small', 39.00, 1, 0, '2024-09-06 00:10:56', '2024-09-06 01:24:00'),
(39, 4, 'Choco Chip Small', 'Choco Chip Small', 39.00, 1, 0, '2024-09-06 00:11:19', '2024-09-06 01:24:00'),
(40, 4, 'Chocolate Small', 'Chocolate Small', 39.00, 1, 0, '2024-09-06 00:12:00', '2024-09-06 01:24:00'),
(42, 4, 'Cookies & Cream Small Frappe', 'Cookies & Cream Small Frappe', 39.00, 1, 0, '2024-09-06 00:12:32', '2024-09-06 01:24:00'),
(43, 4, 'Strawberry Small Frappe', 'Strawberry Small Frappe', 39.00, 1, 0, '2024-09-06 00:13:12', '2024-09-06 01:24:00'),
(45, 4, 'Vanilla Small Frappe', 'Vanilla Small Frappe', 39.00, 1, 0, '2024-09-06 00:13:33', '2024-09-06 01:24:00'),
(46, 5, 'Black Forest Small Frappe', 'Black Forest Small Frappe', 39.00, 1, 0, '2024-09-06 00:14:02', '2024-09-06 01:24:00'),
(47, 5, 'Coffre Jelly Small', 'Coffre Jelly Small', 39.00, 1, 0, '2024-09-06 00:14:32', '2024-09-06 01:24:00'),
(48, 5, 'Coffee Mint Small', 'Coffee Mint Small', 39.00, 1, 0, '2024-09-06 00:14:54', '2024-09-06 01:24:00'),
(49, 5, 'Coffee Oreo Small', 'Coffee Oreo Small', 39.00, 1, 0, '2024-09-06 00:15:17', '2024-09-06 01:24:00'),
(50, 5, 'Coffee Vanilla', 'Coffee Vanilla', 39.00, 1, 0, '2024-09-06 00:15:34', '2024-09-06 01:24:00'),
(51, 5, 'Coffee Vanilla-Caramel Small', 'Coffee Vanilla-Caramel Small', 39.00, 1, 0, '2024-09-06 00:16:02', '2024-09-06 01:24:00'),
(52, 5, 'Java Chip Small', 'Java Chip Small', 39.00, 1, 0, '2024-09-06 00:16:15', '2024-09-06 01:24:00'),
(53, 5, 'Mocha Small Frappe', 'Mocha Small Frappe', 39.00, 1, 0, '2024-09-06 00:16:30', '2024-09-06 01:24:00'),
(54, 7, 'Blueberry Small Fruit', 'Blueberry Small Fruit', 39.00, 1, 0, '2024-09-06 00:16:51', '2024-09-06 00:16:51'),
(55, 7, 'Green Apple Small', 'Green Apple Small', 39.00, 1, 0, '2024-09-06 00:17:05', '2024-09-06 00:17:05'),
(56, 7, 'Lemon Small', 'Lemon Small', 39.00, 1, 0, '2024-09-06 00:17:22', '2024-09-06 01:24:00'),
(57, 7, 'Lychee Small', 'Lychee Small', 39.00, 1, 0, '2024-09-06 00:17:53', '2024-09-06 00:17:53'),
(58, 7, 'Mango Small', 'Mango Small', 39.00, 1, 0, '2024-09-06 00:18:06', '2024-09-06 01:24:00'),
(59, 7, 'Peach Small', 'Peach Small', 39.00, 1, 0, '2024-09-06 00:18:23', '2024-09-06 01:24:00'),
(60, 7, 'Strawberry Small Fruit', 'Strawberry Small Fruit', 39.00, 1, 0, '2024-09-06 00:18:42', '2024-09-06 00:18:42'),
(61, 8, 'Kofee Vanilla Small', 'Kofee Vanilla Small', 39.00, 1, 0, '2024-09-06 00:19:14', '2024-09-06 01:24:00'),
(62, 8, 'Kofee Macchiato Small', 'Kofee Macchiato Small', 39.00, 1, 0, '2024-09-06 00:19:41', '2024-09-06 01:24:00'),
(63, 8, 'Kofee Cappuccino Small', 'Kofee Cappuccino Small', 39.00, 1, 0, '2024-09-06 00:20:07', '2024-09-06 01:24:00'),
(64, 8, 'Kofee Double Dutch Small', 'Kofee Double Dutch Small', 39.00, 1, 0, '2024-09-06 00:20:31', '2024-09-06 01:24:00'),
(65, 8, 'Black Coffee Small', 'Black Coffee Small', 39.00, 1, 0, '2024-09-06 00:20:51', '2024-09-06 01:24:00'),
(66, 8, 'Hot Choco Small', 'Hot Choco Small', 39.00, 1, 0, '2024-09-06 00:21:06', '2024-09-06 01:24:00'),
(67, 3, 'Americano Large', '', 49.00, 1, 0, '2024-09-05 23:22:51', '2024-09-05 23:22:51'),
(68, 3, 'Cappuccino Large', 'Cappucino', 49.00, 1, 0, '2024-09-05 23:50:26', '2024-09-05 23:50:26'),
(69, 3, 'Caramel Large', 'caramell large', 49.00, 1, 0, '2024-09-05 23:50:57', '2024-09-05 23:50:57'),
(70, 3, 'Caramel Macchiato Large', 'Caramel Macchiato Large', 49.00, 1, 0, '2024-09-05 23:52:48', '2024-09-05 23:52:48'),
(71, 3, 'Dark Choco Large', 'Dark Choco large', 49.00, 1, 0, '2024-09-05 23:53:15', '2024-09-05 23:53:15'),
(72, 3, 'Double Dutch Large', 'Double Dutch Large', 49.00, 1, 0, '2024-09-05 23:53:44', '2024-09-05 23:53:44'),
(73, 3, 'Macchiato Large', 'Macchiato Large', 49.00, 1, 0, '2024-09-05 23:54:49', '2024-09-05 23:54:49'),
(74, 3, 'Mocha Large', 'Mocha Large', 49.00, 1, 0, '2024-09-05 23:58:12', '2024-09-05 23:58:12'),
(75, 3, 'Salted Caramel Large', 'Salted Caramel Large', 49.00, 1, 0, '2024-09-05 23:58:34', '2024-09-05 23:58:34'),
(76, 6, 'Black Forest Large', 'Black Forest Large', 49.00, 1, 0, '2024-09-05 23:59:26', '2024-09-05 23:59:26'),
(77, 6, 'Brown Sugar Large', 'Brown Sugar Large', 49.00, 1, 0, '2024-09-06 00:00:01', '2024-09-06 00:00:01'),
(78, 6, 'Cookies & Cream Large', 'Cookies & Cream Large', 49.00, 1, 0, '2024-09-06 00:00:38', '2024-09-06 00:00:38'),
(79, 6, 'Dark Choco Large MilkTea', 'Dark Choco Large MilkTea', 49.00, 1, 0, '2024-09-06 00:01:51', '2024-09-06 00:01:51'),
(80, 3, 'Vanilla Large', 'Vanilla Large', 49.00, 1, 0, '2024-09-06 00:02:58', '2024-09-06 00:02:58'),
(81, 6, 'Hazelnut Large', 'Hazelnut Large', 49.00, 1, 0, '2024-09-06 00:04:42', '2024-09-06 00:04:42'),
(82, 6, 'Hokaido Large', 'Hokaido Large', 49.00, 1, 0, '2024-09-06 00:05:00', '2024-09-06 00:05:00'),
(83, 6, 'Mango Cheese Cake Large', 'Mango Cheese Cake Large', 49.00, 1, 0, '2024-09-06 00:05:26', '2024-09-06 00:05:26'),
(84, 6, 'Matcha Large', 'Matcha Large', 49.00, 1, 0, '2024-09-06 00:05:48', '2024-09-06 00:05:48'),
(85, 6, 'Okinawa Large', 'Okinawa Large', 49.00, 1, 0, '2024-09-06 00:07:59', '2024-09-06 00:07:59'),
(86, 6, 'Red Velvet Large', 'Red Velvet Large', 49.00, 1, 0, '2024-09-06 00:08:56', '2024-09-06 00:08:56'),
(87, 6, 'Salted Caramel Large MilkTea', 'Salted Caramel Large MilkTea', 49.00, 1, 0, '2024-09-06 00:09:26', '2024-09-06 00:09:26'),
(88, 6, 'Strawberry Large', 'Strawberry Large', 49.00, 1, 0, '2024-09-06 00:09:58', '2024-09-06 00:09:58'),
(89, 6, 'Taro Large', 'Taro Large', 49.00, 1, 0, '2024-09-06 00:10:15', '2024-09-06 00:10:15'),
(90, 6, 'Winter Melon Large', 'Winter Melon Large', 49.00, 1, 0, '2024-09-06 00:10:33', '2024-09-06 00:10:33'),
(91, 4, 'Blueberry Large', 'Blueberry Large', 49.00, 1, 0, '2024-09-06 00:10:56', '2024-09-06 00:10:56'),
(92, 4, 'Choco Chip Large', 'Choco Chip Large', 49.00, 1, 0, '2024-09-06 00:11:19', '2024-09-06 00:11:19'),
(93, 4, 'Chocolate Large', 'Chocolate Large', 49.00, 1, 0, '2024-09-06 00:12:00', '2024-09-06 00:12:00'),
(94, 4, 'Cookies & Cream Large Frappe', 'Cookies & Cream Large Frappe', 49.00, 1, 0, '2024-09-06 00:12:32', '2024-09-06 00:12:32'),
(95, 4, 'Strawberry Large Frappe', 'Strawberry Large Frappe', 49.00, 1, 0, '2024-09-06 00:13:12', '2024-09-06 00:13:12'),
(96, 4, 'Vanilla Large Frappe', 'Vanilla Large Frappe', 49.00, 1, 0, '2024-09-06 00:13:33', '2024-09-06 00:13:33'),
(97, 5, 'Black Forest Large Frappe', 'Black Forest Large Frappe', 49.00, 1, 0, '2024-09-06 00:14:02', '2024-09-06 00:14:02'),
(98, 5, 'Coffre Jelly Large', 'Coffre Jelly Large', 49.00, 1, 0, '2024-09-06 00:14:32', '2024-09-06 00:14:32'),
(99, 5, 'Coffee Mint Large', 'Coffee Mint Large', 49.00, 1, 0, '2024-09-06 00:14:54', '2024-09-06 00:14:54'),
(100, 5, 'Coffee Oreo Large', 'Coffee Oreo Large', 49.00, 1, 0, '2024-09-06 00:15:15', '2024-09-06 00:15:15'),
(101, 5, 'Oreo Large', 'Oreo Large', 49.00, 1, 0, '2024-09-06 00:15:36', '2024-09-06 00:15:36'),
(102, 6, 'Test Tea', 'Test Tea', 50.00, 1, 0, '2024-09-12 21:38:07', '2024-09-12 21:38:07');

-- --------------------------------------------------------

--
-- Table structure for table `sale_list`
--

CREATE TABLE `sale_list` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `code` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `client_name` text COLLATE utf8mb4_general_ci NOT NULL,
  `amount` float(15,2) NOT NULL DEFAULT '0.00',
  `tendered` float(15,2) NOT NULL DEFAULT '0.00',
  `payment_type` tinyint(1) NOT NULL COMMENT '1 = Cash,\r\n2 = Debit Card,\r\n3 = Credit Card',
  `payment_code` text COLLATE utf8mb4_general_ci,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale_list`
--

INSERT INTO `sale_list` (`id`, `user_id`, `code`, `client_name`, `amount`, `tendered`, `payment_type`, `payment_code`, `date_created`, `date_updated`) VALUES
(1, 1, '202204220001', 'Guest', 710.00, 1000.00, 1, '', '2022-04-22 13:54:44', '2022-04-22 13:54:44'),
(2, NULL, '202204220002', 'Guest', 675.00, 700.00, 2, '123121ABcdF', '2022-04-22 15:27:02', '2022-04-22 15:27:02');

-- --------------------------------------------------------

--
-- Table structure for table `sale_products`
--

CREATE TABLE `sale_products` (
  `sale_id` int NOT NULL,
  `product_id` int NOT NULL,
  `qty` int NOT NULL,
  `price` float(15,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int NOT NULL,
  `meta_field` text COLLATE utf8mb4_general_ci NOT NULL,
  `meta_value` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Coffee Shop Cashiering System'),
(6, 'short_name', 'CSCS - PHP'),
(11, 'logo', 'uploads/logo.png?v=1650590302'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover.png?v=1650590309');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `firstname` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `username` text COLLATE utf8mb4_general_ci NOT NULL,
  `password` text COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` text COLLATE utf8mb4_general_ci,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', 'Admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'uploads/avatars/1.png?v=1649834664', NULL, 1, '2021-01-20 14:02:37', '2024-09-12 21:29:19'),
(9, 'seancvpugosa@gmail.com', 'seancvpugosa@gmail.com', 'seancvpugosa@gmail.com', 'e4447e63d0a0dffead7007cdc5c8dd51', 'uploads/avatars/9.png?v=1726151933', NULL, 2, '2024-09-12 22:23:15', '2024-09-12 22:38:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `sale_list`
--
ALTER TABLE `sale_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sale_products`
--
ALTER TABLE `sale_products`
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `sale_list`
--
ALTER TABLE `sale_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_list`
--
ALTER TABLE `product_list`
  ADD CONSTRAINT `category_id_fk_pl` FOREIGN KEY (`category_id`) REFERENCES `category_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sale_list`
--
ALTER TABLE `sale_list`
  ADD CONSTRAINT `user_id_fk_sl` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sale_products`
--
ALTER TABLE `sale_products`
  ADD CONSTRAINT `fk_product_id_unique` FOREIGN KEY (`product_id`) REFERENCES `product_list` (`id`),
  ADD CONSTRAINT `product_id_fk_sp` FOREIGN KEY (`product_id`) REFERENCES `product_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_id_fk_sp` FOREIGN KEY (`sale_id`) REFERENCES `sale_list` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
