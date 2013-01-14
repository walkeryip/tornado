-- phpMyAdmin SQL Dump
-- version 3.4.11.1
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 14 jan 2013 kl 19:37
-- Serverversion: 5.0.96
-- PHP-version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE DATABASE `tornado` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `tornado`;
-- --------------------------------------------------------

--
-- Tabellstruktur `contexts`
--

CREATE TABLE IF NOT EXISTS `contexts` (
  `id` int(11) NOT NULL auto_increment,
  `name` text character set latin1 NOT NULL,
  `created` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `contexts_tasks`
--

CREATE TABLE IF NOT EXISTS `contexts_tasks` (
  `id` int(11) NOT NULL auto_increment,
  `task_id` int(11) NOT NULL,
  `context_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=616 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `contexts_task_lists`
--

CREATE TABLE IF NOT EXISTS `contexts_task_lists` (
  `id` int(11) NOT NULL auto_increment,
  `context_id` int(11) NOT NULL,
  `task_list_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL auto_increment,
  `name` text character set latin1 NOT NULL,
  `created` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=52 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `tags_tasks`
--

CREATE TABLE IF NOT EXISTS `tags_tasks` (
  `id` int(11) NOT NULL auto_increment,
  `task_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=743 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `tags_task_lists`
--

CREATE TABLE IF NOT EXISTS `tags_task_lists` (
  `id` int(11) NOT NULL auto_increment,
  `task_list_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=110 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL auto_increment,
  `name` text character set latin1 NOT NULL,
  `description` text character set latin1 NOT NULL,
  `checked` tinyint(1) NOT NULL,
  `deadline` date default NULL,
  `priority` int(11) default NULL,
  `created` date NOT NULL,
  `todo` tinyint(1) NOT NULL default '1',
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=733 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `tasks_users`
--

CREATE TABLE IF NOT EXISTS `tasks_users` (
  `id` int(11) NOT NULL auto_increment,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `read` tinyint(1) NOT NULL,
  `write` tinyint(1) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=726 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `task_lists`
--

CREATE TABLE IF NOT EXISTS `task_lists` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `created` date NOT NULL,
  `parent_id` int(11) default NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=86 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `task_lists_tasks`
--

CREATE TABLE IF NOT EXISTS `task_lists_tasks` (
  `id` int(11) NOT NULL auto_increment,
  `task_id` int(11) NOT NULL,
  `task_list_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=746 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `task_lists_users`
--

CREATE TABLE IF NOT EXISTS `task_lists_users` (
  `id` int(11) NOT NULL auto_increment,
  `task_list_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `read` tinyint(1) NOT NULL,
  `write` tinyint(1) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
