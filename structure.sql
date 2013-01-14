-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 28, 2012 at 09:29 AM
-- Server version: 5.5.22
-- PHP Version: 5.3.10-1ubuntu3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `todo`
--

-- --------------------------------------------------------

--
-- Table structure for table `contexts`
--

CREATE TABLE IF NOT EXISTS `contexts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET latin1 NOT NULL,
  `created` date NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=27 ;

--
-- Dumping data for table `contexts`
--

INSERT INTO `contexts` (`id`, `name`, `created`, `user_id`) VALUES
(6, 'dator', '2012-05-23', 5),
(25, 'penna och papper', '2012-05-30', 5),
(26, 'test', '2012-10-25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contexts_tasks`
--

CREATE TABLE IF NOT EXISTS `contexts_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `context_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=425 ;

--
-- Dumping data for table `contexts_tasks`
--

INSERT INTO `contexts_tasks` (`id`, `task_id`, `context_id`) VALUES
(39, 16, 6),
(54, 25, 6),
(55, 26, 6),
(66, 32, 6),
(70, 36, 6),
(71, 37, 6),
(74, 38, 6),
(218, 34, 6),
(224, 39, 6),
(240, 373, 6),
(247, 45, 6),
(264, 46, 6),
(283, 375, 6),
(284, 376, 6),
(288, 367, 6),
(291, 377, 6),
(293, 35, 6),
(297, 74, 6),
(324, 27, 6),
(331, 24, 6),
(332, 13, 6),
(333, 14, 6),
(334, 28, 6),
(335, 40, 6),
(336, 47, 6),
(337, 48, 6),
(338, 51, 6),
(339, 64, 6),
(340, 78, 6),
(341, 96, 6),
(342, 49, 6),
(345, 50, 6),
(346, 52, 6),
(347, 53, 6),
(349, 55, 6),
(350, 56, 6),
(351, 57, 6),
(352, 58, 6),
(353, 59, 6),
(354, 73, 6),
(357, 54, 6),
(363, 60, 6),
(364, 62, 6),
(365, 63, 6),
(366, 65, 6),
(368, 66, 6),
(369, 378, 6),
(370, 67, 6),
(371, 75, 6),
(372, 77, 6),
(373, 79, 6),
(374, 94, 6),
(375, 370, 6),
(388, 15, 6),
(389, 393, 6),
(390, 395, 6),
(391, 394, 6),
(392, 396, 6),
(399, 398, 6),
(401, 399, 6),
(406, 404, 6),
(407, 104, 6),
(409, 397, 6),
(411, 379, 6),
(413, 406, 6),
(414, 407, 6),
(415, 408, 6),
(416, 415, 6),
(417, 416, 6),
(418, 417, 6),
(419, 418, 6),
(420, 419, 6),
(421, 420, 6),
(422, 421, 6),
(423, 23, 6),
(424, 23, 26);

-- --------------------------------------------------------

--
-- Table structure for table `contexts_task_lists`
--

CREATE TABLE IF NOT EXISTS `contexts_task_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `context_id` int(11) NOT NULL,
  `task_list_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

--
-- Dumping data for table `contexts_task_lists`
--

INSERT INTO `contexts_task_lists` (`id`, `context_id`, `task_list_id`) VALUES
(52, 6, 17),
(53, 25, 17),
(61, 6, 33),
(72, 6, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET latin1 NOT NULL,
  `created` date NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=41 ;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `created`, `user_id`) VALUES
