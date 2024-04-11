-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2023 at 05:07 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `assign_order` (IN `OID_identifier` INT, IN `DID_identifier` INT)   BEGIN
	START TRANSACTION;
		UPDATE Delivery_Personnel set stat = "busy" where DID = DID_identifier;
        UPDATE Orders set DID = DID_identifier, stat = "delivery confirmed" where OID = OID_identifier;
	COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `complete_order` (IN `OID_identifier` INT, IN `DID_identifier` INT)   BEGIN
	DECLARE now date;
	START TRANSACTION;
        SELECT curdate() INTO now;
		UPDATE Delivery_Personnel set stat = "active" where DID = DID_identifier;
        UPDATE Orders set stat = "delivered", Date_of_delivery = now where OID = OID_identifier;
	COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `order_user` (IN `UID_identifier` INT)   BEGIN
	DECLARE cur_oid INT;
    DECLARE now date;
    DECLARE exit handler for sqlexception
		BEGIN
        	SELECT "ERROR";
            ROLLBACK;
		END;
    start transaction;
		SELECT max(oid)+1 INTO cur_oid FROM orders;
		SELECT curdate() INTO now;
		INSERT INTO orders(oid,uid,Date_of_order) VALUES(cur_oid,UID_identifier,now);       
		INSERT INTO bills(oid,pid,quan) SELECT cur_oid,c.pid,c.quan FROM cart c WHERE c.uid = UID_identifier;    
		DELETE FROM cart WHERE cart.uid = UID_identifier;
        SELECT "success" AS "ERROR";
	COMMIT;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `OID` int(11) DEFAULT NULL,
  `PID` varchar(10) DEFAULT NULL,
  `quan` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`OID`, `PID`, `quan`, `price`) VALUES
(2, 'd05', 2, 774),
(2, 'd01', 1, 62),
(2, 'd04', 2, 562),
(2, 'f03', 1, 47),
(2, 'f02', 1, 58),
(2, 'f06', 1, 52),
(2, 'f07', 1, 85),
(2, 'p04', 1, 149),
(2, 'pf01', 1, 10),
(2, 'v07', 1, 71),
(2, 'v11', 1, 13),
(2, 'f15', 1, 20),
(3, 'd04', 2, 562),
(3, 'd05', 1, 387),
(3, 'de01', 3, 900),
(3, 'd03', 1, 17),
(4, 'v02', 2, 82),
(4, 'v03', 1, 26),
(4, 'v08', 3, 270),
(4, 'v10', 3, 63),
(4, 'v11', 1, 13),
(4, 'v12', 3, 51),
(4, 'v15', 2, 90),
(4, 'f15', 1, 20),
(5, 'cn03', 5, 275),
(5, 'cn01', 3, 600),
(5, 'cn02', 1, 80),
(5, 'd04', 1, 281),
(5, 'f01', 1, 62),
(5, 'ds01', 3, 270),
(6, 'f06', 1, 52),
(6, 'f07', 1, 85),
(7, 'f10', 1, 113),
(8, 'de01', 1, 300),
(8, 'de02', 1, 300),
(9, 'd03', 1, 17),
(9, 'ds01', 1, 90),
(10, 'f01', 1, 62),
(10, 'f02', 1, 58),
(10, 'f03', 1, 47),
(10, 'f04', 2, 368),
(10, 'f05', 1, 109),
(10, 'f06', 1, 52),
(10, 'f07', 1, 85),
(10, 'f13', 3, 186),
(10, 'f14', 1, 53),
(11, 'v13', 1, 62),
(11, 'v12', 1, 17),
(11, 'v11', 1, 13),
(11, 'v10', 1, 21);

--
-- Triggers `bills`
--
DELIMITER $$
CREATE TRIGGER `generate_total` AFTER INSERT ON `bills` FOR EACH ROW UPDATE orders 
SET total = total + (NEW.quan*(SELECT price FROM store_inv WHERE pid = NEW.pid))
WHERE oid = NEW.oid
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `reduce_quantity` AFTER INSERT ON `bills` FOR EACH ROW UPDATE store_inv 
SET quan = quan - NEW.quan
WHERE pid = NEW.pid
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `set_bills_price` BEFORE INSERT ON `bills` FOR EACH ROW BEGIN
	SET NEW.price = NEW.quan * (SELECT S.price FROM store_inv S WHERE S.PID = NEW.PID);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `UID` int(11) DEFAULT NULL,
  `PID` varchar(10) DEFAULT NULL,
  `quan` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`UID`, `PID`, `quan`, `price`) VALUES
