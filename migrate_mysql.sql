ALTER TABLE `cemyx_emails` ADD `email_title` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `subject`;


-- Synathina - ACCMR database
ALTER TABLE `cemyx_actions` ADD `origin` SMALLINT NOT NULL AFTER `action_id`;

ALTER TABLE `cemyx_stegihours` ADD `origin` SMALLINT NOT NULL AFTER `accmr_team_id`;


