CREATE TABLE IF NOT EXISTS `information` (
  `starttime` int(11) NOT NULL,
  `refreshtime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `information` (`starttime`, `refreshtime`) VALUES
(0, 0);

CREATE TABLE IF NOT EXISTS `servers` (
  `ip` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `servers` (`ip`) VALUES
('127.0.0.1:27015');

CREATE TABLE IF NOT EXISTS `settings` (
  `host` varchar(15) NOT NULL,
  `port` int(5) NOT NULL,
  `sort` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  UNIQUE KEY `port` (`port`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `settings` (`host`, `port`, `sort`, `status`) VALUES
('127.0.0.1', 27010, 1, 1);

CREATE TABLE IF NOT EXISTS `statistics` (
  `ip` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;