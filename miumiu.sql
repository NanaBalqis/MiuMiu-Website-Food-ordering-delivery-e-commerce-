-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2024 at 09:02 PM
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
-- Database: `miumiu`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `order_ID` varchar(150) NOT NULL,
  `cust_ID` varchar(150) NOT NULL,
  `category_ID` varchar(100) NOT NULL,
  `item_ID` varchar(150) NOT NULL,
  `itemName` varchar(30) NOT NULL,
  `itemPrice` decimal(20,2) NOT NULL,
  `quantity` int(150) NOT NULL,
  `amount` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`order_ID`, `cust_ID`, `category_ID`, `item_ID`, `itemName`, `itemPrice`, `quantity`, `amount`) VALUES
('order1', 'comel', 'DF', 'DF3', 'Pretzels', 20.00, 1, 20.00),
('order2', 'momodah', 'DF', 'DF1', 'Mochi Doughnut', 20.00, 1, 20.00),
('order3', 'mimi', 'DF', 'DF3', 'Pretzels', 20.00, 1, 20.00),
('order4', 'nana', 'DF', 'DF1', 'Mochi Doughnut', 20.00, 1, 20.00),
('order5', 'comel', 'NC', 'NC1', 'Mojito', 9.00, 1, 9.00),
('order6', 'momodah', 'CF', 'CF2', 'Americano', 11.50, 1, 11.50),
('order7', 'nana', 'DF', 'DF1', 'Mochi Doughnut', 20.00, 1, 20.00);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_ID` varchar(100) NOT NULL,
  `categoryName` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_ID`, `categoryName`) VALUES
('C', 'Cakes'),
('CF', 'Coffee'),
('CR', 'Croffle'),
('DF', 'Deep Fried'),
('NC', 'Non-Coffee'),
('PS', 'Pastries');

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `cust_ID` varchar(150) NOT NULL,
  `category_ID` varchar(100) NOT NULL,
  `item_ID` varchar(150) NOT NULL,
  `itemName` varchar(30) NOT NULL,
  `itemPrice` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forgotpassword`
--

CREATE TABLE `forgotpassword` (
  `email` varchar(150) NOT NULL,
  `resetlink` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forgotpassword`
--

INSERT INTO `forgotpassword` (`email`, `resetlink`) VALUES
('tehas@gmail.com', 'http:example'),
('tehas@gmail.com', 'http:resetLink.com'),
('tehas@gmail.com', 'http:resetLink.com'),
('nuya@gmail.com', 'http:resetLink.com'),
('nene@gmail.com', 'http:resetLink.com');

-- --------------------------------------------------------

--
-- Table structure for table `forgotpasswordadmin`
--

