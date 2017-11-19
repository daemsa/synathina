-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2017 at 02:42 PM
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
-- Table structure for table `cemyx_emails`
--

CREATE TABLE IF NOT EXISTS `cemyx_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  `from_name` varchar(100) NOT NULL,
  `from_email` varchar(200) NOT NULL,
  `to_email` varchar(300) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `email_title` varchar(150) NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `cemyx_emails`
--

INSERT INTO `cemyx_emails` (`id`, `type`, `from_name`, `from_email`, `to_email`, `subject`, `email_title`, `body`) VALUES
(1, 'team_activate', '', '', '', 'ενεργοποίηση ομάδας', '', 'κείμενο ενεργοποίησης ομάδας'),
(2, 'open_call_user', 'Συναθηνά', 'info@synathina.gr', '', 'To open call σας έχει καταχωριστεί στο www.synathina.gr', 'Open Call', '<p>Το open call σας έχει καταχωριστεί με επιτυχία στην παρακάτω διεύθυνση:<br /><a href="%s1">%s1</a></p>\r\n<p>Εάν θέλετε να επεξεργαστείτε το open call για να προσθέσετε ενεργούς συνδέσμους ή να αλλάξετε τα στοιχεία του, μπορείτε να κάνετε κλικ στο "Επεξεργασία open calls" που βρίσκεται στο "O λογαριασμός μου".</p>\r\n<p>Σας ευχαριστούμε που επιλέξατε την πλατφόρμα του συνΑθηνά για τη δημοσίευση του του open call σας.</p>\r\n<p>Η ομάδα του συνΑθηνά.</p>\r\n'),
(3, 'open_call_admin', 'Συναθηνά', 'info@synathina.gr', 'synathinaplatform@gmail.com', 'Νέο open call στο www.synathina.gr', 'Open Call', '<p>Ένα νέο open call έχει καταχωριστεί στην ιστοσελίδα του συνΑθηνά.</p>\n<p><a href="%s1">%s1</a></p>\n<p>Εάν θέλετε να κάνετε ανάκληση πιέστε <a href="%s2">εδώ</a>.</p>'),
(4, 'body_head', '', '', '', '', '', '<body style="margin:0px auto; padding:0px; background-color:#FFFFFF; color:#5d5d5d; font-family:Arial; outline:none; font-size:12px;" bgcolor="#FFFFFF">\n								<div style="background-color:#FFFFFF;margin:0px auto; font-family:Arial;color:#5d5d5d;">\n									<div style="margin:0px auto; width:640px; text-align:left; background-color:#ebebeb; font-family:Arial; padding:20px;color:#5d5d5d;">\n									<div style="font-size: 18px;font-weight:bold; color:#05c0de;padding-bottom: 10px;">Open Call</div>'),
(5, 'body_footer', '', '', '', '', '', '</div></div></body>'),
(6, 'team_created_user', '', '', '', 'Το αίτημά σας για εγγραφή στο www.synathina.gr καταχωρίστηκε', 'Αίτημα Εγγραφής', '<p>Το αίτημά σας για εγγραφή στην ιστοσελίδα του συνΑθηνά έχει καταχωριστεί. Εντός 48 ωρών θα ενημερωθείτε με νέο μήνυμα για την ενεργοποίηση του λογαριασμού σας.</p>\r\n<p>Σας ευχαριστούμε</p>\r\n<p>Η ομάδα του συνΑθηνά</p>\r\n'),
(7, 'team_created_admin', '', '', 'synathinaplatform@gmail.com', 'Nέος χρήστης στο www.synathina.gr', 'Αίτημα Εγγραφής', '<p>Ελέγξτε το προφίλ του <a href="%s1" target="_blank">εδώ</a> και στη συνέχεια επιλέξτε δημοσίευση.</p>'),
(8, 'team_activated_user', '', '', '', 'Καλώς ήρθατε στο www.synathina.gr!', 'Ο Λογαριασμός σας ενεργοποιήθηκε', '<p>Ο λογαριασμός σας στην ιστοσελίδα του συνΑθηνά έχει ενεργοποιηθεί. Τώρα μπορείτε να δημοσιεύετε τις δράσεις σας, να διασυνδέεστε ηλεκτρονικά με άλλες ομάδες που συμμετέχουν στην ψηφιακή πλατφόρμα του συνΑθηνά, να κάνετε online κράτηση στη στέγη του συνΑθηνά και να ανεβάζετε ανοιχτές προσκλήσεις.</p><p>Για οποιαδήποτε διευκρίνιση είμαστε στη διάθεσή σας στο synathina@athens.gr ή τηλεφωνικά στο 210 5277523.</p>\r\n<p>Σας ευχαριστούμε</p>\r\n<p>Η ομάδα του συνΑθηνά</p>\r\n'),
(9, 'action_created_municipality', '', '', '', 'Αίτημα προς το δήμο Αθηναίων από ομάδα - χρήστη του www.synathina.gr', 'Αίτημα από ομάδα - χρήστη του συνΑθηνά', '<p>Η ομάδα πολιτών <a href="%s1" target="_blank">%s2</a> που συμμετέχει στην ψηφιακή πλατφόρμα του συνΑθηνά του δήμου Αθηναίων έχει υποβάλει το ακόλουθο αίτημα για:</p>\r\n<p>%s3</p>\r\n<p>"%s4"</p>\r\n<p>Περισσότερες πληροφορίες για τη δράση της ομάδας %s2 μπορείτε να διαβάσετε <a href="%s5" target="_blank">εδώ</a>. </p>\r\n<p>Για να κάνετε διευκρινιστικές ερωτήσεις ή για να ενημερώσετε τον χρήστη για την εξέλιξη του αιτήματός του χρησιμοποιήστε τα παρακάτω στοιχεία επικοινωνίας.</p>\r\n<p>%s6</p>\r\n<p>Για οποιαδήποτε άλλη πληροφορία, μπορείτε να επικοινωνήσετε με την ομάδα του συνΑθηνά στο synathina@athens.gr και στο 2105277523.</p>\r\n<p>Σας ευχαριστούμε για την προσοχή σας</p>\r\n<p>Η ομάδα του συνΑθηνά</p>'),
(10, 'action_created_supporters', '', '', '', 'Αίτημα για υποστήριξη από ομάδα πολιτών που συμμετέχει στο συνΑθηνά', 'Παράκληση για υποστήριξη', '<p>Σας ενημερώνουμε ότι η ομάδα <a href="%s1" target="_blank">%s2</a> έχει ζητήσει υποστήριξη για τη δράση της σε %s3.</p>\r\n<p>Αυτό είναι το μήνυμα της ομάδας προς τους υποστηρικτές:</p>\r\n<p>%s4</p>\r\n<p>Περισσότερες πληροφορίες για τη δράση της ομάδας %s2 μπορείτε να διαβάσετε εδώ <a href="%s5" target="_blank">%s6</a></p>\r\n<p>Εάν θέλετε να υποστηρίξετε τη συγκεκριμένη δράση, μπορείτε να επικοινωνήσετε με τον/την %s7 στο email %s8 και στο τηλέφωνο %s9.</p>\r\n<p>Σας ευχαριστούμε</p>'),
(11, 'action_created_user_confirmed', '', '', '', 'Η δράση σας έχει καταχωριστεί στο www.synathina.gr', 'Επιτυχής καταχώριση δράσης', '<p>Αγαπητέ χρήστη,</p><p>Η δράση σας έχει καταχωριστεί με επιτυχία στο www.synathina.gr. Μπορείτε να επεξεργαστείτε ξανά τα στοιχεία της δράσης σας από τον πίνακα ελέγχου του προφίλ σας.</p>\r\n%s1\r\n%s2\r\n%s3\r\n<p>Σας ευχαριστούμε</p>\r\n<p>Η ομάδα του συνΑθηνά</p>\r\n'),
(12, 'action_created_admin', '', '', 'synathinaplatform@gmail.com', 'Νέα δράση στο www.synathina.gr', 'Νέα Δράση', '<p>Μια νέα δράση έχει υποβληθεί στο www.synathina.gr από την ομάδα %s1.</p>\r\n<p><a href="%s2" target="_blank">%s3</a></p>\r\n<p>Για να εγκρίνετε τη δράση συνδεθείτε ως διαχειριστής στο site και επεξεργαστείτε τη δράση από εδώ: <a href="%s4" target="_blank">εδώ</a>.</p>'),
(13, 'action_cancelled_user', '', '', '', 'Έχει γίνει ανάκληση της δράσης σας στο www.synathina.gr', 'Ανάκληση δράσης', '<p>H δράση σας με τίτλο "%s1" δεν εμφανίζεται πλέον στην ιστοσελίδα του συνΑθηνά.</p>\r\n<p>Παρακαλούμε επικοινωνήστε με την ομάδα του συνΑθηνά στο synathina@athens.gr ή τηλεφωνικά, στο 2105277521.</p>\r\n<p>Σας ευχαριστούμε</p>\r\n<p>Η ομάδα του συνΑθηνά</p>\r\n'),
(14, 'stegi_created_admin', '', '', 'synathinaplatform@gmail.com', 'Νέα συνάντηση στη στέγη του συνΑθηνά', 'Συνάντηση στη Στέγη του συνΑθηνά', 'Η ομάδα "%s1" έχει κλείσει τη στέγη του συνΑθηνά από την %s2 έως την %s3. '),
(15, 'stegi_action_created_admin', '', '', 'synathinaplatform@gmail.com', 'Νέα δράση στη στέγη του συνΑθηνά', 'Δράση στη στέγη του συνΑθηνά', 'Η ομάδα "%s1" έχει κλείσει τη στέγη του συνΑθηνά για τις ανάγκες της δράσης "%s2" την %s3 και ώρα από %s4 έως %s5. '),
(16, 'action_created_user_pending', '', '', '', 'Η δράση σας έχει υποβληθεί για έγκριση στο www.synathina.gr', 'Υποβολή δράσης στο συνΑθηνά', '<p>Αγαπητέ χρήστη,</p><p>Η δράση σας έχει υποβληθεί για έγκριση στο www.synathina.gr. Εντός 48 ωρών θα λάβετε ειδοποίηση για την δημοσίευση της δράσης σας.</p>\r\n<p>Σας ευχαριστούμε</p>\r\n<p>Η ομάδα του συνΑθηνά</p>\r\n'),
(17, 'action_created_user_from_root', '', '', '', 'Η δράση σας αναρτήθηκε στο www.synathina.gr', 'Ανάρτηση δράσης στο συνΑθηνά', '<p>Η δράση σας με τίτλο <a href="%s1" target="_blank">%s2</a> έχει αναρτηθεί στην ιστοσελίδα του συνΑθηνά.<br />\r\nΕάν θέλετε να επεξεργαστείτε τα στοιχεία της, μπορείτε να συνδεθείτε με τα στοιχεία του λογαριασμού σας στο www.synathina.gr και στη συνέχεια να επιλέξετε το link "Επεξεργασία Δράσεων" το οποίο βρίσκεται στη σελίδα "Ο λογαριασμός μου".</p>\r\n\r\n<p>Παραμένουμε στη διάθεσή σας για οποιαδήποτε διευκρίνιση.</p>\r\n<p>Με φιλικούς χαιρετισμούς</p>\r\n<p>Η ομάδα του συνΑθηνά</p>'),
(18, 'action_fail_admin', '', '', 'synathinaplatform@gmail.com', 'Πρόβλημα με καταχώριση δράσης στο www.synathina.gr', 'Πρόβλημα καταχώρισης δράσης', '<p>Παρουσιάστηκε σφάλμα κατά την καταχώριση  δράσης με τίτλο "%s1" από την ομάδα "%s2".</p>'),
(19, 'stegi_created_user', '', '', '', 'Νέα συνάντηση στη στέγη του συνΑθηνά', 'Κλείσατε τη στέγη του συνΑθηνά για τη συνάντησή σας', '<p>Αγαπητέ χρήστη,</p><p>Έχετε κλείσει τη στέγη του συνΑθηνά για τις ανάγκες της ομάδας σας από την %s2 έως την %s3.<br />Στα συνημμένα μπορείτε να διαβάσετε τους όρους χρήσης της στέγης τους οποίους δηλώνετε ότι αποδέχεστε ανεπιφύλακτα.</p><p>Σας ευχαριστούμε,<br />Η ομάδα του συνΑθηνά.</p> ');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
