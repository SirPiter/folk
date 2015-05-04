ALTER TABLE `arch25_konsa_exp_organizations` 
ADD `created`  DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Created Date and Time',
ADD `created_by`  INT( 11 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Created by User ID',
ADD `modified`  DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified Date and Time',
ADD `modified_by`  INT( 11 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Modified by User ID'