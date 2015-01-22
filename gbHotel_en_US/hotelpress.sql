-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 24, 2013 at 09:11 AM
-- Server version: 5.5.31
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gbhotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `hp_reservations`
--

CREATE TABLE IF NOT EXISTS `hp_reservations` (
  `reservation_id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_unit_id` int(11) NOT NULL,
  `reservation_tourist_id` int(11) NOT NULL,
  `reservation_from` date NOT NULL,
  `reservation_to` date NOT NULL,
  `gb_package` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`reservation_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `hp_reservations`
--


-- --------------------------------------------------------

--
-- Table structure for table `hp_tourists`
--

CREATE TABLE IF NOT EXISTS `hp_tourists` (
  `tourist_id` int(11) NOT NULL AUTO_INCREMENT,
  `tourist_name` text COLLATE latin1_general_ci NOT NULL,
  `tourist_contact` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`tourist_id`),
  UNIQUE KEY `tourist_id` (`tourist_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `hp_tourists`
--


-- --------------------------------------------------------

--
-- Table structure for table `hp_units`
--

CREATE TABLE IF NOT EXISTS `hp_units` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_number` int(11) NOT NULL,
  `unit_description` text COLLATE latin1_general_ci NOT NULL,
  `unit_type` int(11) NOT NULL,
  `unit_status` int(11) NOT NULL,
  PRIMARY KEY (`unit_id`),
  UNIQUE KEY `unit_id` (`unit_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `hp_units`
--


-- --------------------------------------------------------

--
-- Table structure for table `hp_unit_types`
--

CREATE TABLE IF NOT EXISTS `hp_unit_types` (
  `unit_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_type` text COLLATE latin1_general_ci NOT NULL,
  UNIQUE KEY `unit_type_id` (`unit_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `hp_unit_types`
--

INSERT INTO `hp_unit_types` (`unit_type_id`, `unit_type`) VALUES
(1, 'Simple'),
(2, 'Double'),
(4, 'Suite');
