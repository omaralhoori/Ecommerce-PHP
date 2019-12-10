-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2019 at 05:05 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` smallint(6) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `icon` varchar(255) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `icon`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(1, 'PC', '', '<i class=\"fas fa-desktop\"></i>', 2, 0, 0, 0),
(4, 'Electroincs', 'elctronic stuffs', '<i class=\"fas fa-bolt\"></i>', 0, 1, 1, 1),
(7, 'PS3 Games', 'PlayStation 3 Games', '', 3, 0, 0, 0),
(8, 'Mobile Phones', 'New Mobile Devices', '', 4, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `C_ID` int(11) NOT NULL,
  `comment` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `rate` int(11) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL,
  `comment_date` date NOT NULL,
  `item_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`C_ID`, `comment`, `title`, `rate`, `likes`, `status`, `comment_date`, `item_ID`, `user_ID`) VALUES
(17, 'cok guzel oyun ,teskkurler', 'guzel oyun', 4, 0, 0, '2019-04-26', 11, 36),
(18, 'fena degil ,sag ol', 'fena degil ', 2, 0, 0, '2019-04-26', 11, 36),
(19, 'very good device ,but has disadvantges', 'good device', 4, 0, 0, '2019-04-26', 14, 1),
(20, 'not bad', 'not bad', 3, 0, 0, '2019-04-26', 14, 1),
(21, 'bad item', 'bad item', 1, 0, 0, '2019-04-26', 42, 1);

-- --------------------------------------------------------

--
-- Table structure for table `imgs_item`
--

