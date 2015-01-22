-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 09, 2013 at 04:40 PM
-- Server version: 5.1.46
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `bmem`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `category` text CHARACTER SET utf8 COLLATE utf8_romanian_ci NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `description`) VALUES
(37, 'Land', ''),
(39, 'Rural', ''),
(38, 'Acreage', ''),
(32, 'Houses', ''),
(33, 'Apartments', ''),
(34, 'Units', ''),
(35, 'Townhouses', ''),
(36, 'Villas', ''),
(41, 'Farms', ''),
(42, 'Ranches', ''),
(43, 'Condos', ''),
(44, 'Single Family Homes', ''),
(45, 'Multi Family Homes', '');

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE IF NOT EXISTS `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `type` text NOT NULL,
  `title` text NOT NULL,
  `price` int(11) NOT NULL,
  `year` text NOT NULL,
  `location` text NOT NULL,
  `address` text NOT NULL,
  `description` text NOT NULL,
  `expire` text NOT NULL,
  `category` text NOT NULL,
  `user` text NOT NULL,
  `contact` text NOT NULL,
  `phone` text NOT NULL,
  `email` text NOT NULL,
  `url` text NOT NULL,
  `photo1` varchar(60) NOT NULL,
  `photo2` varchar(60) NOT NULL,
  `photo3` varchar(60) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=67 ;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id`, `date`, `type`, `title`, `price`, `year`, `location`, `address`, `description`, `expire`, `category`, `user`, `contact`, `phone`, `email`, `url`, `photo1`, `photo2`, `photo3`, `approved`) VALUES
(49, '05/04/2011', '2', '1 Castor Bay Road, Castor Bay', '1200000', '2000', 'Castor Bay', '', 'Tears of joy for you, the new owner. An inspiration for artists, dreamers and poets; the sun rises over Rangi as the world sleeps and you see North Head to the city, over suburbias sprawl, above the land, the harbour, the lake; you see it all. This is your home, a nest in the heavens. There will be tears- parting for the owners is such sweet sorrow but they must go, and now. Ignore all previous marketing, time is of the essence as an early offer is demanded. ', '05.5.2011', 'Apartments', 'demo', 'Ethan Saaris', '5550809', 'ethan@dominion.org', 'http://www.blogtycoon.net/', 'MJ6335-1.jpg', 'MJ6335-3.jpg', 'MJ6335-4.jpg', 1),
(48, '05/04/2011', '1', 'The Most Gorgeous Home, Bathed In Sun'', Til The Very Last Thing!', '300000', '1995', 'REMUERA', '', 'If you have been looking for a character home, built of the best materials not so long ago, in the best of positions, for the best of the sun, that will show off your much loved art and possessions to their best advantage, then this is it. As soon as you walk through the front door you can feel the ambience, the peace and the calm. The feeling that you have entered your very own private environment.The place you would rather be''.\r\n\r\nAll main living areas open out onto the private court yard, garden, outdoor living and easily maintained pool. The kitchen is the hub'' of the house. There is separate sitting or TV room, a study plus interconnecting entrance hall, formal sitting and dining. The guests bathroom includes an additional shower.\r\n\r\nFrom the entrance hall a curved staircase leads you up to the master suite including bedroom, great sized dressing room and bathroom. There are three further double bedrooms plus a third bathroom to service them. And, because the property is positioned North West'', the sun is in all the main rooms till the very last of the day''.\r\n\r\nSituated down a private right of way, with the security of a fully walled'' garden, in one of the best streets in Remuera this really is a rare find. ', '05.5.2011', 'Apartments', 'demo', 'Ethan Saaris', '5550809', 'ethan@dominion.org', 'http://www.blogtycoon.net/', 'RMU20660-1.jpg', 'RMU20660-3.jpg', 'RMU20660-9.jpg', 1),
(45, '05/04/2011', '1', '3 Wedgewood Grove, Raumati Beach', '60000', '2006', 'Raumati Beach', '3 Wedgewood Grove, Raumati Beach', 'Our sellers only have a small window of opportunity to take up a transfer to the "City of Sails" with their work and require the sale of their meticulously restored villa (circa 1900).\r\n\r\nLocated in a quiet and leafy part of Raumati and centrally situated to schools, transport and shops. Put your family here and enjoy all the benefits of a year round holiday on the Kapiti Coast. Featuring all the ''mod cons'', four double bedrooms, big enough for a party, master with ensuite, gracious lounge and reception area, modern kitchen with separate laundry, and all centrally heated. There;s room for the caravan or boat and even a real mans garage.\r\n\r\nDesigned to enjoy the Kapiti Coast lifestyle, the expansive decking and verandahs are big enough to accommodate any occasion. With time being of the essence, this is a must view. ', '05.10.2011', 'Houses', 'demo', 'Ethan Saaris', '5550809', 'ethan@dominion.org', 'http://www.blogtycoon.net/', 'PR11453-1.jpg', 'PR11453-6.jpg', 'PR11453-9.jpg', 1),
(46, '05/04/2011', '1', '154 Evans Road, PAPAMOA', '140000', '1998', 'PAPAMOA', '', 'Owners need to move to Auckland urgently so have put their much loved family home, complete with in ground swimming pool and triple car garaging on the market. Recently re-clad with a cavity system and a code of compliance this home has five bedrooms, or four bedrooms plus a study, two bathrooms, and two lounges. Sunny living areas open out to an in ground pool which has a gas heating system. Zoned for Tahatai School, this is a must see family home.', '05.5.2011', 'Houses', 'demo', 'Ethan Saaris', '5550809', 'ethan@dominion.org', 'http://www.blogtycoon.net/', 'LJH18UAGSQ-1.jpg', 'LJH18UAGSQ-20.jpg', 'LJH18UAGSQ-2.jpg', 1),
(47, '05/04/2011', '2', 'Mortgage Sale- Magnificence By The Sea', '300000', '2002', 'WHANGAPARAOA', '', 'Proudly sitting on a prime site in the fabulous Gulf Harbour, this prestigious home boasts a myriad of features that will impress.\r\nFrom the landscaped outdoors the panoramic180 degree views of the Gulf and Rangitoto Island are spectacular. Indoors from most rooms these uninterrupted views are your own ever changing vista. Couple this with the natural surround sound of the birdlife from the reserve which borders this cliff top property and you have magnificence by the Sea!\r\n\r\n4 bedrooms 4 bathrooms spread over two separate wings in this ''seaside'' home. On upper levels two of the four bedrooms both have ensuites and private balconies that enjoy those sights and sounds. An office area and great storage mean that there is room for your family and for guests. Central to the spacious, separate living areas is a great kitchen, well lit with superb bench space and an awesome oven: here functionality meets style. Enjoy dining from the kitchen or in the separate dining room. Separate family room and lounge mean that there is space for every one. Acess to the large private courtyard and gazebo is seamless from the kitchen and living area making outdoor dining and entertaining a treat for all. ', '05.7.2011', 'Houses', 'demo', 'Ethan Saaris', '5550809', 'ethan@dominion.org', 'http://www.blogtycoon.net/', 'PPK21051-1.jpg', 'PPK21051-2.jpg', 'PPK21051-5.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) NOT NULL DEFAULT '0',
  `rating` int(11) NOT NULL DEFAULT '0',
  `users_ip` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `image_id`, `rating`, `users_ip`) VALUES
