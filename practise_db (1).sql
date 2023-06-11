-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2023 at 06:26 PM
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
-- Database: `practise_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `city_table`
--

CREATE TABLE `city_table` (
  `CID` int(11) NOT NULL,
  `city` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `city_table`
--

INSERT INTO `city_table` (`CID`, `city`) VALUES
(1, 'Agra'),
(2, 'Bhupal'),
(3, 'Delhi'),
(4, 'Noida');

-- --------------------------------------------------------

--
-- Table structure for table `employeeposition`
--

CREATE TABLE `employeeposition` (
  `EmpID` int(11) NOT NULL,
  `E_ID` int(11) DEFAULT NULL,
  `Position` varchar(100) DEFAULT NULL,
  `DateOfJoining` date NOT NULL,
  `Salary` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employeeposition`
--

INSERT INTO `employeeposition` (`EmpID`, `E_ID`, `Position`, `DateOfJoining`, `Salary`) VALUES
(1, 1, 'Manager', '2022-01-05', 500000),
(2, 2, 'Executive', '2022-02-05', 75000),
(3, 3, 'Manager', '2022-01-05', 90000),
(4, 2, 'Lead', '2022-02-05', 85000),
(5, 1, 'Executive', '2022-01-05', 300000);

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `ID` int(11) UNSIGNED NOT NULL,
  `stud_id` int(11) NOT NULL,
  `chemistry` int(11) NOT NULL,
  `biology` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`ID`, `stud_id`, `chemistry`, `biology`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 92, 75, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `ID` int(11) NOT NULL,
  `firstname` varchar(150) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `address` varchar(150) DEFAULT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `price` decimal(6,2) DEFAULT NULL,
  `country` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`ID`, `firstname`, `lastname`, `address`, `mobile`, `price`, `country`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Soumen', 'Das', '12 C', '2147483647', '50.00', 'Germany', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Mita', 'Das', '15 PC Road', '8945124152', '160.85', 'Germany', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Gita', 'Roy', '36 UN Road', '7945124152', '210.00', 'China', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Sanhita', 'Dikshit', '25 KC Road', '9451241522', '10.12', 'India', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Arpan', 'Dey', '90 PC Road', '5545124152', '45.85', 'Pakistan', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'Subhendu', 'Sen', '89 PC Road', '7745124152', '117.85', 'Pakistan', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `student_table`
--