(22, 'utveckling', '2012-05-23', 5),
(40, 'design', '2012-05-30', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tags_tasks`
--

CREATE TABLE IF NOT EXISTS `tags_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=476 ;

--
-- Dumping data for table `tags_tasks`
--

INSERT INTO `tags_tasks` (`id`, `task_id`, `tag_id`) VALUES
(84, 16, 22),
(101, 25, 22),
(102, 26, 22),
(115, 32, 22),
(121, 36, 22),
(123, 37, 22),
(126, 38, 22),
(268, 34, 22),
(274, 39, 22),
(285, 240, 22),
(286, 241, 22),
(287, 242, 22),
(297, 373, 22),
(305, 45, 22),
(321, 46, 22),
(341, 375, 22),
(342, 376, 22),
(343, 367, 22),
(346, 377, 22),
(348, 35, 22),
(349, 35, 40),
(357, 74, 40),
(361, 24, 22),
(362, 13, 22),
(363, 14, 22),
(364, 28, 22),
(365, 40, 22),
(366, 47, 22),
(367, 48, 22),
(368, 51, 22),
(369, 64, 22),
(370, 78, 22),
(371, 96, 22),
(372, 49, 22),
(384, 50, 22),
(385, 52, 22),
(386, 53, 22),
(388, 55, 22),
(389, 56, 22),
(390, 57, 22),
(391, 58, 22),
(392, 59, 22),
(393, 73, 22),
(395, 54, 22),
(406, 60, 22),
(407, 62, 22),
(408, 63, 22),
(409, 65, 22),
(411, 66, 22),
(412, 378, 22),
(413, 67, 22),
(414, 75, 22),
(415, 77, 22),
(416, 79, 22),
(417, 94, 22),
(418, 370, 22),
(432, 15, 22),
(433, 393, 22),
(434, 395, 22),
(435, 394, 22),
(436, 396, 22),
(443, 398, 22),
(445, 399, 22),
(455, 404, 22),
(456, 404, 40),
(457, 104, 22),
(460, 397, 22),
(464, 379, 22),
(465, 406, 22),
(466, 407, 22),
(467, 408, 22),
(468, 415, 22),
(469, 416, 22),
(470, 417, 22),
(471, 418, 22),
(472, 419, 22),
(473, 420, 22),
(474, 421, 22),
(475, 23, 22);

-- --------------------------------------------------------

--
-- Table structure for table `tags_task_lists`
--

CREATE TABLE IF NOT EXISTS `tags_task_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_list_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

--
-- Dumping data for table `tags_task_lists`
--

INSERT INTO `tags_task_lists` (`id`, `task_list_id`, `tag_id`) VALUES
(56, 17, 22),
(57, 17, 40),
(66, 33, 22),
(77, 5, 22);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET latin1 NOT NULL,
  `description` text CHARACTER SET latin1,
  `checked` tinyint(1) NOT NULL,
  `deadline` date DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `created` date NOT NULL,
  `todo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=422 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `description`, `checked`, `deadline`, `priority`, `created`, `todo`) VALUES
