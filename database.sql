-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 25, 2018 at 07:50 PM
-- Server version: 5.6.35
-- PHP Version: 7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `plan18`
--
CREATE DATABASE IF NOT EXISTS `plan18` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `plan18`;

-- --------------------------------------------------------

--
-- Table structure for table `barcodes`
--

DROP TABLE IF EXISTS `barcodes`;
CREATE TABLE `barcodes` (
  `participiant_id` int(11) NOT NULL,
  `barcode_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `checkin`
--

DROP TABLE IF EXISTS `checkin`;
CREATE TABLE `checkin` (
  `participant_id` int(11) NOT NULL,
  `first_checkin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'time of first checkin',
  `last_changed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'time of last checkin/checkout',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'true = checked in, false = checked out'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

DROP TABLE IF EXISTS `participants`;
CREATE TABLE `participants` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `meal1` tinyint(1) NOT NULL DEFAULT '0',
  `meal2` tinyint(1) NOT NULL DEFAULT '0',
  `meal3` tinyint(1) NOT NULL DEFAULT '0',
  `payed` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `participants`
--
DROP TRIGGER IF EXISTS `createBarcode`;
DELIMITER $$
CREATE TRIGGER `createBarcode` AFTER INSERT ON `participants` FOR EACH ROW BEGIN
INSERT INTO `barcodes` (`participiant_id`) VALUES (NEW.id);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `participants_debt`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `participants_debt`;
CREATE TABLE `participants_debt` (
`id` int(11)
,`debt` decimal(43,0)
);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `barcode` varchar(25) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

DROP TABLE IF EXISTS `purchase`;
CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_products`
--

DROP TABLE IF EXISTS `purchase_products`;
CREATE TABLE `purchase_products` (
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_checkin`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `view_checkin`;
CREATE TABLE `view_checkin` (
`id` int(11)
,`name` varchar(50)
,`barcode` varchar(10)
,`status` tinyint(1)
,`debt` decimal(43,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_debt`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `view_debt`;
CREATE TABLE `view_debt` (
`id` int(11)
,`barcode` varchar(10)
,`name` varchar(50)
,`payed` int(11)
,`debt` decimal(43,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_print_cards`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `view_print_cards`;
CREATE TABLE `view_print_cards` (
`id` int(11)
,`name` varchar(50)
,`meal1` tinyint(1)
,`meal2` tinyint(1)
,`meal3` tinyint(1)
,`barcode` varchar(10)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_products_sold`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `view_products_sold`;
CREATE TABLE `view_products_sold` (
`id` int(11)
,`name` varchar(50)
,`amount_sold` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Structure for view `participants_debt`
--
DROP TABLE IF EXISTS `participants_debt`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `participants_debt`  AS  select `participants`.`id` AS `id`,(((50 + (((`participants`.`meal1` + `participants`.`meal2`) + `participants`.`meal3`) * 50)) - `participants`.`payed`) + coalesce(sum((`purchase_products`.`amount` * `products`.`price`)),0)) AS `debt` from (`participants` left join ((`purchase` join `purchase_products` on((`purchase`.`id` = `purchase_products`.`purchase_id`))) join `products` on((`purchase_products`.`product_id` = `products`.`id`))) on((`participants`.`id` = `purchase`.`participant_id`))) group by `participants`.`id` ;

-- --------------------------------------------------------

--
-- Structure for view `view_checkin`
--
DROP TABLE IF EXISTS `view_checkin`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_checkin`  AS  select `view_print_cards`.`id` AS `id`,`view_print_cards`.`name` AS `name`,`view_print_cards`.`barcode` AS `barcode`,`checkin`.`status` AS `status`,`participants_debt`.`debt` AS `debt` from ((`view_print_cards` left join `checkin` on((`view_print_cards`.`id` = `checkin`.`participant_id`))) join `participants_debt` on((`view_print_cards`.`id` = `participants_debt`.`id`))) order by `view_print_cards`.`barcode` ;

-- --------------------------------------------------------

--
-- Structure for view `view_debt`
--
DROP TABLE IF EXISTS `view_debt`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_debt`  AS  select `participants`.`id` AS `id`,`view_checkin`.`barcode` AS `barcode`,`participants`.`name` AS `name`,`participants`.`payed` AS `payed`,`participants_debt`.`debt` AS `debt` from ((`participants` join `participants_debt` on((`participants`.`id` = `participants_debt`.`id`))) join `view_checkin` on((`participants`.`id` = `view_checkin`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_print_cards`
--
DROP TABLE IF EXISTS `view_print_cards`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_print_cards`  AS  select `participants`.`id` AS `id`,`participants`.`name` AS `name`,`participants`.`meal1` AS `meal1`,`participants`.`meal2` AS `meal2`,`participants`.`meal3` AS `meal3`,concat('PLAN18_',lpad(`barcodes`.`barcode_number`,3,'0')) AS `barcode` from (`participants` join `barcodes` on((`participants`.`id` = `barcodes`.`participiant_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_products_sold`
--
DROP TABLE IF EXISTS `view_products_sold`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_products_sold`  AS  select `products`.`id` AS `id`,`products`.`name` AS `name`,coalesce(sum(`purchase_products`.`amount`),0) AS `amount_sold` from (`products` left join `purchase_products` on((`products`.`id` = `purchase_products`.`product_id`))) group by `products`.`id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barcodes`
--
ALTER TABLE `barcodes`
  ADD PRIMARY KEY (`participiant_id`),
  ADD UNIQUE KEY `barcode_number` (`barcode_number`);

--
-- Indexes for table `checkin`
--
ALTER TABLE `checkin`
  ADD PRIMARY KEY (`participant_id`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barcode` (`barcode`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_participant` (`participant_id`);

--
-- Indexes for table `purchase_products`
--
ALTER TABLE `purchase_products`
  ADD PRIMARY KEY (`purchase_id`,`product_id`),
  ADD KEY `purchase_products_ibfk_1` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barcodes`
--
ALTER TABLE `barcodes`
  MODIFY `barcode_number` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `barcodes`
--
ALTER TABLE `barcodes`
  ADD CONSTRAINT `barcodes_ibfk_1` FOREIGN KEY (`participiant_id`) REFERENCES `participants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `checkin`
--
ALTER TABLE `checkin`
  ADD CONSTRAINT `checkin_ibfk_1` FOREIGN KEY (`participant_id`) REFERENCES `participants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `purchase_participant` FOREIGN KEY (`participant_id`) REFERENCES `participants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_products`
--
ALTER TABLE `purchase_products`
  ADD CONSTRAINT `purchase_products_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_products_ibfk_2` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
