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
  `electronic_rate` decimal(4,2) DEFAULT NULL,
  `audio_rate` decimal(4,2) DEFAULT NULL,
  `soft_rate` decimal(4,2) DEFAULT NULL,
  `hard_rate` decimal(4,2) DEFAULT NULL,
  PRIMARY KEY (`email`,`book_id`),
  KEY `book_id` (`book_id`),
  KEY `author_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`book_id`, `email`, `name_on_book`, `electronic_rate`, `audio_rate`, `soft_rate`, `hard_rate`) VALUES
(1, 'bradymarkovich@trentu.ca', 'Meena Mason', '4', '5', '6', '7'),
(2, 'anthony.walton@live.com', 'Anthony Walton', '1', '2', '3', '4');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
CREATE TABLE IF NOT EXISTS `book` (
  `book_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` text,
  `electronic_price` decimal(8,2) DEFAULT NULL,
  `audio_price` decimal(8,2) DEFAULT NULL,
  `soft_price` decimal(8,2) DEFAULT NULL,
  `hard_price` decimal(8,2) DEFAULT NULL,
  `in_text` tinyint(1) NOT NULL,
  `in_epub` tinyint(1) NOT NULL DEFAULT '0',
  `in_pdf` tinyint(1) NOT NULL DEFAULT '0',
  `in_mp3` tinyint(1) NOT NULL DEFAULT '0',
  `in_soft` tinyint(1) NOT NULL DEFAULT '0',
  `in_hard` tinyint(1) NOT NULL DEFAULT '0',
  `status_id` smallint(1) NOT NULL,
  `ISBN` varchar(17) DEFAULT NULL,
  `date_published` date DEFAULT NULL,
  `full_location` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`book_id`),
  UNIQUE KEY `ISBN` (`ISBN`),
  UNIQUE KEY `full_location` (`full_location`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`book_id`, `title`, `description`, `electronic_price`, `audio_price`, `soft_price`, `hard_price`, `in_text`, `in_epub`, `in_pdf`, `in_mp3`, `in_soft`, `in_hard`, `status_id`, `ISBN`, `date_published`, `full_location`) VALUES
(1, 'Because of a Woman', 'A dry desert, vultures circling, a man, half-dead, lashed to an oak tree, stripped down to almost nothing --  the story begins. Famous bounty-hunter, Paxton Reign, has been left for dead. It all started because of a woman --  a beautiful woman and a dangerous obsession for her. Determined to have Elizabeth Dalton for his own, Maxwell Stanton is prepared to do anything --  even kill. Believing heâ€™s no stranger to murder, Elizabeth absolutely loathes Maxwell and has branded him responsible for her fatherâ€™s sudden and mysterious disappearance. Convinced Elizabeth and Maxwell orchestrated his current excruciating predicament; Paxton curses his love for Elizabeth. Deceit, betrayal, unrequited love, and thirsts for revenge are not uncommon, as unanticipated circumstances dramatically collide to irrevocably alter lives, reveal dark secrets and open old wounds. All of this will come to pass --  because of a woman. ', '5.00', '15.00', '0.00', '0.00', 1, 1, 1, 1, 1, 1, 7, '-9878945', '2012-12-12', '4545y4564'),
(2, 'Cowboy Heart', 'When death comes knocking on Hannah Lowryâ€™s door, she plummets into the abyss of devastation, unable to cope with the loss of her beloved boyfriend. Like a tightly bundled parcel, she is shipped off to a strict boarding school in rural Colorado, where she faces the greatest isolation she has ever known. But not all is bad. Before long, she meets Ray â€“ diligent, steady and soft-spoken â€“ who teaches her some tough lessons about love and how to see death not just as an end, but also a beginning.', '5.00', '0.00', '0.00', '0.00', 0, 0, 1, 1, 1, 1, 7, '-9865645', '2010-10-10', '112e12312e112'),
(3, 'Demon''s Blood', 'Ryo goes by his days living with his adoptive parents in the small town of Lemuris.  Nearing the date of his eighteenth birthday he meets a new girl in town, whose captivating and sweet personality overcomes Ryoâ€™s defensive perspective on his surroundings.  The love is short-lived as a dark unwelcome and unavoidable destiny hangs on Ryoâ€™s shoulders; on which will change his own world as much as it will scar humanityâ€™s history forever.\r\n\r\nA world of fantasy, where celestial beings battle fallen angels and humanity is caught in the crossfire, but also a story of the real world, of the fears, the desires and the ambition that exist within each and every person that walks the world.\r\n', '5.00', '1.00', '1.00', '1.00', 1, 1, 1, 1, 1, 0, 7, '978-0-9879914-2-3', '2015-01-15', '2h3h2783h2'),
(4, 'Stay the night', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 0, 1, NULL, NULL, NULL),
(5, 'Anthonys Test Book', 'The best book youve ever seen as a tester book in your entire life. The best book youve ever seen as a tester book in your entire life. The best book youve ever seen as a tester book in your entire life. The best book youve ever seen as a tester book in your entire life. The best book youve ever seen as a tester book in your entire life. The best book youve ever seen as a tester book in your entire life. The best book youve ever seen as a tester book in your entire life. The best book youve ever seen as a tester book in your entire life. The best book youve ever seen as a tester book in your entire life. ', NULL, NULL, NULL, '25.00', 0, 0, 0, 0, 0, 1, 7, '22352352352', '2015-01-01', '325253252353252353253253252'),
(6, 'Electronic Only', 'This book has only electronic copies available. This book has only electronic copies available. This book has only electronic copies available. This book has only electronic copies available. This book has only electronic copies available. This book has only electronic copies available. This book has only electronic copies available. This book has only electronic copies available. This book has only electronic copies available. This book has only electronic copies available. This book has only electronic copies available. This book has only electronic copies available.', '7.5', NULL, NULL, NULL, 1, 1, 1, 0, 0, 0, 7, '11717117171', '2015-02-02', '8481861651518691'),
(7, 'Audio Only', 'Audio only copies for this book. Audio only copies for this book. Audio only copies for this book. Audio only copies for this book. Audio only copies for this book. Audio only copies for this book. Audio only copies for this book. Audio only copies for this book. Audio only copies for this book. Audio only copies for this book. Audio only copies for this book. Audio only copies for this book. Audio only copies for this book. Audio only copies for this book. Audio only copies for this book. Audio only copies for this book. Audio only copies for this book. Audio only copies for this book. Audio only copies for this book. ', NULL, '9', NULL, NULL, 0, 0, 0, 1, 0, 0, 7, '81635156158', '2015-04-04', '1815611312891'),
(8, 'Brad''s Too Hot To Handle Quarantine Book', 'This book should never show up on the store page because it committed several felonies and this is Canada so they''re not called felonies. But that''s how stone cold this book is. This book is currently on the run from 8 countries.','1000','1050',NULL,'1150',1,0,0,1,0,0,6,'54366653454', '2015-01-06', 'NOT TELLING');
-- --------------------------------------------------------

--
-- Table structure for table `book_comment`
--

DROP TABLE IF EXISTS `book_comment`;
CREATE TABLE IF NOT EXISTS `book_comment` (
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `rating` smallint(1) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_status` varchar(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`book_id`,`email`),
  CONSTRAINT `uq_book_comment` UNIQUE (`book_id`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book_comment`
--

INSERT INTO `book_comment` (`book_id`, `email`, `name`, `text`, `rating`, `created_on`, `comment_status`) VALUES
(1, 'bradymarkovich@trentu.ca', 'brad', 'test comment', 1, '2016-04-05 22:51:19', 'N'),
(3, 'leebodyjg@hotmail.com', 'Jamie', 'Thanks for an excellent Story. I really enjoyed the fight scenes.', 5, '2015-01-20 05:00:00', 'E');

-- --------------------------------------------------------

--
-- Table structure for table `book_editor`
--

DROP TABLE IF EXISTS `book_editor`;
CREATE TABLE IF NOT EXISTS `book_editor` (
  `book_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(80) NOT NULL,
  PRIMARY KEY (`email`,`book_id`),
  KEY `book_id` (`book_id`),
  KEY `assigned_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `book_status`
--

DROP TABLE IF EXISTS `book_status`;
CREATE TABLE IF NOT EXISTS `book_status` (
  `status_id` smallint(1) NOT NULL,
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
-- Table structure for table `news_comment`
--

DROP TABLE IF EXISTS `news_comment`;
CREATE TABLE IF NOT EXISTS `news_comment` (
  `comment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `news_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(80) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_status` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`comment_id`),
  UNIQUE KEY `comment_id` (`comment_id`),
  KEY `commenter_email` (`email`),
  KEY `news_comment_ibfk_1` (`news_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news_comment`
--

INSERT INTO `news_comment` (`comment_id`, `news_id`, `email`, `alias`, `text`, `created_on`, `comment_status`) VALUES
(4, 10, 'tomdavison12@gmail.com', 'tom', 'cvcvcvcv', '2016-04-05 22:51:19', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `news_comment_opinion`
--

DROP TABLE IF EXISTS `news_comment_opinion`;
CREATE TABLE IF NOT EXISTS `news_comment_opinion` (
  `comment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(80) NOT NULL,
  `reported` tinyint(1) NOT NULL DEFAULT '0',
  `agreed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`,`email`),
  KEY `news_comment_opinion_ibfk_2` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news_comment_opinion`
--

INSERT INTO `news_comment_opinion` (`comment_id`, `email`, `reported`, `agreed`) VALUES
(4, 'tomdavison12@gmail.com', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `news_post`
--

DROP TABLE IF EXISTS `news_post`;
CREATE TABLE IF NOT EXISTS `news_post` (
  `news_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL,
  `html` text NOT NULL,
  `created_on` date NOT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news_post`
--

INSERT INTO `news_post` (`news_id`, `title`, `html`, `created_on`) VALUES
(1, '"Because of a Woman" is Now Available in E-PUB Format', 'It is finally here! "Because of a Woman" is now available in E-Pub format. Click here to get a taste of this captivating western romance.', '2013-05-13'),
(2, 'AMPL is looking for Summer Help', 'AMPL Publishing is looking for summer contract help. If you have experience with the following: <br/><ol>\r\n\r\n        <li>Implementation of Pay Pals API protocol (called PAY PAL Integration) for transactions (using PHP)</li>\r\n\r\n        <li>html / java scripting to make the site more dynamic. Convert some documents to E-Pub format</li>\r\n\r\n        <li>Improve our SEO optimization to get higher ranks, so we come up higher on Google</li>\r\n\r\n        <li>Improve our ability to attract new e-book writers</li><ol>', '2013-07-05'),
(3, 'Thank you AMPL Readers', 'AMPL Publishing has raised 25 dollars for Feed the Need Durham. Thank you to all those who purchased a copy of our latest E-book and supported this cause.', '2013-03-13'),
(4, 'Helping Feed the Community', 'AMPL Publishing is donating a dollar from each purchase of its featured publication --  Because of a Woman by Meena Mason to Feed the Need in Durham. We at AMPL Publishing want to give back to the community, and help support those people who have difficulty finding their next meal; therefore, AMPL will donate $1 dollar from each purchase of Because of a Woman, to Feed the Need in Durham. This promotion is from December 1st, 2012 to February 28th, 2013.', '2012-12-12'),
(5, '"Because of a Woman" is on Facebook', 'Meena Mason, with the help of AMPL team has created a Facebook fan page. This is where Because of a Woman readers can stay up to date via social media. You can check this out at Because of a Woman Official Facebook fan page', '2012-11-01'),
(6, ' Cowboy Heart is now available on AMPL  ', 'Looking for an easy read? "Cowboy Heart" is now available for purchase in PDF and soon to be available in EPUB format. The first in an anticipated three book series, this captivating story is about letting go of the past and learning to take a chance on love. <br/><br/>\r\n\r\nI think every author has one book that is really close to their heart; Cowboy Heart is mine. When I read it now, at almost 23, I tend to laugh at myself and the way my perspective on certain aspects of life (love, grief, identity, etc.) has changed. Truthfully, I''m looking forward to wrapping up the series with the book I''m currently writing, and moving on to other genres and story lines.\r\n\r\n', '2014-08-22'),
(7, 'AMPL Website Version 2.0 Live      ', 'AMPL Publishing has spent the last 6 months updating its site. It is now ready for all to view. Special thanks to our programming team for all their hard work to make this site what it is today. ', '2014-08-22'),
(8, ' First Publication about AMPL   ', 'Jessica Ingold our newest AMPL author has written a publication (review) about AMPL Publishing entitled <a href="http://jessicaingold.webs.com/apps/blog/entries/show/42607097-the-little-publishing-house-that-can"> "The little publishing house that can". </a>\r\n\r\nThank you Jessica for your thoughts and very kind words about AMPL. ', '2014-09-09'),
(9, 'New AMPL Book Coming Soon ', 'Demon''s Blood by Emanuel Silva is coming soon to AMPL Publishing. Projected availability is January 2015.\r\n\r\n', '2014-10-13'),
(10, 'Demon''s Blood Now Available', 'Emanuel Silva is the newest AMPL author, and has just released <br/>\r\n"DEMON''S BLOOD ~BOOK I: Spiral of Deception~"<br/>\r\nThis Fight between Angels and Demons is now available in PDF format. ', '2015-01-15');

-- --------------------------------------------------------

--
-- Table structure for table `reset_password`
--

DROP TABLE IF EXISTS `reset_password`;
CREATE TABLE IF NOT EXISTS `reset_password` (
  `email` varchar(80) NOT NULL,
  `code` char(60) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, 
  `email` varchar(80) NOT NULL UNIQUE,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `password` char(60) NOT NULL,
  `user_type_id` smallint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `facebook_id` varchar(100) NOT NULL,
  `google_id` varchar(100) NOT NULL,
  `remember_token` varchar(250) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_ibfk_1` (`user_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`email`, `first_name`, `last_name`, `password`, `user_type_id`, `created_at`, `updated_at`, `facebook_id`, `google_id`, `remember_token`) VALUES
('bradymarkovich@trentu.ca', 'Brady', 'Markovich', '$2y$10$Kd5ZyGA8vIzlCsIQYCg0geXldDk3a9cHR8ChV/mz04mhdzKMGHgje', 2, '2015-01-22 05:00:00', NULL, '0', '0', ''),
('leebodyj@amplbooks.com', 'Jamie', 'Leebody', '$2y$10$boc/JI3JpAqu.ds5trA30u8TiWrlaCCvJNsyudvbnoDDOmkpdXzja', 7, '2015-01-15 05:00:00', '2015-01-23 23:13:05', '0', '0', ''),
('leebodyjg@hotmail.com', 'test', 'customer', '$2y$10$dSMkqhdalwrHXAN6Mc6piOkdnQiIukemeKraoH1IFMY27QHHCkwoy', 2, '2015-01-15 05:00:00', NULL, '0', '0', ''),
('tomdavison12@gmail.com', 'Thomas', 'Davison', '', 1, '2016-04-05 23:24:01', '2016-04-06 01:19:46', '10155063971375241', '', 'xxCLqlHD2sJpI2yne4QWoYda7ePmyJQ8Jxs01J30qqGip5WeQ0lm1eskWgZK'),
('anthony.walton@live.com', 'Anthony', 'Walton', '$2y$10$5HPM8hCyzrI1sG0zqAK1H.XsGi8Mwpo5BgkH05EhlHLt9v.K/VmiC', 7, '2016-04-08 14:20:12', '2016-04-08 14:20:12', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_invoice`
--

DROP TABLE IF EXISTS `user_invoice`;
CREATE TABLE IF NOT EXISTS `user_invoice` (
  `sale_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(80) NOT NULL,
  `type_id` smallint(1) NOT NULL DEFAULT '0',
  `sold_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` decimal(4,2) NOT NULL,
  PRIMARY KEY (`sale_id`,`book_id`,`type_id`),
  KEY `book_id` (`book_id`),
  KEY `type_id` (`type_id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

DROP TABLE IF EXISTS `user_type`;
CREATE TABLE IF NOT EXISTS `user_type` (
  `user_type_id` smallint(1) NOT NULL,
  `description` varchar(20) NOT NULL,
  PRIMARY KEY (`user_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`user_type_id`, `description`) VALUES
(1, 'Customer'),
(2, 'Author'),
(3, 'Editor'),
(4, 'Website Controller'),
(7, 'Administrator');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `author`
--
ALTER TABLE `author`
  ADD CONSTRAINT `author_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `author_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `book_status` (`status_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `book_comment`
--
ALTER TABLE `book_comment`
  ADD CONSTRAINT `book_comment_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_comment_ibfk_2` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `book_editor`
--
ALTER TABLE `book_editor`
  ADD CONSTRAINT `book_editor_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_editor_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE;

--
-- Constraints for table `news_comment`
--
ALTER TABLE `news_comment`
  ADD CONSTRAINT `news_comment_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news_post` (`news_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `news_comment_ibfk_2` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `news_comment_opinion`
--
ALTER TABLE `news_comment_opinion`
  ADD CONSTRAINT `news_comment_opinion_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `news_comment` (`comment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `news_comment_opinion_ibfk_2` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reset_password`
--
ALTER TABLE `reset_password`
  ADD CONSTRAINT `reset_password_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`user_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_invoice`
--
ALTER TABLE `user_invoice`
  ADD CONSTRAINT `user_invoice_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_invoice_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `book_type` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_invoice_ibfk_3` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