CREATE TABLE `forgotpasswordadmin` (
  `ademail` varchar(100) NOT NULL,
  `adcode` int(50) NOT NULL,
  `resetlink` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forgotpasswordadmin`
--

INSERT INTO `forgotpasswordadmin` (`ademail`, `adcode`, `resetlink`) VALUES
('nurainaa@gmail.com', 10203, 'http:example'),
('nurainaa@gmail.com', 10203, 'http:example'),
('nurainaa@gmail.com', 10203, 'http:example');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_ID` varchar(150) NOT NULL,
  `itemName` varchar(30) NOT NULL,
  `itemPrice` decimal(20,2) NOT NULL,
  `quantity` int(250) NOT NULL,
  `category_ID` varchar(150) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_ID`, `itemName`, `itemPrice`, `quantity`, `category_ID`, `image_path`) VALUES
('C1', 'Mousse Cake', 25.79, 100, 'C', 'image/mousse.jpeg'),
('C2', 'Mousse Mini', 15.99, 90, 'C', 'image/moussecake.jpeg'),
('C3', 'Cheese Cake', 40.50, 50, 'C', 'image/Cheese cake.jpeg'),
('C4', 'Mini Cake', 30.00, 60, 'C', 'image/mini cake.jpeg'),
('CF1', 'Matchapresso', 12.00, 200, 'CF', 'image/Matcha Esspresso.jpg'),
('CF2', 'Americano', 11.50, 200, 'CF', 'image/Ice Americano.jpg'),
('CF3', 'Latte', 10.99, 200, 'CF', 'image/Ice Latte.jpg'),
('CF4', 'Macchiato', 13.10, 200, 'CF', 'image/Caramel Macchiato.jpg'),
('CR1', 'Croffle Set', 34.20, 50, 'CR', 'image/croffle.jpg'),
('CR2', 'Icecream Croffle', 20.15, 40, 'CR', 'image/croffleicecream.jpeg'),
('CR3', 'Berry Croffle', 19.90, 30, 'CR', 'image/Berry Croofle.jpg'),
('CR4', 'Biscoff Croffle', 19.90, 35, 'CR', 'image/BiscoffCroffle.jpg'),
('DF1', 'Mochi Doughnut', 20.00, 100, 'DF', 'image/mochidonut.jpeg'),
('DF2', 'Churros', 18.89, 90, 'DF', 'image/churros.jpeg'),
('DF3', 'Pretzels', 20.00, 90, 'DF', 'image/pretzels.jpeg'),
('DF4', 'Bomboloni', 14.20, 80, 'DF', 'image/bomboloni.jpeg'),
('NC1', 'Mojito', 9.00, 200, 'NC', 'image/mojito.jpg'),
('NC2', 'Melon Sorbet', 11.50, 200, 'NC', 'image/watermelon.jpg'),
('NC3', 'Berry Dolce', 20.99, 200, 'NC', 'image/strawberry dolce.jpg'),
('NC4', 'Bubble Matcha', 15.10, 200, 'NC', 'image/bubble tea matcha.jpg'),
('PS1', 'Berry Croissant', 20.00, 60, 'PS', 'image/erryCroissant.jpeg'),
('PS2', 'Struddle', 20.99, 70, 'PS', 'image/struddels.jpeg'),
('PS3', 'Cromboloni', 20.99, 60, 'PS', 'image/cromboloni.jpeg'),
('PS4', 'Eclair', 15.10, 80, 'PS', 'image/eclair.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_ID` varchar(150) NOT NULL,
  `cust_ID` varchar(150) NOT NULL,
  `order_ID` varchar(150) NOT NULL,
  `totalAmount` decimal(20,2) NOT NULL,
  `dateTime` datetime NOT NULL DEFAULT current_timestamp(),
  `delivery_ID` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_ID`, `cust_ID`, `order_ID`, `totalAmount`, `dateTime`, `delivery_ID`) VALUES
('pay1', 'comel', 'order1', 20.24, '2024-01-08 11:28:35', 'del1'),
('pay10', 'momodah', 'order10', 35.25, '2024-04-15 11:10:55', 'del10'),
('pay11', 'comel', 'order11', 19.50, '2024-05-03 09:45:22', 'del11'),
('pay12', 'nana', 'order12', 27.80, '2024-05-08 12:30:15', 'del12'),
('pay13', 'comel', 'order13', 23.40, '2024-06-14 15:20:30', 'del13'),
('pay14', 'momodah', 'order14', 31.60, '2024-06-20 17:40:18', 'del14'),
('pay15', 'nana', 'order15', 25.75, '2024-07-05 11:55:40', 'del15'),
('pay16', 'comel', 'order16', 18.90, '2024-07-10 14:10:55', 'del16'),
('pay17', 'momodah', 'order17', 29.20, '2024-08-18 08:30:22', 'del17'),
('pay18', 'mimi', 'order18', 22.30, '2024-08-22 10:45:30', 'del18'),
('pay19', 'comel', 'order19', 26.45, '2024-09-09 13:20:45', 'del19'),
('pay2', 'momodah', 'order2', 25.30, '2024-01-08 11:32:19', 'del2'),
('pay20', 'momodah', 'order20', 33.75, '2024-09-14 15:40:28', 'del20'),
('pay3', 'mimi', 'order3', 25.30, '2024-01-08 11:34:58', 'del3'),
('pay4', 'nana', 'order4', 25.30, '2024-01-08 11:37:12', 'del4'),
('pay5', 'comel', 'order5', 15.50, '2024-02-15 10:20:45', 'del5'),
('pay6', 'comel', 'order6', 30.75, '2024-02-18 12:45:30', 'del6'),
('pay7', 'mimi', 'order7', 22.80, '2024-03-05 14:10:22', 'del7'),
('pay8', 'comel', 'order8', 18.60, '2024-03-08 16:30:15', 'del8'),
('pay9', 'comel', 'order9', 27.90, '2024-04-12 08:55:40', 'del9');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `name` varchar(150) NOT NULL,
  `cust_ID` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phoneno` int(11) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `confirmpass` varchar(255) NOT NULL,
  `address` varchar(250) NOT NULL,
  `city` varchar(250) NOT NULL,
  `zipCode` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`name`, `cust_ID`, `email`, `phoneno`, `pass`, `confirmpass`, `address`, `city`, `zipCode`) VALUES
