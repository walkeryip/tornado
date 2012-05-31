-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 31, 2012 at 11:14 PM
-- Server version: 5.5.22
-- PHP Version: 5.3.10-1ubuntu3

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=27 ;

--
-- Dumping data for table `contexts`
--

INSERT INTO `contexts` (`id`, `name`, `created`) VALUES
(1, 'c1', '2012-05-13'),
(2, 'c2', '2012-05-13'),
(3, 'c3', '2012-05-13'),
(4, 'c5', '2012-05-13'),
(5, 'bla', '2012-05-23'),
(6, 'dator', '2012-05-23'),
(7, 'hemma', '2012-05-23'),
(8, 'fin context', '2012-05-24'),
(9, 'rasmus', '2012-05-26'),
(10, 'a', '2012-05-27'),
(11, 'b', '2012-05-27'),
(12, 'c', '2012-05-27'),
(13, '2', '2012-05-27'),
(14, '1', '2012-05-27'),
(15, 'a', '2012-05-27'),
(16, '1', '2012-05-27'),
(17, '3', '2012-05-27'),
(18, 'ful context', '2012-05-27'),
(19, 'fin', '2012-05-27'),
(20, 'sad', '2012-05-30'),
(21, 'context1', '2012-05-30'),
(22, 'context2', '2012-05-30'),
(23, 'context3', '2012-05-30'),
(24, 'asd', '2012-05-30'),
(25, 'penna och papper', '2012-05-30'),
(26, 'testc', '2012-05-31');

-- --------------------------------------------------------

--
-- Table structure for table `contexts_tasks`
--

CREATE TABLE IF NOT EXISTS `contexts_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `context_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=88 ;

--
-- Dumping data for table `contexts_tasks`
--

INSERT INTO `contexts_tasks` (`id`, `task_id`, `context_id`) VALUES
(29, 13, 6),
(30, 13, 7),
(38, 15, 6),
(39, 16, 6),
(52, 23, 6),
(54, 25, 6),
(55, 26, 6),
(56, 14, 6),
(57, 27, 6),
(58, 28, 6),
(63, 31, 6),
(64, 30, 6),
(65, 29, 6),
(66, 32, 6),
(70, 36, 6),
(71, 37, 6),
(72, 35, 6),
(73, 34, 6),
(74, 38, 6),
(75, 39, 6),
(76, 40, 6),
(77, 40, 25),
(87, 24, 6);

-- --------------------------------------------------------

--
-- Table structure for table `contexts_task_lists`
--

CREATE TABLE IF NOT EXISTS `contexts_task_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `context_id` int(11) NOT NULL,
  `task_list_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `contexts_task_lists`
--

INSERT INTO `contexts_task_lists` (`id`, `context_id`, `task_list_id`) VALUES
(15, 14, 3),
(16, 13, 3),
(17, 17, 3),
(21, 1, 4),
(22, 2, 4),
(23, 3, 4),
(24, 6, 5),
(31, 6, 17),
(32, 25, 17),
(33, 6, 18);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET latin1 NOT NULL,
  `created` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=42 ;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `created`) VALUES
(9, 'a', '2012-05-12'),
(10, 'b', '2012-05-12'),
(11, 'c', '2012-05-12'),
(12, 'd', '2012-05-12'),
(13, 'e', '2012-05-12'),
(14, 'f', '2012-05-12'),
(15, 'g', '2012-05-12'),
(16, 'h', '2012-05-12'),
(17, 't1', '2012-05-13'),
(18, 't2', '2012-05-13'),
(19, 't3', '2012-05-13'),
(20, 'spenen', '2012-05-23'),
(21, 'todo', '2012-05-23'),
(22, 'utveckling', '2012-05-23'),
(23, 'abc', '2012-05-26'),
(24, '2', '2012-05-27'),
(25, 'array', '2012-05-27'),
(26, 'array', '2012-05-27'),
(27, 'abc', '2012-05-27'),
(28, 'l1', '2012-05-27'),
(29, 'l2', '2012-05-27'),
(30, 'l3', '2012-05-27'),
(31, 'l5', '2012-05-27'),
(32, 'arraym array2', '2012-05-27'),
(33, 'array2', '2012-05-27'),
(34, 'bla', '2012-05-29'),
(35, 'asd', '2012-05-30'),
(36, 'tag1', '2012-05-30'),
(37, 'tag2', '2012-05-30'),
(38, 'tag3', '2012-05-30'),
(39, 'sda', '2012-05-30'),
(40, 'design', '2012-05-30'),
(41, 'grafik', '2012-05-30');

-- --------------------------------------------------------

--
-- Table structure for table `tags_tasks`
--

