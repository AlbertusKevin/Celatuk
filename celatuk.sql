-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2020 at 06:20 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `celatuk`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmarked`
--

CREATE TABLE `bookmarked` (
  `idPost` bigint(20) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookmarked`
--

INSERT INTO `bookmarked` (`idPost`, `username`) VALUES
(1, 'mikazuki'),
(1, 'vin_albertus'),
(3, 'mikazuki');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` bigint(20) NOT NULL,
  `idPost` bigint(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `idPost`, `username`, `comment`, `time`) VALUES
(1, 3, 'vin_albertus', 'test comment pertama', '0000-00-00 00:00:00'),
(4, 3, 'vernaprilia', 'test comment dari user yang berbeda', '2020-07-16 11:49:49'),
(5, 3, 'vin_albertus', 'test', '2020-07-16 14:40:58'),
(10, 3, 'mikazuki', 'test comment edit', '2020-08-02 09:47:47');

-- --------------------------------------------------------

--
-- Table structure for table `friend_list`
--

CREATE TABLE `friend_list` (
  `username` varchar(50) NOT NULL,
  `friendUserName` varchar(50) NOT NULL,
  `isBlocked` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friend_list`
--

INSERT INTO `friend_list` (`username`, `friendUserName`, `isBlocked`, `status`) VALUES
('mikazuki', 'vernaprilia', 0, 0),
('mikazuki', 'vin_albertus', 0, 0),
('vin_albertus', 'hizkia', 0, 1),
('vin_albertus', 'holmes', 0, 1),
('vin_albertus', 'michele', 0, 0),
('vin_albertus', 'vernaprilia', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `groupName` varchar(50) NOT NULL,
  `founder` varchar(60) NOT NULL,
  `dateCreated` varchar(50) NOT NULL,
  `about` text DEFAULT NULL,
  `visibility` tinyint(1) DEFAULT NULL,
  `picture` varchar(50) DEFAULT NULL,
  `bgPicture` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`groupName`, `founder`, `dateCreated`, `about`, `visibility`, `picture`, `bgPicture`) VALUES