('nuraina', 'ain', 'nuraina@gmail.com', 1118810602, '$2y$10$yPRjObb3yEMsBGTw8lwWAOYMXofTUiSme2pCXF0SO2j5wCFk8f4ty', '$2y$10$LbD6YekQkrra9bATLo4NyOdcu8zhnd6kA/v5BOeEUNRRoz3oDwRXK', 'kg joh', 'machang', '18500'),
('nananana', 'comel', 'comel@gmail.com', 1211417452, '$2y$10$cdAJ/08hFsWNzXqi4uIbfOzISHXLVzyzhZADHdXf8i3HzWRvDben.', '$2y$10$cdAJ/08hFsWNzXqi4uIbfOzISHXLVzyzhZADHdXf8i3HzWRvDben.', 'UNIVERSTY TECHNOLOGY OF DEPRESSI', 'Araustralia', '02600'),
('Hanis Natasya', 'hanisomey', 'hanisghazali27@gmail.com', 182401883, '$2y$10$l2TbcXa9KLC4Rqi8lV8vOup90t2tC/.dRx3IgwJkKpjtJPVkD4AB6', '$2y$10$9P6PAB/yil9s/KiimTl0Oeho7BozEMqhKDuBgPcQbB4da3DxiQA8W', 'Lot 480 Kg menjual diri, chabang tiga', 'tumpat', '16210'),
('mimi', 'mimi', 'mi@gmail.com', 111110009, '$2y$10$/HE9Bpf0sqcuExnk6NW6heNbRLxLtl.mDIxr.UMWGdeKpF02WzkJK', '$2y$10$6tD7tRF1oenONZ4BhYUqvePUlJzyl/1OpDDCL1XEqvfDQu3DwWC6O', '', '', '0'),
('momo', 'momodah', 'momocomei@gmail.com', 122928822, '$2y$10$vcel4NgeaxbV3r4iH1utouu9mfF1NtQHE4LVgf.p9LBxWszHHWS9S', '$2y$10$SZoRwAsmiGdL3N8xZZWFyOSUP5ObMd1WfCf/Rth3CjLE76mlEZIiO', 'MEREMPAT JAH', 'NOWHERE', '12008'),
('nurainaa balqis', 'nana', 'nurainaabalqis83@gmail.com', 1100417452, '$2y$10$3yEt8fy3e/E/3vsz5BPI5O28mQMoux5SpJDQe.9DIqlA282j1HKHS', '$2y$10$b3jxXuxmNb54awoGV29CQujblk/DtyYzVV09oY9WvL5wXcpMnIk7G', 'Lot 100 Kg hutan Hilir, Jln raja tuo redo', 'Wenchester', '16250'),
('AUNI INSYIRAH', 'NINI', 'insyirahauni86@gmail.com', 1125502267, '$2y$10$qz5BMVnvb8K8h3oSCWuOOulFUk/8IRL3ekcK0nVNfsx2QQAAhzNAK', '$2y$10$tQn1J1I/MHLO27EEuYoD7ekxl6YeDZqIcywPDkOx98fuzxIUeFVFe', '6732 kg pulau derita, depression, 200 jln mati', 'Kualeeeee penyu', '31700'),
('Muhammad Saleh', 'saleh', 'saleh@gmail.com', 1010908011, '$2y$10$ThI3n/0uamkhkK8mlPasgOHAIyrM6ixUGM/tnPFOxVNiO2tAs.CQm', '$2y$10$uuY5Z6Rolbyy9rRx3eWQ1.RCRsdZCU5ymAagSCcxlzUL1PEy.9eWW', 'Kg Membatu ', 'Ketereh', '12650'),
('titi', 'wesh', 'meow@gmail.com', 1111111111, '$2y$10$FOLtKBMZnquS4VwpzXxDI.7lBTtuaY0Qpgby2RSIc1PmR.2oXCgWq', '$2y$10$PaXMN5i3k3etYQnOiOClmO7repEu146slsEhDI.B8ae7WA7bwj5ma', 'Kg tak tahu, taman maheran something', 'jitra', '41025');

