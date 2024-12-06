/*
SQLyog Enterprise v8.63 
MySQL - 5.5.5-10.1.6-MariaDB : Database - tester
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `projects` */

CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `base_url` varchar(255) DEFAULT NULL,
  `annot` text,
  `status` tinyint(4) DEFAULT NULL,
  `status_text` varchar(255) DEFAULT NULL,
  `lastrun_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Table structure for table `tests` */

CREATE TABLE `tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `annot` text,
  `url` varchar(255) NOT NULL,
  `xpath` varchar(255) DEFAULT NULL,
  `xpath_exclude` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `template` text,
  `body` text,
  `lastrun_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
