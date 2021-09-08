-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 08, 2021 at 05:45 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gcomdb`
--
CREATE DATABASE IF NOT EXISTS `gcomdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gcomdb`;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT IGNORE INTO `cart` (`id`, `user_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `cart_product`
--

CREATE TABLE `cart_product` (
  `product_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart_product`
--

INSERT IGNORE INTO `cart_product` (`product_id`, `cart_id`, `date`, `id`) VALUES
(1, 1, '2021-09-08', 1),
(1, 2, '2021-09-08', 4);

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `total` decimal(6,2) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `checkout`
--

INSERT IGNORE INTO `checkout` (`id`, `cart_id`, `total`, `date`) VALUES
(1, 2, '1559.99', '2021-09-08 17:44:04');

-- --------------------------------------------------------

--
-- Table structure for table `checkout_product`
--

CREATE TABLE `checkout_product` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `checkout_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `checkout_product`
--

INSERT IGNORE INTO `checkout_product` (`id`, `product_id`, `checkout_id`) VALUES
(1, 4, 1),
(2, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `path` varchar(250) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `image`
--

INSERT IGNORE INTO `image` (`id`, `path`, `product_id`) VALUES
(1, '../uploads/products/suede jacket_primary.jpg', 1),
(2, '../uploads/products/suede jacket_hover.jpg', 1),
(3, '../uploads/products/satin blouse with a draped collar_primary.jpeg', 2),
(4, '../uploads/products/satin blouse with a draped collar_hover.jpeg', 2),
(5, '../uploads/products/apple macbook pro_primary.jpg', 3),
(6, '../uploads/products/apple macbook pro_hover.jpeg', 3),
(7, '../uploads/products/tenet_primary.jpg', 4),
(8, '../uploads/products/tenet_hover.jpeg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT IGNORE INTO `product` (`id`, `name`, `description`, `price`, `quantity`, `store_id`) VALUES
(1, 'Suede Jacket', '\r\nSuede is a high-quality form of leather, made from the underside of the animal hide. It\'s characterized by a soft smooth surface, and it is popular for fashion items, like shoes, accessories, and jackets.', '120.99', 30, 1),
(2, 'SATIN BLOUSE WITH A DRAPED COLLAR', 'SATIN BLOUSE WITH A DRAPED COLLAR. Blouse featuring a high neck with gathered details and long sleeves.', '229.99', 5, 1),
(3, 'Apple MacBook Pro', '3-Inch 256GB Ssd Space Grey M1 Chip with 8-Core CPU/8-Core GPU [Arabic/English]', '1550.00', 2, 2),
(4, 'Tenet', 'This is a science fiction-action-thriller film starring John David Washington, Robert Pattinson, Elizabeth Debicki, and Kenneth Branagh, among others. It\'s the story of a secret agent who learns to manipulate the flow of time to prevent an attack from the future that threatens to annihilate the present.', '9.99', 119, 2);

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `store_image` varchar(250) NOT NULL,
  `store_header_image` varchar(250) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `email` varchar(150) NOT NULL,
  `user_id` int(11) NOT NULL,
  `street` varchar(200) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `store`
--

INSERT IGNORE INTO `store` (`id`, `name`, `description`, `store_image`, `store_header_image`, `phone_number`, `email`, `user_id`, `street`, `city`, `country`) VALUES
(1, 'ZARA', 'Zara is a Spanish clothing retailer based in Galicia, Spain. Founded by Amancio Ortega in 1975, it is the flagship chain store of the Inditex group, the world\'s largest apparel retailer. ... Zara has consistently acted as a pioneer in fast fashion based in a higly responsive supply chain.', '../uploads/stores/zara_primary.jpg', '../uploads/stores/zara_header.png', '01 771 250', 'customercare@zara.com', 3, 'ABC Verdun', 'Beirut', 'Lebanon'),
(2, 'Virgin MegaStore', 'Virgin Megastores is an international entertainment retailing chain, founded in early 1976 by Sir Richard Branson as a record shop on London\'s Oxford Street. In 1979 the company opened their first Megastore at the end of Oxford Street and Tottenham Court Road.', '../uploads/stores/virgin megastore_primary.png', '../uploads/stores/virgin megastore_header.jpeg', '01 215 504', 'contactus@virgin.com', 4, 'ABC, Ashrafiyeh', 'Beirut', 'Lebanon'),
(3, 'H&M', 'H&M is a Swedish multinational clothing-retail company known for its fast-fashion clothing for men, women, teenagers, and children. ... It is the second-largest global clothing retailer, behind Spain-based Inditex (parent company of Zara).', '../uploads/stores/h&m_primary.png', '../uploads/stores/h&m_header.jpg', '01890399', 'contactus@hm.com', 5, 'Saida Mall, Main Rd', 'Saida', 'Lebanon');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `gender` tinyint(4) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT IGNORE INTO `user` (`id`, `first_name`, `last_name`, `email`, `gender`, `password`) VALUES
(1, 'John', 'Doe', 'customer1@gmail.com', 1, 'dea26157fa355301663174eac368538cff8939f36681d6712dedba439ab98b70'),
(2, 'Jane', 'Doe', 'customer2@gmail.com', 0, 'c8c7cb5b9e8f7a1b3d1d02602ada62327132391dbe0e8ee07913cd550eea1f3b'),
(3, 'Zara', 'Hr', 'marketing@zara.com', 0, '1a637788c9e469bd4e4ef4bf05507d20d3fa2c37e046f21a43ca06ed650b36a4'),
(4, 'Virgin', 'Megastore HR', 'marketing@virgin.com', 0, '4098e1a88ff7d1811c0b9043066c8a5df457cfac8b810cbf1d7c5105d9ed0a0b'),
(5, 'H&M', 'Marketer', 'marketing@hm.com', 1, '80cbc1625e7ed32854a459f96e43c7f1c009d7aeec79f105f1508c479558a361');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wishlist`
--

INSERT IGNORE INTO `wishlist` (`id`, `user_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_product`
--

CREATE TABLE `wishlist_product` (
  `product_id` int(11) NOT NULL,
  `wishlist_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wishlist_product`
--

INSERT IGNORE INTO `wishlist_product` (`product_id`, `wishlist_id`, `date`, `id`) VALUES
(2, 1, '2021-09-08', 1),
(3, 1, '2021-09-08', 2),
(1, 2, '2021-09-08', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_cart` (`user_id`);

--
-- Indexes for table `cart_product`
--
ALTER TABLE `cart_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `for_cart` (`cart_id`),
  ADD KEY `product_in_cart` (`product_id`);

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_cart_checkout` (`cart_id`);

--
-- Indexes for table `checkout_product`
--
ALTER TABLE `checkout_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_checkout` (`checkout_id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_image` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_products` (`store_id`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_owner` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_wishlist` (`user_id`);

--
-- Indexes for table `wishlist_product`
--
ALTER TABLE `wishlist_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `for_wislist` (`wishlist_id`),
  ADD KEY `product_in_wishlist` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cart_product`
--
ALTER TABLE `cart_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `checkout_product`
--
ALTER TABLE `checkout_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wishlist_product`
--
ALTER TABLE `wishlist_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `user_cart` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `cart_product`
--
ALTER TABLE `cart_product`
  ADD CONSTRAINT `for_cart` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_in_cart` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `checkout`
--
ALTER TABLE `checkout`
  ADD CONSTRAINT `user_cart_checkout` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `checkout_product`
--
ALTER TABLE `checkout_product`
  ADD CONSTRAINT `user_checkout` FOREIGN KEY (`checkout_id`) REFERENCES `checkout` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `product_image` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `store_products` FOREIGN KEY (`store_id`) REFERENCES `store` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `store`
--
ALTER TABLE `store`
  ADD CONSTRAINT `store_owner` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `user_wishlist` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `wishlist_product`
--
ALTER TABLE `wishlist_product`
  ADD CONSTRAINT `for_wislist` FOREIGN KEY (`wishlist_id`) REFERENCES `wishlist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_in_wishlist` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
