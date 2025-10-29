-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 29, 2025 at 09:12 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `motoshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `adminID` int NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`adminID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`adminID`, `password`) VALUES
(100, 'ricastig');

-- --------------------------------------------------------

--
-- Table structure for table `cardpayment`
--

DROP TABLE IF EXISTS `cardpayment`;
CREATE TABLE IF NOT EXISTS `cardpayment` (
  `paymentID` int NOT NULL,
  `cardholderName` varchar(50) NOT NULL,
  `cardNumber` int NOT NULL,
  `csv` int NOT NULL,
  KEY `paymentID` (`paymentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cardpayment`
--

INSERT INTO `cardpayment` (`paymentID`, `cardholderName`, `cardNumber`, `csv`) VALUES
(2, 'wassup', 2147483647, 232);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gcashpayment`
--

DROP TABLE IF EXISTS `gcashpayment`;
CREATE TABLE IF NOT EXISTS `gcashpayment` (
  `paymentID` int NOT NULL,
  `AccountName` varchar(50) NOT NULL,
  `phonenumber` int NOT NULL,
  KEY `paymentID` (`paymentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `Email` varchar(50) DEFAULT NULL,
  `loginDate` date DEFAULT NULL,
  `loginTime` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`Email`, `loginDate`, `loginTime`) VALUES
('ricvalenzuela17@gmail.com', '2025-10-26', '15:58:14'),
('ricvalenzuela17@gmail.com', '2025-10-26', '15:59:47'),
('ricvalenzuela17@gmail.com', '2025-10-26', '16:09:10'),
('ricvalenzuela17@gmail.com', '2025-10-26', '16:30:43'),
('ricvalenzuela17@gmail.com', '2025-10-26', '16:34:15'),
('ricvalenzuela17@gmail.com', '2025-10-26', '16:45:35'),
('coffefitoy@gmail.com', '2025-10-26', '16:58:05'),
('ricvalenzuela17@gmail.com', '2025-10-26', '17:03:20'),
('ricvalenzuela17@gmail.com', '2025-10-26', '17:06:18'),
('ricvalenzuela17@gmail.com', '2025-10-26', '17:28:27'),
('ricvalenzuela17@gmail.com', '2025-10-26', '17:29:23'),
('ric', '2025-10-26', '19:02:25'),
('wmam@gmail.com', '2025-10-26', '19:03:59'),
('ric', '2025-10-26', '19:10:45'),
('ric', '2025-10-26', '19:13:29'),
('ric', '2025-10-26', '19:20:50'),
('ricvalenzuela17@gmail.com', '2025-10-26', '19:24:52'),
('ricvalenzuela17@gmail.com', '2025-10-26', '19:26:59'),
('ricvalenzuela17@gmail.com', '2025-10-26', '19:27:53'),
('1000@gmail.com', '2025-10-27', '23:10:31'),
('ricvalenzuela17@gmail.com', '2025-10-29', '16:27:55'),
('ricvalenzuela17@gmail.com', '2025-10-29', '16:45:38'),
('ricvalenzuela17@gmail.com', '2025-10-29', '16:59:58'),
('ricvalenzuela17@gmail.com', '2025-10-29', '17:09:01');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `OrderID` int NOT NULL AUTO_INCREMENT,
  `userID` int DEFAULT NULL,
  `productID` int DEFAULT NULL,
  `OrderQuantity` int DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `PaymentMethod` varchar(50) DEFAULT NULL,
  `OrderAddress` varchar(255) DEFAULT NULL,
  `OrderStatus` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`OrderID`),
  KEY `userID` (`userID`),
  KEY `productID` (`productID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `userID`, `productID`, `OrderQuantity`, `OrderDate`, `PaymentMethod`, `OrderAddress`, `OrderStatus`) VALUES
(1, 1, 1, 3, '2025-10-26', NULL, '0', 'On Delivery'),
(2, 1, 2, 2, '2025-10-26', NULL, '0', 'Pending'),
(3, 1, 4, 1, '2025-10-26', NULL, '0', 'Pending'),
(4, 1, 1, 1, '2025-10-26', NULL, '0', 'Processing'),
(5, 2, 2, 1, '2025-10-26', NULL, '0', 'Pending'),
(6, 6, 5, 5, '2025-10-26', NULL, '0', 'Pending'),
(7, 5, 2, 4, '2025-10-26', NULL, '0', 'Pending'),
(8, 5, 2, 1, '2025-10-26', NULL, '0', 'Pending'),
(9, 5, 2, 1, '2025-10-26', NULL, '0', 'Pending'),
(10, 1, 42, 1, '2025-10-29', 'Credit Card or Debit Card', 'jaro iloilo', 'Processing'),
(11, 1, 41, 1, '2025-10-29', NULL, 'jnjnj', 'Pending'),
(12, 1, 41, 1, '2025-10-29', 'Credit Card or Debit Card', 'gruingo', 'Processing'),
(13, 1, 42, 1, '2025-10-29', NULL, 'oton buray 5000', 'Pending'),
(14, 1, 41, 1, '2025-10-29', NULL, 'crocrocrocro jaroiloilo city iloilo', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `otheronlinebanking`
--

DROP TABLE IF EXISTS `otheronlinebanking`;
CREATE TABLE IF NOT EXISTS `otheronlinebanking` (
  `paymentID` int NOT NULL,
  `accountname` int NOT NULL,
  `accountnumber` int NOT NULL,
  KEY `paymentID` (`paymentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `paymentID` int NOT NULL AUTO_INCREMENT,
  `OrderID` int DEFAULT NULL,
  `paymentMethod` varchar(50) DEFAULT NULL,
  `paymentAmount` double DEFAULT NULL,
  `paymentStatus` varchar(50) NOT NULL,
  `paymentDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`paymentID`),
  KEY `OrderID` (`OrderID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`paymentID`, `OrderID`, `paymentMethod`, `paymentAmount`, `paymentStatus`, `paymentDate`) VALUES
