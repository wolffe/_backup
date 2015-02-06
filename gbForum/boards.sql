-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 10, 2013 at 04:41 PM
-- Server version: 5.5.31
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gbforum`
--

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE IF NOT EXISTS `forum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forum` text COLLATE latin1_general_ci NOT NULL,
  `gb_thread_title` text COLLATE latin1_general_ci NOT NULL,
  `gb_thread_id` int(11) NOT NULL,
  `gb_username` text COLLATE latin1_general_ci NOT NULL,
  `gb_message` text COLLATE latin1_general_ci NOT NULL,
  `gb_email` text COLLATE latin1_general_ci NOT NULL,
  `gb_date` text COLLATE latin1_general_ci NOT NULL,
  `gb_date_added` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gb_thread_id` (`gb_thread_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
