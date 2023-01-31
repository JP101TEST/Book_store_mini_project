-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2023 at 05:49 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `book_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id_author` char(10) NOT NULL,
  `authorFN` varchar(100) NOT NULL,
  `authorLN` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id_author`, `authorFN`, `authorLN`) VALUES
('A001', 'Danchun', 'Zhainan'),
('A002', 'Pingfan', 'Moshushi'),
('C001', 'สมขยัน', 'ขยัน'),
('C002', 'กอไก่', 'บินได้'),
('D001', 'ปลา', 'ตายาว');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id_isbn` char(20) NOT NULL,
  `id_typeB` varchar(100) NOT NULL,
  `bookN` varchar(200) NOT NULL,
  `imgeB` varchar(200) NOT NULL,
  `id_publisher` varchar(100) DEFAULT NULL,
  `id_author` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `amount` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id_isbn`, `id_typeB`, `bookN`, `imgeB`, `id_publisher`, `id_author`, `price`, `amount`) VALUES
('1232327893216', '000', 'Sense and Sensibility      ', 'G_01.jpg', 'G001', 'D001', 81, 7),
('1234567232116', '001', 'A Rose for Emily', 'anbprobuy.jpg', 'G002', 'C001', 99, 2),
('1234567893216', '000', 'Brave New World', 'tlp_hero_book-cover-adb8a02f82394b605711f8632a44488b-1627474998.jpg', 'G002', 'A001', 5, 12),
('1237865432198', '001', 'Pride and Prejudice', 'the-great-gatsby.jpg', 'T001', 'A002', 23, 6),
('3210987654321', '001', 'The Hobbit', 'C_03.jpg', 'G002', 'C001', 25, 4),
('3216549870321', '002', 'The Great Gatsby', 'tlp_hero_book-cover-adb8a02f82394b605711f8632a44488b-1627474998.jpg', 'P001', 'D001', 52, 12),
('4561237895213', '000', 'To Kill a Mockingbird', 'gardenwall.jpg', 'G002', 'A002', 45, 4),
('4567893210123', '002', 'To the Lighthouse', 'art.jpg', 'G002', 'C001', 69, 2),
('4567893210987', '001', '1984', 'C_04.jpg', 'G001', 'D001', 15, 5),
('6547193210987', '000', 'Heart of Darkness   ', 'Illustrationareeeefanart.jpg', 'E001', 'A001', 123, 21),
('6547334210987', '000', 'The Count of Monte Cristo', 'G_02.jpg', 'G002', 'C002', 65, 2),
('6547893210987', '002', 'Animal Farm', 'the-great-gatsby.jpg', 'E001', 'A002', 70, 2),
('6547893231987', '002', 'The Return of Sherlock Holmes', 'anbpro.jpg', 'G001', 'A001', 121, 6),
('6549873211234', '000', 'Harry Potter and the Philosophers Stone', 'G_04.jpg', 'P001', 'C002', 76, 3),
('7896543210987', '002', 'Lord of the Rings', 'N_02.jpg', 'G001', 'A002', 12, 5),
('7896543216542', '001', 'Wuthering Heights', 'anbprobuy.jpg', 'G001', 'C002', 51, 7),
('8234567893236', '000', 'Moby Dick', 'Dowcon.png', 'E001', 'C001', 151, 2),
('9234537893216', '001', 'The Invisible Man', 'C_04.jpg', 'T001', 'A001', 16, 5),
('9723746259002', '000', 'Moby-Dick 2', 'Illustrationareeeefanart.jpg', 'G002', 'C002', 67, 1),
('9789346259002', '000', 'The Yellow Wallpaper    ', 'G_03.jpg', 'E001', 'A001', 123, 5),
('9789746259002', '000', 'ทั่วไป เล่ม1', 'anbpro.jpg', 'P001', 'A001', 23, 233),
('9829543219876', '000', 'The Picture of Dorian Gray', 'book.jpg', 'E001', 'A002', 51, 4),
('9876123239876', '000', 'Beloved', 'the-great-gatsby.jpg', 'G001', 'A002', 62, 2),
('9876123789521', '000', 'One Hundred Years of Solitude', 'anbpro.jpg', 'T001', 'A002', 11, 6),
('9876543219876', '000', 'The Adventures of Tom Sawyer', 'book.jpg', 'P001', 'C001', 24, 3),
('9899543219876', '000', 'The Brothers Karamazov ', 'G_05.jpg', 'T001', 'A001', 51, 23);

-- --------------------------------------------------------

--
-- Table structure for table `publisher_name`
--

CREATE TABLE `publisher_name` (
  `id_publisher` char(10) NOT NULL,
  `publisherN` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `publisher_name`
--

INSERT INTO `publisher_name` (`id_publisher`, `publisherN`) VALUES
('P001', 'EA'),
('E001', 'Epic'),
('G001', 'Steam'),
('G002', 'Unity'),
('T001', 'Xbox');

-- --------------------------------------------------------

--
-- Table structure for table `type_book`
--

CREATE TABLE `type_book` (
  `id_typeB` char(10) NOT NULL,
  `typeN` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `type_book`
--

INSERT INTO `type_book` (`id_typeB`, `typeN`) VALUES
('001', 'การ์ตูน(Comic)'),
('000', 'ทั่วไป(General)'),
('002', 'นิยาย(Novel)');

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `Username` varchar(100) NOT NULL,
  `Userpassword` varchar(100) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `house_number` varchar(60) NOT NULL,
  `road` varchar(60) DEFAULT NULL,
  `sub_district` varchar(255) DEFAULT NULL,
  `district` varchar(255) NOT NULL,
  `provinces` varchar(255) NOT NULL,
  `postal_code` varchar(5) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`Username`, `Userpassword`, `first_name`, `last_name`, `house_number`, `road`, `sub_district`, `district`, `provinces`, `postal_code`, `email`) VALUES
('admin', '1234', 'ad', 'min', '12', NULL, NULL, 'เมือง', 'สุรินทร์', '32000', 'book.job2012@gmail.com'),
('dewdiw', 'dewdiw', 'สิรวิชญ์', 'เลิกตื่นสาย', '7/7', NULL, 'ทานตะวัน', 'ทานตะวัน', 'นครราชศ', '52345', 'dewdiw@gmail.com'),
('imonthx', 'imonthx', 'มณกานต์', 'มีดี', '8/8', NULL, 'เฟื้องฟ้า', 'เฟื้องฟ้า', 'สุพรรณบุรี', '11001', 'imonthx@gmail.com'),
('jopper', 'jopper', 'ชนกานต์', 'ขยันมาก', '9/9', NULL, 'กุหลาบ', 'กุหลาบ', 'สุรินทร์', '12345', 'jopper@gmail.com'),
('looktannaka', 'looktannaka', 'สุรินทร', 'นอนไม่ตื่น', '5/5', NULL, 'ทัพ\r\nหลวง', 'หนอง\r\nหญ้าไซ', 'สุพรรณ\r\nบุรี\r\n', '72240', 'looktanna\r\nka@gmail.\r\ncom'),
('user', '1234', 'u', 's', '12', NULL, NULL, 'เมือง', 'สุรินทร์', '32000', 'jobbook2012@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id_author`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id_isbn`),
  ADD UNIQUE KEY `bookN` (`bookN`),
  ADD KEY `id_typeB` (`id_typeB`),
  ADD KEY `id_publisher` (`id_publisher`),
  ADD KEY `id_author` (`id_author`);

--
-- Indexes for table `publisher_name`
--
ALTER TABLE `publisher_name`
  ADD PRIMARY KEY (`id_publisher`),
  ADD UNIQUE KEY `publisherN` (`publisherN`);

--
-- Indexes for table `type_book`
--
ALTER TABLE `type_book`
  ADD PRIMARY KEY (`id_typeB`),
  ADD UNIQUE KEY `typeN` (`typeN`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`Username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`id_typeB`) REFERENCES `type_book` (`id_typeB`),
  ADD CONSTRAINT `book_ibfk_2` FOREIGN KEY (`id_publisher`) REFERENCES `publisher_name` (`id_publisher`),
  ADD CONSTRAINT `book_ibfk_3` FOREIGN KEY (`id_author`) REFERENCES `author` (`id_author`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