-- --------------------------------------------------------

--
-- Table structure for table `registration admin`
--

CREATE TABLE `registration admin` (
  `staff_ID` int(150) NOT NULL,
  `name` varchar(150) NOT NULL,
  `aduser` varchar(150) NOT NULL,
  `ademail` varchar(100) NOT NULL,
  `adphoneno` int(11) NOT NULL,
  `adpass` varchar(255) NOT NULL,
  `adconfirmpass` varchar(255) NOT NULL,
  `adcode` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration admin`
--

INSERT INTO `registration admin` (`staff_ID`, `name`, `aduser`, `ademail`, `adphoneno`, `adpass`, `adconfirmpass`, `adcode`) VALUES
(1276, 'somel', 'somel', 'somel@gmail.com', 123434545, '$2y$10$0fR3w4s37IhDruXzEKAsP.eseM2rt5hQeqYZCQIcLjfjjXPeZs7gy', '$2y$10$JNyJG1blilVK4sb4uNJBdeE0T4RYsHw4ETJzT7.3ZXh12nPOXk3uy', 10203),
(15467, 'syamimia smeg', 'mimi', 'mimi@gmail.com', 10909900, '$2y$10$5VpYGHvXhT6Z7VPzZgjMBuSha1JaDjHNADntExcgA6K5ENG.Iy/P2', '$2y$10$xlcnlVd6l5f0fbkXVVkg8.u.fRBq78uBB/zT0FtCDGDRPLk1X3usG', 10203),
(56789, 'busuk', 'busuk', 'busuk@gmail.com', 1929929929, '$2y$10$p60G0mPOo5xDcxnDMjGJEutG4WyVmSRCkExryx4MYIO6TmgCAKMOC', '$2y$10$INY2Js0PKhfPQ86lzYm0I.W3/Pfg3T.Zz9t5MReFa1agLR6vliIqe', 10203);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD KEY `item_ID` (`item_ID`),
  ADD KEY `cust_ID` (`cust_ID`),
  ADD KEY `category_ID` (`category_ID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_ID`);

--
-- Indexes for table `favorite`
--
ALTER TABLE `favorite`
  ADD KEY `item_ID` (`item_ID`),
  ADD KEY `cust_ID` (`cust_ID`),
  ADD KEY `category_ID` (`category_ID`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_ID`),
  ADD UNIQUE KEY `itemName` (`itemName`),
  ADD KEY `item_ibfk_1` (`category_ID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_ID`),
  ADD KEY `cust_ID` (`cust_ID`),
  ADD KEY `payment_ibfk_1` (`delivery_ID`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`cust_ID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phoneno` (`phoneno`);

--
-- Indexes for table `registration admin`
--
ALTER TABLE `registration admin`
  ADD PRIMARY KEY (`staff_ID`),
  ADD UNIQUE KEY `adphoneno` (`adphoneno`),
  ADD UNIQUE KEY `ademail` (`ademail`),
  ADD UNIQUE KEY `aduser` (`aduser`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`item_ID`) REFERENCES `item` (`item_ID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`cust_ID`) REFERENCES `registration` (`cust_ID`),
  ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`category_ID`) REFERENCES `category` (`category_ID`);

--
-- Constraints for table `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `favorite_ibfk_1` FOREIGN KEY (`item_ID`) REFERENCES `item` (`item_ID`),
  ADD CONSTRAINT `favorite_ibfk_2` FOREIGN KEY (`cust_ID`) REFERENCES `registration` (`cust_ID`),
  ADD CONSTRAINT `favorite_ibfk_3` FOREIGN KEY (`category_ID`) REFERENCES `category` (`category_ID`);

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`category_ID`) REFERENCES `category` (`category_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`cust_ID`) REFERENCES `registration` (`cust_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
