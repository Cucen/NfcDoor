# Host: localhost  (Version: 5.1.72-community)
# Date: 2014-08-26 17:34:08
# Generator: MySQL-Front 5.3  (Build 4.128)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "key"
#

DROP TABLE IF EXISTS `key`;
CREATE TABLE `key` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(50) DEFAULT NULL,
  `userid` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "key"
#

