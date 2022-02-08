SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `jokes`;
CREATE TABLE `jokes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` text NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `changed_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) unsigned zerofill NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `jokes_categories`;
CREATE TABLE `jokes_categories` (
  `joke_id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  KEY `joke_id` (`joke_id`),
  KEY `categories_id` (`categories_id`),
  CONSTRAINT `jokes_categories_ibfk_1` FOREIGN KEY (`joke_id`) REFERENCES `jokes` (`id`),
  CONSTRAINT `jokes_categories_ibfk_2` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `categories` (`id`, `value`) VALUES
(1,	'russekort'),
(2,	'allebarna'),
(3,	'svenske'),
(4,	'helse'),
(6,	'it');

INSERT INTO `jokes` (`id`, `value`, `added_date`, `changed_date`, `deleted`) VALUES
(1,	'Det er bedre å la andre tro du er en idiot, enn å åpne kjeften og fjerne enhver tvil.',	'2022-01-02 09:36:35',	'2022-01-02 09:36:35',	0),
(2,	'Ingenting er mer irriterende enn å diskutere med en person som vet hva han snakker om.',	'2022-01-02 09:36:49',	'2022-01-02 09:36:49',	0),
(3,	'Jeg har vært i tvil hele livet, men nå er jeg ikke sikker lenger, eller…',	'2022-01-02 09:37:01',	'2022-01-02 09:37:01',	0),
(4,	'Hvorfor skal jeg tenke før jeg snakker, når jeg ikke aner hva jeg skal si før jeg har sagt det?',	'2022-01-02 09:37:12',	'2022-02-07 12:00:13',	0),
(5,	'Hvis det er så sunt å arbeide, så la de syke gjøre det!',	'2022-01-02 09:37:23',	'2022-01-02 09:37:23',	0),
(6,	'Mine kunnskaper er som en løk. \r\nDen kan skrelles av lag for lag og det som kommer ut er til å grine av.',	'2022-01-02 09:37:34',	'2022-01-03 16:49:19',	0),
(7,	'Du kan ikke beskylde meg for å være en besserwisser bare fordi du alltid tar feil!',	'2022-01-02 09:37:48',	'2022-01-02 09:37:48',	0),
(8,	'Min spesialitet er å ha rett når andre tar feil.',	'2022-01-02 09:37:58',	'2022-01-02 09:37:58',	0),
(9,	'Folk som tror de vet alt, er veldig irriterende for oss som faktisk gjør det.',	'2022-01-02 09:38:09',	'2022-01-02 09:38:09',	0),
(10,	'Dobbeltmoral er bra. Mister man den ene, har man den andre igjen.',	'2022-01-02 09:38:19',	'2022-01-02 09:38:19',	0),
(11,	'Det er bedre å drite seg ut enn å dø av forstoppelse.',	'2022-01-02 09:39:28',	'2022-01-02 09:39:28',	0),
(12,	'Platon er død. Einstein er død. Og jeg føler meg ikke helt vel, jeg heller.',	'2022-01-02 09:39:39',	'2022-01-02 09:39:39',	0),
(13,	'Verden er full av B-mennesker som står opp for tidlig.',	'2022-01-02 09:39:49',	'2022-01-02 09:40:30',	0),
(14,	'Det er utrolig hva enkelte kan finne på når de mangler fantasi.',	'2022-01-02 09:40:01',	'2022-01-02 09:40:01',	0),
(15,	'Alle barna satt på do i fred unntatt Åse, hun glemte å låse.',	'2022-01-02 09:42:51',	'2022-01-02 09:42:51',	0),
(16,	'Alle barna støttet regnskogen unntatt Sara, hun støttet Sahara.',	'2022-01-02 09:46:12',	'2022-01-02 09:46:12',	0),
(17,	'Alle barna hadde fine tenner unntatt Rune, hans var brune.',	'2022-01-02 09:47:17',	'2022-01-02 09:47:17',	0),
(18,	'Vet du hvorfor svenskene holder seg unna spaghetti?\r\n- De har ikke så lange tallerkener i Sverige...',	'2022-01-03 10:04:40',	'2022-01-03 16:48:39',	0),
(19,	'Hvorfor smiler ikke svenskene når de soler seg?\r\n- De er redde for å få brune tenner..',	'2022-01-03 10:04:50',	'2022-01-03 16:48:47',	0),
(20,	'Alle barna skrev dikt unntatt Per, han kunne ikke rime. ',	'2022-01-03 13:52:27',	'2022-01-03 13:52:27',	0),
(21,	'Alle barna hadde navn, unntatt ',	'2022-01-03 13:53:02',	'2022-02-07 12:12:49',	0),
(22,	'Alle barna var smittefrie unntatt Lene, hun var i karantene. ',	'2022-01-03 13:54:59',	'2022-01-03 13:54:59',	0),
(23,	'Hvorfor heller svenskene vann over PC-en sin?\r\n- For å vaske Windows.',	'2022-01-03 14:01:12',	'2022-01-03 16:49:03',	0),
(25,	'Tenk om det ikke fantes elektrisitet. Da måtte vi spille dataspill i mørket!',	'2022-02-08 09:40:08',	'2022-02-08 09:40:08',	0),
(26,	'– Dette beste med internett er at du kan dikte og lyve om alt.\r\nBjørnstjerne Bjørnson.',	'2022-02-08 09:41:51',	'2022-02-08 09:41:51',	0);

INSERT INTO `jokes_categories` (`joke_id`, `categories_id`) VALUES
(1,	1),
(2,	1),
(3,	1),
(4,	1),
(5,	1),
(6,	1),
(7,	1),
(8,	1),
(9,	1),
(10,	1),
(11,	1),
(12,	1),
(13,	1),
(14,	1),
(15,	2),
(16,	2),
(17,	2),
(18,	3),
(19,	3),
(21,	2),
(22,	2),
(23,	3),
(5,	4),
(22,	4),
(17,	4),
(5,	4),
(11,	4),
(12,	4),
(19,	4),
(25,	6),
(26,	6),
(23,	6);
