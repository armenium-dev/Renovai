<?php
$tables = "
CREATE TABLE IF NOT EXISTS `{prefix}country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iso` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `nicename` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET={charset_collate} COLLATE=utf8mb4_unicode_520_ci;
";

$views = "";

return ['tables' => $tables, 'views' => $views];
