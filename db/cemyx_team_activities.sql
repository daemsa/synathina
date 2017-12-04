-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2017 at 02:47 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `synathina_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cemyx_team_activities`
--

CREATE TABLE IF NOT EXISTS `cemyx_team_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) NOT NULL,
  `name_en` varchar(200) NOT NULL,
  `image` varchar(300) NOT NULL DEFAULT 'images/activities/',
  `color` varchar(10) NOT NULL,
  `published` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `cemyx_team_activities`
--

INSERT INTO `cemyx_team_activities` (`id`, `name`, `name_en`, `image`, `color`, `published`) VALUES
(1, 'ΑΛΛΗΛΕΓΓΥΗ', 'SOLIDARITY', 'images/activities/1.png', '6da9a4', 1),
(2, 'ΠΟΛΙΤΙΣΜΟΣ', 'CULTURE', 'images/activities/2.png', 'be5d33', 1),
(4, 'ΟΙΚΟΝΟΜΙΑ', 'ECONOMY', 'images/activities/3.png', 'ab6ad1', 1),
(5, 'ΔΗΜΟΣΙΟΣ ΧΩΡΟΣ', 'PUBLIC SPACE', 'images/activities/6.png', 'ff9933', 1),
(6, 'ΠΕΡΙΒΑΛΛΟΝ', 'ENVIRONMENT', 'images/activities/4.png', '41c241', 1),
(7, 'ΤΕΧΝΟΛΟΓΙΑ', 'TECHNOLOGY', 'images/activities/7.png', '6851ff', 1),
(8, 'ΥΓΕΙΑ', 'HEALTH', 'images/activities/8.png', '1d9ee5', 1),
(9, 'ΕΚΠΑΙΔΕΥΣΗ / ΕΝΗΜΕΡΩΣΗ', 'EDUCATION / INFORMATION', 'images/activities/9.png', 'c29950', 1),
(10, 'ΤΟΥΡΙΣΜΟΣ', 'TOURISM', 'images/activities/10.png', 'd1b700', 1),
(11, 'ΠΑΙΔΙ', 'CHILDREN', 'images/activities/5.png', 'dfb0dc', 1),
(12, 'ΜΕΤΑΝΑΣΤΕΣ & ΠΡΟΣΦΥΓΕΣ', 'REFUGEES & IMMIGRANTS', 'images/activities/11.png', '6da9a4', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
