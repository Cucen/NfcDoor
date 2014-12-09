# Host: localhost  (Version: 5.1.72-community)
# Date: 2014-08-26 17:33:41
# Generator: MySQL-Front 5.3  (Build 4.128)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "door"
#

DROP TABLE IF EXISTS `door`;
CREATE TABLE `door` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `telephone_number` varchar(255) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `yetkiVerildi` int(11) DEFAULT NULL,
  `imeiNumber` varchar(50) DEFAULT NULL,
  `key` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

#
# Data for table "door"
#

INSERT INTO `door` VALUES (1,'Muzeyyen','0 535 438 02 82','2014-07-03 11:12:11',1,'111111 00 \r\n111111 /0','35511589120142160','muzeyyen.histioglu@gmail.com'),(2,'Ali Ihsan','0 532 317 98 73','2014-07-03 12:12:34',1,'222222 00 222222 /2','55135925230570136','muzeyyen.histioglu@gmail.com'),(3,'Kayra','0 535 438 02 83','2014-07-02 12:45:55',0,'333333 00 333333 /3',NULL,'muzeyyen.histioglu@gmail.com'),(4,'Kubra','0 535 438 02 84','2014-06-03 10:12:34',0,'444444 00 444444 /4','62219752441160380','muzeyyen.histioglu@gmail.com'),(5,'Mustafa','0 535 438 02 85','2014-05-04 01:12:34',0,'555555 00 555555 /5','83892395603470510','muzeyyen.histioglu@gmail.com'),(6,'Samet','0 535 438 02 66','2014-05-05 15:12:22',0,'666666 00 666666 /6','17439530463889242','muzeyyen.histioglu@gmail.com'),(7,'Halit','0 535 438 02 77','2014-07-03 12:12:34',0,'777777 00 777777 /7',NULL,'muzeyyen.histioglu@gmail.com'),(8,'Hanife','0 535 438 02 88','2014-07-03 12:12:34',0,'888888 00 888888 /8',NULL,'muzeyyen.histioglu@gmail.com'),(9,'Ali','0 535 438 02 99','2014-07-03 12:12:34',0,'999999 00 999999 /9',NULL,'muzeyyen.histioglu@gmail.com'),(10,'Ihsan','0 535 438 02 00','2014-07-03 12:12:34',0,'123456 00 789123 /4',NULL,'muzeyyen.histioglu@gmail.com');