CREATE TABLE `imgs_item` (
  `imgID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `imgName` varchar(255) NOT NULL,
  `uploadDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `imgs_item`
--

INSERT INTO `imgs_item` (`imgID`, `itemID`, `imgName`, `uploadDate`) VALUES
(12, 40, '46575985_pen1.jpg', '2019-03-18'),
(13, 40, '324046133_pen2.jpg', '2019-03-18'),
(14, 40, '161938685_pen3.jpg', '2019-03-18'),
(15, 11, '449721928_fifa.jpg', '2019-03-19'),
(16, 12, '654939194_card-world-of-warcraft-54576e6364584e35.jpg', '2019-03-19'),
(17, 13, 'xiaom.jpg', '2019-03-19'),
(18, 13, 'xiaom2.jpg', '2019-03-19'),
(19, 13, 'xiaom3.jpg', '2019-03-19'),
(20, 13, 'xiaom4.jpg', '2019-03-19'),
(21, 13, 'xiaom5.jpg', '2019-03-19'),
(22, 14, 'iphn.jpg', '2019-03-19'),
(23, 14, 'iphn2.png', '2019-03-19'),
(24, 41, '491302304_1080gtx.jpg', '2019-03-19'),
(25, 41, '746235743_nvidia.jpg', '2019-03-19'),
(26, 42, '398603104_ram.jpg', '2019-03-19'),
(27, 42, '711279523_ram2.jpg', '2019-03-19'),
(28, 42, '820903343_ram3.jpg', '2019-03-19');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `discount` tinyint(4) DEFAULT NULL,
  `Status` varchar(255) NOT NULL,
  `1_Star` int(11) NOT NULL DEFAULT '0',
  `2_Star` int(11) NOT NULL DEFAULT '0',
  `3_Star` int(11) NOT NULL DEFAULT '0',
  `4_Star` int(11) NOT NULL DEFAULT '0',
  `5_Star` int(11) NOT NULL DEFAULT '0',
  `Rating` decimal(5,1) NOT NULL DEFAULT '0.0',
  `Approve` tinyint(4) NOT NULL DEFAULT '0',
  `Cat_ID` smallint(11) NOT NULL,
  `Member_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Image`, `discount`, `Status`, `1_Star`, `2_Star`, `3_Star`, `4_Star`, `5_Star`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`) VALUES
(11, 'Fifa 2006', 'PC game', '30$', '2019-03-05', 'USA', '449721928_fifa.jpg', 1, '2', 0, 1, 0, 1, 0, '3.0', 1, 1, 1),
(12, 'War Craft 3', 'ps3 games', '30$', '2019-03-05', 'USA', '654939194_card-world-of-warcraft-54576e6364584e35.jpg', 0, '2', 0, 0, 0, 0, 0, '0.0', 1, 7, 16),
(13, 'Xiaomi mi a1', 'one android device', '300', '2019-03-09', 'China', '', 10, '1', 0, 0, 0, 0, 0, '0.0', 1, 8, 1),
(14, 'iphone 6', 'ios phone', '400', '2019-03-09', 'USA', '', 20, '2', 0, 0, 1, 1, 0, '3.5', 1, 8, 18),
(40, 'pen', 'very good pen', '12', '2019-03-18', 'USA', '', 10, '2', 0, 0, 0, 0, 0, '0.0', 1, 4, 16),
(41, 'GTX 1080 niv', 'vrey powerful graphic card for pc', '200', '2019-03-19', 'usa', '', 10, '1', 0, 0, 0, 0, 0, '0.0', 1, 1, 16),
(42, 'DDR4 Ram', '16gb ram colorful', '100', '2019-03-19', 'china', '', 10, '1', 1, 0, 0, 0, 0, '1.0', 1, 1, 17);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Fullname` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT 'default_avatar.png',
  `GroupID` int(11) NOT NULL DEFAULT '0',
  `TrustStatus` int(11) NOT NULL DEFAULT '0',
  `RegStatus` int(11) NOT NULL DEFAULT '0',
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `Fullname`, `avatar`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`) VALUES
(1, 'omar', '8cb2237d0679ca88db6464eac60da96345513964', 'omaralhori@ktu.edu.tr', 'Omar', 'default_avatar.png', 1, 0, 1, '0000-00-00'),
(16, 'ammar', '2fabf9df9731040cf94f27a3ecf6eaa9f829168d', 'amma@gmai', 'ammmar', 'default_avatar.png', 0, 0, 1, '2019-02-26'),
(17, 'amma', '2fabf9df9731040cf94f27a3ecf6eaa9f829168d', 'amma@gmai', 'ammmar', 'default_avatar.png', 0, 0, 1, '2019-03-02'),
(18, 'ahmad', 'a53a33601b8dd9d06ae9e50f1f30fbe957aba866', 'ahmad@gmail', 'ahmad', 'default_avatar.png', 0, 0, 1, '2019-03-02'),
(20, '', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'amma@gmail.com', '', 'default_avatar.png', 0, 0, 0, '0000-00-00'),
(26, '', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'omar@gmail.com', '', 'default_avatar.png', 0, 0, 0, '2019-03-14'),
(29, '', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'omar@alhoir', '', 'default_avatar.png', 0, 0, 0, '2019-04-20'),
(36, '', '6caffb999b49281110d5f686ea3b8dd741c24439', '1sa@dsa', '', 'default_avatar.png', 0, 0, 1, '2019-04-23'),
(37, '', '9f840f638ebd8c4f600ef26724a959dad34ba527', 'asd@ew', '', 'default_avatar.png', 0, 0, 1, '2019-04-23'),
(38, '', '6caffb999b49281110d5f686ea3b8dd741c24439', 'osd@om', '', 'default_avatar.png', 0, 0, 1, '2019-04-26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`C_ID`),
  ADD KEY `item_comment` (`item_ID`),
  ADD KEY `user_comment` (`user_ID`);

--
-- Indexes for table `imgs_item`
--
ALTER TABLE `imgs_item`
  ADD PRIMARY KEY (`imgID`),
  ADD KEY `item_id_fk` (`itemID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_ID`),
  ADD UNIQUE KEY `Name` (`Name`),
  ADD KEY `member_1` (`Member_ID`),
  ADD KEY `cat_1` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `imgs_item`
--
ALTER TABLE `imgs_item`
  MODIFY `imgID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `item_comment` FOREIGN KEY (`item_ID`) REFERENCES `items` (`item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_comment` FOREIGN KEY (`user_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `imgs_item`
--
ALTER TABLE `imgs_item`
  ADD CONSTRAINT `item_id_fk` FOREIGN KEY (`itemID`) REFERENCES `items` (`item_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
