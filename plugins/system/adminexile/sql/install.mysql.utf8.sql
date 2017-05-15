CREATE TABLE IF NOT EXISTS `#__plg_system_adminexile` (
  `ip` varchar(45) NOT NULL,
  `firstattempt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastattempt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `attempts` int(11) NOT NULL,
  `penalty` int(11) NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__plg_system_adminexile_tmpwhitelist` (
  `ip` varchar(15) NOT NULL,
  `expire` datetime NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