(7, 'f01', 1, 62),
(7, 'f02', 1, 58),
(7, 'f03', 1, 47),
(7, 'f06', 1, 52),
(7, 'f07', 1, 85),
(7, 'f08', 1, 50),
(7, 'p04', 1, 149),
(2, 'c02', 1, 100),
(2, 'c03', 1, 100),
(2, 'cn02', 1, 80),
(2, 'cn03', 1, 55),
(2, 'f01', 1, 62),
(2, 'f02', 1, 58),
(2, 'f03', 1, 47),
(2, 'f04', 1, 184),
(3, 'f03', 1, 47),
(3, 'f02', 1, 58),
(3, 'f01', 1, 62),
(3, 'ds01', 1, 90),
(3, 'f05', 1, 109),
(3, 'v15', 1, 45),
(5, 'b01', 1, 120),
(5, 'c02', 1, 100),
(5, 'd02', 1, 70),
(5, 'cn02', 1, 80),
(5, 'd03', 1, 17),
(5, 'd05', 1, 387),
(5, 'de02', 1, 300),
(5, 're01', 1, 60);

--
-- Triggers `cart`
--
DELIMITER $$
CREATE TRIGGER `set_cart_price` BEFORE INSERT ON `cart` FOR EACH ROW BEGIN
	SET NEW.price = NEW.quan * (SELECT S.price FROM store_inv S WHERE S.PID = NEW.PID);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_cart_price_for_quantity_update` BEFORE UPDATE ON `cart` FOR EACH ROW BEGIN
	IF (NEW.quan <> OLD.quan) THEN
		SET NEW.price = NEW.quan * (SELECT price FROM store_inv WHERE PID = OLD.PID);
	END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_personnel`
--

