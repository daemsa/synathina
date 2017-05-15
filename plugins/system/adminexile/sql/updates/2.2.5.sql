CREATE TABLE IF NOT EXISTS `#__plg_system_adminexile_tmpwhitelist` (
  `ip` varchar(15) NOT NULL,
  `expire` datetime NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
