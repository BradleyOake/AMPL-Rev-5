-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2016 at 07:06 PM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ampl`
--
DROP DATABASE IF EXISTS  `ampl`;
CREATE DATABASE IF NOT EXISTS `ampl` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ampl`;

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

DROP TABLE IF EXISTS `author`;
CREATE TABLE IF NOT EXISTS `author` (
  `book_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(80) NOT NULL,
  `name_on_book` varchar(40) NOT NULL,
  `electronic_rate` decimal(4,2) NOT NULL DEFAULT '0.00',
  `audio_rate` decimal(4,2) NOT NULL DEFAULT '0.00',
  `soft_rate` decimal(4,2) NOT NULL DEFAULT '0.00',
  `hard_rate` decimal(4,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`email`,`book_id`),
  KEY `book_id` (`book_id`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`book_id`, `email`, `name_on_book`, `electronic_rate`, `audio_rate`, `soft_rate`, `hard_rate`) VALUES
(8, 'akb73@yahoo.com', 'Andy Bowers', '40.00', '0.00', '0.00', '0.00'),
(1, 'aquestria@hotmail.com', 'Meena Mason', '40.00', '40.00', '0.00', '0.00'),
(9, 'Jess.Ingold@outlook.com', 'Jessica Ingold', '40.00', '40.00', '0.00', '0.00'),
(8, 'jgilmor13@hotmail.com', 'Jacklyn Gilmor', '0.00', '0.00', '0.00', '0.00'),
(5, 'leebodyj@amplbooks.com', 'Jamie Leebody', '0.00', '0.00', '0.00', '0.00'),
(7, 'lynnworthington@rogers.com', 'Lynn Worthington', '40.00', '40.00', '0.00', '0.00'),
(6, 'pmphoto@porchlight.ca', 'Rachel Rose', '0.00', '0.00', '0.00', '0.00'),
(2, 'skryba@hotmail.com', 'Emanuel Silva', '40.00', '40.00', '0.00', '0.00'),
(13, 'tomdavison12@gmail.com', 'tom dav', '0.00', '0.00', '0.00', '0.00'),
(14, 'tomdavison12@gmail.com', 'tom dav', '0.00', '0.00', '0.00', '0.00'),
(15, 'tomdavison12@gmail.com', 'tom davs', '0.00', '0.00', '0.00', '0.00'),
(16, 'tomdavison12@gmail.com', 'tom davss', '0.00', '0.00', '0.00', '0.00'),
(17, 'tomdavison12@gmail.com', 'tom davssx', '0.00', '0.00', '0.00', '0.00'),
(18, 'tomdavison12@gmail.com', 'tom davssxs', '0.00', '0.00', '0.00', '0.00'),
(19, 'tomdavison12@gmail.com', 'tom davssxss', '0.00', '0.00', '0.00', '0.00'),
(20, 'tomdavison12@gmail.com', 'tom dav', '0.00', '0.00', '0.00', '0.00'),
(21, 'tomdavison12@gmail.com', 'tom dav', '0.00', '0.00', '0.00', '0.00'),
(22, 'tomdavison12@gmail.com', 'tom dav', '0.00', '0.00', '0.00', '0.00'),
(23, 'tomdavison12@gmail.com', 'tom dav', '0.00', '0.00', '0.00', '0.00'),
(24, 'tomdavison12@gmail.com', 'tom dav', '0.00', '0.00', '0.00', '0.00'),
(3, 'tomdavison12@hotmail.com', 'tom dav', '0.00', '0.00', '0.00', '0.00'),
(4, 'tomdavison12@hotmail.com', 'thomas davison', '0.00', '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `author_invoice`
--

DROP TABLE IF EXISTS `author_invoice`;
CREATE TABLE IF NOT EXISTS `author_invoice` (
  `sale_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(80) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rate` decimal(4,2) NOT NULL,
  PRIMARY KEY (`sale_id`,`email`),
  KEY `sale_id` (`sale_id`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `author_invoice`
--

INSERT INTO `author_invoice` (`sale_id`, `email`, `created_on`, `rate`) VALUES
(1, 'aquestria@hotmail.com', '2015-06-02 01:21:44', '40.00'),
(3, 'aquestria@hotmail.com', '2015-06-02 20:37:30', '40.00'),
(4, 'aquestria@hotmail.com', '2015-06-02 20:52:23', '40.00'),
(5, 'aquestria@hotmail.com', '2015-06-02 21:07:24', '40.00'),
(6, 'aquestria@hotmail.com', '2015-06-10 03:02:25', '40.00'),
(8, 'lynnworthington@rogers.com', '2015-09-16 18:33:05', '40.00'),
(9, 'lynnworthington@rogers.com', '2015-09-17 17:02:34', '40.00'),
(10, 'akb73@yahoo.com', '2015-11-04 00:45:41', '40.00'),
(10, 'jgilmor13@hotmail.com', '2015-11-04 00:45:41', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
CREATE TABLE IF NOT EXISTS `book` (
  `book_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `m_keywords` varchar(200) NOT NULL,
  `m_description` varchar(200) NOT NULL,
  `description` text,
  `electronic_price` decimal(8,2) DEFAULT NULL,
  `audio_price` decimal(8,2) DEFAULT NULL,
  `soft_price` decimal(8,2) DEFAULT NULL,
  `hard_price` decimal(8,2) DEFAULT NULL,
  `in_soft` tinyint(1) NOT NULL DEFAULT '0',
  `in_hard` tinyint(1) NOT NULL DEFAULT '0',
  `status_id` smallint(6) NOT NULL,
  `isbn` varchar(17) DEFAULT NULL,
  `date_published` date DEFAULT NULL,
  `notes` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`book_id`),
  UNIQUE KEY `ISBN` (`isbn`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`book_id`, `title`, `m_keywords`, `m_description`, `description`, `electronic_price`, `audio_price`, `soft_price`, `hard_price`, `in_soft`, `in_hard`, `status_id`, `isbn`, `date_published`, `notes`) VALUES
