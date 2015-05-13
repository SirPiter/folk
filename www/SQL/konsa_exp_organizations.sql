--
-- Структура таблицы `arch25_konsa_exp_organizations`
--

CREATE TABLE IF NOT EXISTS `arch25_konsa_exp_organizations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID организации',
  `name` text NOT NULL COMMENT 'Название организации',
  `code` text NOT NULL COMMENT 'код организации (макс. 5 знаков)',
  `comment` text NOT NULL COMMENT 'Комментарий',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Created Date and Time',
  `created_by` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Created by User ID',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified Date and Time',
  `modified_by` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Modified by User ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

