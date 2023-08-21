-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `author`;
CREATE TABLE `author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `author` (`id`, `firstname`, `lastname`) VALUES
(1,	'Ben',	'Ichou');

DROP TABLE IF EXISTS `character`;
CREATE TABLE `character` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `released_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `comics`;
CREATE TABLE `comics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poster` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `released_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `synopsis` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `rarity` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2D56FB58F675F31B` (`author_id`),
  CONSTRAINT `FK_2D56FB58F675F31B` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `comics` (`id`, `author_id`, `title`, `poster`, `released_at`, `synopsis`, `rarity`) VALUES
(1,	1,	'Batman VS Superman',	'https://media.gqmagazine.fr/photos/639ae5bcaa342b4423bab372/3:2/w_3594,h_2396,c_limit/MCDBAVV_EC017.jpg',	'2023-08-21 19:50:15',	'Cest un super Comics!',	5);

DROP TABLE IF EXISTS `comics_characters`;
CREATE TABLE `comics_characters` (
  `comics_id` int(11) NOT NULL,
  `characters_id` int(11) NOT NULL,
  PRIMARY KEY (`comics_id`,`characters_id`),
  KEY `IDX_1088B50271AE76A2` (`comics_id`),
  KEY `IDX_1088B502C70F0E28` (`characters_id`),
  CONSTRAINT `FK_1088B50271AE76A2` FOREIGN KEY (`comics_id`) REFERENCES `comics` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `comics_characters` (`comics_id`, `characters_id`) VALUES
(1,	1);

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230821171557',	'2023-08-21 19:16:04',	79),
('DoctrineMigrations\\Version20230821172411',	'2023-08-21 19:24:16',	38),
('DoctrineMigrations\\Version20230821172829',	'2023-08-21 19:28:32',	48);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `user_collection`;
CREATE TABLE `user_collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` smallint(6) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_5B2AA3DEA76ED395` (`user_id`),
  CONSTRAINT `FK_5B2AA3DEA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `user_collection_comics`;
CREATE TABLE `user_collection_comics` (
  `user_collection_id` int(11) NOT NULL,
  `comics_id` int(11) NOT NULL,
  PRIMARY KEY (`user_collection_id`,`comics_id`),
  KEY `IDX_276CB885BFC7FBAD` (`user_collection_id`),
  KEY `IDX_276CB88571AE76A2` (`comics_id`),
  CONSTRAINT `FK_276CB88571AE76A2` FOREIGN KEY (`comics_id`) REFERENCES `comics` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_276CB885BFC7FBAD` FOREIGN KEY (`user_collection_id`) REFERENCES `user_collection` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 2023-08-21 18:22:40