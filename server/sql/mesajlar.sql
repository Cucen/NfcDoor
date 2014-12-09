# Host: localhost  (Version: 5.1.72-community)
# Date: 2014-10-21 22:15:09
# Generator: MySQL-Front 5.3  (Build 4.128)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "mesajlar"
#

DROP TABLE IF EXISTS `mesajlar`;
CREATE TABLE `mesajlar` (
  `idmesajlar` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `gelen` varchar(500) DEFAULT NULL,
  `giden` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`idmesajlar`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

#
# Data for table "mesajlar"
#

INSERT INTO `mesajlar` VALUES (2,2,'1 gun sonra size bilgi verilecektir.','Ihale bittikten ne kadar sure sonra bize bilgi vereceksiniz?'),(3,2,'Ihale bitiminde size mesajla bilgi verilecektir.','Ihalenin kime kaldigini nasil ogrenebilirim?'),(4,1,'5 gun sonra size bilgi verilecektir.','Ihale bittikten ne kadar sure sonra bize bilgi vereceksiniz?'),(5,1,'Son gun 22 Mayis 2014','Son gun ne zaman?');
