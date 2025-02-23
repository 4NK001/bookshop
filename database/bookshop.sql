-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: bookshop
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_author`
--

DROP TABLE IF EXISTS `tbl_author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_author` (
  `authorid` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(225) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`authorid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_book`
--

DROP TABLE IF EXISTS `tbl_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_book` (
  `bookid` int(10) NOT NULL AUTO_INCREMENT,
  `authorid` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `categoryid` int(10) NOT NULL,
  `image` varchar(100) NOT NULL,
  `bookfile` varchar(100) NOT NULL,
  PRIMARY KEY (`bookid`),
  KEY `authorid` (`authorid`),
  KEY `categoryid` (`categoryid`),
  CONSTRAINT `tbl_book_ibfk_1` FOREIGN KEY (`authorid`) REFERENCES `tbl_author` (`authorid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_book_ibfk_2` FOREIGN KEY (`categoryid`) REFERENCES `tbl_category` (`categoryid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_bookmark`
--

DROP TABLE IF EXISTS `tbl_bookmark`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_bookmark` (
  `bookmark_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `page_no` int(11) NOT NULL,
  `title` varchar(1000) NOT NULL,
  PRIMARY KEY (`bookmark_id`),
  KEY `book_id` (`book_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tbl_bookmark_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `tbl_book` (`bookid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_bookmark_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_reader` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_category`
--

DROP TABLE IF EXISTS `tbl_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_category` (
  `categoryid` int(11) NOT NULL AUTO_INCREMENT,
  `categoryname` varchar(50) NOT NULL,
  PRIMARY KEY (`categoryid`),
  UNIQUE KEY `categoryname` (`categoryname`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_comment`
--

DROP TABLE IF EXISTS `tbl_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_comment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `book_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `comments` varchar(500) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `book_id` (`book_id`),
  KEY `tbl_comment_ibfk_2` (`user_id`),
  CONSTRAINT `tbl_comment_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `tbl_book` (`bookid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_reader` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_donation`
--

DROP TABLE IF EXISTS `tbl_donation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_donation` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) NOT NULL,
  `bookId` int(10) NOT NULL,
  `authorId` int(10) NOT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `bookId` (`bookId`),
  KEY `authorId` (`authorId`),
  CONSTRAINT `tbl_donation_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `tbl_reader` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_donation_ibfk_2` FOREIGN KEY (`bookId`) REFERENCES `tbl_book` (`bookid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_donation_ibfk_3` FOREIGN KEY (`authorId`) REFERENCES `tbl_author` (`authorid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_history`
--

DROP TABLE IF EXISTS `tbl_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_history` (
  `reader_book_id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `bookid` int(11) NOT NULL,
  `page_no` int(11) NOT NULL,
  PRIMARY KEY (`reader_book_id`),
  KEY `bookid` (`bookid`),
  KEY `userid` (`userid`),
  CONSTRAINT `tbl_history_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `tbl_reader` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_history_ibfk_3` FOREIGN KEY (`bookid`) REFERENCES `tbl_book` (`bookid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_login`
--

DROP TABLE IF EXISTS `tbl_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_login` (
  `loginid` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(225) NOT NULL,
  `password` varchar(50) NOT NULL,
  `keyuser` varchar(10) NOT NULL,
  PRIMARY KEY (`loginid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_otp`
--

DROP TABLE IF EXISTS `tbl_otp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_otp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `timestamp` datetime NOT NULL,
  `status` enum('unused','used') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`,`otp`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_reader`
--

DROP TABLE IF EXISTS `tbl_reader`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_reader` (
  `userid` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(225) NOT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-22 18:00:50
