-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 13 2015 г., 21:10
-- Версия сервера: 5.5.38
-- Версия PHP: 5.4.4-14+deb7u14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `db_archive2012`
--

-- --------------------------------------------------------

--
-- Структура таблицы `arch25_konsa_exp_artists`
--

CREATE TABLE IF NOT EXISTS `arch25_konsa_exp_artists` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `artist_name` varchar(128) NOT NULL DEFAULT '',
  `artist_lastname` varchar(128) NOT NULL DEFAULT '',
  `artist_secondname` varchar(128) NOT NULL DEFAULT '',
  `artist_full_name` varchar(255) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `death_date` date DEFAULT NULL,
  `place_of_birth` int(11) unsigned DEFAULT '0',
  `place` int(11) unsigned DEFAULT '0',
  `place_of_death` int(11) unsigned DEFAULT '0',
  `letter` varchar(1) NOT NULL,
  `image` varchar(127) NOT NULL,
  `comment` text NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Created Date and Time',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Created by User ID',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified Date and Time',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Modified by User ID',
  `related` varchar(63) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `keywords` varchar(2048) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `performer_name` (`artist_name`),
  KEY `performer_lastname` (`artist_lastname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Исполнители' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `arch25_konsa_exp_artists_to_phonograms`
--

CREATE TABLE IF NOT EXISTS `arch25_konsa_exp_artists_to_phonograms` (
  `artist_id` int(11) unsigned NOT NULL,
  `phonogram_id` int(11) NOT NULL,
  `artists_role_in_phonogram` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`artist_id`,`phonogram_id`),
  KEY `fk_arch25_konsa_exp_artists_has_arch25_konsa_exp_phonograms_idx` (`phonogram_id`),
  KEY `fk_arch25_konsa_exp_artists_has_arch25_konsa_exp_phonograms_idx1` (`artist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `arch25_konsa_exp_artists_to_sessions`
--

CREATE TABLE IF NOT EXISTS `arch25_konsa_exp_artists_to_sessions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `artist_id` int(11) unsigned NOT NULL,
  `session_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Структура таблицы `arch25_konsa_exp_sessions`
--

CREATE TABLE IF NOT EXISTS `arch25_konsa_exp_sessions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `session_code` varchar(255) NOT NULL DEFAULT 'Код сессии',
  `session_title` varchar(255) NOT NULL DEFAULT 'Тема сессии',
  `date` date DEFAULT NULL,
  `place_id` int(11) unsigned DEFAULT '0',
  `expedition_id` int(11) unsigned DEFAULT '0',
  `comment` text NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `image_folder` varchar(255) NOT NULL,
  `added` datetime NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Сессии записи' AUTO_INCREMENT=3 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `arch25_konsa_exp_artists_to_phonograms`
--
ALTER TABLE `arch25_konsa_exp_artists_to_phonograms`
  ADD CONSTRAINT `fk_artists` FOREIGN KEY (`artist_id`) REFERENCES `arch25_konsa_exp_artists` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_phonograms` FOREIGN KEY (`phonogram_id`) REFERENCES `arch25_konsa_exp_phonograms` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
