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
-- Table structure for table `cemyx_team_donation_types`
--

CREATE TABLE IF NOT EXISTS `cemyx_team_donation_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `name_en` varchar(200) NOT NULL,
  `published` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `cemyx_team_donation_types`
--

INSERT INTO `cemyx_team_donation_types` (`id`, `parent_id`, `name`, `name_en`, `published`) VALUES
(1, 0, 'Προσφορά σε είδος', 'Offering material resources', 1),
(2, 1, 'Κατασκευαστικά υλικά', 'Construction materials', 1),
(3, 1, 'Βιβλία / γραφική ύλη', 'Books / writing materials', 1),
(4, 1, 'Έπιπλα / οικιακά σκεύη', 'Furniture / household appliances', 1),
(5, 1, 'Οπτικοακουστικά μέσα', 'Visual and audio materials', 1),
(6, 1, 'Παιχνίδια', 'Toys', 1),
(7, 1, 'Ρουχισμός', 'Clothes', 1),
(8, 1, 'Σεντόνια / πετσέτες / κουβέρτες', 'Bed sheets / towels / blankets', 1),
(9, 1, 'Τεχνολογικός εξοπλισμός / εξοπλισμός για συναυλίες', 'Technological equipment / equipment for concerts', 1),
(10, 1, 'Τρόφιμα', 'Food', 1),
(11, 1, 'Υλικά καθαρισμού', 'Cleaning materials', 1),
(12, 1, 'Φάρμακα / νοσηλευτικό υλικό', 'Medicine / healthcare materials', 1),
(13, 1, 'Φυτά', 'Plants', 1),
(14, 1, 'Χώρος', 'Space', 0),
(15, 1, 'Μεταφορά', 'Transportation', 1),
(16, 0, 'Προσφορά σε τεχνογνωσία', 'Providing knowledge', 1),
(17, 16, 'Νομική υποστήριξη', 'Legal support', 1),
(18, 16, 'Λογιστική υποστήριξη', 'Accounting support', 1),
(19, 16, 'Επικοινωνία', 'Communication', 1),
(20, 16, 'Project management και οργάνωση event', 'Project management and event planning', 1),
(21, 16, 'Διαχείριση ανθρώπινων πόρων', 'Human resource management', 1),
(22, 16, 'Σύνταξη business plan και χρηματοδοτικής πρότασης', 'Compiling a business plan and a funding proposal', 1),
(23, 16, 'Χρήση Η/Υ και ψηφιακές εφαρμογές', 'Use of computers and digital applications', 1),
(24, 16, 'Αρχιτεκτονικές και τεχνικές μελέτες', 'Architectural and technical planning ', 1),
(25, 16, 'Επιλογή και χρήση τεχνικών υλικών', 'Choice and use of materials', 1),
(26, 16, 'Γραφικές τέχνες', 'Graphic design', 1),
(27, 0, 'Εθελοντές', 'Volunteering', 1),
(28, 0, 'Χρηματική χορηγία', 'Financial support', 1),
(31, 0, 'Προσφορά σε φυτά', '', 0),
(32, 0, 'Χώρος', 'Space', 1),
(33, 1, 'test', '', 0),
(34, 1, 'Test 2', '', 0),
(35, 1, 'Είδη προσωπικής υγιεινής', '', 1),
(36, 0, 'Διερμηνεία', 'Interpretation', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
