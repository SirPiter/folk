-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Мар 02 2015 г., 15:46
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `konsa`
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
-- Структура таблицы `arch25_konsa_exp_collectors`
--

CREATE TABLE IF NOT EXISTS `arch25_konsa_exp_collectors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `collector_name` varchar(128) NOT NULL DEFAULT '',
  `collector_lastname` varchar(128) NOT NULL DEFAULT '',
  `collector_secondname` varchar(128) NOT NULL DEFAULT '',
  `collector_full_name` varchar(255) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `death_date` date DEFAULT NULL,
  `place_of_birth` int(11) unsigned DEFAULT '0',
  `place` int(11) unsigned DEFAULT '0',
  `place_of_death` int(11) unsigned DEFAULT '0',
  `letter` varchar(1) NOT NULL,
  `image` varchar(127) NOT NULL,
  `comment` text NOT NULL,
  `added` datetime NOT NULL,
  `related` varchar(63) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `keywords` varchar(2048) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `collector_name` (`collector_name`),
  KEY `collector_lastname` (`collector_lastname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Собиратели' AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Структура таблицы `arch25_konsa_exp_documents`
--

CREATE TABLE IF NOT EXISTS `arch25_konsa_exp_documents` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT 'заголовок',
  `short_description` varchar(255) DEFAULT NULL COMMENT 'краткое описание',
  `description` text COMMENT 'описание',
  `num_of_pages` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'количество листов',
  `parents_id` int(11) unsigned DEFAULT NULL COMMENT 'ссылка на главный документ',
  `doc_image` varchar(255) DEFAULT NULL COMMENT 'картинка к документу',
  `doc_date` date DEFAULT NULL COMMENT 'дата составления документа',
  `add_date` date DEFAULT NULL COMMENT 'дата добавления в базу',
  `autor_id` int(11) DEFAULT NULL COMMENT 'ссылка на автора',
  `collector_id` int(11) DEFAULT NULL COMMENT 'ссылка на собирателя',
  `expedition_id` int(11) DEFAULT NULL COMMENT 'ссылка на экспедицию',
  `place_id` int(11) DEFAULT NULL COMMENT 'ссылка на место',
  `doc_path` varchar(255) DEFAULT NULL,
  `doc_comment` text,
  `session_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`,`title`),
  KEY `id_idx` (`expedition_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Структура таблицы `arch25_konsa_exp_expeditions`
--

CREATE TABLE IF NOT EXISTS `arch25_konsa_exp_expeditions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `expedition_title` varchar(255) NOT NULL DEFAULT 'Тема экспедиции',
  `begin_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `chief_collector` int(11) unsigned DEFAULT '0',
  `comment` text NOT NULL,
  `keywords` varchar(2048) NOT NULL,
  `image_folder` varchar(255) NOT NULL,
  `added` datetime NOT NULL,
  `year_begin` year(4) NOT NULL DEFAULT '0000',
  `month_begin` int(2) NOT NULL DEFAULT '0',
  `month_end` int(2) NOT NULL DEFAULT '0',
  `year_end` year(4) NOT NULL DEFAULT '0000',
  PRIMARY KEY (`id`),
  KEY `year` (`year_begin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Экспедиции' AUTO_INCREMENT=70 ;

-- --------------------------------------------------------

--
-- Структура таблицы `arch25_konsa_exp_phonograms`
--

CREATE TABLE IF NOT EXISTS `arch25_konsa_exp_phonograms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phonogram_title` varchar(255) DEFAULT NULL COMMENT 'название фонограммы',
  `collector_id` int(11) DEFAULT NULL COMMENT 'ссылка на собирателя',
  `expedition_id` int(11) DEFAULT NULL COMMENT 'ссылка на экспедицию',
  `town_id` int(11) DEFAULT NULL COMMENT 'ссылка на населенный пункт',
  `recorddate` date DEFAULT NULL COMMENT 'Дата записи',
  `soundfile` varchar(255) DEFAULT NULL COMMENT 'путь к звуковому файлу',
  `textfile` varchar(255) DEFAULT NULL COMMENT 'путь к текстовому файлу',
  `text` text COMMENT 'для текста',
  `comment` text COMMENT 'комментарий',
  `session_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3548 ;

-- --------------------------------------------------------

--
-- Структура таблицы `arch25_konsa_exp_photos`
--

CREATE TABLE IF NOT EXISTS `arch25_konsa_exp_photos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT 'заголовок',
  `short_description` varchar(255) DEFAULT NULL COMMENT 'краткое описание',
  `description` text COMMENT 'описание',
  `parents_id` int(11) unsigned DEFAULT NULL COMMENT 'ссылка на главный документ',
  `image` varchar(255) DEFAULT NULL COMMENT 'картинка к фотографии',
  `date` date DEFAULT NULL COMMENT 'дата создания',
  `add_date` date DEFAULT NULL COMMENT 'дата добавления в базу',
  `autor_id` int(11) DEFAULT NULL COMMENT 'ссылка на автора',
  `collector_id` int(11) DEFAULT NULL COMMENT 'ссылка на собирателя',
  `expedition_id` int(11) DEFAULT NULL COMMENT 'ссылка на экспедицию',
  `place_id` int(11) DEFAULT NULL COMMENT 'ссылка на место',
  `path` varchar(255) DEFAULT NULL,
  `comment` text,
  `session_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`,`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `arch25_konsa_exp_regions`
--

CREATE TABLE IF NOT EXISTS `arch25_konsa_exp_regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region_name` varchar(128) NOT NULL,
  `okrug` varchar(128) NOT NULL COMMENT 'федеральный округ',
  `capital` varchar(64) NOT NULL COMMENT 'Столица',
  `region_code` int(11) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `region_name` (`region_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='таблица регионов' AUTO_INCREMENT=36 ;

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

-- --------------------------------------------------------

--
-- Структура таблицы `arch25_konsa_exp_towns`
--

CREATE TABLE IF NOT EXISTS `arch25_konsa_exp_towns` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `town_name` varchar(64) NOT NULL,
  `coordinata` varchar(128) NOT NULL,
  `oldname` varchar(64) NOT NULL,
  `rename_year` int(11) NOT NULL DEFAULT '0',
  `type` varchar(128) NOT NULL DEFAULT 'Город',
  `region` int(11) NOT NULL DEFAULT '0',
  `expeditions` int(11) NOT NULL DEFAULT '0',
  `autors` int(11) NOT NULL,
  `audio` int(11) NOT NULL,
  `photos` int(11) NOT NULL,
  `books` int(11) NOT NULL,
  `video` int(11) NOT NULL,
  `subname` varchar(64) NOT NULL COMMENT 'район внутри',
  `comment` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`town_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Населенные пункты' AUTO_INCREMENT=279 ;

-- --------------------------------------------------------

--
-- Структура таблицы `arch25_konsa_exp_tracks`
--

CREATE TABLE IF NOT EXISTS `arch25_konsa_exp_tracks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `town_id` int(11) DEFAULT NULL COMMENT 'привязка к населенному пункту',
  `expedition_id` int(11) DEFAULT NULL COMMENT 'привязка к экспедиции',
  `village_name` varchar(128) DEFAULT NULL COMMENT 'название населенного пункта если его нет в базе населенных пунктов',
  `number` int(4) NOT NULL DEFAULT '0' COMMENT 'Номер по порядку',
  `date` date NOT NULL COMMENT 'дата приезда',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Таблица маршрутов экспедиций' AUTO_INCREMENT=284 ;

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
