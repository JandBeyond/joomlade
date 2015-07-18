CREATE TABLE IF NOT EXISTS `#__kickcck_cck` (
  `cck` varchar(50) NOT NULL,
  `context` varchar(50) NOT NULL,
  `id` int(11) NOT NULL
);

CREATE TABLE IF NOT EXISTS `#__kickcck_content` (
  `content_id` int(11) NOT NULL,
  `context` varchar(50) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  PRIMARY KEY (`content_id`,`context`)
);

CREATE TABLE IF NOT EXISTS `#__kickcck_images` (
  `content_id` int(11) NOT NULL,
  `context` varchar(50) NOT NULL,
  `cckimages` text NOT NULL,
  PRIMARY KEY (`content_id`,`context`)
);