(13, 'Lägg till stöd för listor', '', 1, '2012-05-23', 10, '2012-05-23', 1),
(14, 'Skapa ett element för att skapa en task', '', 1, '2012-05-27', 10, '2012-05-27', 1),
(15, 'Skapa ett element för att skapa en lista', 'Med default context ifylld', 1, '2012-05-27', 10, '2012-05-27', 1),
(16, 'Få igång så man kan använda elementet tasks både från en find() och från en sub-nod från find()', '', 1, '2012-05-27', 10, '2012-05-27', 1),
(23, 'Skapa tjänster för att visa olika typer av tasks', 'T ex en för done, en för checked. Skicka in parameter till elementet för att säga till ajax-anropet vad som ska ersätta elementet. ', 0, '2012-05-30', 1, '2012-05-30', 1),
(24, 'Rensa fält efter add', '', 1, '2012-05-30', 0, '2012-05-30', 1),
(25, 'Skapa default context för en lista', '', 1, '2012-05-30', 0, '2012-05-30', 1),
(26, 'Skapa default tags för en lista?', '', 0, '2012-05-30', 0, '2012-05-30', 1),
(27, 'Skapa en lista på sidor som kan användas för inspiration', '* Kontroller\n* Övergripande desing\n* Stil', 0, '2012-05-30', 0, '2012-05-30', 1),
(28, 'Skapa generella funktioner och refaktorera', '* Funktion för att hämta tasks i task_lists\n* Hämta en task/task_list med labels och contexts', 1, '2012-05-30', 0, '2012-05-30', 1),
(32, 'Skapa view för tasks', '', 1, '2012-05-30', NULL, '2012-05-30', 1),
(34, 'Skapa en header', '', 0, '2012-05-31', 0, '2012-05-31', 1),
(35, 'Skapa en footer', '', 0, '2012-05-31', 0, '2012-05-31', 1),
(36, 'Skapa ett css-tema', '', 0, '2012-05-31', NULL, '2012-05-31', 1),
(37, 'Skapa en html-struktur', '', 0, '2012-05-31', NULL, '2012-05-31', 1),
(38, 'Begränsa antal done tasks', 'Kanske räcker 10 st?', 0, '2012-05-31', 0, '2012-05-31', 1),
(39, 'View för klara tasks', 'Med paginering', 1, '2012-05-31', 0, '2012-05-31', 1),
(40, 'Lägg add task/list i en modal-ruta', '', 1, '2012-05-31', 0, '2012-05-31', 1),
(45, 'Skapa view för tag', '', 1, '2012-05-31', 0, '2012-05-31', 1),
(46, 'Skapa view för context', '', 1, '2012-05-31', 0, '2012-05-31', 1),
(47, 'Refaktorera context', '', 1, '2012-05-31', 0, '2012-05-31', 1),
(48, 'Refaktorera tag', '', 1, '2012-05-31', 0, '2012-05-31', 1),
(49, 'Lägg till fält för tidsåtgång och energiåtgång', '', 0, '2012-06-01', 0, '2012-06-01', 1),
(50, 'Lista info om tasks', 'Hur många listor, sublistor', 0, '2012-06-01', 0, '2012-06-01', 1),
(51, 'Kunna ta bort lista', '', 1, '2012-06-01', 0, '2012-06-01', 1),
(52, 'Möjlighet att sortera listor', '', 0, '2012-06-01', 0, '2012-06-01', 1),
(53, 'Möjlighet att sortera tasks', '', 0, '2012-06-01', 0, '2012-06-01', 1),
(54, 'Skapa en registreringssida', '', 0, '2012-06-01', 0, '2012-06-01', 1),
(55, 'Stöd för att logga in', '', 0, '2012-06-01', 0, '2012-06-01', 1),
(56, 'Lägg till stöd för rättigheter för tasks/lists', 'RW', 0, '2012-06-01', 0, '2012-06-01', 1),
(57, 'Lägg in användarid för tags och contexts', '', 1, '2012-06-01', 0, '2012-06-01', 1),
(58, 'Möjlighet att ta bort tags', '', 1, '2012-06-01', 0, '2012-06-01', 1),
(59, 'Möjlighet att ta bort contexts', '', 1, '2012-06-01', 0, '2012-06-01', 1),
(60, 'Möjlighet att editera contexts', '', 1, '2012-06-01', 0, '2012-06-01', 1),
(62, 'Kunna aktivera/avaktivera listor', '', 0, '2012-06-01', 0, '2012-06-01', 1),
(63, 'Visa avaktiverade listor', '', 0, '2012-06-01', 0, '2012-06-01', 1),
(64, 'Bestäm om det ska heta ', '', 1, '2012-06-01', 0, '2012-06-01', 1),
(65, 'Skapa en view för stuff', '', 0, '2012-06-01', 0, '2012-06-01', 1),
(66, 'Skapa stöd för listor som inte är todo', '', 0, '2012-06-01', 0, '2012-06-01', 1),
(67, 'Skapa en view för att visa ~todo-listor', '', 0, '2012-06-01', 0, '2012-06-01', 1),
(68, 'Implementera stöd för recurring tasks', '', 0, '2012-06-01', NULL, '2012-06-01', 1),
(69, 'Sätta defer på en task', '', 0, '2012-06-01', NULL, '2012-06-01', 1),
(70, 'Lista alla defered tasks', '', 0, '2012-06-01', NULL, '2012-06-01', 1),
(71, 'Sätta delegate på en task', 'Kanske gråmarkera den tasken', 0, '2012-06-01', NULL, '2012-06-01', 1),
(72, 'Visa alla delegated tasks', '', 0, '2012-06-01', NULL, '2012-06-01', 1),
(73, 'Skapa ett javascript för att dölja/visa ', '', 0, '2012-06-01', 0, '2012-06-01', 1),
(74, 'Skapa en logo', '', 0, '2012-06-01', 0, '2012-06-01', 1),
(75, 'Välja context, tag, energy, tid i agenda', '', 0, '2012-06-01', 0, '2012-06-01', 1),
(76, 'http://todoist.com/', '', 0, '2012-06-01', NULL, '2012-06-01', 1),
(77, 'Döp om det till List och Project?', '', 0, '2012-06-01', 0, '2012-06-01', 1),
(78, 'Möjlighet att skapa en task med endast ett fält', 'Skriv tags med #, contexts med @, recurrent som "every" eller "at"', 1, '2012-06-01', 0, '2012-06-01', 1),
(79, 'Funktion för att lista breadcrumbs för en lista', '', 0, '2012-06-01', 0, '2012-06-01', 1),
(94, 'Skapa javascript-templates', '', 0, '2012-06-05', 0, '2012-06-05', 1),
(96, 'Stöd för att visa samma task på flera ställen', 'Men alla ska tas bort om en tas bort, och alla ska ändras om en ändras, men bara en ska editeras i taget.', 1, '2012-06-05', 0, '2012-06-05', 1),
(98, 'Skapa en klass för context', 'Skapa en global hash med contexts som alla kan komma åt, en load-funktion, statisk funktion för att generera en sträng från flera contexts', 1, '2012-06-05', NULL, '2012-06-05', 1),
(102, 'Dela upp klasserna i olika filer', 'En för task, context, tag, list och en global med maps med gemensamma objekt i', 1, '2012-06-05', 0, '2012-06-05', 1),
(104, 'Fixa delete', 'Trasig, försöker ta bort från alla elements, men foreach fungerar inte för maps', 1, '2012-06-05', 0, '2012-06-05', 1),
(105, 'afsddfs', NULL, 0, NULL, NULL, '2012-06-11', 1),
(106, 'lista med tornado som default task?', NULL, 0, NULL, NULL, '2012-06-11', 1),
(107, 'afdafsd', NULL, 0, NULL, NULL, '2012-06-11', 1),
(108, 'asddsadsa', NULL, 0, NULL, NULL, '2012-06-11', 1),
(109, 'asddsadsa', NULL, 0, NULL, NULL, '2012-06-11', 1),
(110, 'asddsadsa', NULL, 0, NULL, NULL, '2012-06-11', 1),
(111, 'afdsafds', NULL, 0, NULL, NULL, '2012-06-11', 1),
(112, 'adfsadfs', NULL, 0, NULL, NULL, '2012-06-11', 1),
(113, 'adfsadfs', NULL, 0, NULL, NULL, '2012-06-11', 1),
(114, 'adfsadfs', NULL, 0, NULL, NULL, '2012-06-11', 1),
(115, 'adfsadfs', NULL, 0, NULL, NULL, '2012-06-11', 1),
(116, 'adfsadfs', NULL, 0, NULL, NULL, '2012-06-11', 1),
(117, 'sdfdsf', NULL, 0, NULL, NULL, '2012-06-11', 1),
(118, 'sdfdsf', NULL, 0, NULL, NULL, '2012-06-11', 1),
(119, 'sdfafds', NULL, 0, NULL, NULL, '2012-06-11', 1),
(120, 'sdfafds', NULL, 0, NULL, NULL, '2012-06-11', 1),
(121, 'afdfds', NULL, 0, NULL, NULL, '2012-06-11', 1),
(122, 'afdfds', NULL, 0, NULL, NULL, '2012-06-11', 1),
(123, 'afdfds', NULL, 0, NULL, NULL, '2012-06-11', 1),
(124, 'sdadsadas', NULL, 0, NULL, NULL, '2012-06-11', 1),
(127, 'asdasd', NULL, 0, NULL, NULL, '2012-06-11', 1),
(128, 'sadsda', NULL, 0, NULL, NULL, '2012-06-11', 1),
(129, 'sadsda', NULL, 0, NULL, NULL, '2012-06-11', 1),
(130, 'sadsda', NULL, 0, NULL, NULL, '2012-06-11', 1),
(131, 'test', NULL, 0, NULL, NULL, '2012-06-13', 1),
(132, 'testing123', NULL, 0, NULL, NULL, '2012-06-13', 1),
(157, 'fin task', NULL, 0, NULL, NULL, '2012-06-13', 1),
(158, 'asddsa', NULL, 0, NULL, NULL, '2012-06-13', 1),
(161, 'asdfasdf', NULL, 0, NULL, NULL, '2012-06-13', 1),
(162, 'saddsa', NULL, 0, NULL, NULL, '2012-06-13', 1),
(163, 'afds', NULL, 0, NULL, NULL, '2012-06-13', 1),
(164, 'asd', NULL, 0, NULL, NULL, '2012-06-13', 1),
(165, 'asdfasdfasdf1222', NULL, 0, NULL, NULL, '2012-06-13', 1),
(166, 'saddsa', NULL, 0, NULL, NULL, '2012-06-13', 1),
(167, 'asdsda', NULL, 0, NULL, NULL, '2012-06-13', 1),
(168, 'sadsdadsa', NULL, 0, NULL, NULL, '2012-06-13', 1),
(169, 'asdasdf1231', NULL, 0, NULL, NULL, '2012-06-13', 1),
(170, 'sasadsad', NULL, 0, NULL, NULL, '2012-06-13', 1),
(171, 'sdfg', NULL, 0, NULL, NULL, '2012-06-13', 1),
(172, 'asdf', NULL, 0, NULL, NULL, '2012-06-13', 1),
(173, 'afdsdfas', NULL, 0, NULL, NULL, '2012-06-13', 1),
(174, 'adfsdfs', NULL, 0, NULL, NULL, '2012-06-13', 1),
(175, 'asddsa', NULL, 0, NULL, NULL, '2012-06-13', 1),
(176, 'asdsda', NULL, 0, NULL, NULL, '2012-06-13', 1),
(177, 'asdads', NULL, 0, NULL, NULL, '2012-06-13', 1),
(178, 'asdsad', NULL, 0, NULL, NULL, '2012-06-13', 1),
(179, '1337', NULL, 0, NULL, NULL, '2012-06-13', 1),
(180, 'sadsda', NULL, 0, NULL, NULL, '2012-06-13', 1),
(199, 'asdasd ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(200, 'asddas ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(201, 'dasasd ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(202, 'asdsda ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(203, 'asdsda ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(204, 'dassda ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(205, 'asdsda ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(206, 'adsdas ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(207, 'asdsad ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(208, 'asdasd ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(209, 'asd ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(210, 'asddas ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(211, 'asdasd ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(212, 'adssda ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(213, 'asdsad ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(214, 'asdsad ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(215, 'asdasd ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(216, 'asdasd ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(217, 'asdsad', '', 0, '2012-09-13', NULL, '2012-09-13', 1),
(218, 'sadsda ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(219, 'asddsa ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(220, 'asdsad ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(221, 'sda ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(222, 'asdasd ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(223, 'adsasd ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(224, 'asddsa ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(225, 'asdasddas ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(226, 'asdasd ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(227, 'asdasd ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(228, 'sdasad ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(229, 'asdasd ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(230, 'asdasd', NULL, 0, NULL, NULL, '2012-09-13', 1),
(231, 'dd', NULL, 0, NULL, NULL, '2012-09-13', 1),
(232, 'ssasdadas ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(233, 'asddsaads ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(234, 'asdadsads ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(235, 'asdsad ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(236, 'sadsda ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(237, 'asdasd ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(238, 'asdasd ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(239, 'sadsda ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(240, 'utvecklingstask ', NULL, 1, NULL, NULL, '2012-09-13', 1),
(241, 'autoupdatera tagview ', NULL, 1, NULL, NULL, '2012-09-13', 1),
(242, 'skriv en generell metod för att ladda en task (med tillhörande tasks osv) så att den inte laddar för djupt ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(249, 'test ', NULL, 0, NULL, NULL, '2012-09-13', 1),
(250, 'testing', NULL, 0, NULL, NULL, '2012-09-13', 1),
(251, 'sadsda', NULL, 0, NULL, NULL, '2012-09-13', 1),
(252, 'sadsad', NULL, 0, NULL, NULL, '2012-09-13', 1),
(299, 'testtask', NULL, 0, NULL, NULL, '2012-09-17', 1),
(300, 'testtask', NULL, 0, NULL, NULL, '2012-09-17', 1),
(301, 'asdasd', NULL, 0, NULL, NULL, '2012-09-17', 1),
(302, 'asdasd', NULL, 0, NULL, NULL, '2012-09-17', 1),
(303, 'dsasad', NULL, 0, NULL, NULL, '2012-09-17', 1),
(304, 'sadsad', NULL, 0, NULL, NULL, '2012-09-17', 1),
(305, 'asdsadsadsadsad123', NULL, 0, NULL, NULL, '2012-09-17', 1),
(306, 'sadasasd2', NULL, 0, NULL, NULL, '2012-09-17', 1),
(307, 'saddsadsa', NULL, 0, NULL, NULL, '2012-09-17', 1),
(366, '', NULL, 0, NULL, NULL, '2012-09-18', 1),
(367, 'Kunna ta bort tasks från done-tasks', 'null', 1, '0000-00-00', 0, '2012-09-18', 1),
(368, '', NULL, 0, NULL, NULL, '2012-09-18', 1),
(369, '', NULL, 0, NULL, NULL, '2012-09-18', 1),
(370, 'Ange parent i tasks', 'null', 0, '0000-00-00', 0, '2012-09-18', 1),
(371, 'fixa stöd för att editera tasks', 'null', 1, '0000-00-00', 0, '2012-09-18', 1),
(373, 'Laga editeringen av tags/contexts så de inte skrivs två gånger efter en save ', NULL, 1, NULL, NULL, '2012-09-24', 1),
(375, 'Laga kryssningen av tasks ', NULL, 1, NULL, NULL, '2012-10-08', 1),
(376, 'Laga editering av klara tasks ', NULL, 1, NULL, NULL, '2012-10-08', 1),
(377, 'Spara en editerad task genom att trycka enter', 'null', 1, '0000-00-00', 0, '2012-10-08', 1),
(378, 'Fixa så att tags/contexts hämtar tasks med labels', 'null', 0, '0000-00-00', 0, '2012-10-10', 1),
(379, 'Kunna skapa en lista ', 'null', 1, '0000-00-00', 0, '2012-10-10', 1),
(393, 'Kunna editera listor', 'null', 1, '0000-00-00', 0, '2012-10-10', 1),
(394, 'Skapa en view för att visa listor med taggar', 'null', 1, '0000-00-00', 0, '2012-10-10', 1),
(395, 'Skapa view för att visa listor med contexts ', NULL, 1, NULL, NULL, '2012-10-10', 1),
(396, 'Lägg till stöd för default tags/contexts/listor när en tag/context/lista visas', 'null', 0, '0000-00-00', 0, '2012-10-10', 1),
(397, 'Kunna ta bort en lista', 'null', 1, '0000-00-00', 0, '2012-10-10', 1),
(398, 'Skapa en view för att endast visa listor', 'null', 1, '0000-00-00', 0, '2012-10-10', 1),
(399, 'Visa info när man hovrar över en task/lista (?)', 'null', 0, '0000-00-00', 0, '2012-10-10', 1),
(404, 'Ta bort/ändra taggar från element när en tagg ändrats/tagits bort ', 'null', 0, '0000-00-00', 0, '2012-10-16', 1),
(406, 'Ta bort tags ', NULL, 1, NULL, NULL, '2012-10-17', 1),
(407, 'Editera tags ', NULL, 1, NULL, NULL, '2012-10-17', 1),
(408, 'Kunna visa en tom view (för att kunna lägga till listor och tasks) ', NULL, 0, NULL, NULL, '2012-10-17', 1),
(409, 'aaaa', NULL, 0, NULL, NULL, '2012-10-17', 1),
(410, 'adsaaa', NULL, 0, NULL, NULL, '2012-10-17', 1),
(411, 'test', NULL, 0, NULL, NULL, '2012-10-17', 1),
(412, 'blabla', NULL, 0, NULL, NULL, '2012-10-17', 1),
(413, 'adsasd ', NULL, 0, NULL, NULL, '2012-10-17', 1),
(414, 'dasasd ', NULL, 0, NULL, NULL, '2012-10-17', 1),
(415, 'Kunna logga ut ', NULL, 0, NULL, NULL, '2012-10-19', 1),
(416, 'Möjlighet att flytta listor/tasks ', NULL, 0, NULL, NULL, '2012-10-19', 1),
(417, 'Fixa så att nya tasks ägs av användaren ', NULL, 0, NULL, NULL, '2012-10-23', 1),
(418, 'Hämta endast tasks som ägs av användaren ', NULL, 0, NULL, NULL, '2012-10-23', 1),
(419, 'Ta endast bort/ändra tasks som användaren äger ', NULL, 0, NULL, NULL, '2012-10-23', 1),
(420, 'Hämta/editera endast/ta endast bort listor/tasks/taggar/contexts som ägs av användaren ', NULL, 0, NULL, NULL, '2012-10-23', 1),
(421, 'Varning/fel om man byter namn på en context/tagg som redan finns (?)', 'null', 0, '0000-00-00', 0, '2012-10-23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tasks_users`
--

CREATE TABLE IF NOT EXISTS `tasks_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=194 ;

--
-- Dumping data for table `tasks_users`
--

INSERT INTO `tasks_users` (`id`, `task_id`, `user_id`) VALUES
(1, 13, 5),
(2, 14, 5),
(3, 15, 5),
(4, 16, 5),
(5, 23, 5),
(6, 24, 5),
(7, 25, 5),
(8, 26, 5),
(9, 27, 5),
(10, 28, 5),
(11, 32, 5),
(12, 34, 5),
(13, 35, 5),
(14, 36, 5),
(15, 37, 5),
(16, 38, 5),
(17, 39, 5),
(18, 40, 5),
(19, 45, 5),
(20, 46, 5),
(21, 47, 5),
(22, 48, 5),
(23, 49, 5),
(24, 50, 5),
(25, 51, 5),
(26, 52, 5),
(27, 53, 5),
(28, 54, 5),
(29, 55, 5),
(30, 56, 5),
(31, 57, 5),
(32, 58, 5),
(33, 59, 5),
(34, 60, 5),
(35, 62, 5),
(36, 63, 5),
(37, 64, 5),
(38, 65, 5),
(39, 66, 5),
(40, 67, 5),
(41, 68, 5),
(42, 69, 5),
(43, 70, 5),
(44, 71, 5),
(45, 72, 5),
(46, 73, 5),
(47, 74, 5),
(48, 75, 5),
(49, 76, 5),
(50, 77, 5),
(51, 78, 5),
(52, 79, 5),
(53, 94, 5),
(54, 96, 5),
(55, 98, 5),
(56, 102, 5),
(57, 104, 5),
(58, 105, 5),
(59, 106, 5),
(60, 107, 5),
(61, 108, 5),
(62, 109, 5),
(63, 110, 5),
(64, 111, 5),
(65, 112, 5),
(66, 113, 5),
(67, 114, 5),
(68, 115, 5),
(69, 116, 5),
(70, 117, 5),
(71, 118, 5),
(72, 119, 5),
(73, 120, 5),
(74, 121, 5),
(75, 122, 5),
(76, 123, 5),
(77, 124, 5),
(78, 127, 5),
(79, 128, 5),
(80, 129, 5),
(81, 130, 5),
(82, 131, 5),
(83, 132, 5),
(84, 157, 5),
(85, 158, 5),
(86, 161, 5),
(87, 162, 5),
(88, 163, 5),
(89, 164, 5),
(90, 165, 5),
(91, 166, 5),
(92, 167, 5),
(93, 168, 5),
(94, 169, 5),
(95, 170, 5),
(96, 171, 5),
(97, 172, 5),
(98, 173, 5),
(99, 174, 5),
(100, 175, 5),
(101, 176, 5),
(102, 177, 5),
(103, 178, 5),
(104, 179, 5),
(105, 180, 5),
(106, 199, 5),
(107, 200, 5),
(108, 201, 5),
(109, 202, 5),
(110, 203, 5),
(111, 204, 5),
(112, 205, 5),
(113, 206, 5),
(114, 207, 5),
(115, 208, 5),
(116, 209, 5),
(117, 210, 5),
(118, 211, 5),
(119, 212, 5),
(120, 213, 5),
(121, 214, 5),
(122, 215, 5),
(123, 216, 5),
(124, 217, 5),
(125, 218, 5),
(126, 219, 5),
(127, 220, 5),
(128, 221, 5),
(129, 222, 5),
(130, 223, 5),
(131, 224, 5),
(132, 225, 5),
(133, 226, 5),
(134, 227, 5),
(135, 228, 5),
(136, 229, 5),
(137, 230, 5),
(138, 231, 5),
(139, 232, 5),
(140, 233, 5),
(141, 234, 5),
(142, 235, 5),
(143, 236, 5),
(144, 237, 5),
(145, 238, 5),
(146, 239, 5),
(147, 240, 5),
(148, 241, 5),
(149, 242, 5),
(150, 249, 5),
(151, 250, 5),
(152, 251, 5),
(153, 252, 5),
(154, 299, 5),
(155, 300, 5),
(156, 301, 5),
(157, 302, 5),
(158, 303, 5),
(159, 304, 5),
(160, 305, 5),
(161, 306, 5),
(162, 307, 5),
(163, 366, 5),
(164, 367, 5),
(165, 368, 5),
(166, 369, 5),
(167, 370, 5),
(168, 371, 5),
(169, 373, 5),
(170, 375, 5),
(171, 376, 5),
(172, 377, 5),
(173, 378, 5),
(174, 379, 5),
(175, 393, 5),
(176, 394, 5),
(177, 395, 5),
(178, 396, 5),
(179, 397, 5),
(180, 398, 5),
(181, 399, 5),
(182, 404, 5),
(183, 406, 5),
(184, 407, 5),
(185, 408, 5),
(186, 409, 5),
(187, 410, 5),
(188, 411, 5),
(189, 412, 5),
(190, 413, 5),
(191, 414, 5),
(192, 415, 5),
(193, 416, 5);

-- --------------------------------------------------------

--
-- Table structure for table `task_lists`
--

CREATE TABLE IF NOT EXISTS `task_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `created` date NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `task_lists`
--

INSERT INTO `task_lists` (`id`, `name`, `description`, `created`, `parent_id`) VALUES
(5, 'tornado', 'desc', '2012-05-27', NULL),
(17, 'Skapa en design', 'Hur ska tornado se ut?', '2012-05-30', 5),
(18, 'Version 0.2', 'Saker som kan komma med i 0.2', '2012-05-31', 5),
(21, 'Inspiration', '', '2012-06-01', 5),
(33, 'Version 0.x', '', '2012-06-01', 5);

-- --------------------------------------------------------

--
-- Table structure for table `task_lists_tasks`
--

CREATE TABLE IF NOT EXISTS `task_lists_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `task_list_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=244 ;

--
-- Dumping data for table `task_lists_tasks`
--

INSERT INTO `task_lists_tasks` (`id`, `task_id`, `task_list_id`) VALUES
(1, 14, 5),
(2, 15, 5),
(3, 16, 5),
(9, 23, 5),
(10, 24, 5),
(11, 25, 5),
(12, 26, 5),
(13, 27, 17),
(14, 28, 5),
(18, 32, 5),
(20, 34, 17),
(21, 35, 17),
(22, 36, 17),
(23, 37, 17),
(24, 38, 5),
(25, 39, 18),
(26, 40, 17),
(28, 45, 5),
(29, 46, 5),
(30, 47, 5),
(31, 48, 5),
(32, 49, 5),
(33, 50, 5),
(34, 51, 5),
(35, 52, 5),
(36, 53, 5),
(37, 54, 5),
(38, 55, 5),
(39, 56, 5),
(40, 57, 5),
(41, 58, 5),
(42, 59, 5),
(43, 60, 5),
(45, 62, 5),
(46, 63, 5),
(47, 64, 5),
(48, 65, 5),
(49, 66, 5),
(50, 67, 5),
(51, 68, 18),
(52, 69, 18),
(53, 70, 18),
(54, 71, 18),
(55, 72, 18),
(56, 73, 17),
(57, 74, 17),
(58, 75, 5),
(59, 76, 21),
(60, 77, 5),
(61, 78, 33),
(62, 79, 5),
(77, 94, 5),
(79, 96, 5),
(81, 98, 5),
(85, 102, 5),
(87, 104, 5),
(192, 367, 5),
(193, 370, 5),
(196, 371, 5),
(198, 373, 5),
(201, 375, 5),
(202, 376, 5),
(204, 377, 5),
(206, 378, 5),
(207, 379, 5),
(221, 393, 5),
(222, 394, 5),
(223, 395, 5),
(224, 396, 5),
(225, 397, 5),
(226, 398, 5),
(227, 399, 5),
(232, 404, 5),
(234, 406, 5),
(235, 407, 5),
(236, 408, 5),
(237, 415, 5),
(238, 416, 5),
(239, 417, 5),
(240, 418, 5),
(241, 419, 5),
(242, 420, 5),
(243, 421, 5);

-- --------------------------------------------------------

--
-- Table structure for table `task_lists_users`
--

CREATE TABLE IF NOT EXISTS `task_lists_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_list_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `task_lists_users`
--

INSERT INTO `task_lists_users` (`id`, `task_list_id`, `user_id`) VALUES
(1, 5, 5),
(2, 17, 5),
(3, 18, 5),
(4, 21, 5),
(5, 33, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, '', 'password'),
(2, 'test', '$6$BeUAVT0N$2Oy6efjfJ.WMnFewxClicAjzI7aQyQqSA7V50TSdzCuAE4ZMx620VNC2ZuqsrRxCans9Pdoe7H6B6JSEbvnkB0'),
(3, 'test1', '$6$rd5VtSXU$5ikfW/TX9U.mLKS5o5p0cobuiPk9G/ClcnW87kWGDwIjN8OOI2ayocENWgvq4N/9w4zEjcJkUs3Sq29eNNdKa0'),
(4, 'testuser', '1616af1bf1a905750c8faf7d945a2ad5e339403a'),
(5, 'rasmus', '6cc6c16257934316fba8d970adb7f5ccf858409f');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
