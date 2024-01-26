CREATE DATABASE `contactsdb` /*!40100 COLLATE 'utf8_polish_ci' */;
USE `contactsDB`;

CREATE TABLE `contacts` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_polish_ci',
	`surname` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_polish_ci',
	`phone` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_polish_ci',
	`email` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_polish_ci',
	`address` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_polish_ci',
	`categoryId` INT(11) NULL DEFAULT NULL COLLATE 'utf8_polish_ci',
	`note` BLOB NULL,
	PRIMARY KEY (`id`),
	INDEX `main` (`name`, `surname`, `email`)
)
	COLLATE='utf8_polish_ci'
	ENGINE=InnoDB
;

CREATE TABLE `categories` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`label` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_polish_ci',
	PRIMARY KEY (`id`)
)
	COLLATE='utf8_polish_ci'
	ENGINE=InnoDB
;

INSERT INTO `contacts` (`id`, `name`, `surname`, `phone`, `email`, `address`, `categoryId`) VALUES (1, 'Jan', 'Myśliński', '600600600', 'j.mys@gmail.com', 'Srebrnikowa 66/6', 1);
INSERT INTO `contacts` (`id`, `name`, `surname`, `phone`, `email`, `address`, `categoryId`) VALUES (2, 'Alicja', 'Strąkiewicz', '500500500', 'a.strak@wp.pl', 'Gdańska 15/4', 2);

INSERT INTO `categories` (`id`, `label`) VALUES (1, 'Prywatne');
INSERT INTO `categories` (`id`, `label`) VALUES (2, 'Służbowe');