CREATE TABLE `student_table` (
  `ID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `Age` int(11) NOT NULL,
  `City` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_table`
--

INSERT INTO `student_table` (`ID`, `name`, `Age`, `City`) VALUES
(1, 'Ram Kumar', 19, '27'),
(2, 'Salman Khan', 18, '6'),
(3, 'Meera Khan', 19, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(100) NOT NULL,
  `updated_at` date DEFAULT current_timestamp(),
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `cat_name`, `updated_at`, `deleted_at`) VALUES
(4, 'Blog', NULL, NULL),
(5, 'Cats', NULL, NULL),
(47, 'Javascript', '2023-05-31', NULL),
(48, 'Jquery', '2023-06-03', NULL),
(49, 'Framework', '2023-06-08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comments`
--

CREATE TABLE `tbl_comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_content` longtext DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_comments`
--

INSERT INTO `tbl_comments` (`id`, `post_id`, `user_id`, `comment_content`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 0, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '2023-06-10 20:05:20', NULL, NULL),
(2, 1, 0, '<p>Myyyyy</p>', '2023-06-10 20:08:09', NULL, NULL),
(3, 1, 0, '<p>Jhhhhhhh</p>', '2023-06-10 20:18:51', NULL, NULL),
(4, 2, 0, '<p><span style=\"color: rgb(16, 28, 84); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 16px; letter-spacing: 0.4px;\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</span><br></p>', '2023-06-10 21:33:04', NULL, NULL),
(5, 2, 0, '<p>Is this good</p>', '2023-06-11 21:50:51', NULL, NULL),
(6, 1, 3, '<p>Good</p>', '2023-06-11 21:55:57', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employeeinfo`
--

CREATE TABLE `tbl_employeeinfo` (
  `EMPID` int(11) NOT NULL,
  `EmpFname` varchar(100) NOT NULL,
  `EmpLname` varchar(100) NOT NULL,
  `Department` varchar(100) NOT NULL,
  `Project` varchar(100) NOT NULL,
  `Address` text NOT NULL,
  `DOB` date NOT NULL,
  `GENDER` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_employeeinfo`
--

INSERT INTO `tbl_employeeinfo` (`EMPID`, `EmpFname`, `EmpLname`, `Department`, `Project`, `Address`, `DOB`, `GENDER`) VALUES
(1, 'Ankit', 'Kapoor', 'Admin', 'P2', 'DEL', '1994-03-07', 'M'),
(2, 'Sanjay', 'Mehra', 'HR', 'P1', 'HYD', '1996-01-12', 'M'),
(3, 'Ananya', 'Mishra', 'Admin', 'P2', 'DEL', '1968-02-05', 'F'),
(4, 'Rohan', 'Diwan', 'Account', 'P3', 'BOM', '1980-01-01', 'M'),
(5, 'Sonia', 'Kulkarni', 'HR', 'P1', 'HYD', '1992-02-05', 'F');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_posts`
--

CREATE TABLE `tbl_posts` (
  `id` int(11) NOT NULL,
  `post_cat_id` int(11) DEFAULT NULL,
  `post_title` varchar(100) DEFAULT NULL,
  `post_author` varchar(100) DEFAULT NULL,
  `post_user` varchar(100) DEFAULT NULL,
  `post_date` varchar(100) DEFAULT NULL,
  `post_image` varchar(100) DEFAULT NULL,
  `post_content` longtext DEFAULT NULL,
  `post_tag` varchar(100) DEFAULT NULL,
  `post_comment_count` varchar(100) DEFAULT NULL,
  `post_status` varchar(100) DEFAULT NULL,
  `post_view_count` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_posts`
--

INSERT INTO `tbl_posts` (`id`, `post_cat_id`, `post_title`, `post_author`, `post_user`, `post_date`, `post_image`, `post_content`, `post_tag`, `post_comment_count`, `post_status`, `post_view_count`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, 'Blog 1', 'Dyan Sheikh', '1', '2023-06-10', '64846a8eadbe2.jpg', 'Here are many variations of passages of <b>Lorem Ipsum available</b>, but the <font color=\"#ff0000\">majority have suffered alteration in some form</font>, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 'aa', '0', 'aa', '0', '2023-06-03 15:30:25', '2023-06-11 11:15:06', NULL),
(2, 5, 'Blog 2', 'Kelvin Clein', '2', '2023-06-10', '64846a996f4a0.jpg', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 'aa', '0', 'aa', '0', '2023-06-07 00:00:00', '2023-06-11 11:32:42', NULL),
(3, 5, 'Blog 3', 'Matt Heardy', '3', '2023-06-10', '64846aa4c9ded.jpg', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 'aa', '0', 'aa', '0', '1900-01-02 00:00:00', '2023-06-11 11:30:40', NULL),
(11, 5, 'Blog 42', 'Brett Watt', '3', '2023-06-10', '64846afa4f8bf.jpg', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 'Test, Post', '0', 'Draft', '0', '1900-01-04 00:00:00', '2023-06-11 11:30:31', NULL),
(12, 49, 'Blog 5', 'John Diwin', '1', '2023-06-11', '6485d75172ec2.jpg', '<p>Lorem ipsum</p>', 'ds', '0', 'draft', '0', '2023-06-10 19:09:21', '2023-06-11 14:16:49', NULL),
(13, 48, 'Blog 6', 'Brett Watts', '1', '2023-06-11', '6485d76ff0129.jpg', '<p>UUUU</p>', 'ds', '0', 'draft', '0', '2023-06-10 19:11:10', '2023-06-11 14:17:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_register`
--

CREATE TABLE `tbl_register` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `cpassword` varchar(100) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_register`
--

INSERT INTO `tbl_register` (`id`, `username`, `password`, `cpassword`, `deleted_at`) VALUES
(2, 'test', 'Soumen@12', 'Soumen@12', '2023-05-14 06:56:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_firstname` varchar(100) NOT NULL,
  `user_lastname` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_role` varchar(100) NOT NULL,
  `user_image` varchar(100) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updateed_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `username`, `password`, `user_firstname`, `user_lastname`, `user_email`, `user_role`, `user_image`, `status`, `created_at`, `updateed_at`, `deleted_at`) VALUES
(1, 'somu1234', 'Soumen@123456677', 'Soumen', 'Das', 'soumen13@gmail.com', 'admin', '6481e60ce903d.jpg', '1', '2023-06-08 21:05:25', '2023-06-08 21:05:25', NULL),
(2, 'dan12345', 'Daniel@123456789', 'Daniel', 'Creg', 'd124@gmail.com', 'admin', '6481e62608392.jpg', '1', '2023-06-08 21:05:28', '2023-06-08 21:05:28', NULL),
(3, 'somu123456', 'Soumen@456137899', 'Josh', 'dyne', 'josh@gmail.com', 'user', '6481e62f14fe7.jpg', '1', '2023-06-08 21:05:30', '2023-06-08 21:05:30', NULL),
(4, 'tim123456', 'Tim|@123456789', 'Tim', 'John', 'tim42@gmail.com', 'user', '6485db80aeb32.jpg', '1', '2023-06-11 20:07:56', '2023-06-11 20:07:56', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `city_table`
--
ALTER TABLE `city_table`
  ADD PRIMARY KEY (`CID`);

--
-- Indexes for table `employeeposition`
--
ALTER TABLE `employeeposition`
  ADD PRIMARY KEY (`EmpID`),
  ADD KEY `E_ID` (`E_ID`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `stud_id` (`stud_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `idx_pname` (`lastname`,`firstname`);

--
-- Indexes for table `student_table`
--
ALTER TABLE `student_table`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_employeeinfo`
--
ALTER TABLE `tbl_employeeinfo`
  ADD PRIMARY KEY (`EMPID`);

--
-- Indexes for table `tbl_posts`
--
ALTER TABLE `tbl_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_PersonOrder` (`post_cat_id`);

--
-- Indexes for table `tbl_register`
--
ALTER TABLE `tbl_register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `city_table`
--
ALTER TABLE `city_table`
  MODIFY `CID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employeeposition`
--
ALTER TABLE `employeeposition`
  MODIFY `EmpID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student_table`
--
ALTER TABLE `student_table`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_employeeinfo`
--
ALTER TABLE `tbl_employeeinfo`
  MODIFY `EMPID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_posts`
--
ALTER TABLE `tbl_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_register`
--
ALTER TABLE `tbl_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employeeposition`
--
ALTER TABLE `employeeposition`
  ADD CONSTRAINT `employeeposition_ibfk_1` FOREIGN KEY (`E_ID`) REFERENCES `tbl_employeeinfo` (`EMPID`),
  ADD CONSTRAINT `employeeposition_ibfk_2` FOREIGN KEY (`E_ID`) REFERENCES `tbl_employeeinfo` (`EMPID`);

--
-- Constraints for table `marks`
--
ALTER TABLE `marks`
  ADD CONSTRAINT `marks_ibfk_1` FOREIGN KEY (`stud_id`) REFERENCES `student` (`ID`);

--
-- Constraints for table `tbl_posts`
--
ALTER TABLE `tbl_posts`
  ADD CONSTRAINT `FK_PersonOrder` FOREIGN KEY (`post_cat_id`) REFERENCES `tbl_category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
