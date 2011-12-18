DROP DATABASE IF EXISTS `test_mldic`;
CREATE DATABASE `test_mldic`
       DEFAULT CHARACTER SET = utf8
       DEFAULT COLLATE = utf8_unicode_ci;

USE `test_mldic`;

DROP TABLE IF EXISTS `entries`;
CREATE TABLE `entries` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `phrase` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language_id` int unsigned NOT NULL,
  `created_by` int unsigned NOT NULL,
  `created_date` timestamp DEFAULT 0,
  `modified_by` int unsigned DEFAULT NULL,
  `modified_date` timestamp DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `phrase` (`phrase`),
  UNIQUE `phrase_lang` (`phrase`, `language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `descriptions`;
CREATE TABLE `descriptions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int unsigned NOT NULL,
  `created_by` int unsigned NOT NULL,
  `created_date` timestamp DEFAULT 0,
  `modified_by` int unsigned DEFAULT NULL,
  `modified_date` timestamp DEFAULT 0,
  `description_text` text COLLATE utf8_unicode_ci NOT NULL,
  `rating_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `associations`;
CREATE TABLE `associations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `rating_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `entries_associations`;
CREATE TABLE `entries_associations` (
  `association_id` int unsigned NOT NULL,
  `entry_id` int unsigned NOT NULL,
  PRIMARY KEY (`association_id`,`entry_id`),
  UNIQUE KEY `REV_PRIMARY` (`entry_id`,`association_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `ratings`;
CREATE TABLE `ratings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `num_of_votes` int unsigned NOT NULL DEFAULT '0',
  `total_rating` float(3,1) NOT NULL DEFAULT '0.0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- TEMPORARY DATA FOR TABLES
INSERT INTO users (id, username, first_name, last_name) VALUES (1, 'admin', 'Test', 'Admin');

INSERT INTO languages (id, code, name) VALUES (1, 'en', 'english');
INSERT INTO languages (id, code, name) VALUES (2, 'hu', 'hungarian');
INSERT INTO languages (id, code, name) VALUES (3, 'ru', 'russian');

INSERT INTO entries (id, phrase, language_id, created_by, created_date, modified_by, modified_date) VALUES (1, 'abdomen', 1, 1, '2011-12-04 02:18:30', NULL, '0000-00-00 00:00:00'),
        (2, 'живот', 3, 1, '2011-12-04 02:24:11', NULL, '0000-00-00 00:00:00'),
        (3, 'has', 2, 1, '2011-12-04 02:35:06', NULL, '0000-00-00 00:00:00');

INSERT INTO ratings (id) VALUES (1), (2), (3);

INSERT INTO associations (id, rating_id) VALUES (1, 1), (2, 2), (3, 3);

INSERT INTO entries_associations (association_id, entry_id) VALUES (1, 1), (1, 2), (2, 1), (2, 3), (3, 2), (3, 3);