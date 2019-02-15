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
-- Dumping data for table `paper`
--
INSERT INTO `paper_type` (`paper_type`, `paper_type_description`) VALUES
(1, 'Plain'),
(2, 'Glossy'),
(3, 'Smooth');


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
-- Dumping data for table `paper`
--
INSERT INTO `paper_usage` (`paper_usage`, `paper_usage_description`) VALUES
(1, 'Novel Cover'),
(2, 'Novel Pages'),
(3, 'Picture Book Pages');


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


--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `paper`
  ADD CONSTRAINT `paper_ibfk_1` FOREIGN KEY (`paper_type`) REFERENCES `paper_type` (`paper_type`),
  ADD CONSTRAINT `paper_ibfk_2` FOREIGN KEY (`paper_usage`) REFERENCES `paper_usage` (`paper_usage`);
