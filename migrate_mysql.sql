-- IMPORT TABLE
--ALTER TABLE `cemyx_emails` ADD `email_title` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `subject`;

-- Synathina - ACCMR database
-- MOVE tables actions, teams, stegihours here
-- delete from original databases all assetes with #__actions, #__teams, #__stegihours
-- zero value to all asset_id
DELETE FROM `cemyx_assets` WHERE name LIKE '#__actions%';
ALTER TABLE `cemyx_actions` ADD `origin` TINYINT NOT NULL DEFAULT '1' AFTER `action_id`;
ALTER TABLE `cemyx_actions` ADD `accmr_team_id` INT NOT NULL DEFAULT '0' AFTER `team_id`;
ALTER TABLE `cemyx_actions` ADD `remote` TINYINT NOT NULL DEFAULT '0' AFTER `origin`;

--ALTER TABLE `cemyx_stegihours` ADD `origin` SMALLINT NOT NULL AFTER `accmr_team_id`;



DROP TABLE IF EXISTS `cemyx_team_donation_types`;
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
(1, 0, 'Προσφορά σε είδος/υπηρεσία', ' In-kind support (Goods & Services)', 1),
(2, 1, 'Κατασκευαστικά υλικά', 'Construction materials', 1),
(3, 1, 'Βιβλία / γραφική ύλη', 'Books/Stationery', 1),
(4, 1, 'Έπιπλα / οικιακά σκεύη', 'Furniture/Homeware', 1),
(5, 1, 'Οπτικοακουστικά μέσα', 'Audiovisual material', 1),
(6, 1, 'Παιχνίδια', 'Toys', 1),
(7, 1, 'Ρουχισμός', 'Clothing', 1),
(8, 1, 'Σεντόνια / πετσέτες / κουβέρτες', 'Sheets/towels/blankets', 1),
(9, 1, 'Τεχνολογικός εξοπλισμός / εξοπλισμός για συναυλίες', 'Technological equipment / equipment for concerts', 1),
(10, 1, 'Τρόφιμα', 'Food', 1),
(11, 1, 'Υλικά καθαρισμού', 'Cleaning products', 1),
(12, 1, 'Φάρμακα / νοσηλευτικό υλικό', 'Medicines and Nursing products', 1),
(13, 1, 'Φυτά', 'Plants', 1),
(14, 1, 'Χώρος', 'Space', 0),
(15, 1, 'Μεταφορά', 'Transportation', 1),
(16, 0, 'Προσφορά σε τεχνογνωσία', 'Know-how', 1),
(17, 16, 'Νομική υποστήριξη', 'Legal support', 1),
(18, 16, 'Λογιστική υποστήριξη', 'Accounting support', 1),
(19, 16, 'Επικοινωνία', 'Communication', 1),
(20, 16, 'Project management και οργάνωση event', 'Project management and Events organization', 1),
(21, 16, 'Διαχείριση ανθρώπινων πόρων', 'Human resource management', 1),
(22, 16, 'Σύνταξη business plan και χρηματοδοτικής πρότασης', 'Business plan and Funding proposal development', 1),
(23, 16, 'Χρήση Η/Υ και ψηφιακές εφαρμογές', 'Computer and Technological applications', 1),
(24, 16, 'Αρχιτεκτονικές και τεχνικές μελέτες', 'Architecture and Construction counseling', 1),
(25, 16, 'Επιλογή και χρήση τεχνικών υλικών', 'Choice and use of materials', 1),
(26, 16, 'Γραφικές τέχνες', 'Graphic design', 1),
(27, 0, 'Εθελοντές', 'Volunteers', 1),
(28, 0, 'Χρηματική χορηγία', 'Donation', 1),
(31, 0, 'Προσφορά σε φυτά', '', 0),
(32, 0, 'Χώρος', 'Space', 1),
(35, 1, 'Είδη προσωπικής υγιεινής', 'Personal hygiene products', 1),
(36, 1, 'Διερμηνεία-Μετάφραση', 'Interpretation/Translation', 1);




