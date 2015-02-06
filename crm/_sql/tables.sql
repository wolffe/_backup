-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 08, 2011 at 10:06 AM
-- Server version: 5.1.46
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE IF NOT EXISTS `attachments` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `attachment` text COLLATE latin1_general_ci NOT NULL,
  `itemid` int(11) NOT NULL,
  UNIQUE KEY `aid` (`aid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=40 ;

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`aid`, `attachment`, `itemid`) VALUES
(11, 'atdsmttnyq4.jpg', 0),
(12, 'be56bdb4fd3bca5de4352c8.jpg', 11),
(13, 'atdsmttnyq4.jpg', 3220),
(14, 'be56bdb4fd3bca5de4352c8.jpg', 3220),
(15, '4ca1c0759d66aaframe.htm', 3221),
(16, '4ca1c0759dcfclogo.png', 3221),
(17, '4ca1c0759e3fbrss.gif', 3221),
(18, '4ca1c0759ff2agp_snake01.jpg', 3221),
(19, '4ca1c0a8ba30faframe.htm', 3222),
(20, '4ca1c0a8ba9c4logo.png', 3222),
(21, '4ca1c0a8bb1aerss.gif', 3222),
(22, '4ca1c0a8bb709gp_snake01.jpg', 3222),
(23, '4ca1c51b6e8a0pariazasigur.gif', 1),
(37, '', 3224),
(31, '', 3223);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `categoryname` text COLLATE latin1_general_ci NOT NULL,
  KEY `cid` (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=52 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cid`, `categoryname`) VALUES
(3, 'programmer'),
(4, 'painter'),
(7, 'electrician'),
(8, 'mechanic'),
(9, 'metal locksmith'),
(11, 'driver'),
(12, 'locksmiths'),
(13, 'welder'),
(15, 'carpenter'),
(16, 'heat insulator'),
(17, 'smelter'),
(18, 'blacksmith concreter'),
(21, 'drywall mechanic'),
(22, 'bricklayer '),
(24, 'economist'),
(27, 'lawyer'),
(29, 'builder'),
(30, 'engineer'),
(31, 'electromechanical'),
(33, 'woodworking operator'),
(35, 'labourer'),
(36, 'technician'),
(48, 'locksmith'),
(42, 'shipbuilding locksmith'),
(43, 'locksmith fitter aggregate'),
(44, 'plumber'),
(46, 'electronist'),
(47, 'waterproof insulator'),
(49, 'sandblaster'),
(50, 'craner'),
(51, 'machinist tools');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE latin1_general_ci NOT NULL,
  `lastname` text COLLATE latin1_general_ci NOT NULL,
  `birthdate` date NOT NULL,
  `email` text COLLATE latin1_general_ci NOT NULL,
  `address` text COLLATE latin1_general_ci NOT NULL,
  `address2` text COLLATE latin1_general_ci NOT NULL,
  `location` text COLLATE latin1_general_ci NOT NULL,
  `county` text COLLATE latin1_general_ci NOT NULL,
  `country` text COLLATE latin1_general_ci NOT NULL,
  `ci` text COLLATE latin1_general_ci NOT NULL,
  `phone` text COLLATE latin1_general_ci NOT NULL,
  `mobile` text COLLATE latin1_general_ci NOT NULL,
  `available` date NOT NULL,
  `diplomas` text COLLATE latin1_general_ci NOT NULL,
  `lastworkplace` text COLLATE latin1_general_ci NOT NULL,
  `driverlicense` text COLLATE latin1_general_ci NOT NULL,
  `category` tinyint(3) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `currentworkplace` text COLLATE latin1_general_ci NOT NULL,
  `description` text COLLATE latin1_general_ci NOT NULL,
  `notes` text COLLATE latin1_general_ci NOT NULL,
  `photo` text COLLATE latin1_general_ci NOT NULL,
  `resume` text COLLATE latin1_general_ci NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3530 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `lastname`, `birthdate`, `email`, `address`, `address2`, `location`, `county`, `country`, `ci`, `phone`, `mobile`, `available`, `diplomas`, `lastworkplace`, `driverlicense`, `category`, `status`, `currentworkplace`, `description`, `notes`, `photo`, `resume`) VALUES
(3528, 'Jared', 'Eckhart', '1969-02-10', 'jared_1087@gmail.com', '26 Last House on the Left', '', 'London', '', '', '0012311', '0727465699', '057 8674315', '2011-02-28', 'programmer', 'Microsoft Corp.', 'No', 3, 2, 'M.I.T.', '', '', 'a4d9ebb74881ebdaniel-samantha-thumb.jpg', ''),
(3529, 'Patti', 'Smith', '1969-02-12', 'patti@worldrecords.org', 'Phoenix Rd.', '', 'Atlanta', '', '', '0027109', '+40721558238', '066 7121200', '2011-02-20', 'singer, punker, icon', 'Garbage', 'Yes', 11, 2, 'Atomic Records', '', '', '', ''),
(3527, 'John', 'Lassiter', '2011-02-17', 'john.lassiter@linkedin.com', '56 Red Hill Street', '', 'Ohio', '', '', '0027348', '0034772582', '0034772583', '2011-02-26', 'welder, tinsmith, sandblaster', 'Nordik Worx', 'Yes', 15, 2, 'Nordik Worx', 'A nice guy, strong and workaholic.', '', 'a4d9ebb5d83a5falex-actor-headshots-theater-model-eugene-oregon-1.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `phpmysqlautobackup`
--

CREATE TABLE IF NOT EXISTS `phpmysqlautobackup` (
  `id` int(11) NOT NULL,
  `version` varchar(6) COLLATE latin1_general_ci DEFAULT NULL,
  `time_last_run` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `phpmysqlautobackup`
--

INSERT INTO `phpmysqlautobackup` (`id`, `version`, `time_last_run`) VALUES
(1, '1.5.5', 1302248551);

-- --------------------------------------------------------

--
-- Table structure for table `phpmysqlautobackup_log`
--

CREATE TABLE IF NOT EXISTS `phpmysqlautobackup_log` (
  `date` int(11) NOT NULL,
  `bytes` int(11) NOT NULL,
  `lines` int(11) NOT NULL,
  PRIMARY KEY (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `phpmysqlautobackup_log`
--

INSERT INTO `phpmysqlautobackup_log` (`date`, `bytes`, `lines`) VALUES
(1298907632, 32208, 82),
(1302222149, 32024, 81),
(1302248551, 10467, 63),
(1298907168, 32105, 81),
(1298907198, 32208, 82);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `salt` varchar(3) COLLATE latin1_general_ci NOT NULL,
  `username` text COLLATE latin1_general_ci NOT NULL,
  `password` text COLLATE latin1_general_ci NOT NULL,
  `email` text COLLATE latin1_general_ci NOT NULL,
  `rank` int(11) NOT NULL,
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `salt`, `username`, `password`, `email`, `rank`) VALUES
(1, 'abc', 'demo', 'demo', 'email@example.com', 0),
(8, '', 'newuser', 'newuser', '', 1);
