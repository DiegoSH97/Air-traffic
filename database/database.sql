CREATE DATABASE `aircrafts`;

USE `aircrafts`;

DROP TABLE IF EXISTS `aircraft_types`;

CREATE TABLE `aircraft_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `aircraft_types` WRITE;
INSERT INTO `aircraft_types` VALUES (1,'Emergency',1),(2,'VIP',2),(3,'Passenger',3),(4,'Cargo',4);
UNLOCK TABLES;

DROP TABLE IF EXISTS `aircrafts`;

CREATE TABLE `aircrafts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `size` smallint(6) NOT NULL,
  `aircraft_type_id` bigint(20) unsigned NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `aircrafts_FK` (`aircraft_type_id`),
  CONSTRAINT `aircrafts_FK` FOREIGN KEY (`aircraft_type_id`) REFERENCES `aircraft_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