(2, 0, 3, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `sid` tinyint(4) NOT NULL,
  `currency` text COLLATE latin1_general_ci NOT NULL,
  `sitetitle` text COLLATE latin1_general_ci NOT NULL,
  `email_paypal` text COLLATE latin1_general_ci NOT NULL,
  `email_notify` text COLLATE latin1_general_ci NOT NULL,
  `price` text COLLATE latin1_general_ci NOT NULL,
  `free_listing` tinyint(1) NOT NULL,
  `header_image` text COLLATE latin1_general_ci NOT NULL,
  `header_display` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`sid`, `currency`, `sitetitle`, `email_paypal`, `email_notify`, `price`, `free_listing`, `header_image`, `header_display`) VALUES
(1, 'CAD', 'Butterfly Multi Estate Manager', 'you@youremail.com', 'you@youremail.com', '1.99', 1, 'http://ns223506.ovh.net/rozne/9399cd37e436f4222a2f1012d4e5b54f/wallpaper-1432519.jpg', 9);

-- --------------------------------------------------------

--
-- Table structure for table `upload`
--

CREATE TABLE IF NOT EXISTS `upload` (
  `upload_id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_name` text COLLATE latin1_general_ci NOT NULL,
  `upload_parent` int(11) NOT NULL,
  PRIMARY KEY (`upload_id`),
  KEY `upload_parent` (`upload_parent`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `upload`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userid` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(32) COLLATE latin1_general_ci NOT NULL,
  `salt` varchar(3) COLLATE latin1_general_ci NOT NULL,
  `contact` text COLLATE latin1_general_ci NOT NULL,
  `phone` text COLLATE latin1_general_ci NOT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `url` text COLLATE latin1_general_ci NOT NULL,
  `rank` tinyint(4) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=25 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `username`, `password`, `salt`, `contact`, `phone`, `email`, `url`, `rank`) VALUES
(13, 'admin', '1234', '6,b', 'Ethan Saaris', '5550809', 'ethan@dominion.org', 'http://www.blogtycoon.net/', 1),
(21, 'Marylena', '3333333', '8B2', 'Marylena', '0762838077', '', '', 0),
(22, 'Shirley Manson', '123456', 'W,s', 'Shirley Manson', '0743154283', '', 'http://www.real-estate.co.nz/', 0),
(23, 'Agnes Sheridan', 'LOREDANA', ':oS', '', '', '', '', 0),
(24, 'Luke Jameson', 'vasile', 'EJ/', '', '', '', 'http://www.realtor.com/', 0);