('IndoMystery', 'holmes', 'Wednesday, 24 June 2020', 'Come if convenience, if not, come anyway', 1, '5ef31a9c47994.jpg', '5ef31a9c49cbc.jpg'),
('JavaScript', 'vin_albertus', 'Saturday, 27 June 2020', 'Learning about Java Script and frameworks', 3, '5ef74a529e369.jpg', '5ef74a52a0a7a.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `group_member`
--

CREATE TABLE `group_member` (
  `username` varchar(50) NOT NULL,
  `groupName` varchar(50) NOT NULL,
  `joinedDate` varchar(50) NOT NULL,
  `role` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_member`
--

INSERT INTO `group_member` (`username`, `groupName`, `joinedDate`, `role`, `status`) VALUES
('holmes', 'IndoMystery', 'Wednesday, 24 June 2020', 'admin', 1),
('vernaprilia', 'JavaScript', 'Sunday, 12 July 2020', 'admin', 1),
('vin_albertus', 'JavaScript', 'Saturday, 27 June 2020', 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `likepost`
--

CREATE TABLE `likepost` (
  `id` bigint(20) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likepost`
--

INSERT INTO `likepost` (`id`, `username`) VALUES
(1, 'mikazuki'),
(1, 'vernaprilia'),
(1, 'vin_albertus'),
(2, 'vernaprilia'),
(2, 'vin_albertus'),
(3, 'vin_albertus'),
(15, 'mikazuki');

-- --------------------------------------------------------

--
-- Table structure for table `messenger`
--

CREATE TABLE `messenger` (
  `id` bigint(20) NOT NULL,
  `fromUser` varchar(50) NOT NULL,
  `toUser` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `status` int(1) NOT NULL,
  `deleted` varchar(50) DEFAULT NULL,
  `message` text NOT NULL,
  `addContent` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messenger`
--

INSERT INTO `messenger` (`id`, `fromUser`, `toUser`, `date`, `status`, `deleted`, `message`, `addContent`) VALUES
(14, 'vin_albertus', 'vernaprilia', 'Sunday, 5 Jul 2020', 1, 'vin_albertus', 'test obejk ke 1', 'Array'),
(15, 'vin_albertus', 'vernaprilia', 'Sunday, 5 Jul 2020', 1, 'vin_albertus', 'hapus chat soft delete dan delete', 'Array'),
(16, 'vin_albertus', 'vernaprilia', 'Sunday, 5 Jul 2020', 1, 'vin_albertus', 'dan menampilkan chat tergantung status delete', 'Array'),
(17, 'vernaprilia', 'vin_albertus', 'Sunday, 5 Jul 2020', 1, 'vin_albertus', 'all clear', 'Array'),
(18, 'vernaprilia', 'vin_albertus', 'Sunday, 5 Jul 2020', 1, 'vin_albertus', 'subjek 1, fix delete done', 'Array'),
(19, 'vernaprilia', 'vin_albertus', 'Sunday, 5 Jul 2020', 1, 'vin_albertus', 'subjek 2, fix menampilkan chat user to user done', 'Array'),
(20, 'vernaprilia', 'vin_albertus', 'Sunday, 5 Jul 2020', 1, 'vin_albertus', 'subjek 3, uji coba dan perbaikan menampilkan list contact dengan keadaan status tertentu', 'Array'),
(21, 'vin_albertus', 'vernaprilia', 'Sunday, 5 Jul 2020', 1, 'vin_albertus', 'get it done, moving on', 'Array'),
(22, 'vernaprilia', 'vin_albertus', 'Sunday, 5 Jul 2020', 1, '', 'contact list chat clear, subjek 3 done', 'Array'),
(23, 'vin_albertus', 'vernaprilia', 'Sunday, 5 Jul 2020', 1, '', 'moving to the next test', 'Array'),
(24, 'vin_albertus', 'vernaprilia', 'Sunday, 5 Jul 2020', 1, '', 'list chat by id', 'Array'),
(25, 'vin_albertus', 'vernaprilia', 'Sunday, 5 Jul 2020', 1, '', 'checking it now', 'Array'),
(26, 'vin_albertus', 'holmes', 'Sunday, 5 Jul 2020', 1, '', 'test, chat list by id', 'Array'),
(27, 'vin_albertus', 'vernaprilia', 'Sunday, 5 Jul 2020', 1, '', 'checking it now', 'Array'),
(28, 'vin_albertus', 'holmes', 'Sunday, 5 Jul 2020', 1, '', 'done', 'Array'),
(29, 'vin_albertus', 'vernaprilia', 'Sunday, 5 Jul 2020', 1, '', 'the newest chat clear', 'Array'),
(30, 'vin_albertus', 'vernaprilia', 'Sunday, 5 Jul 2020', 1, '', 'subjek 4, try to change status message', 'Array'),
(31, 'vernaprilia', 'vin_albertus', 'Sunday, 5 Jul 2020', 1, '', 'trying it now', 'Array'),
(32, 'vin_albertus', 'vernaprilia', 'Sunday, 5 Jul 2020', 1, '', 'cek status read', 'Array'),
(33, 'vin_albertus', 'vernaprilia', 'Sunday, 5 Jul 2020', 1, '', 'typing', 'Array'),
(34, 'vin_albertus', 'vernaprilia', 'Sunday, 5 Jul 2020', 1, '', '3 status must be zero between vi and ve', 'Array'),
(35, 'vin_albertus', 'vernaprilia', 'Sunday, 5 Jul 2020', 1, '', 'project status and notification pending', 'Array'),
(36, 'vin_albertus', 'vernaprilia', 'Sunday, 5 Jul 2020', 1, '', 'moving to search', 'Array');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` bigint(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `privacy` tinyint(1) NOT NULL,
  `createdDate` varchar(25) NOT NULL,
  `updatedDate` varchar(25) NOT NULL,
  `likeCount` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `username`, `content`, `image`, `privacy`, `createdDate`, `updatedDate`, `likeCount`) VALUES
(1, 'vernaprilia', 'Test post pertama di sosmed baru ini. Test post dengan gambar.', '5f06ea51aeaf9.jpg', 1, 'Thursday, 9 July 2020', 'Thursday, 9 July 2020', 3),
(2, 'vin_albertus', 'Test post dengan text saja tanpa gambar. Edit berhasil!', ' ', 2, 'Thursday, 9 July 2020', 'Saturday, 11 July 2020', 2),
(3, 'vin_albertus', 'Coba post lagi dengan tambahan visibility. Text diedit, tambah gambar, ubah privacy ', '5f09be3ab9b29.jpg', 1, 'Thursday, 9 July 2020', 'Saturday, 11 July 2020', 1),
(5, 'vin_albertus', 'What\'s do you want to post?', ' ', 0, 'Saturday, 11 July 2020', 'Saturday, 11 July 2020', 0),
(6, 'vin_albertus', 'What\'s do you want to post?', ' ', 0, 'Saturday, 11 July 2020', 'Saturday, 11 July 2020', 0),
(7, 'vin_albertus', 'What\'s do you want to post?', ' ', 0, 'Saturday, 11 July 2020', 'Saturday, 11 July 2020', 0),
(8, 'vin_albertus', 'What\'s do you want to post?', ' ', 0, 'Saturday, 11 July 2020', 'Saturday, 11 July 2020', 0),
(15, 'vin_albertus', 'What do you want to post?', ' ', 1, 'Saturday, 1 August 2020', 'Saturday, 1 August 2020', 1),
(17, 'vernaprilia', 'Ini visibility friend', ' ', 2, 'Sunday, 2 August 2020', 'Sunday, 2 August 2020', 0);

-- --------------------------------------------------------

--
-- Table structure for table `post_in_group`
--

CREATE TABLE `post_in_group` (
  `id` bigint(20) NOT NULL,
  `groupName` varchar(50) NOT NULL,
  `statusPost` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(50) NOT NULL,
  `name` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `picture` varchar(50) DEFAULT NULL,
  `bgPicture` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `name`, `password`, `email`, `phone`, `picture`, `bgPicture`) VALUES
('hizkia', 'Hizkia Andrew', '$2y$10$92QHYDHiaub3Tj9Y4Q2oE..2Ze9EUsD3yrlWXz9isor4wUraNC2pG', 'hizkia@gmail.com', '7799766234', '5f002d1bdeff8.jpg', '5f002d1be0f38.jpg'),
('holmes', 'Sherlock Holmes', '$2y$10$Uq7vK219NqfXe85nUSx.FuFzhQKS/wuNSstUicTgZXPYWBLoF40B2', 'sherlock@gmail.com', '99820000192', '5ef319f426003.jpg', '5ef319f427773.jpg'),
('michele', 'Michele Natasha', '$2y$10$phVPZ7FhELIWUo8q/Wsk/emD5X.oFW/TSXDJvizMdj10/WhuVxAT2', 'michele@gmail.com', '8863863234', '5f002c6e8cfce.jpg', '5f002c6e8ef0e.jpg'),
('mikazuki', 'Mikazuki Augus', '$2y$10$zUulc6baJhZDyxk/QYG4c.qh7PHw47fHWISMakoIN0a/5imnx6pYG', 'mikazuki@gmail.co.id', '10091209983', '5f267e2589180.jpg', '5f267e258acd8.jpg'),
('mikha', 'Mikhael Adriel', '$2y$10$t2V9ck6RQ71mt6d1lCCf.uTa3cJX4rtKwf4rgKpYKiLtSBYFP9gOq', 'mikhael@gmail.com', '12398889902', '5f002a170a4d2.jpg', '5f002a170c7fb.jpg'),
('vernaprilia', 'Vern Aprilia Rousalen', '$2y$10$9qDidUbh2AC6tSBpkeVUCuXl1jey1wq96k/L8nlLSx50QMOHsMHVS', 'vern@gmail.com', '089612340987', '5ef319b05005b.jpg', '5ef319b0513e4.jpg'),
('vin_albertus', 'Albertus Kevin', '$2y$10$CnHAnpMtot1YE7pWtgVfAe1J0SN3jWGs2QRViiSqKXfEKImkT3P82', 'vinalbertus@gmail.com', '087897821122', '5ef31976243dc.jpg', '5ef3197628645.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_setting`
--

CREATE TABLE `user_setting` (
  `username` varchar(50) NOT NULL,
  `darkmode` tinyint(1) NOT NULL,
  `cookie` tinyint(1) NOT NULL,
  `statusOnline` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_setting`
--

INSERT INTO `user_setting` (`username`, `darkmode`, `cookie`, `statusOnline`) VALUES
('hizkia', 0, 0, 0),
('holmes', 0, 0, 0),
('michele', 0, 0, 0),
('mikazuki', 0, 0, 0),
('mikha', 0, 0, 0),
('vernaprilia', 1, 0, 0),
('vin_albertus', 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookmarked`
--
ALTER TABLE `bookmarked`
  ADD PRIMARY KEY (`idPost`,`username`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idPost` (`idPost`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `friend_list`
--
ALTER TABLE `friend_list`
  ADD PRIMARY KEY (`username`,`friendUserName`),
  ADD KEY `friendUserName` (`friendUserName`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`groupName`);

--
-- Indexes for table `group_member`
--
ALTER TABLE `group_member`
  ADD PRIMARY KEY (`username`,`groupName`),
  ADD KEY `groupName` (`groupName`);

--
-- Indexes for table `likepost`
--
ALTER TABLE `likepost`
  ADD PRIMARY KEY (`id`,`username`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `messenger`
--
ALTER TABLE `messenger`
  ADD PRIMARY KEY (`id`,`fromUser`,`toUser`) USING BTREE,
  ADD KEY `fromUser` (`fromUser`),
  ADD KEY `toUser` (`toUser`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `post_in_group`
--
ALTER TABLE `post_in_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groupName` (`groupName`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `user_setting`
--
ALTER TABLE `user_setting`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `messenger`
--
ALTER TABLE `messenger`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookmarked`
--
ALTER TABLE `bookmarked`
  ADD CONSTRAINT `bookmarked_ibfk_1` FOREIGN KEY (`idPost`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `bookmarked_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user` (`username`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`idPost`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user` (`username`);

--
-- Constraints for table `friend_list`
--
ALTER TABLE `friend_list`
  ADD CONSTRAINT `friend_list_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `friend_list_ibfk_2` FOREIGN KEY (`friendUserName`) REFERENCES `user` (`username`);

--
-- Constraints for table `group_member`
--
ALTER TABLE `group_member`
  ADD CONSTRAINT `group_member_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `group_member_ibfk_2` FOREIGN KEY (`groupName`) REFERENCES `groups` (`groupName`);

--
-- Constraints for table `likepost`
--
ALTER TABLE `likepost`
  ADD CONSTRAINT `likepost_ibfk_1` FOREIGN KEY (`id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `likepost_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user` (`username`);

--
-- Constraints for table `messenger`
--
ALTER TABLE `messenger`
  ADD CONSTRAINT `messenger_ibfk_1` FOREIGN KEY (`fromUser`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `messenger_ibfk_2` FOREIGN KEY (`toUser`) REFERENCES `user` (`username`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`);

--
-- Constraints for table `post_in_group`
--
ALTER TABLE `post_in_group`
  ADD CONSTRAINT `post_in_group_ibfk_1` FOREIGN KEY (`id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `post_in_group_ibfk_2` FOREIGN KEY (`groupName`) REFERENCES `groups` (`groupName`);

--
-- Constraints for table `user_setting`
--
ALTER TABLE `user_setting`
  ADD CONSTRAINT `user_setting_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
