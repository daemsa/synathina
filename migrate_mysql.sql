-- IMPORT TABLE
ALTER TABLE `cemyx_emails` ADD `email_title` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `subject`;

-- Synathina - ACCMR database
-- MOVE tables actions, teams, stegihours here
-- delete from original databases all assetes with #__actions, #__teams, #__stegihours
-- zero value to all asset_id
DELETE FROM `cemyx_assets` WHERE name LIKE '#__actions%';
ALTER TABLE `cemyx_actions` ADD `origin` TINYINT NOT NULL DEFAULT '1' AFTER `action_id`;
ALTER TABLE `cemyx_actions` ADD `accmr_team_id` INT NOT NULL DEFAULT '0' AFTER `team_id`;
ALTER TABLE `cemyx_actions` ADD `remote` TINYINT NOT NULL DEFAULT '0' AFTER `origin`;

ALTER TABLE `cemyx_stegihours` ADD `origin` SMALLINT NOT NULL AFTER `accmr_team_id`;