(1, 'Because of a Woman', '', '', 'A dry desert, vultures circling, a man, half-dead, lashed to an oak tree, stripped down to almost nothing -- the story begins. Famous bounty-hunter, Paxton Reign, has been left for dead. It all started because of a woman -- a beautiful woman and a dangerous obsession for her. Determined to have Elizabeth Dalton for his own, Maxwell Stanton is prepared to do anything -- even kill. Believing he’s no stranger to murder, Elizabeth absolutely loathes Maxwell and has branded him responsible for her father’s sudden and mysterious disappearance. Convinced Elizabeth and Maxwell orchestrated his current excruciating predicament; Paxton curses his love for Elizabeth. Deceit, betrayal, unrequited love, and thirsts for revenge are not uncommon, as unanticipated circumstances dramatically collide to irrevocably alter lives, reveal dark secrets and open old wounds. All of this will come to pass -- because of a woman. ', '5.00', '15.00', NULL, NULL, 0, 0, 7, '978-0-9879914-0-9', '2012-10-12', NULL),
(2, 'Demon''s Blood', '', '', 'Ryo goes by his days living with his adoptive parents in the small town of Lemuris.  Nearing the date of his eighteenth birthday he meets a new girl in town, whose captivating and sweet personality overcomes Ryo’s defensive perspective on his surroundings.  The love is short-lived as a dark unwelcome and unavoidable destiny hangs on Ryo’s shoulders; on which will change his own world as much as it will scar humanity’s history forever. A world of fantasy, where celestial beings battle fallen angels and humanity is caught in the crossfire, but also a story of the real world, of the fears, the desires and the ambition that exist within each and every person that walks the world.', '5.00', '15.00', NULL, NULL, 0, 0, 7, '978-0-9879914-2-3', '2015-01-15', NULL),
(7, 'Billy Bass: The 5 Waves Rocks', 'children''s book, fish, Billy, Bass', 'My name is Billy Bass, and I am a smallmouth bass (a type of fish that lives in fresh water).  \r\n', 'My name is Billy Bass, and I am a smallmouth bass (a type of fish that lives in fresh water).  \r\nI want to share my experiences with you.  Perhaps you might want to make choices like mine, but only time will tell.  I will help you understand how a fish lives by sharing the first five stages, or waves, of my life…underwater.  \r\n', '5.00', '0.00', NULL, NULL, 0, 0, 7, '978-0-9879914-4-7', '2015-09-15', NULL),
(8, 'Georgia Goes to Bed', 'E Book, Children''s Book, Georgia Goes to Bed, Bed Time Story ', 'Georgia goes to bed shares the difficulty parents face in getting their toddlers to sleep', 'Georgia goes to bed shares the difficulty parents face in getting their toddlers to sleep; Although they are quite young, children are crafty, evasive, and have finely developed stall tactics. This story reveals Georgia’s father’s struggle to convince his young child to shut down for the day.', '5.00', '0.00', NULL, NULL, 0, 0, 7, '978-0-9879914-5-4', '2015-10-09', NULL),
(9, 'Fate Unwritten', '', '', 'Eighteen-year-old Hannah Lowry had what she believed to be the perfect plan: graduate university, get a job working for her father, and when the time was right, settle down with her high school sweetheart. But when one night transforms her life, she soon realizes that even the best-laid plans don’t come with any guarantees.', '5.00', '0.00', NULL, NULL, 0, 0, 7, NULL, '2015-10-25', NULL),
(10, 'test', '', '', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL),
(11, 'test', '', '', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL),
(12, 'test', '', '', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL),
(13, 'test', '', '', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL),
(14, 'test', '', '', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL),
(15, 'test', '', '', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL),
(16, 'test', '', '', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL),
(17, 'test', '', '', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL),
(18, 'test', '', '', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL),
(19, 'test', '', '', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL),
(20, 'ds', '', '', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL),
(21, 'dfdf', '', '', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL),
(22, 'err', '', '', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL),
(23, 'dfdf', '', '', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL),
(24, 'sdsd', '', '', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `book_comment`
--

DROP TABLE IF EXISTS `book_comment`;
CREATE TABLE IF NOT EXISTS `book_comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(50) NOT NULL,
  `alias` varchar(50) DEFAULT 'anonymous',
  `text` text NOT NULL,
  `rating` smallint(6) NOT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`,`book_id`,`email`),
  KEY `comment_email` (`email`),
  KEY `book_id` (`book_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book_comment`
--

INSERT INTO `book_comment` (`comment_id`, `book_id`, `email`, `alias`, `text`, `rating`, `created_on`, `comment_status`) VALUES
(1, 7, 'lynnworthington@rogers.com', 'Lynn Worthington', 'I wrote this book for children and I found out later people of all ages and walk of life found the book interesting and gives you a strong message to help save our environment.  \n\nI ask the question; what is the number 2 killer of birds and fish?  People cannot believe that the answer is GUM, gum is flavoured plastic.  Please dispose of GUM properly, do not spit it out THANK YOU', 5, '2015-09-16 00:15:10', 1),
(2, 8, 'hunterkinch42@gmail.com', 'hunter kinch', 'i love your book bowers!!\n', 3, '2016-01-27 16:11:43', 1),
(3, 1, 'tomdavison12@gmail.com', 'tom dav', 'fgfg', 1, '2016-04-13 04:01:48', 0);

-- --------------------------------------------------------

--
-- Table structure for table `book_comment_opinion`
--

DROP TABLE IF EXISTS `book_comment_opinion`;
CREATE TABLE IF NOT EXISTS `book_comment_opinion` (
  `comment_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `agreed` tinyint(1) DEFAULT NULL,
  `reported` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`email`,`comment_id`),
  KEY `comment_id` (`comment_id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book_comment_opinion`
--

INSERT INTO `book_comment_opinion` (`comment_id`, `email`, `agreed`, `reported`) VALUES
(1, 'tomdavison12@gmail.com', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `book_editor`
--

DROP TABLE IF EXISTS `book_editor`;
CREATE TABLE IF NOT EXISTS `book_editor` (
  `book_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(80) NOT NULL,
  `amount_owed` decimal(10,2) DEFAULT '0.00',
  `status_id` smallint(6) DEFAULT NULL,
  `cost_of_service` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`email`,`book_id`),
  KEY `book_id` (`book_id`),
  KEY `assigned_email` (`email`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `book_status`
--

DROP TABLE IF EXISTS `book_status`;
CREATE TABLE IF NOT EXISTS `book_status` (
  `status_id` smallint(6) NOT NULL,
  `description` varchar(20) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book_status`
--

INSERT INTO `book_status` (`status_id`, `description`) VALUES
(1, 'Initial Submission'),
(2, 'In Review'),
(3, 'Review Complete'),
(4, 'On Hold'),
(5, 'Upcoming'),
(6, 'Quarantined'),
(7, 'Final Product');

-- --------------------------------------------------------

--
-- Table structure for table `book_type`
--

DROP TABLE IF EXISTS `book_type`;
CREATE TABLE IF NOT EXISTS `book_type` (
  `type_id` smallint(1) NOT NULL,
  `description` varchar(20) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book_type`
--

INSERT INTO `book_type` (`type_id`, `description`) VALUES
(0, 'Generic Electronic'),
(1, 'Text'),
(2, 'E-Pub'),
(3, 'PDF'),
(4, 'MP3'),
(5, 'Soft Copy'),
(6, 'Hard Copy');

-- --------------------------------------------------------

--
-- Table structure for table `ink`
--
DROP TABLE IF EXISTS `ink`;
CREATE TABLE IF NOT EXISTS `ink` (
  `ink_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ink_name` varchar(40) NOT NULL,
  `cost_per_side` decimal(5,4) NOT NULL, 
  PRIMARY KEY (`ink_id`),
  KEY `ink_id` (`ink_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
--
-- Dumping data for table `ink`
--
INSERT INTO `ink` (`ink_id`, `ink_name`, `cost_per_side`) VALUES
(1, 'Black', '0.015'),
(2, 'Colour', '0.09');

-- --------------------------------------------------------

--
-- Table structure for table `paper`
--
DROP TABLE IF EXISTS `paper`;
CREATE TABLE IF NOT EXISTS `paper` (
  `paper_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `paper_name` varchar(40) NOT NULL,
  `paper_type` varchar(20) NOT NULL,
  `paper_usage` varchar(20) NOT NULL,
  `paper_size` varchar(20) NOT NULL,
  `unit_cost` decimal(5,4) NOT NULL, 
  PRIMARY KEY (`paper_id`),
  KEY `paper_id` (`paper_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
--
-- Dumping data for table `paper`
--
INSERT INTO `paper` (`paper_id`, `paper_name`, `paper_type`, `paper_usage`, `paper_size`, `unit_cost`) VALUES
(1, 'Rolland Enviro', 1, 2, '11x17', '0.0306'),
(2, 'Opus Gloss', 2, 3, '12x18', '0.0375'),
(3, '100lb Cogar', 3, 1, '11x17', '0.0706');

-- --------------------------------------------------------

--
-- Table structure for table `paper_type`
--
DROP TABLE IF EXISTS `paper_type`;
CREATE TABLE IF NOT EXISTS `paper_type` (
  `paper_type` varchar(20) NOT NULL,
  `paper_type_description` varchar(20) NOT NULL,
  PRIMARY KEY (`paper_type`),
  KEY `paper_type` (`paper_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- Dumping data for table `paper_type`
--
INSERT INTO `paper_type` (`paper_type`, `paper_type_description`) VALUES
(1, 'Plain'),
(2, 'Glossy'),
(3, 'Smooth');

-- --------------------------------------------------------

--
-- Table structure for table `paper_usage`
--
DROP TABLE IF EXISTS `paper_usage`;
CREATE TABLE IF NOT EXISTS `paper_usage` (
  `paper_usage` varchar(20) NOT NULL,
  `paper_usage_description` varchar(20) NOT NULL,
  PRIMARY KEY (`paper_usage`),
  KEY `paper_usage` (`paper_usage`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- Dumping data for table `paper_usage`
--
INSERT INTO `paper_usage` (`paper_usage`, `paper_usage_description`) VALUES
(1, 'Novel Cover'),
(2, 'Novel Pages'),
(3, 'Picture Book Pages');

-- --------------------------------------------------------

--
-- Table structure for table `news_comment`
--

DROP TABLE IF EXISTS `news_comment`;
CREATE TABLE IF NOT EXISTS `news_comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(50) NOT NULL,
  `alias` varchar(50) DEFAULT 'anonymous',
  `text` text NOT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`),
  KEY `comment_email` (`email`),
  KEY `news_id` (`news_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news_comment`
--

INSERT INTO `news_comment` (`comment_id`, `news_id`, `email`, `alias`, `text`, `created_on`, `comment_status`) VALUES
(1, 8, 'lynnworthington@rogers.com', 'Lynn Worthington', 'I need to let people know that gum is flavoured plastic.  Gum is the number 2 KILLER of birds and fish in this World.  Please deposit gum in a wrapper and place into a garbage bag.  Please do not swallow the gum for it takes 7 years for the fibres to break down in a Human.', '2016-03-11 21:58:00', 1),
(2, 8, 'tomdavison12@gmail.com', ' tom dav ', 'sdsdsd', '2016-04-13 03:59:15', 0);

-- --------------------------------------------------------

--
-- Table structure for table `news_comment_opinion`
--

DROP TABLE IF EXISTS `news_comment_opinion`;
CREATE TABLE IF NOT EXISTS `news_comment_opinion` (
  `comment_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `agreed` tinyint(1) NOT NULL DEFAULT '0',
  `reported` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`email`,`comment_id`),
  KEY `comment_id` (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news_comment_opinion`
--

INSERT INTO `news_comment_opinion` (`comment_id`, `email`, `agreed`, `reported`) VALUES
(1, 'tomdavison12@gmail.com', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `news_post`
--

DROP TABLE IF EXISTS `news_post`;
CREATE TABLE IF NOT EXISTS `news_post` (
  `news_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL,
  `m_keywords` varchar(200) NOT NULL,
  `m_description` varchar(200) NOT NULL,
  `subtopic` text NOT NULL,
  `html` text NOT NULL,
  `created_on` date DEFAULT NULL,
  `image` tinyint(1) DEFAULT '0',
  `image_align` varchar(6) DEFAULT NULL,
  `image_path` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news_post`
--

INSERT INTO `news_post` (`news_id`, `title`, `m_keywords`, `m_description`, `subtopic`, `html`, `created_on`, `image`, `image_align`, `image_path`) VALUES
(3, '<u>Billy Bass: The 5 Wave Rocks </u> is Now Available', 'Children''s story, new, coming soon, e-book, fish story', 'My name is Billy Bass, and I am a smallmouth bass (a type of fish that lives in fresh water).  I want to share my experiences with you. \r\n', 'Billy Bass has arrived at AMPL Publishing. Download your copy today. ', 'My name is Billy Bass, and I am a smallmouth bass (a type of fish that lives in fresh water).  \r\nI want to share my experiences with you.  Perhaps you might want to make choices like mine, but only time will tell.  I will help you understand how a fish lives by sharing the first five stages, or waves, of my life…underwater.  \r\n', '2015-08-29', 0, 'right', NULL),
(4, '<u>Georgia Goes to Bed</u> is Now Available', 'Georgia Goes to Bed, Children''s, E-Book, Bed time,', 'Georgia goes to bed shares the difficulty parents face in getting their toddlers to sleep.', 'The newest AMPL bed time story is now available in PDF format. <br/>\r\n\r\nWritten by: Andy Bowers <br/>\r\nIllustrations By: Jacklyn Gilmor <br/>\r\nRelease Date: October 9th, 2015', '<u>Georgia goes to bed</u>  shares the difficulty parents face in getting their toddlers to sleep.  Although quite young, children are crafty, evasive and have finely developed stall tactics.  This story reveals Georgia’s father’s struggle to convince his young child to shut down for the day.<br/><br/>\r\n\r\nWritten by: Andy Bowers <br/>\r\n\r\nIllustrations By: Jacklyn Gilmor<br/>\r\n\r\nRelease Date: October 9th, 2015\r\n\r\n', '2015-10-03', 0, 'right', NULL),
(5, 'Get your Copy of <u>Fate Unwritten</u>', 'Fate Unwritten, fiction, E-book, New Release, Jessica Ingold', 'Eighteen-year-old Hannah Lowry had what she believed to be the perfect plan: graduate university, get a job working for her father, and when the time was right, settle down with her high school sweeth', '"...best-laid plans don’t come with any guarantees."<br/>\r\nWritten by Jessica Ingold <br/>\r\nRelease Date: Oct. 25, 2015\r\n', 'Eighteen-year-old Hannah Lowry had what she believed to be the perfect plan: graduate university, get a job working for her father, and when the time was right, settle down with her high school sweetheart. But when one night transforms her life, she soon realizes that even the best-laid plans don’t come with any guarantees.\r\n', '2015-10-13', 0, 'right', NULL),
(6, 'Two New Titles Coming Soon to AMPL', 'New Books, E-Books, ', 'Motivational Quotes, and Power Spending. ', '<u>Best Motivational Quotes  </u>&\r\n<u>Power Spending</u>', 'We have been fortunate to have two new novels join the AMPL Library in electronic and physical formats.  Welcome to <u>Best Motivational Quotes  </u> and <u>Power Spending</u>.', '2016-02-02', 0, 'right', NULL),
(7, 'Billy Bass Colouring Event at Kelseys in Bowmanville', 'Saturday, event, Kids, Colouring, Kelsey''s, bowmanville', 'When: 	Saturday, February 6th\r\nWhere: 	Kelsey''s restaurant\r\n	90 Clarington Blvd.\r\n	Bowmanville, ON\r\n\r\n', 'Event details are as follows:<br/>\r\nWhen: 	Saturday, February 6th<br/>\r\nWhere: 	Kelsey''s restaurant<br/>	90 Clarington Blvd.<br/>\r\n	Bowmanville, ON<br/>\r\n', 'Looking for something fun to do with the kids this weekend? Author Lynn Worthington will be at Kelsey''s in Bowmanville to discuss his latest book, Billy Bass: The 5 Waves Rocks, and the importance of preserving the environment for generations to come. Lynn''s youngest fans will also have the chance to participate in a colouring contest, with a prize for every contestant and several special prizes available while quantities last.\r\n\r\nEvent details are as follows:<br/><br/>\r\n\r\nWhen: 	Saturday, February 6th<br/>\r\nWhere: 	Kelsey''s restaurant<br/>	90 Clarington Blvd.<br/>\r\n	Bowmanville, ON<br/><br/>\r\n\r\nTo learn more about Lynn and his work, please visit: www.happytrailslynn.ca \r\n\r\n', '2016-02-03', 0, 'right', NULL),
(8, 'Making Waves ', 'Making Waves, Billy Bass, Author, Colouring Contest', 'On Saturday, February 6th, he made an appearance at Kelsey’s restaurant in Bowmanville, Ontario, where several young patrons participated in a colouring contest for prizes, including goody bags, gift ', 'Lynn Worthington & The Adventures of Billy Bass', '<style>\r\n<!--\r\n /* Font Definitions */\r\n @font-face\r\n	{font-family:Helvetica;\r\n	panose-1:2 11 6 4 2 2 2 2 2 4;\r\n	mso-font-charset:0;\r\n	mso-generic-font-family:swiss;\r\n	mso-font-format:other;\r\n	mso-font-pitch:variable;\r\n	mso-font-signature:3 0 0 0 1 0;}\r\n@font-face\r\n	{font-family:Helvetica;\r\n	panose-1:2 11 6 4 2 2 2 2 2 4;\r\n	mso-font-charset:0;\r\n	mso-generic-font-family:swiss;\r\n	mso-font-format:other;\r\n	mso-font-pitch:variable;\r\n	mso-font-signature:3 0 0 0 1 0;}\r\n@font-face\r\n	{font-family:Cambria;\r\n	panose-1:2 4 5 3 5 4 6 3 2 4;\r\n	mso-font-charset:0;\r\n	mso-generic-font-family:roman;\r\n	mso-font-pitch:variable;\r\n	mso-font-signature:-536870145 1073743103 0 0 415 0;}\r\n@font-face\r\n	{font-family:Tahoma;\r\n	panose-1:2 11 6 4 3 5 4 4 2 4;\r\n	mso-font-charset:0;\r\n	mso-generic-font-family:swiss;\r\n	mso-font-pitch:variable;\r\n	mso-font-signature:-520081665 -1073717157 41 0 66047 0;}\r\n@font-face\r\n	{font-family:"Lucida Bright";\r\n	panose-1:2 4 6 2 5 5 5 2 3 4;\r\n	mso-font-charset:0;\r\n	mso-generic-font-family:roman;\r\n	mso-font-pitch:variable;\r\n	mso-font-signature:3 0 0 0 1 0;}\r\n /* Style Definitions */\r\n p.MsoNormal, li.MsoNormal, div.MsoNormal\r\n	{mso-style-unhide:no;\r\n	mso-style-qformat:yes;\r\n	mso-style-parent:"";\r\n	margin:0in;\r\n	margin-bottom:.0001pt;\r\n	mso-pagination:widow-orphan;\r\n	font-size:12.0pt;\r\n	font-family:"Cambria","serif";\r\n	mso-ascii-font-family:Cambria;\r\n	mso-ascii-theme-font:minor-latin;\r\n	mso-fareast-font-family:Cambria;\r\n	mso-fareast-theme-font:minor-latin;\r\n	mso-hansi-font-family:Cambria;\r\n	mso-hansi-theme-font:minor-latin;\r\n	mso-bidi-font-family:"Times New Roman";\r\n	mso-bidi-theme-font:minor-bidi;}\r\np.MsoCommentText, li.MsoCommentText, div.MsoCommentText\r\n	{mso-style-noshow:yes;\r\n	mso-style-priority:99;\r\n	mso-style-link:"Comment Text Char";\r\n	margin:0in;\r\n	margin-bottom:.0001pt;\r\n	mso-pagination:widow-orphan;\r\n	font-size:10.0pt;\r\n	font-family:"Cambria","serif";\r\n	mso-ascii-font-family:Cambria;\r\n	mso-ascii-theme-font:minor-latin;\r\n	mso-fareast-font-family:Cambria;\r\n	mso-fareast-theme-font:minor-latin;\r\n	mso-hansi-font-family:Cambria;\r\n	mso-hansi-theme-font:minor-latin;\r\n	mso-bidi-font-family:"Times New Roman";\r\n	mso-bidi-theme-font:minor-bidi;}\r\nspan.MsoCommentReference\r\n	{mso-style-noshow:yes;\r\n	mso-style-priority:99;\r\n	mso-ansi-font-size:8.0pt;\r\n	mso-bidi-font-size:8.0pt;}\r\np.MsoCommentSubject, li.MsoCommentSubject, div.MsoCommentSubject\r\n	{mso-style-noshow:yes;\r\n	mso-style-priority:99;\r\n	mso-style-parent:"Comment Text";\r\n	mso-style-link:"Comment Subject Char";\r\n	mso-style-next:"Comment Text";\r\n	margin:0in;\r\n	margin-bottom:.0001pt;\r\n	mso-pagination:widow-orphan;\r\n	font-size:10.0pt;\r\n	font-family:"Cambria","serif";\r\n	mso-ascii-font-family:Cambria;\r\n	mso-ascii-theme-font:minor-latin;\r\n	mso-fareast-font-family:Cambria;\r\n	mso-fareast-theme-font:minor-latin;\r\n	mso-hansi-font-family:Cambria;\r\n	mso-hansi-theme-font:minor-latin;\r\n	mso-bidi-font-family:"Times New Roman";\r\n	mso-bidi-theme-font:minor-bidi;\r\n	font-weight:bold;}\r\np.MsoAcetate, li.MsoAcetate, div.MsoAcetate\r\n	{mso-style-noshow:yes;\r\n	mso-style-priority:99;\r\n	mso-style-link:"Balloon Text Char";\r\n	margin:0in;\r\n	margin-bottom:.0001pt;\r\n	mso-pagination:widow-orphan;\r\n	font-size:8.0pt;\r\n	font-family:"Tahoma","sans-serif";\r\n	mso-fareast-font-family:Cambria;\r\n	mso-fareast-theme-font:minor-latin;}\r\nspan.CommentTextChar\r\n	{mso-style-name:"Comment Text Char";\r\n	mso-style-noshow:yes;\r\n	mso-style-priority:99;\r\n	mso-style-unhide:no;\r\n	mso-style-locked:yes;\r\n	mso-style-link:"Comment Text";\r\n	mso-ansi-font-size:10.0pt;\r\n	mso-bidi-font-size:10.0pt;}\r\nspan.CommentSubjectChar\r\n	{mso-style-name:"Comment Subject Char";\r\n	mso-style-noshow:yes;\r\n	mso-style-priority:99;\r\n	mso-style-unhide:no;\r\n	mso-style-locked:yes;\r\n	mso-style-parent:"Comment Text Char";\r\n	mso-style-link:"Comment Subject";\r\n	mso-ansi-font-size:10.0pt;\r\n	mso-bidi-font-size:10.0pt;\r\n	font-weight:bold;}\r\nspan.BalloonTextChar\r\n	{mso-style-name:"Balloon Text Char";\r\n	mso-style-noshow:yes;\r\n	mso-style-priority:99;\r\n	mso-style-unhide:no;\r\n	mso-style-locked:yes;\r\n	mso-style-link:"Balloon Text";\r\n	mso-ansi-font-size:8.0pt;\r\n	mso-bidi-font-size:8.0pt;\r\n	font-family:"Tahoma","sans-serif";\r\n	mso-ascii-font-family:Tahoma;\r\n	mso-hansi-font-family:Tahoma;\r\n	mso-bidi-font-family:Tahoma;}\r\n.MsoChpDefault\r\n	{mso-style-type:export-only;\r\n	mso-default-props:yes;\r\n	font-size:12.0pt;\r\n	mso-ansi-font-size:12.0pt;\r\n	mso-bidi-font-size:12.0pt;\r\n	font-family:"Cambria","serif";\r\n	mso-ascii-font-family:Cambria;\r\n	mso-ascii-theme-font:minor-latin;\r\n	mso-fareast-font-family:Cambria;\r\n	mso-fareast-theme-font:minor-latin;\r\n	mso-hansi-font-family:Cambria;\r\n	mso-hansi-theme-font:minor-latin;\r\n	mso-bidi-font-family:"Times New Roman";\r\n	mso-bidi-theme-font:minor-bidi;}\r\n@page WordSection1\r\n	{size:8.5in 11.0in;\r\n	margin:1.0in 1.25in 1.0in 1.25in;\r\n	mso-header-margin:.5in;\r\n	mso-footer-margin:.5in;\r\n	mso-paper-source:0;}\r\ndiv.WordSection1\r\n	{page:WordSection1;}\r\n-->\r\n</style>\r\n<!--[if gte mso 10]>\r\n<style>\r\n /* Style Definitions */\r\n table.MsoNormalTable\r\n	{mso-style-name:"Table Normal";\r\n	mso-tstyle-rowband-size:0;\r\n	mso-tstyle-colband-size:0;\r\n	mso-style-noshow:yes;\r\n	mso-style-priority:99;\r\n	mso-style-parent:"";\r\n	mso-padding-alt:0in 5.4pt 0in 5.4pt;\r\n	mso-para-margin:0in;\r\n	mso-para-margin-bottom:.0001pt;\r\n	mso-pagination:widow-orphan;\r\n	font-size:12.0pt;\r\n	font-family:"Cambria","serif";\r\n	mso-ascii-font-family:Cambria;\r\n	mso-ascii-theme-font:minor-latin;\r\n	mso-hansi-font-family:Cambria;\r\n	mso-hansi-theme-font:minor-latin;}\r\n</style>\r\n<![endif]--><!--[if gte mso 9]><xml>\r\n <o:shapedefaults v:ext="edit" spidmax="1026"/>\r\n</xml><![endif]--><!--[if gte mso 9]><xml>\r\n <o:shapelayout v:ext="edit">\r\n  <o:idmap v:ext="edit" data="1"/>\r\n </o:shapelayout></xml><![endif]-->\r\n</head>\r\n\r\n<body lang=EN-US style=''tab-interval:.5in''>\r\n\r\n<div class=WordSection1>\r\n\r\n<p class=MsoNormal align=center style=''text-align:center;line-height:120%;\r\nmso-pagination:none;mso-layout-grid-align:none;text-autospace:none''><b><i\r\nstyle=''mso-bidi-font-style:normal''><span style=''mso-bidi-font-size:14.0pt;\r\nline-height:120%;font-family:"Lucida Bright","serif";mso-bidi-font-family:Helvetica;\r\ncolor:#191919''>Making Waves: Lynn Worthington &amp; The Adventures of Billy\r\nBass<o:p></o:p></span></i></b></p>\r\n\r\n<p class=MsoNormal style=''line-height:120%;mso-pagination:none;mso-layout-grid-align:\r\nnone;text-autospace:none''><span style=''mso-bidi-font-size:14.0pt;line-height:\r\n120%;font-family:"Lucida Bright","serif";mso-bidi-font-family:Helvetica;\r\ncolor:#191919''><o:p>&nbsp;</o:p></span></p>\r\n\r\n<p class=MsoNormal style=''line-height:120%;mso-pagination:none;mso-layout-grid-align:\r\nnone;text-autospace:none''><span style=''mso-bidi-font-size:14.0pt;line-height:\r\n120%;font-family:"Lucida Bright","serif";mso-bidi-font-family:Helvetica;\r\ncolor:#191919''><o:p>&nbsp;</o:p></span></p>\r\n\r\n<p class=MsoNormal style=''line-height:120%;mso-pagination:none;mso-layout-grid-align:\r\nnone;text-autospace:none''><span style=''mso-bidi-font-size:14.0pt;line-height:\r\n120%;font-family:"Lucida Bright","serif";mso-bidi-font-family:Helvetica;\r\ncolor:#191919''>There’s an old saying that claims the pen is mightier than the\r\nsword, and now one children’s book author is hoping to leave his mark on the\r\npages of history.<o:p></o:p></span></p>\r\n\r\n<p class=MsoNormal style=''line-height:120%;mso-pagination:none;mso-layout-grid-align:\r\nnone;text-autospace:none''><span style=''mso-bidi-font-size:14.0pt;line-height:\r\n120%;font-family:"Lucida Bright","serif";mso-bidi-font-family:Helvetica;\r\ncolor:#191919''><o:p>&nbsp;</o:p></span></p>\r\n\r\n<p class=MsoNormal style=''line-height:120%;mso-pagination:none;mso-layout-grid-align:\r\nnone;text-autospace:none''><span style=''mso-bidi-font-size:14.0pt;line-height:\r\n120%;font-family:"Lucida Bright","serif";mso-bidi-font-family:Helvetica;\r\ncolor:#191919''>Like most creative types, Lynn Worthington is a firm believer in\r\nthe power of the written word. Armed with a Dictaphone and a wealth of knowledge,\r\nhis approach to self-promotion is as subtle as it is original: enter a food\r\nestablishment as an ordinary patron and wait for curious strangers to take the\r\nbait (in this case, a life-sized lure reminiscent of his angler roots). It’s an\r\ningenious strategy, and one that has netted him a considerable amount of\r\ninterest in a world that ever longs for a good story.<o:p></o:p></span></p>\r\n\r\n<p class=MsoNormal style=''line-height:120%;mso-pagination:none;mso-layout-grid-align:\r\nnone;text-autospace:none''><span style=''mso-bidi-font-size:14.0pt;line-height:\r\n120%;font-family:"Lucida Bright","serif";mso-bidi-font-family:Helvetica;\r\ncolor:#191919''><o:p>&nbsp;</o:p></span></p>\r\n\r\n<p class=MsoNormal style=''line-height:120%;mso-pagination:none;mso-layout-grid-align:\r\nnone;text-autospace:none''><span style=''mso-bidi-font-size:14.0pt;line-height:\r\n120%;font-family:"Lucida Bright","serif";mso-bidi-font-family:Helvetica;\r\ncolor:#191919''>Lynn is the author of <i style=''mso-bidi-font-style:normal''>Billy\r\nBass: The 5 Waves Rocks</i>, which explores humankind’s impact on the waterways\r\nthrough the eyes of a smallmouth bass named Billy. Whereas the characters are\r\nmade to appeal to Lynn’s younger fans, the overriding message is sure to resonate\r\nwith readers of all ages: we only have one Earth, and it’s up to us to save it.\r\n<o:p></o:p></span></p>\r\n\r\n<p class=MsoNormal style=''line-height:120%;mso-pagination:none;mso-layout-grid-align:\r\nnone;text-autospace:none''><span style=''mso-bidi-font-size:14.0pt;line-height:\r\n120%;font-family:"Lucida Bright","serif";mso-bidi-font-family:Helvetica;\r\ncolor:#191919''><o:p>&nbsp;</o:p></span></p>\r\n\r\n<p class=MsoNormal style=''line-height:120%;mso-pagination:none;mso-layout-grid-align:\r\nnone;text-autospace:none''><span style=''mso-bidi-font-size:14.0pt;line-height:\r\n120%;font-family:"Lucida Bright","serif";mso-bidi-font-family:Helvetica;\r\ncolor:#191919''>There’s a universal attitude among members of the writing\r\ncommunity that believes no effort is ever wasted that changes even one person’s\r\nperspective. In the pond of life, even the tiniest pebble is bound to make a\r\nripple. This is the philosophy fueling Lynn’s mission and the driving force\r\nbehind the landslide of international attention that culminated in a whopping\r\n24,000 emails—proving yet again the power of the written word to transcend\r\ngeographic and ideological barriers. <o:p></o:p></span></p>\r\n\r\n<p class=MsoNormal style=''line-height:120%;mso-pagination:none;mso-layout-grid-align:\r\nnone;text-autospace:none''><span style=''mso-bidi-font-size:14.0pt;line-height:\r\n120%;font-family:"Lucida Bright","serif";mso-bidi-font-family:Helvetica;\r\ncolor:#191919''><o:p>&nbsp;</o:p></span></p>\r\n\r\n<p class=MsoNormal style=''line-height:120%;mso-pagination:none;mso-layout-grid-align:\r\nnone;text-autospace:none''><span style=''mso-bidi-font-size:14.0pt;line-height:\r\n120%;font-family:"Lucida Bright","serif";mso-bidi-font-family:Helvetica;\r\ncolor:#191919''>Determined to captivate the hearts and minds of the younger\r\ngeneration, Lynn recently added another stop on his journey to promote Billy\r\nBass. On Saturday, February 6th, he made an appearance at Kelsey’s restaurant\r\nin Bowmanville, Ontario, where several young patrons participated in a\r\ncolouring contest for prizes, including goody bags, gift cards, and a few\r\nlarger items to be distributed at the discretion of the judges (in this case,\r\nthe wait staff). <o:p></o:p></span></p>\r\n\r\n<p class=MsoNormal style=''line-height:120%;mso-pagination:none;mso-layout-grid-align:\r\nnone;text-autospace:none''><span style=''mso-bidi-font-size:14.0pt;line-height:\r\n120%;font-family:"Lucida Bright","serif";mso-bidi-font-family:Helvetica;\r\ncolor:#191919''><o:p>&nbsp;</o:p></span></p>\r\n\r\n<p class=MsoNormal style=''line-height:120%;mso-pagination:none;mso-layout-grid-align:\r\nnone;text-autospace:none''><span style=''mso-bidi-font-size:14.0pt;line-height:\r\n120%;font-family:"Lucida Bright","serif";mso-bidi-font-family:Helvetica;\r\ncolor:#191919''>Like all stories, the story of Billy Bass doesn’t end at the\r\nlast page. At its heart, it’s a story about triumph: triumph over the external\r\nforces beyond our control, and triumph over ourselves in the face of doubt and\r\nuncertainty. In a world that often seems to be moving too quickly, the\r\npermanence of a printed book is an underrated consolation. <o:p></o:p></span></p>\r\n\r\n<p class=MsoNormal style=''line-height:120%;mso-pagination:none;mso-layout-grid-align:\r\nnone;text-autospace:none''><span style=''mso-bidi-font-size:14.0pt;line-height:\r\n120%;font-family:"Lucida Bright","serif";mso-bidi-font-family:Helvetica;\r\ncolor:#191919''><o:p>&nbsp;</o:p></span></p>\r\n\r\n<p class=MsoNormal style=''line-height:120%;mso-pagination:none;mso-layout-grid-align:\r\nnone;text-autospace:none''><span style=''mso-bidi-font-size:14.0pt;line-height:\r\n120%;font-family:"Lucida Bright","serif";mso-bidi-font-family:Helvetica;\r\ncolor:#191919''>These days it is only too easy to become discouraged and believe\r\nour impact on society is insignificant. However, if Lynn’s success is any\r\nindication, even the smallest ripple has the potential to become a wave. After\r\nall, as individuals we may only be one drop, but together, we form an ocean.<o:p></o:p></span></p>\r\n\r\n<p class=MsoNormal style=''line-height:120%''><span style=''font-family:"Lucida Bright","serif"''><o:p>&nbsp;</o:p></span></p>\r\n', '2016-02-10', 0, 'right', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reset_password`
--

DROP TABLE IF EXISTS `reset_password`;
CREATE TABLE IF NOT EXISTS `reset_password` (
  `email` varchar(80) NOT NULL,
  `code` char(60) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `valid_till` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `reset_password`
--
DROP TRIGGER IF EXISTS `t`;
DELIMITER $$
CREATE TRIGGER `t` BEFORE INSERT ON `reset_password` FOR EACH ROW BEGIN

SET
    NEW.created_on = IFNULL(NEW.created_on,NOW()),
    NEW.valid_till= TIMESTAMPADD(HOUR,2,NEW.created_on);



END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(80) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `password` char(60) NOT NULL,
  `role_id` smallint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `remember_token` varchar(100) NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `m_description` varchar(200) DEFAULT NULL,
  `m_keywords` varchar(200) NOT NULL,
  `facebook_id` varchar(100) DEFAULT NULL,
  `google_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`email`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `facebook_id` (`facebook_id`),
  UNIQUE KEY `google_id` (`google_id`),
  KEY `user_ibfk_1` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `first_name`, `last_name`, `password`, `role_id`, `created_at`, `updated_at`, `remember_token`, `last_login`, `m_description`, `m_keywords`, `facebook_id`, `google_id`) VALUES
(35, 'akb73@yahoo.com', 'Andy', 'Bowers', '$2y$10$Rx0Mzc3Ma1wbMea3DxsZyuPRUDuRRyjDo6hyeASZmSLwmEniJJeki', 2, '2015-09-23 21:51:06', '2015-09-25 04:05:49', 'RGx1JkvArSsEBsqOIMLCHFDNAOSszhRTtlM0T8Dtpspa6RWFsE27c0u2o6HU', NULL, '', '', NULL, NULL),
(46, 'anthony.walton@live.com', 'Anthony', 'Walton', '$2y$10$dxEbE9p12ja.v/m8DkmWQ.I21lBioCok70RGSjp8NV5504WU3OqXS', 7, '2016-04-12 16:14:13', '0000-00-00 00:00:00', '', NULL, NULL, '', NULL, NULL),
(4, 'aquestria@hotmail.com', 'Meena', 'Mason', '$2y$10$XY8Lvz4iTCoSDzuuYD0VT.JYsB4jvGbhh2soJ8fimLwFQ758Sfv7i', 2, '2015-05-31 23:34:57', '2016-01-27 05:55:52', 'w00a2NfaeTaVJIV4nbbpBomnDa6RfpG0ofY1W4ZvGxltZEolxvMTvHHbaMNb', NULL, '', '', NULL, NULL),
(37, 'dianatomietto88@gmail.com', 'Diana', 'tomietto', '$2y$10$8nSu89L8Da/zNnhGMSKZU.98fqEpnxvAabux5oSSS99SEUcq6E6im', 1, '2015-10-03 01:29:00', '2015-10-03 08:34:01', 'F5SD10bdPw5bNVcLC8YApEGoqMdSrZSQicvjTpuRgPpH2kSSMC3XFJYo14jq', NULL, NULL, '', NULL, NULL),
(27, 'eric.poulin@digitalmarketingpeople.ca', 'Eric', 'Poulin', '$2y$10$HBqUhF6RBurFRQGHVPZIieumw.ihoF7AvNprrtJsadBGO9W20T0.O', 1, '2015-06-25 19:57:34', '0000-00-00 00:00:00', '', NULL, NULL, '', NULL, NULL),
(38, 'fairfield.laura@gmail.com', 'Laura', 'Fairfield', '$2y$10$9YjnFsFTzZh2oJxByXli.uzSdikE2ie5s9Y/1wlhvlpVXIYaAkap.', 1, '2015-10-04 14:42:57', '0000-00-00 00:00:00', '', NULL, NULL, '', NULL, NULL),
(44, 'hunterkinch42@gmail.com', 'hunter', 'kinch', '$2y$10$K.3M15C/8OZnUL6TNOaj8emzV3PvskwLO/u9r90nW8Q/zh7Gyz8zG', 1, '2016-01-27 16:11:01', '0000-00-00 00:00:00', '', NULL, NULL, '', NULL, NULL),
(41, 'Jess.Ingold@outlook.com', 'Jess', 'Ingold', '$2y$10$YgbZlZNvhGk9JQg93LIkFO3BRYTm46hdx5HH3Lsf5PLQAuFAJ/BcC', 2, '2015-10-25 04:15:44', '2015-10-29 05:22:28', 'Lyxuiom7EmJxuoZMJfSZTtHLDac4sHP40xPbeghklY8HcMG4w4OpdMUxTflW', NULL, '', '', NULL, NULL),
(39, 'jgilmor13@hotmail.com', 'Jacklyn', 'Gilmor', '$2y$10$ZRACK56MIlfT.osrPqI0AupcA3jJDccx1rQcln/no/9Za.Kyizi3e', 2, '2015-10-08 03:12:45', '0000-00-00 00:00:00', '', NULL, 'Illustrator', 'Illustrator', NULL, NULL),
(40, 'jgilmor501@hotmail.com', 'James', 'Gilmor', '$2y$10$YLhYqIhakN6c9iLk9i.Ro.vEclQnuBu5.fhyZiAmsZGA5aTB/6dPO', 1, '2015-10-10 14:10:23', '0000-00-00 00:00:00', '', NULL, NULL, '', NULL, NULL),
(30, 'jonathanyoung11@gmail.com', 'JONATHAN', 'YOUNG', '$2y$10$57jF1GA3GqHPut1BzwmXAuUfg4aKdoYApk5ZxlmAyqCkc4sLP3vH6', 1, '2015-08-04 22:34:25', '2015-08-05 10:43:13', 'ertu2VzxSNx7e3Np6CO0EjnyiNfQh40LGHBOdPtBgkSfPy3LhKDaJQivZun7', NULL, NULL, '', NULL, NULL),
(43, 'jsgilmor@primus.ca', 'James', 'Gilmor', '$2y$10$4Ipz8c7hThn5.7B/B4Etfee7qkE0HCHgmMoONqrLmQD1lSkZD49U2', 1, '2015-11-04 00:41:21', '0000-00-00 00:00:00', '', NULL, NULL, '', NULL, NULL),
(45, 'julienouimet@gmail.com', 'Julien', 'Ouimet', '$2y$10$ipZ0M.jE5FE4LwBMeqPCVuvi7r4ORbPxJVS91qZG01gVDcmi3SJsK', 1, '2016-03-03 23:31:14', '0000-00-00 00:00:00', '', NULL, NULL, '', NULL, NULL),
(36, 'Kelsey@kommunitykonsulting.ca', 'Kelsey', 'Kashluba', '$2y$10$SOuoS9Yx51jds0KAARDzk.VeC6Yzj/S62v/UyAzzTWjQKJ5WIcjGa', 1, '2015-09-28 23:15:18', '0000-00-00 00:00:00', '', NULL, NULL, '', NULL, NULL),
(28, 'Kulendiren2509@gmail.com', 'Pon', 'Kulendiren', '$2y$10$8zkZTQZ3rZrjMSsfC/WeUekuSuXXiRL1upgTOEHlNPHe1Mw73AmEi', 1, '2015-07-07 18:39:35', '0000-00-00 00:00:00', '', NULL, NULL, '', NULL, NULL),
(1, 'leebodyj@amplbooks.com', 'Jamie', 'Leebody', '$2y$10$kkAwT0XVuqx.es9qFTFWx.0r1hnng7EAzxOa2VVNHgJxYX2E65K5i', 7, '2015-01-15 13:00:00', '2016-04-13 09:51:04', '6UCqYMMrkTobHZVR3sfEN5kCWPZm3QLU9ESD32hhnwnY3k2NYYnQnkmDHnxj', '2015-01-24 07:13:05', '', '', NULL, NULL),
(32, 'lynnworthington@rogers.com', 'Lynn', 'Worthington', '$2y$10$dyuqSA5nbLGkaex/kzT9geLdq.2/Na8nGMtXWY49gE3VsjLZkLgw2', 2, '2015-09-11 02:57:41', '2015-10-05 23:04:19', 'jPqA5OOkA81O2rs8vMf4KqyXDBk6o0jgsuqUhrOoLdVm7IGoUHbWYmRSYwHO', NULL, '', '', NULL, NULL),
(42, 'magic-pete@hotmail.com', 'Peter', 'Di Lisi', '$2y$10$KRauX4KiUYC3C57FiWxHmevEo8ZMYkkX/vVi/Ocsny8mLhdi5sAnq', 1, '2015-10-26 19:22:49', '0000-00-00 00:00:00', '', NULL, NULL, '', NULL, NULL),
(34, 'monkeyville123@gmail.com', 'Rachelle', 'Gallant', '$2y$10$uJhZka9wKBY5DU4O9GrkQeew7nVBtDlc2wZbeeIVKYZdeFK9OBbhi', 1, '2015-09-17 17:01:25', '0000-00-00 00:00:00', '', NULL, NULL, '', NULL, NULL),
(31, 'pmphoto@porchlight.ca', 'Sally', 'Carter', '$2y$10$WYO.2IC2isEet6iqvimeke8ug7ZaycOg5uFV0EcnWDpi30QdPn.Ku', 1, '2015-08-17 17:48:28', '2015-08-28 20:23:36', 'Hko91hAYGqsJyoi9tURGjJAQgsmHMLKvuoM0nhsP5NYfFJaNs05Diq4G5Z5V', NULL, NULL, '', NULL, NULL),
(33, 'rob@thomaspontiac.com', 'Rob', 'Nicholas', '$2y$10$h6GvadtaA3JkTCYZ1sLVLuruKo0SLFWQUsGvKWnPQ2gbjTY6K.18C', 1, '2015-09-16 18:27:29', '0000-00-00 00:00:00', '', NULL, NULL, '', NULL, NULL),
(3, 'skryba@hotmail.com', 'Emanuel', 'Silva', '$2y$10$FFBe6Z2RVu1ZIJqOicC6puvEYOHHAYM0Z5oVMMLtZK2gZK9DshLPm', 2, '2015-05-31 23:28:37', '2015-06-25 11:01:46', 'bwyr1fEOh1Yo3TBimTqYYA5XAeTmUKabHx9AAFdUiP6unGWToLcohsa0XqBQ', NULL, '', '', NULL, NULL),
(29, 'tj.kechego@gmail.com', 'Thalia', 'Kechego', '$2y$10$KWALFg88f.ZJHPMy1hn7k.ftGiqHJwwybH/Ft.QCNvj1ti8R7BX/u', 1, '2015-08-01 22:23:12', '0000-00-00 00:00:00', '', NULL, NULL, '', NULL, NULL),
(25, 'tomdavison12@gmail.com', 'tomdfdf', 'davvdfdfdf', '$2y$10$6ixQo9w.m6B7pHHs1V7WquOUv9JXxm5y8b..lKN3KwYuZ7tGZ.nlq', 1, '2015-06-02 20:49:52', '2016-04-13 08:03:53', 'edhs179fGTB5aWyCFapm6IUX04QGKzOBJA6NnACNpl4VHsmws2fy4TWQL0k3', NULL, NULL, '', '10155063971375241', NULL),
(26, 'tomdavison12@hotmail.com', 'thomas', 'davison', '$2y$10$datrVWH8ZpYsyv.RFwYPX..2MYSg8vV7M1rsP9FQzrcnno3Hcdbo6', 1, '2015-06-02 21:06:13', '2015-06-03 05:23:32', 'NMv6rF0VASt7GsBkLOWw11f8MKEDNX4bkV7fhCTTA4rTtk3lNJ1j5lYcRCGm', NULL, NULL, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_invoice`
--

DROP TABLE IF EXISTS `user_invoice`;
CREATE TABLE IF NOT EXISTS `user_invoice` (
  `sale_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(80) NOT NULL,
  `type_id` smallint(6) NOT NULL DEFAULT '0',
  `sold_on` timestamp NULL DEFAULT NULL,
  `access_until` datetime DEFAULT NULL,
  `amount` decimal(4,2) NOT NULL,
  PRIMARY KEY (`sale_id`,`book_id`,`type_id`),
  KEY `book_id` (`book_id`),
  KEY `type_id` (`type_id`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_invoice`
--

INSERT INTO `user_invoice` (`sale_id`, `book_id`, `email`, `type_id`, `sold_on`, `access_until`, `amount`) VALUES
(1, 1, 'leebodyj@amplbooks.com', 3, '2015-06-02 00:56:25', '2015-07-31 17:56:25', '4.00'),
(3, 1, 'leebodyj@amplbooks.com', 3, '2015-06-02 20:37:30', '2015-08-01 13:37:30', '4.00'),
(4, 1, 'tomdavison12@gmail.com', 3, '2015-06-02 20:52:23', '2017-08-31 13:52:23', '4.00'),
(5, 1, 'tomdavison12@hotmail.com', 3, '2015-06-02 21:07:24', '2015-08-01 14:07:24', '4.00'),
(6, 1, 'leebodyj@amplbooks.com', 3, '2015-06-10 03:02:25', '2015-08-08 20:02:25', '4.00'),
(7, 1, 'jonathanyoung11@gmail.com', 4, '2015-08-04 07:00:00', '2015-10-03 00:00:00', '0.00'),
(8, 7, 'rob@thomaspontiac.com', 3, '2015-09-16 18:33:05', '2015-11-15 11:33:05', '5.00'),
(9, 7, 'monkeyville123@gmail.com', 3, '2015-09-17 17:02:34', '2015-11-16 10:02:34', '5.00'),
(10, 8, 'jsgilmor@primus.ca', 3, '2015-11-04 00:45:41', '2016-01-02 16:45:41', '5.00');

--
-- Triggers `user_invoice`
--
DROP TRIGGER IF EXISTS `test_trigger`;
DELIMITER $$
CREATE TRIGGER `test_trigger` BEFORE INSERT ON `user_invoice` FOR EACH ROW BEGIN

SET
    NEW.sold_on = IFNULL(NEW.sold_on,NOW()),
    NEW.access_until= TIMESTAMPADD(DAY,60,NEW.sold_on);



END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_payment`
--

DROP TABLE IF EXISTS `user_payment`;
CREATE TABLE IF NOT EXISTS `user_payment` (
  `email` varchar(80) NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `amount` decimal(11,0) NOT NULL,
  `description` varchar(200) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`payment_id`),
  UNIQUE KEY `payment_id` (`payment_id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `role_id` tinyint(4) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`role_id`, `description`) VALUES
(1, 'Customer'),
(2, 'Author'),
(3, 'Editor'),
(7, 'Administrator');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `book_status` (`status_id`);

--
-- Constraints for table `book_comment`
--
ALTER TABLE `book_comment`
  ADD CONSTRAINT `book_comment_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_comment_ibfk_2` FOREIGN KEY (`email`) REFERENCES `user` (`email`);

--
-- Constraints for table `book_comment_opinion`
--
ALTER TABLE `book_comment_opinion`
  ADD CONSTRAINT `book_comment_opinion_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`),
  ADD CONSTRAINT `book_comment_opinion_ibfk_2` FOREIGN KEY (`comment_id`) REFERENCES `book_comment` (`comment_id`) ON DELETE CASCADE;

--
-- Constraints for table `paper`
--
ALTER TABLE `paper`
  ADD CONSTRAINT `paper_ibfk_1` FOREIGN KEY (`paper_type`) REFERENCES `paper_type` (`paper_type`),
  ADD CONSTRAINT `paper_ibfk_2` FOREIGN KEY (`paper_usage`) REFERENCES `paper_usage` (`paper_usage`);

--
-- Constraints for table `news_comment`
--
ALTER TABLE `news_comment`
  ADD CONSTRAINT `news_comment_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news_post` (`news_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `news_comment_ibfk_2` FOREIGN KEY (`email`) REFERENCES `user` (`email`);

--
-- Constraints for table `news_comment_opinion`
--
ALTER TABLE `news_comment_opinion`
  ADD CONSTRAINT `news_comment_opinion_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `news_comment` (`comment_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `news_comment_opinion_ibfk_2` FOREIGN KEY (`email`) REFERENCES `user` (`email`);

--
-- Constraints for table `user_invoice`
--
ALTER TABLE `user_invoice`
  ADD CONSTRAINT `user_invoice_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`),
  ADD CONSTRAINT `user_invoice_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`),
  ADD CONSTRAINT `user_invoice_ibfk_3` FOREIGN KEY (`type_id`) REFERENCES `book_type` (`type_id`);

--
-- Constraints for table `user_payment`
--
ALTER TABLE `user_payment`
  ADD CONSTRAINT `user_payment_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