(1, 10, 'Credit Card or Debit Card', 765000, 'Paid', '2025-10-29 08:44:20'),
(2, 12, 'Credit Card or Debit Card', 595000, 'Paid', '2025-10-29 09:00:44');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `productID` int NOT NULL AUTO_INCREMENT,
  `productimage` varchar(100) DEFAULT NULL,
  `productModel` varchar(50) DEFAULT NULL,
  `BrandName` varchar(50) DEFAULT NULL,
  `Price` double NOT NULL,
  `productDescription` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`productID`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productID`, `productimage`, `productModel`, `BrandName`, `Price`, `productDescription`) VALUES
(1, 'CF150nk.webp', '150nk', 'Cfmoto', 100900, ''),
(2, 'CF230dual.webp', '230 dual', 'Cfmoto', 99900, ''),
(3, 'CF250sr.webp', '250sr', 'Cfmoto', 135000, ''),
(4, 'CF450nk.webp', '450nk', 'Cfmoto', 272800, ''),
(5, 'CF450sr.webp', '450sr', 'Cfmoto', 299900, ''),
(6, 'CF500sr.webp', '500sr', 'Cfmoto', 383900, ''),
(7, 'CFcx-2e.webp', 'cx-2e', 'Cfmoto', 88800, ''),
(8, 'CFstpapio125.webp', 'stpapio125', 'Cfmoto', 118900, 'Displacement: ~ 124.5 cc (also listed as 126 cc in some regions) \r\n\r\n\r\nEngine type: Single-cylinder, 4-stroke, air-cooled \r\n\r\nBore × Stroke: 57 mm × 49.4 mm (or 48.8 mm in some listings) \r\n\r\ncfmotomalaysia.com.my\r\n\r\nCompression Ratio: 9.0 : 1 \r\n\r\n\r\nMax Po'),
(9, 'Dmultistrada v4.webp', 'Multistrada v4', 'Ducati', 1650000, 'Adventure tourer powered by the smooth 1158cc V4 Granturismo engine, featuring front and rear radar for Adaptive Cruise Control and Blind Spot Detection.'),
(10, 'Dpanigalev2.webp', 'Panigale v2', 'Ducati', 1365000, ''),
(11, 'Dpanigalev4.webp', 'Panigale v4', 'Ducati', 1990000, ''),
(12, 'Dscramblericon.webp', 'Scrambler icon', 'Ducati', 670000, ''),
(13, 'Dscramblernightshift.webp', 'Scrambler nightshift', 'Ducati', 785000, ''),
(14, 'Dstreetfighterv2.webp', 'Street Fighter v2  ', 'Ducati', 1150000, 'Panigale V2-derived naked sport bike with a 955cc Superquadro engine (153hp) and a full suite of cutting-edge rider electronics.'),
(15, 'Dsuperleggerav4.webp', 'Super Leggera v4', 'Ducati', 7500000, 'Ultra-exclusive superbike with a carbon fiber chassis, 998cc V4 engine, and track-ready power-to-weight ratio.'),
(16, 'Dsupersport.webp', 'Supersport', 'Ducati', 1225000, ''),
(17, 'Hadv160.webp', 'adv 160 ', 'Honda', 116900, ' Rugged adventure scooter with a powerful 157cc eSP+ engine, ABS, Honda Selectable Torque Control (HSTC), and adjustable windscreen.'),
(18, 'Hcb1000R.webp', 'Cb1000R', 'Honda', 865000, ''),
(19, 'Hcbr150r.webp', 'CBR150r', 'Honda', 183000, ''),
(20, 'Hcbr500r.webp', 'CBR500r', 'Honda', 389000, ''),
(21, 'Hcbr650r.webp', 'CBR650r', 'Honda', 554000, ''),
(22, 'HCBR1000RR.webp', 'CBR1000RR', 'Honda', 1699000, ''),
(23, 'Hgiorno.webp', 'Giorno', 'Honda', 110000, ''),
(24, 'Hwinnerx.webp', 'Winner X', 'Honda', 165000, ''),
(25, 'Kbarako.webp', 'Barako', 'Kawasaki', 80000, ''),
(26, 'Kninja500.webp', 'Ninja 500', 'Kawasaki', 865000, ''),
(27, 'Kninjae1.webp', 'Ninja  E-1', 'Kawasaki', 624000, ''),
(28, 'Kninjazx25r.webp', 'Ninja zx-25r', 'Kawasaki', 406000, ''),
(29, 'Kvulcan900.webp', 'Vulcan 900', 'Kawasaki', 600000, ''),
(30, 'Kvulcan1700.webp', 'Vulcan 1700', 'Kawasaki', 856000, ''),
(31, 'Kz1000r.webp ', 'z1000r', 'Kawasaki', 710000, 'Aggressive \"Sugomi\" styled supernaked with a powerful 1043cc engine, Brembo brakes, and Öhlins suspension.'),
(32, 'Kzx14r.webp ', 'Zx-14r', 'Kawasaki', 750000, 'Hyper-sport motorcycle with an ultra-powerful 1441cc engine, advanced KTRC traction control, and an aluminum monocoque frame.\r\n'),
(33, 'Ymioaerox.webp', 'Mio Aerox', 'Yamaha', 123000, ''),
(34, 'Ymiogravis.webp', 'Mio gravis', 'Yamaha', 75000, ''),
(35, 'Yyzfr15.webp', 'YZF R15', 'Yamaha', 164000, ''),
(36, 'Ysniper155.webp', 'Sniper 155', 'Yamaha', 125900, ''),
(37, 'Yytx125.webp', 'YTX 125', 'Yamaha', 95000, ''),
(38, 'Yyzfr15m.webp', 'YZF R15m', 'Yamaha', 203000, ''),
(39, 'Yyzfr3.webp', 'YZF R3', 'Yamaha', 399000, ''),
(40, 'Yyzfr1m.webp', 'YZF R1m', 'Yamaha', 1739000, ''),
(41, 'Bc400gt.webp', 'C 400gt', 'BMW', 595000, ''),
(42, 'B-f750gs.webp', 'F 750gs', 'BMW', 765000, ''),
(43, 'Bf850gs.webp', 'F 850gs', 'BMW', 855000, ''),
(44, 'Bf900xr.webp', 'F 900xr', 'BMW', 995000, ''),
(45, 'Bg310r.webp', 'G 310r', 'BMW', 300000, ''),
(46, 'Bs1000r.webp', 's1000r', 'BMW', 1455000, ''),
(47, 'Bs1000rr.webp', 's1000rr', 'BMW', 1575000, ''),
(48, 'Bs1000xr.webp', 's1000xr', 'BMW', 1855000, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userID` int NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `phoneNo` int NOT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `FirstName`, `LastName`, `phoneNo`, `Email`, `Password`) VALUES
(1, 'niggawat', 'nigga', 0, 'ricvalenzuela17@gmail.com', '123'),
(2, 'coffee', 'fitoy', 0, 'coffefitoy@gmail.com', '12345'),
(3, 'fff', 'sdkfsk', 90099090, 'hh@g.ail', 'alskdjakds'),
(4, 'asdasd', 'asdasddsd', 303492394, 'sasdasd', 'asdasdasd'),
(5, 'ric', 'ric', 123, 'ric', 'ric'),
(6, 'naethan', 'james', 3424, 'wmam@gmail.com', '12345'),
(7, 'ric', 'valenzuela', 0, '1000@gmail.com', '1234');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cardpayment`
--
ALTER TABLE `cardpayment`
  ADD CONSTRAINT `cardpayment_ibfk_1` FOREIGN KEY (`paymentID`) REFERENCES `payments` (`paymentID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `gcashpayment`
--
ALTER TABLE `gcashpayment`
  ADD CONSTRAINT `gcashpayment_ibfk_1` FOREIGN KEY (`paymentID`) REFERENCES `payments` (`paymentID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`);

--
-- Constraints for table `otheronlinebanking`
--
ALTER TABLE `otheronlinebanking`
  ADD CONSTRAINT `otheronlinebanking_ibfk_1` FOREIGN KEY (`paymentID`) REFERENCES `payments` (`paymentID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