CREATE TABLE IF NOT EXISTS `tags_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=138 ;

--
-- Dumping data for table `tags_tasks`
--

INSERT INTO `tags_tasks` (`id`, `task_id`, `tag_id`) VALUES
(77, 13, 21),
(78, 13, 22),
(83, 15, 22),
(84, 16, 22),
(99, 23, 22),
(101, 25, 22),
(102, 26, 22),
(103, 14, 22),
(104, 27, 22),
(105, 27, 41),
(106, 27, 40),
(107, 28, 22),
(112, 31, 22),
(113, 30, 22),
(114, 29, 22),
(115, 32, 22),
(121, 36, 22),
(122, 36, 41),
(123, 37, 22),
(124, 35, 22),
(125, 34, 22),
(126, 38, 22),
(127, 39, 22),
(128, 40, 22),
(129, 40, 40),
(130, 40, 41),
(137, 24, 22);

-- --------------------------------------------------------

--
-- Table structure for table `tags_task_lists`
--

CREATE TABLE IF NOT EXISTS `tags_task_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_list_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `tags_task_lists`
--

INSERT INTO `tags_task_lists` (`id`, `task_list_id`, `tag_id`) VALUES
(14, 3, 23),
(18, 4, 28),
(19, 4, 29),
(20, 4, 30),
(21, 4, 31),
(22, 5, 22),
(30, 17, 22),
(31, 17, 40),
(32, 17, 41),
(33, 18, 22);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=49 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `description`, `checked`, `deadline`, `priority`, `created`, `todo`) VALUES
(13, 'Lägg till stöd för listor', '', 1, '2012-05-23', 10, '2012-05-23', 1),
(14, 'Skapa ett element för att skapa en task', '', 1, '2012-05-27', 10, '2012-05-27', 1),
(15, 'Skapa ett element för att skapa en lista', 'Med default context ifylld', 1, '2012-05-27', 10, '2012-05-27', 1),
(16, 'Få igång så man kan använda elementet tasks både från en find() och från en sub-nod från find()', '', 1, '2012-05-27', 10, '2012-05-27', 1),
(23, 'Skapa tjänster för att visa olika typer av tasks', 'T ex en för done, en för checked. Skicka in parameter till elementet för att säga till ajax-anropet vad som ska ersätta elementet. ', 0, '2012-05-30', 1, '2012-05-30', 1),
(24, 'Rensa fält efter add', '', 0, '2012-05-30', NULL, '2012-05-30', 1),
(25, 'Skapa default context för en lista', '', 1, '2012-05-30', NULL, '2012-05-30', 1),
(26, 'Skapa default tags för en lista?', '', 1, '2012-05-30', NULL, '2012-05-30', 1),
(27, 'Skapa en lista på sidor som kan användas för inspiration', '* Kontroller\n* Övergripande desing\n* Stil', 0, '2012-05-30', NULL, '2012-05-30', 1),
(28, 'Skapa generella funktioner och refaktorera', '* Funktion för att hämta tasks i task_lists\n* Hämta en task/task_list med labels och contexts', 0, '2012-05-30', NULL, '2012-05-30', 1),
(29, 'Skapa view för tags', '', 1, '2012-05-30', NULL, '2012-05-30', 1),
(30, 'Skapa view för contexts', '', 1, '2012-05-30', NULL, '2012-05-30', 1),
(31, 'Skapa view för task', '', 0, '2012-05-30', NULL, '2012-05-30', 1),
(32, 'Skapa view för tasks', '', 1, '2012-05-30', NULL, '2012-05-30', 1),
(34, 'Skapa en header', '', 0, '2012-05-31', NULL, '2012-05-31', 1),
(35, 'Skapa en footer', '', 0, '2012-05-31', NULL, '2012-05-31', 1),
(36, 'Skapa ett css-tema', '', 0, '2012-05-31', NULL, '2012-05-31', 1),
(37, 'Skapa en html-struktur', '', 0, '2012-05-31', NULL, '2012-05-31', 1),
(38, 'Begränsa antal done tasks', 'Kanske räcker 10 st?', 0, '2012-05-31', NULL, '2012-05-31', 1),
(39, 'View för klara tasks', 'Med paginering', 0, '2012-05-31', NULL, '2012-05-31', 1),
(40, 'Lägg add task/list i en modal-ruta', '', 0, '2012-05-31', NULL, '2012-05-31', 1),
(45, 'Skapa view för tag', '', 0, '2012-05-31', NULL, '2012-05-31', 1),
(46, 'Skapa view för context', '', 1, '2012-05-31', NULL, '2012-05-31', 1),
(47, 'Refaktorera context', '', 0, '2012-05-31', NULL, '2012-05-31', 1),
(48, 'Refaktorera tag', '', 0, '2012-05-31', NULL, '2012-05-31', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `task_lists`
--

INSERT INTO `task_lists` (`id`, `name`, `description`, `created`, `parent_id`) VALUES
(3, 'Hemmafix2', 'Saker att göra hemma2', '2012-05-25', 2),
(4, 'Hemmafix3', 'Saker att göra hemma3', '2012-05-25', 3),
(5, 'tornado', 'desc', '2012-05-27', NULL),
(17, 'Skapa en design', 'Hur ska tornado se ut?', '2012-05-30', 5),
(18, 'Version 0.2', 'Saker som kan komma med i 0.2', '2012-05-31', 5);

-- --------------------------------------------------------

--
-- Table structure for table `task_lists_tasks`
--

CREATE TABLE IF NOT EXISTS `task_lists_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `task_list_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

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
(15, 29, 5),
(16, 30, 5),
(17, 31, 5),
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
(31, 48, 5);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
