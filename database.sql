# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.7.23)
# Database: express
# Generation Time: 2018-10-10 20:39:04 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table accounts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `accounts`;

CREATE TABLE `accounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account_name` varchar(200) DEFAULT NULL,
  `account_code` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table completed_orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `completed_orders`;

CREATE TABLE `completed_orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(200) DEFAULT NULL,
  `order` text,
  `time_placed` varchar(100) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `full_name` varchar(200) DEFAULT NULL,
  `email_address` varchar(200) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `processed_by` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `config`;

CREATE TABLE `config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `business_name` varchar(200) DEFAULT NULL,
  `business_slogan` varchar(500) DEFAULT NULL,
  `theme_color` varchar(200) DEFAULT NULL,
  `order_time` int(11) DEFAULT NULL,
  `logo_enabled` varchar(5) DEFAULT NULL,
  `logo_width` varchar(5) DEFAULT NULL,
  `logo_height` varchar(5) DEFAULT NULL,
  `pos_enabled` varchar(5) DEFAULT NULL,
  `express_enabled` varchar(5) DEFAULT NULL,
  `email_address` varchar(200) DEFAULT NULL,
  `currency` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table hours
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hours`;

CREATE TABLE `hours` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `monday_open` varchar(10) DEFAULT NULL,
  `monday_close` varchar(10) DEFAULT NULL,
  `monday_closed` varchar(10) DEFAULT NULL,
  `tuesday_open` varchar(10) DEFAULT NULL,
  `tuesday_close` varchar(10) DEFAULT NULL,
  `tuesday_closed` varchar(10) DEFAULT NULL,
  `wednesday_open` varchar(10) DEFAULT NULL,
  `wednesday_close` varchar(10) DEFAULT NULL,
  `wednesday_closed` varchar(10) DEFAULT NULL,
  `thursday_open` varchar(10) DEFAULT NULL,
  `thursday_close` varchar(10) DEFAULT NULL,
  `thursday_closed` varchar(10) DEFAULT NULL,
  `friday_open` varchar(10) DEFAULT NULL,
  `friday_close` varchar(10) DEFAULT NULL,
  `friday_closed` varchar(10) DEFAULT NULL,
  `saturday_open` varchar(10) DEFAULT NULL,
  `saturday_close` varchar(10) DEFAULT NULL,
  `saturday_closed` varchar(10) DEFAULT NULL,
  `sunday_open` varchar(10) DEFAULT NULL,
  `sunday_close` varchar(10) DEFAULT NULL,
  `sunday_closed` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table incoming_orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `incoming_orders`;

CREATE TABLE `incoming_orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(200) DEFAULT NULL,
  `order` text,
  `time_ordered` varchar(100) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `full_name` varchar(200) DEFAULT NULL,
  `email_address` varchar(200) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log`;

CREATE TABLE `log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `information` text,
  `user` varchar(500) DEFAULT NULL,
  `time` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table login
# ------------------------------------------------------------

DROP TABLE IF EXISTS `login`;

CREATE TABLE `login` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(500) DEFAULT NULL,
  `password` varchar(500) DEFAULT NULL,
  `name` varchar(500) DEFAULT NULL,
  `admin` varchar(3) DEFAULT NULL,
  `permanent` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `item_name` varchar(200) DEFAULT NULL,
  `item_slogan` varchar(500) DEFAULT NULL,
  `item_price` varchar(10) DEFAULT NULL,
  `item_modifiers` text,
  `item_category` varchar(200) DEFAULT NULL,
  `for_sale` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table modifiers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `modifiers`;

CREATE TABLE `modifiers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `modifier_name` varchar(200) DEFAULT NULL,
  `modifier_data` text,
  `modifier_type` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