CREATE TABLE `delivery_personnel` (
  `DID` int(11) NOT NULL,
  `aadhaar` bigint(20) DEFAULT NULL,
  `Delivery_name` varchar(50) DEFAULT NULL,
  `stat` varchar(20) DEFAULT 'inactive' CHECK (`stat` in ('active','busy','inactive')),
  `phone_number` bigint(20) DEFAULT NULL,
  `License_number` int(11) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_personnel`
--

INSERT INTO `delivery_personnel` (`DID`, `aadhaar`, `Delivery_name`, `stat`, `phone_number`, `License_number`, `password`) VALUES
(93, 453222341678, 'Ramesh', 'active', 1234567890, 483295, 'a1'),
(94, 789651237493, 'Suresh', 'inactive', 1233661190, 483293, 'a2'),
(95, 778991245678, 'Mukesh', 'busy', 1849603925, 483298, 'a3'),
(96, 789566762278, 'Mahesh', 'active', 5682343456, 876345, 'a4'),
(97, 455562389567, 'Ajitesh', 'busy', 9884567298, 722495, 'a5');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OID` int(11) NOT NULL,
  `UID` int(11) DEFAULT NULL,
  `DID` int(11) DEFAULT NULL,
  `stat` varchar(20) DEFAULT 'ordered' CHECK (`stat` in ('ordered','delivery confirmed','dispatched','delivered')),
  `Date_of_order` date DEFAULT NULL,
  `Date_of_delivery` date DEFAULT NULL,
  `total` double DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OID`, `UID`, `DID`, `stat`, `Date_of_order`, `Date_of_delivery`, `total`) VALUES
(1, 1, 95, NULL, NULL, NULL, NULL),
(2, 2, 93, 'delivered', '2023-05-24', '2023-05-24', 1903),
(3, 3, 93, 'delivered', '2023-05-24', '2023-05-24', 1866),
(4, 3, 93, 'delivered', '2023-05-24', '2023-05-24', 615),
(5, 4, 93, 'delivered', '2023-05-24', '2023-05-24', 1568),
(6, 4, 95, 'dispatched', '2023-05-24', NULL, 137),
(7, 4, 97, 'delivery confirmed', '2023-05-24', NULL, 113),
(8, 5, NULL, 'ordered', '2023-05-24', NULL, 600),
(9, 6, NULL, 'ordered', '2023-05-24', NULL, 107),
(10, 6, NULL, 'ordered', '2023-05-24', NULL, 1020),
(11, 7, NULL, 'ordered', '2023-05-24', NULL, 113);

-- --------------------------------------------------------

--
-- Table structure for table `store_inv`
--

CREATE TABLE `store_inv` (
  `PID` varchar(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `quan` int(11) DEFAULT 0 CHECK (`quan` >= 0),
  `price` float NOT NULL,
  `category` varchar(20) DEFAULT NULL,
  `link` varchar(50) DEFAULT NULL,
  `info` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `store_inv`
--

INSERT INTO `store_inv` (`PID`, `Name`, `quan`, `price`, `category`, `link`, `info`) VALUES
('b01', 'Muffin', 2, 120, 'baked goods', 'images/muffin.jpg\r\n', 'A chocolate muffin for the Afternoon'),
('b02', 'Cup Cake', 8, 90, 'baked goods', 'images/cake.jpg', 'A birthday celebration?'),
('c01', 'Golden Wheat (1Kg)', 8, 100, 'cereals', 'images/wheat.jpg', 'Golden, Yellow wheat'),
('c02', 'White rice', 57, 100, 'cereals', 'images/rice.jpg', 'White clean husked rice'),
('c03', 'Barley (1Kg)', 19, 100, 'cereals', 'images/barley.jpg', 'A kilogram of barley flour'),
('cn01', 'Rasgulla', 40, 200, 'canned', 'images/rasgulla.jpg', 'Your favourite sweet, now in a can'),
('cn02', 'Beans', 32, 80, 'canned', 'images/beans.jpg', 'Canned beans, ready to serve'),
('cn03', 'Canned noodles', 20, 55, 'canned', 'images/noodles.jpg', 'A tin of canned noodles'),
('d01', 'GoodLife Toned Milk (1L)', 6, 62, 'dairy', 'images/milk.jpg', 'Fresh and Toned Cow Milk FROM Good life'),
('d02', 'Taaza Toned Milk (1L)', 10, 70, 'dairy', 'images/taaza_milk.jpg', 'Taaza Milk with your morning coffee'),
('d03', 'Curd Ndandini (500g)', 3, 17, 'dairy', 'images/curd.jpg', 'Curd FROM nandini to fish up your meals'),
('d04', 'Milky Mist Paneer (500g)', 8, 281, 'dairy', 'images/paneer.jpg', 'Crisp diced paneer'),
('d05', 'D\'lecta Natural Cheddar Cheese(200g)', 31, 387, 'dairy', 'images/cheese.jpg', 'Care for a hINT of cheese?'),
('de01', 'surfexcel', 16, 300, 'Daily Essentials', 'images/surf.jpg', 'Sufexcel matic liquid to wash your clothes'),
('de02', 'Odonil Room Freshner (3)', 7, 300, 'Daily Essentials', 'images/odonil.jpg', 'Add fragrance to your room'),
('ds01', 'Amul Ice cream', 15, 90, 'Desserts', 'images/icecream.jpg', 'The perfect dessert'),
('f01', 'Shimla Apple (1 kg)', 11, 62, 'fruits', 'images/apple.jpg', 'Only the finest apples FROM Shimla'),
('f02', 'Robusta Banana (4 pc)', 45, 58, 'fruits', 'images/banana.jpg', 'Fresh Yellow Bananas'),
('f03', 'Thai Guava (1 kg)', 37, 47, 'fruits', 'images/guava.jpg', 'Guavas FROM Thailand'),
('f04', 'Imported Blueberries (120 g)', 57, 184, 'fruits', 'images/blueberry.jpg', 'Think of it as blue balls'),
('f05', 'Semiripe Avacado (1 pc)', 66, 109, 'fruits', 'images/avacado.jpg', 'Crave an avacado?'),
('f06', 'Pineapple (Ananas) (1 pc)', 40, 52, 'fruits', 'images/pineapple.jpg', 'Ananas.....'),
('f07', 'Green Kiwi (3 pc)', 18, 85, 'fruits', 'images/kiwi.jpg', 'Is it a bird or a fruit?'),
('f08', 'Figs(Anjurada Hannu (250 g)', 32, 50, 'fruits', 'images/fig.jpg', 'Quality Figs'),
('f09', 'Kinnow Orange(Kithale) (500 g)', 52, 43, 'fruits', 'images/orange.jpg', 'Is it orange ?'),
('f10', 'Fresh Tender Coconut (1 pc)', 64, 113, 'fruits', 'images/coconut.jpg', 'Tender coconut water to quench your thirst'),
('f11', 'Pomegranate (500 g)', 74, 93, 'fruits', 'images/pomogrenate.jpg', 'Juicy red pomograntes'),
('f12', 'Green Pear(500 g)', 85, 67, 'fruits', 'images/pear.jpg', 'Ripe green pears'),
('f13', 'Pinky Strawberry(1 pack)', 42, 62, 'fruits', 'images/strawberry.jpg', 'A royal fruit for our royal customers'),
('f14', 'Green Grapes(Dhraakshi) (500 g)', 88, 53, 'fruits', 'images/grapes.jpg', 'The finest green grapes'),
('f15', 'Cherry Tomato (200 g)', 17, 20, 'fruits', 'images/tomato.jpg', 'Is it a fruit or a vegetable?'),
('fz01', 'Freeze dried fruits', 21, 150, 'Freeze dried', 'images/freeze.jpg', 'Short on space?'),
('g01', 'French Toast', 18, 45, 'Gourment foods', 'images/frenchtoast.jpg', 'A quick breakfast'),
('p01', 'Toor Dal-Supreme Harvest(1 kg)', 26, 145, 'pulses', 'images/toor_dal.jpg', 'The higher quality toor daal'),
('p02', 'Moong Dal-Supreme Harvest(1 kg)', 55, 146, 'pulses', 'images/moong_dal.jpg', 'A cosuin of toor-daal....?'),
('p03', 'Moong Chilka-Supreme Harvest(500 g)', 78, 74, 'pulses', 'images/moong_chilka.jpg', 'Quality Moong-Chilka'),
('p04', 'Urad Dal Split-Supreme Harvest(1 kg)', 90, 149, 'pulses', 'images/urad_dal_split.jpg', 'Regular split urad daal'),
('p05', 'Urad Dal Whole-Supreme Harvest(1 kg)', 68, 145, 'pulses', 'images/urad_dal_whole.jpg', 'The whole package'),
('pf01', 'kurkure', 21, 10, 'packed foods', 'images/kurkure.jpg', 'A midnight snack'),
('pf02', 'Lays', 34, 10, 'packed foods', 'images/lays.jpg', 'Can\'t have a party without lays'),
('re01', 'Jeera rice', 29, 60, 'Ready to eat', 'images/jeera.jpg', ' A ready to eat meal FROM mtr'),
('v01', 'Onion(1 kg)', 22, 31, 'vegetables', 'images/onion.jpg', 'Brings tears to your eyes'),
('v02', 'Potato(1 kg)', 6, 41, 'vegetables', 'images/potato.jpg', 'A versatile vegetable'),
('v03', 'Red Carrot(1 kg)', 27, 26, 'vegetables', 'images/carrot.jpg', 'Long, red carrots'),
('v04', 'Cauliflower (1 pc)', 32, 31, 'vegetables', 'images/cauliflower.jpg', 'A leafy vegetable indeed'),
('v05', 'Arugula(1 kg)', 120, 78, 'vegetables', 'images/arugula.jpg', 'A whole unit of Arugula'),
('v06', 'Lettuce(1 kg)', 120, 38, 'vegetables', 'images/lettuce.jpg', 'Let-us eat '),
('v07', 'Mustard greens(1 kg)', 209, 71, 'vegetables', 'images/mustard.jpg', 'Tiny beads'),
('v08', 'Bok choy(1 kg)', 27, 90, 'vegetables', 'images/bok_choy.jpg', 'A whole unit of Bok Choy'),
('v09', 'Horseradish(1 kg)', 40, 33, 'vegetables', 'images/raddish.jpg', 'Is it related to horses?'),
('v10', 'Sugar beet(1 kg)', 41, 21, 'vegetables', 'images/beetroot.jpg', 'Hefty red beetroots'),
('v11', 'Celeriac(1 kg)', 57, 13, 'vegetables', 'images/celeriac.jpg', 'All the celeriac you need'),
('v12', 'Daikon(1 kg)', 21, 17, 'vegetables', 'images/daikon.jpg', 'Heard of me?'),
('v13', 'Celery(1 kg)', 34, 62, 'vegetables', 'images/celery.jpg', 'That\'s a lot of celery'),
('v14', 'Turnip(1 kg)', 67, 67, 'vegetables', 'images/turnip.jpg', 'Will it spin like a top?'),
('v15', 'Kohlrabi(1 kg)', 32, 45, 'vegetables', 'images/kohlrabi.jpg', 'A big vegetable');

--
-- Triggers `store_inv`
--
DELIMITER $$
CREATE TRIGGER `update_cart_price_for_inventory_update` AFTER UPDATE ON `store_inv` FOR EACH ROW BEGIN
	IF (NEW.price <> OLD.price) THEN
		UPDATE cart SET cart.price = cart.quan * NEW.price WHERE NEW.PID = cart.PID;
	END IF;	
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UID` int(11) NOT NULL,
  `User_name` varchar(50) DEFAULT NULL,
  `phone_number` bigint(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `Addr_l1` varchar(10) DEFAULT NULL,
  `Addr_l2` varchar(30) DEFAULT NULL,
  `Addr_l3` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UID`, `User_name`, `phone_number`, `email`, `password`, `Addr_l1`, `Addr_l2`, `Addr_l3`) VALUES
(1, 'Database Administrator', 7245639203, 'dba@gmail.com', '$2y$10$XrU.cSV.IDVcfEcgmZeeDeRxiIpQcVaTQmfhfehnqz0eGvMekHwyi', 'HQ', 'HQ', 'HQ'),
(2, 'Adithya gj', 8334560923, 'adithyagj@gmail.com', '$2y$10$gzXI5i/xFTMRaY/EMul3x.34HBMo4h9ehUg9w13fPrAxQiAtaS22u', '4th cross', 'JP nagar ', 'Bangalore'),
(3, 'Chetna', 7556789223, 'chetna@gmail.com', '$2y$10$KIVMYYAmT8Q.WhHLU21Gl.RoCQf4DJ.CZ8c0Vf5TBbEhJjhX44HY6', '1th cross', 'Peenya ', 'Bangalore'),
(4, 'Amal', 9557642304, 'amal@gmail.com', '$2y$10$SUXgjDqXp6uNxMHRHUWhFuPoFaaZtje5RyukMYabVgi/z5L2ViR5u', '7th cross', 'Garuda nagar', 'Bangalore'),
(5, 'Gauri', 7942555621, 'gauri@gmail.com', '$2y$10$dVtrQ4nA1zPUlJ.WRzL2CeNNptECBGk1INDvnEfb1zYwEN9YswIaC', '5th cross', 'Marathahalli', 'Bangalore'),
(6, 'Deeksha', 7224556864, 'deeksha@gmail.com', '$2y$10$HWcIlCIFykwcRBCXPFAneu14qafUOb97ttlHQtHkpvFeOP1YtooYa', '6th main', 'NR colony', 'Bangalore'),
(7, 'Ilaa', 9337842345, 'ilaa@gmail.com', '$2y$10$YKoTeh9eU1MhCAhc//LSLOvbaF0USlo5RaxAT4VbXh/Uw5wSRuGqK', '7th main', 'padmanabhnagar', 'Bangalore');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD KEY `OID` (`OID`),
  ADD KEY `PID` (`PID`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD KEY `UID` (`UID`),
  ADD KEY `PID` (`PID`);

--
-- Indexes for table `delivery_personnel`
--
ALTER TABLE `delivery_personnel`
  ADD PRIMARY KEY (`DID`),
  ADD UNIQUE KEY `aadhaar` (`aadhaar`),
  ADD UNIQUE KEY `License_number` (`License_number`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OID`),
  ADD KEY `DID` (`DID`),
  ADD KEY `UID` (`UID`);

--
-- Indexes for table `store_inv`
--
ALTER TABLE `store_inv`
  ADD PRIMARY KEY (`PID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_ibfk_1` FOREIGN KEY (`OID`) REFERENCES `orders` (`OID`),
  ADD CONSTRAINT `bills_ibfk_2` FOREIGN KEY (`PID`) REFERENCES `store_inv` (`PID`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `users` (`UID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`PID`) REFERENCES `store_inv` (`PID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`DID`) REFERENCES `delivery_personnel` (`DID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`UID`) REFERENCES `users` (`UID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
