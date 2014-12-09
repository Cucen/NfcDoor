# Host: localhost  (Version: 5.1.72-community)
# Date: 2014-08-26 17:33:58
# Generator: MySQL-Front 5.3  (Build 4.128)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(30) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `phone_Number` varchar(25) DEFAULT NULL,
  `phone_IMEI` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

#
# Data for table "users"
#

INSERT INTO `users` VALUES (1,'Muzeyyen','123','0 535 438 02 82','111111 00 \r\n111111 /4 ','user4.jpg'),(2,'Ali Ihsan','123','0 535 438 02 81','111111 00 \r\n111111 /5','user6.jpg'),(3,'Kayra','123','0 535 438 02 83','111111 00 \r\n111111 /6','user1.jpg'),(4,'Kubra','123','0 535 438 02 84','111111 00 \r\n111111 /7','user3.jpg'),(5,'Mustafa','123','0 535 438 02 85','111111 00 \r\n111111 /8','user2.jpg'),(6,'Samet','123','0 535 438 02 86','111111 00 \r\n111111 /9','user5.jpg'),(7,'Halit','123','0 535 438 02 87','111111 00 \r\n111111 /0','user7.jpg'),(8,'Hanife','123','0 535 438 02 88','111111 00 \r\n111111 /1 ','user9.jpg'),(9,'Ali','123','0 535 438 02 89','111111 00 \r\n111111 /2','user8.jpg'),(10,'Ihsan','123','0 535 438 02 82','111111 00 \r\n111111 /3','user10.jpg');
