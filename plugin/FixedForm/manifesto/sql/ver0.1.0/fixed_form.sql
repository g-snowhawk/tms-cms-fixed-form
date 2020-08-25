-- 
-- Fixed Form optional SQl
-- 
-- version 0.1
--
-- Create Reservation function master table
-- 
CREATE TABLE IF NOT EXISTS `TMS_fixed_form` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sitekey` int NOT NULL,
  `userkey` int unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text,
  `tags` varchar(1024) DEFAULT NULL,
  `fgcolor` varchar(255) DEFAULT NULL,
  `bgcolor` varchar(255) DEFAULT NULL,
  `author_date` datetime DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `modify_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sitekey` (`sitekey`),
  KEY `userkey` (`userkey`),
  CONSTRAINT `TMS_fixed_form_ibfk_1` FOREIGN KEY (`sitekey`) REFERENCES `TMS_site` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `TMS_fixed_form_ibfk_2` FOREIGN KEY (`userkey`) REFERENCES `TMS_user` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
