/* Date: 2016-11-04 */

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `coupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `delivery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delivery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned NOT NULL COMMENT 'ID пользователя',
  `emailBase` varchar(255) DEFAULT NULL COMMENT 'Путь к фалу адресов',
  `senderBase` varchar(255) DEFAULT NULL,
  `titleBase` varchar(255) DEFAULT NULL COMMENT 'Путь к файлу тем',
  `title` varchar(255) DEFAULT NULL COMMENT 'Тема если еденичная',
  `email` varchar(255) DEFAULT NULL COMMENT 'Контрольная почта',
  `body` varchar(255) DEFAULT NULL COMMENT 'Тело письма',
  `file` varchar(255) DEFAULT NULL COMMENT 'Файл приложения',
  `macros` varchar(255) DEFAULT NULL COMMENT 'Путь к архиву с макросом',
  `type` enum('text','html') DEFAULT 'html',
  `count` int(11) DEFAULT NULL COMMENT 'Количество рассылаемых писем ',
  `sendCount` int(11) DEFAULT NULL,
  `tookTime` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  `message` varchar(255) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `read` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Заказы на рассылку';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `generated_link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `generated_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  CONSTRAINT `generated_link_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=608 DEFAULT CHARSET=utf8 COMMENT='Созданные ссылки редиректа';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `i`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `buyAmount` varchar(10) DEFAULT NULL,
  `buyPrice` varchar(10) DEFAULT NULL,
  `sellAmount` varchar(10) DEFAULT NULL,
  `sellPrice` varchar(10) DEFAULT NULL,
  `city` varchar(10) DEFAULT '10101',
  `district` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `start` int(11) DEFAULT '10',
  `live` int(11) DEFAULT '18',
  `login` varchar(32) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `login_minfin` varchar(32) DEFAULT NULL,
  `password_minfin` varchar(32) DEFAULT NULL,
  `phone_minfin` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Покупка / продажа i.ua';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `interkassa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `interkassa` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payAmount` decimal(10,2) DEFAULT NULL,
  `currency` varchar(5) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `userId` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` smallint(1) DEFAULT '0',
  `date` datetime DEFAULT NULL,
  `system` varchar(32) DEFAULT NULL,
  `systemId` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `date` timestamp NULL DEFAULT NULL,
  `type` enum('slider','new') DEFAULT 'new',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='Новости';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `USER_LOGIN` varchar(50) DEFAULT NULL COMMENT 'Логин пользователя',
  `ORDER_TYPE` smallint(6) DEFAULT NULL COMMENT 'ID товара',
  `RUN_COUNT` smallint(6) DEFAULT NULL COMMENT 'Количество в заказе',
  `URL` varchar(255) DEFAULT NULL COMMENT 'Ссылка на продукт???',
  `DATE_TIME` datetime DEFAULT NULL COMMENT 'Время заказа',
  `URL_RESULT` varchar(255) DEFAULT NULL COMMENT 'Что тут????',
  `ORDER_STATE` smallint(6) DEFAULT NULL COMMENT 'Статус: 0 не обработан, 1 в обработке, 2 завершен',
  `read` tinyint(1) DEFAULT '0',
  `informed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `countPrice` int(11) NOT NULL DEFAULT '1',
  `description` text,
  `url` varchar(255) DEFAULT NULL,
  `productUrl` varchar(255) DEFAULT NULL,
  `activateKey` varchar(255) DEFAULT NULL,
  `type` enum('buy','processing') DEFAULT 'buy',
  `sort` int(11) DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `purchase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned NOT NULL COMMENT 'Ид пользователя.',
  `region` varchar(255) DEFAULT NULL COMMENT 'Регион.',
  `count` int(11) DEFAULT NULL COMMENT 'Количество адресов для парса.',
  `sex` enum('male','female','all') DEFAULT 'all' COMMENT 'Пол.',
  `from` int(11) DEFAULT NULL,
  `to` int(11) DEFAULT NULL,
  `online` tinyint(1) DEFAULT NULL COMMENT 'Онлайн.',
  `price` int(11) DEFAULT NULL COMMENT 'Цена за заказ.',
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата и время.',
  `status` int(1) DEFAULT NULL COMMENT 'Статус заказа не запущенн - 0,в процессе - 1, завершен-2',
  `execution` varchar(64) DEFAULT NULL COMMENT 'Приблизительно время выполнения.',
  `read` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  CONSTRAINT `purchase_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Покупка парсинга mail.ru';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `read` tinyint(1) DEFAULT '0',
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  CONSTRAINT `question_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Вопросы';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `question_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `questionId` int(10) unsigned NOT NULL,
  `type` enum('user','admin') DEFAULT NULL,
  `message` text,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questionId` (`questionId`),
  CONSTRAINT `question_message_ibfk_1` FOREIGN KEY (`questionId`) REFERENCES `question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Тексты вопросов';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `refill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refill` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `min` decimal(10,2) DEFAULT NULL,
  `max` decimal(10,2) DEFAULT NULL,
  `bonus` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `key` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='Настройки';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `softCode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `softCode` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productId` int(10) unsigned NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `productId` (`productId`),
  CONSTRAINT `softCode_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `softOrders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `softOrders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productId` int(10) unsigned NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `productId` (`productId`),
  KEY `userId` (`userId`),
  CONSTRAINT `softOrders_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `softOrders_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Покупки софта';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `statistics_link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statistics_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `linkId` int(10) unsigned NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `linkId` (`linkId`),
  CONSTRAINT `statistics_link_ibfk_1` FOREIGN KEY (`linkId`) REFERENCES `generated_link` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='История редиректов';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `skype` varchar(64) DEFAULT NULL,
  `icq` varchar(64) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `balance` decimal(10,2) NOT NULL,
  `referralCode` varchar(255) DEFAULT NULL,
  `authCode` int(11) DEFAULT NULL,
  `paid` timestamp NULL DEFAULT NULL,
  `i_ua_login` varchar(255) DEFAULT NULL,
  `i_ua_password` varchar(255) DEFAULT NULL,
  `i_ua_city` varchar(10) DEFAULT NULL,
  `minfin_login` varchar(255) DEFAULT NULL,
  `minfin_password` varchar(255) DEFAULT NULL,
  `minfin_phone` varchar(32) DEFAULT NULL,
  `buyAmount` varchar(10) DEFAULT '0',
  `buyPrice` varchar(10) DEFAULT NULL,
  `sellAmount` varchar(10) DEFAULT '0',
  `sellPrice` varchar(10) DEFAULT NULL,
  `currency` varchar(5) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `start` int(11) DEFAULT NULL,
  `live` int(11) DEFAULT NULL,
  `role` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=682 DEFAULT CHARSET=utf8 COMMENT='юзера';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_identifying`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_identifying` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteId` int(10) unsigned NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `nid` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT '1',
  `cookid` varchar(32) DEFAULT NULL,
  `vkid` varchar(32) DEFAULT NULL,
  `vkname` varchar(32) DEFAULT NULL,
  `lname` varchar(32) DEFAULT NULL,
  `sex` varchar(5) DEFAULT NULL,
  `domain` varchar(32) DEFAULT NULL,
  `bdate` varchar(16) DEFAULT NULL,
  `city` varchar(16) DEFAULT NULL,
  `citytxt` varchar(16) DEFAULT NULL,
  `photo_50` varchar(255) DEFAULT NULL,
  `interests` varchar(255) DEFAULT NULL,
  `activities` varchar(16) DEFAULT NULL,
  `contacts` varchar(255) DEFAULT NULL,
  `remoteid` varchar(16) DEFAULT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `siteId` (`siteId`),
  CONSTRAINT `user_identifying_ibfk_1` FOREIGN KEY (`siteId`) REFERENCES `user_sites` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='Посетители сайтов';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `ip` varchar(32) DEFAULT NULL,
  `isAuth` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=274 DEFAULT CHARSET=latin1 COMMENT='Посетители сайта.';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_referral`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_referral` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parentId` int(10) unsigned NOT NULL,
  `refId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `refId` (`refId`),
  KEY `parentId` (`parentId`,`refId`),
  CONSTRAINT `user_referral_ibfk_1` FOREIGN KEY (`parentId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_referral_ibfk_2` FOREIGN KEY (`refId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Рефералы';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_sites` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `script` text,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='Сайты пользователей.';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

LOCK TABLES `coupon` WRITE;
/*!40000 ALTER TABLE `coupon` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupon` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `delivery` WRITE;
/*!40000 ALTER TABLE `delivery` DISABLE KEYS */;
/*!40000 ALTER TABLE `delivery` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `generated_link` WRITE;
/*!40000 ALTER TABLE `generated_link` DISABLE KEYS */;
INSERT INTO `generated_link` VALUES (2,1,'UdTcJ',0),(3,1,'chVCh',1),(4,1,'YhsSS',4),(11,1,'GLnvG',0),(15,1,'OXfzM',0),(17,1,'NijeP',0),(18,1,'cBVUN',0),(22,1,'ysLId',5),(447,1,'pftlx',0),(451,1,'EFDsI',0),(452,1,'CDtnI',0),(453,1,'gsAMG',0),(454,1,'euALn',0),(455,1,'ULdZE',0),(529,1,'okzRJ',0),(600,1,'MhKap',0),(601,1,'PztHu',0),(602,1,'TOYHT',0),(603,1,'klnnL',0),(604,1,'sRMtR',0),(605,1,'ItfPc',0),(606,1,'eolvk',0),(607,1,'BPeFX',0);
/*!40000 ALTER TABLE `generated_link` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `i` WRITE;
/*!40000 ALTER TABLE `i` DISABLE KEYS */;
INSERT INTO `i` VALUES (1,'0','25.1','0','25.1','10101','Теремки, ул. Глушкова, Магелан','можно частями',10,21,'boosyck@i.ua','g65uerden','boosyck','g65uerden','+380508571647');
/*!40000 ALTER TABLE `i` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `interkassa` WRITE;
/*!40000 ALTER TABLE `interkassa` DISABLE KEYS */;
INSERT INTO `interkassa` VALUES (1,NULL,NULL,10.00,1,'Пополнение баланса на сайте http://vkdirect.ru/cabinet на сумму 10$',1,'2015-07-30 17:49:16',NULL,'38704330'),(2,NULL,NULL,600.00,1,'Пополнение баланса на сайте http://vkdirect.ru/cabinet на сумму 600$',0,'2015-07-30 17:58:23',NULL,NULL),(3,NULL,NULL,600.00,1,'Пополнение баланса на сайте http://vkdirect.ru/cabinet на сумму 10$',1,'2015-07-30 17:59:57',NULL,'38704683'),(4,NULL,NULL,600.00,1,'Пополнение баланса на сайте http://vkdirect.ru/cabinet на сумму 10$',0,'2015-07-31 11:26:12',NULL,NULL),(5,10.00,'USD',10.00,1,'Пополнение баланса на сайте http://vkdirect.ru/cabinet на сумму 10$',0,'2015-07-31 13:25:21','webmoney',NULL),(6,10.00,'USD',10.00,1,'Пополнение баланса на сайте http://vkdirect.ru/cabinet на сумму 10$',0,'2015-07-31 13:27:29','webmoney',NULL),(7,10.00,'USD',10.00,1,'Пополнение баланса на сайте http://vkdirect.ru/cabinet на сумму 10$',0,'2015-07-31 13:28:20','webmoney',NULL),(8,10.00,'USD',10.00,1,'Пополнение баланса на сайте http://vkdirect.ru/cabinet на сумму 10$',0,'2015-07-31 13:32:35','webmoney',NULL),(9,10.00,'USD',10.00,1,'Пополнение баланса на сайте http://vkdirect.ru/cabinet на сумму 10$',0,'2015-07-31 13:32:44','webmoney',NULL),(10,10.00,'USD',10.00,1,'Пополнение баланса на сайте http://vkdirect.ru/cabinet на сумму 10$',0,'2015-07-31 13:33:20','webmoney',NULL),(11,10.00,'USD',10.00,1,'Пополнение баланса',0,'2015-07-31 13:33:56','webmoney',NULL),(12,10.00,'RUR',0.16,1,'Пополнение баланса',0,'2015-07-31 13:34:25','webmoney',NULL),(13,100.00,'RUR',1.62,1,'Пополнение баланса',0,'2015-07-31 13:40:23','webmoney',NULL),(14,10.00,'USD',10.00,1,'Пополнение баланса',0,'2015-07-31 13:44:31','webmoney',NULL),(15,10.00,'RUR',0.16,1,'Пополнение баланса на сайте http://vkdirect.ru/cabinet на сумму 0.16$',1,'2015-07-31 13:55:25','interkassa','38726480'),(16,50.00,'UAH',2.31,1,'Пополнение баланса на сайте http://vkdirect.ru/cabinet на сумму 2.31$',0,'2015-07-31 13:56:17','interkassa',NULL),(17,210.00,'USD',210.00,1,'Пополнение баланса',0,'2015-07-31 13:56:39','webmoney',NULL),(18,210.00,'UAH',9.72,1,'Пополнение баланса на сайте http://vkdirect.ru/cabinet на сумму 9.72$',0,'2015-07-31 13:57:34','interkassa',NULL),(19,210.00,'UAH',9.72,1,'Пополнение баланса на сайте http://vkdirect.ru/cabinet на сумму 9.72$',1,'2015-07-31 14:04:33','interkassa','38726724'),(20,10.00,'USD',10.00,1,'Пополнение баланса',0,'2015-07-31 14:05:04','webmoney',NULL),(21,65.00,'RUR',1.05,1,'Пополнение баланса',1,'2015-07-31 14:05:57','webmoney','244'),(22,40.00,'UAH',1.85,1,'Пополнение баланса',1,'2015-07-31 14:07:24','webmoney','738'),(23,10.00,'RUR',0.16,1,'Пополнение баланса на сайте http://vkdirect.ru/cabinet на сумму 0.16$',0,'2015-07-31 14:11:10','interkassa',NULL),(24,10.00,'USD',10.00,1,'Пополнение баланса',0,'2015-08-05 14:16:36','webmoney',NULL),(25,1.00,'RUR',0.02,665,'Пополнение баланса на сайте http://vkdirect.ru/cabinet на сумму 0.02$',0,'2015-08-11 20:32:46','interkassa',NULL),(26,10.00,'USD',10.00,665,'Пополнение баланса',0,'2015-08-11 20:33:09','webmoney',NULL),(27,10.00,'RUR',0.16,665,'Пополнение баланса на сайте http://vkdirect.ru/cabinet на сумму 0.16$',0,'2015-08-11 20:33:22','interkassa',NULL),(28,10.00,'USD',10.00,665,'Пополнение баланса',0,'2015-08-11 20:34:53','webmoney',NULL),(29,10.00,'RUR',0.16,665,'Пополнение баланса на сайте http://vkdirect.ru/cabinet на сумму 0.16$',0,'2015-08-11 20:35:08','interkassa',NULL),(30,10.00,'USD',10.00,1,'Пополнение баланса',0,'2015-12-28 13:13:19','webmoney',NULL),(31,10.00,'UAH',0.42,677,'Пополнение баланса на сайте http://exchange.vkdirect.ru/cabinet на сумму 0.42$',0,'2015-12-28 19:25:33','interkassa',NULL),(32,10.00,'UAH',0.42,677,'Пополнение баланса',0,'2015-12-28 19:27:53','webmoney',NULL),(33,20.00,'UAH',0.84,677,'Пополнение баланса на сайте http://exchange.vkdirect.ru/cabinet на сумму 0.84$',0,'2015-12-29 11:41:57','interkassa',NULL),(34,10.00,'UAH',0.42,677,'Пополнение баланса',0,'2015-12-29 12:21:12','liqpay',NULL),(35,25.00,'UAH',1.05,677,'Пополнение баланса',0,'2015-12-29 12:23:44','liqpay',NULL),(36,1.00,'UAH',0.04,677,'Пополнение баланса',1,'2015-12-29 13:21:17','liqpay','784806u1451388177713371'),(37,2.00,'UAH',0.08,677,'Пополнение баланса',1,'2015-12-29 13:47:09','liqpay','784806u1451389748284440'),(38,10.00,'USD',10.00,677,'Пополнение баланса',0,'2015-12-29 13:52:20','webmoney',NULL),(39,100.00,'RUR',1.62,677,'Пополнение баланса',1,'2015-12-29 13:54:54','webmoney','646'),(40,10.00,'UAH',0.42,677,'Пополнение баланса',0,'2015-12-29 13:57:15','webmoney',NULL),(41,10.00,'USD',10.00,1,'Пополнение баланса',0,'2016-08-12 10:32:31','webmoney',NULL);
/*!40000 ALTER TABLE `interkassa` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (4,'Автоматический сервис создания редиректов','Домены обновлены, добавлена система рефералов и бонусов.','2015-02-23 11:40:33','slider'),(8,'Сделать редиректы разных типов.','В кабинете у вас будет возможность заказать создание редиректов разных типов чем дороже тип редиректов тем больше там доменов и эти домены менее подвержены спам филтрам.\r\nТакже доступны персональные редиректы которые создаются на выделенных специально для вас доменах, такие редиректы лучше всего обходят спам фильтры.','2015-01-09 23:46:35','slider');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `purchase` WRITE;
/*!40000 ALTER TABLE `purchase` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchase` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `question_message` WRITE;
/*!40000 ALTER TABLE `question_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `question_message` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `refill` WRITE;
/*!40000 ALTER TABLE `refill` DISABLE KEYS */;
INSERT INTO `refill` VALUES (3,50.00,100.00,5.00),(5,25.00,50.00,2.00),(6,100.00,200.00,10.00);
/*!40000 ALTER TABLE `refill` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `setting` WRITE;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
INSERT INTO `setting` VALUES (1,'deliveryPrice','1','1000'),(2,'deliveryMacrosPrice','2','1000'),(3,'purchasePrice','2','1000'),(4,'vk_app_id','','5015909'),(5,'identify_price','','0.01');
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `softCode` WRITE;
/*!40000 ALTER TABLE `softCode` DISABLE KEYS */;
/*!40000 ALTER TABLE `softCode` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `softOrders` WRITE;
/*!40000 ALTER TABLE `softOrders` DISABLE KEYS */;
/*!40000 ALTER TABLE `softOrders` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `statistics_link` WRITE;
/*!40000 ALTER TABLE `statistics_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `statistics_link` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'TurboPWNZ','kasp89s@gmail.com','TurboPWNZ','kasp89s','1565465456','1ad1cc12ca176e470d4fb1c44ff82aba',487.71,'7226de7ab759fd51d2226f81bc8832b8',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(662,'ksm','kasp89s@mail.ru','','','','1ad1cc12ca176e470d4fb1c44ff82aba',0.90,'ff99ca295f8881111258b9fca56b12f7',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(663,'лафа','aliya.latypova@mail.ru','','','','4757c70298f5ec8b539d3d1264670e17',0.00,'7422ed373615300e5b046fd29ce0c7e8',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(664,'vladislava ','vladislava.cherepowa@yandex.ru','','НЕту','Нету','0b4877826858f44572171e5bcdbbb506',0.00,'ca284b2a6c0ee865610fab3c43e85171',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(665,'vazerman','vadim@lugovoi.ru','Vadim','','','a2cc9a3c73b1079054669b85f4c747ed',0.49,'cf043e274b528e0fe7d9d701503a10e1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(666,'fantastika18','ohapkinaa@list.ru','anastasya','','','c567bd395ad0c49317e0ca73eb58127d',0.50,'b0a46bc7175b853d7cbbf1f8aa68c300',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(667,'gorput','gorput_minsk@mail.ru','','','','20eff6d031256003c9ca2daafa227a17',0.50,'c88515b8b9d433345fbf4db09510dda6',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(668,'chika17','chika-90@inbox.ru','Sergey','','','79ba48586bf44ae9dca868c8c9f6033b',0.50,'47a0cb76081eb4259104c98016d9648f',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(669,'ogorbova','ongorbova@gmail.com','ol','','','9f7f9274291c6c942379af9039fb0a14',0.50,NULL,88713740,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(670,'Deac','lao4716@gmail.com','Andrew','','429038162','5f27db4c780bc9ab1216f9eaffb0487d',0.50,'5b8336233ccc31601ec8ae91cf37ac62',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(671,'day-night72','oteltrio@yandex.ru','Rustam','rus7719','','4f8b8ec07c1942fff8f7f4e10726611a',0.50,'6121af11d859be2d0ba1b47b2717112d',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(672,'Vitaminchikk','p.volinsckiy@yandex.ru','Pavel','','','fe6a106966842536cb62a54ba8798612',0.50,'c24bafbf0ae4513656af01d3dc317e29',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(673,'Williambar','temptest1220919793@mail.ru','Williambar','WilliambarGY','245636155','afd73c3d90de842e049ec25004a2c642',0.50,NULL,91981609,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(674,'Richarddiz','temptest7889536@mail.ru','Richarddiz','RicharddizGE','264631116','241c3e1441ee16e262236efbb1d271a0',0.50,NULL,84088183,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(675,'WilliamCab','scmpvkomp@mail.ru','WilliamCab','WilliamCabHC','214142563','b439056ccc75bc1d37b0af6e062f6b11',0.50,NULL,13953899,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(676,'nikitin','my.bin@ya.ru','','','','c609121d5ff0a2ba31cb015996ab47cd',0.50,'78a744d59c906bc5e3af83bae7b40725',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(677,'kasp89s','boosyck@i.ua','kasp89s','','','1ad1cc12ca176e470d4fb1c44ff82aba',1.64,'5c66e6d3ada72177e53249d6c89df639',NULL,'2015-12-30 13:39:46','boosyck@i.ua','g65uerden','10101','boosyck','g65uerden','+380508571647','0','27.1','0','27.5','eur','Борщаговка, ул. Симеренко','целиком',10,18,0),(678,'testua9@gmail.com','testua9@gmail.com','','yama123456','erg','afed4d19b1ee0e0c797d249609782970',0.00,'32766b24671e5432d24f3d3144f3e8b0',NULL,'2015-12-29 11:41:56',NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,0),(679,'Fuenniapsen','sydneyfru@rambler.ru','Fuenniapsen','FuenniapsenXN','333872073','4ee4fc73c650d256f06421c6a60a8f60',0.00,NULL,62156770,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,0),(680,'MichaelBig','znakomchelbystor@yandex.ru','MichaelBig','MichaelBigJD','341178752','40d8f5021dc49cff085d4670ff2d47c7',0.00,NULL,99066042,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,0),(681,'proflinks.ru','chuzhinar@mail.ru','proflinks.ru','proflinks.ru','254111837','5d391094b82259a7abb742823f50b6bb',0.00,NULL,92524279,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0',NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `user_identifying` WRITE;
/*!40000 ALTER TABLE `user_identifying` DISABLE KEYS */;
INSERT INTO `user_identifying` VALUES (2,1,1,0,1,'4','12140344','Сережа','Каспрук','2','turbopwnz','19.2','314','Киев','http://cs625620.vk.me/v625620344/4218b/GIBPUWvT0XQ.jpg','','','','178.159.238.134','2015-07-28 00:34:48'),(3,4,1,0,1,'5','12140344','Сережа','Каспрук','2','turbopwnz','19.2','314','Киев','http://cs625620.vk.me/v625620344/4218b/GIBPUWvT0XQ.jpg','','','','178.159.238.134','2015-07-28 00:35:42'),(4,4,1,0,1,'8','135950813','Дмитрий','Краснов','2','id135950813','','1','Москва','http://cs418231.vk.me/v418231813/91c9/-ZaSFk72r44.jpg','','','','83.220.51.234','2015-07-28 07:22:18'),(5,4,1,0,1,'13','12140344','Сережа','Каспрук','2','turbopwnz','19.2','314','Киев','http://cs625620.vk.me/v625620344/4218b/GIBPUWvT0XQ.jpg','','','','94.153.218.229','2015-07-28 15:03:56'),(6,4,1,0,1,'14','230200961','Юрий','Пидгорный','2','newwwzzz','15.5.1986','5915','Киселевск','http://cs624931.vk.me/v624931961/2d9a0/1PkY4k1WpM0.jpg','','','','81.161.122.251','2015-07-28 17:08:50'),(7,4,1,0,1,'15','259694953','Виталий','Балицевич','2','id259694953','14.6.1986','1517767','Актобе','http://cs625728.vk.me/v625728953/1cc9b/omU45ntImnc.jpg','','','','92.47.3.148','2015-07-29 14:33:09'),(8,6,662,0,6,'1','12140344','Сережа','Каспрук','2','turbopwnz','19.2','314','Киев','http://cs625620.vk.me/v625620344/4218b/GIBPUWvT0XQ.jpg','','','','94.153.218.229','2015-07-31 12:08:11'),(9,9,665,0,1,'17','344669','Вадим','Луговой','2','lugovoi','18.9','2','Санкт-Петербург','http://cs11437.vk.me/v11437669/1130/4sA4ZYyn_d8.jpg','','','','188.162.64.3','2015-08-15 15:33:14');
/*!40000 ALTER TABLE `user_identifying` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `user_log` WRITE;
/*!40000 ALTER TABLE `user_log` DISABLE KEYS */;
INSERT INTO `user_log` VALUES (1,662,'94.153.218.229',1),(2,662,'94.153.218.229',1),(3,662,'94.153.218.229',1),(4,662,'94.153.218.229',1),(5,662,'94.153.218.229',1),(6,662,'94.153.218.229',1),(7,662,'66.249.78.129',0),(8,662,'109.86.12.241',0),(9,665,'94.153.218.229',0),(10,665,'2a02:6b8:0:f09::5c',0),(11,670,'79.134.4.59',0),(12,665,'46.242.113.232',0),(13,665,'66.249.75.93',0),(14,665,'2a02:6b8:0:1602::54',0),(15,665,'37.151.236.168',0),(16,665,'2a02:6b8:0:f09::5c',0),(17,665,'188.162.64.3',1),(18,665,'2a02:6b8:0:f09::5c',0),(19,665,'2a02:6b8:0:f09::5c',0),(20,665,'85.143.131.206',0),(21,665,'2a02:6b8:0:1a33:8ca8:91fa:d74b:2',0),(22,665,'2a02:6b8:0:f09::5c',0),(23,670,'79.134.4.59',0),(24,670,'79.134.4.59',0),(25,665,'2a02:6b8:0:1a33:8ca8:91fa:d74b:2',0),(26,665,'2a02:6b8:0:1602::54',0),(27,665,'2a02:6b8:0:1a33:8ca8:91fa:d74b:2',0),(28,665,'2a02:6b8:0:f09::5c',0),(29,662,'66.249.79.52',0),(30,665,'2a02:6b8:0:1a33:8ca8:91fa:d74b:2',0),(31,665,'2a02:6b8:0:f09::5c',0),(32,665,'64.74.215.88',0),(33,665,'176.77.122.163',0),(34,665,'2a02:6b8:0:1602::54',0),(35,665,'208.91.115.10',0),(36,662,'178.159.238.134',0),(37,665,'66.249.82.182',0),(38,665,'2a02:6b8:0:1602::54',0),(39,665,'66.249.69.61',0),(40,665,'2a02:6b8:0:f09::5c',0),(41,665,'2.101.48.152',0),(42,665,'2a02:6b8:0:1a33:8ca8:91fa:d74b:2',0),(43,665,'2a01:4f8:200:534a::2',0),(44,665,'66.102.8.243',0),(45,665,'176.98.48.10',0),(46,665,'95.103.81.167',0),(47,665,'2601:141:101:8d9a:649a:33a9:6b1f',0),(48,665,'2a02:6b8:0:1602::54',0),(49,665,'38.99.82.208',0),(50,665,'38.99.82.226',0),(51,665,'2a02:6b8:0:1a33:8ca8:91fa:d74b:2',0),(52,665,'217.69.132.242',0),(53,665,'178.78.123.66',0),(54,665,'38.99.82.207',0),(55,665,'38.99.82.208',0),(56,665,'38.99.82.208',0),(57,665,'38.99.82.208',0),(58,665,'38.99.82.208',0),(59,665,'38.99.82.208',0),(60,665,'38.99.82.207',0),(61,665,'38.99.82.207',0),(62,665,'2a02:6b8:0:1a33:8ca8:91fa:d74b:2',0),(63,665,'38.99.82.207',0),(64,665,'38.99.82.207',0),(65,665,'38.99.82.207',0),(66,665,'38.99.82.207',0),(67,665,'38.99.82.207',0),(68,665,'38.99.82.207',0),(69,665,'38.99.82.207',0),(70,665,'38.99.82.207',0),(71,665,'38.99.82.233',0),(72,665,'38.99.82.233',0),(73,665,'38.99.82.233',0),(74,665,'2a01:4f8:201:116a::2',0),(75,665,'38.99.82.233',0),(76,665,'38.99.82.233',0),(77,665,'38.99.82.208',0),(78,665,'38.99.82.208',0),(79,665,'38.99.82.208',0),(80,665,'38.99.82.208',0),(81,665,'125.54.249.27',0),(82,665,'2a02:6b8:0:1a33:8ca8:91fa:d74b:2',0),(83,662,'66.249.78.136',0),(84,665,'66.249.75.109',0),(85,665,'66.249.75.109',0),(86,665,'66.249.75.101',0),(87,665,'66.249.75.101',0),(88,665,'66.249.75.109',0),(89,665,'2a02:6b8:0:1a33:8ca8:91fa:d74b:2',0),(90,665,'81.30.243.170',0),(91,665,'2a02:6b8:0:f09::5c',0),(92,665,'77.37.242.107',0),(93,665,'2.92.201.252',0),(94,665,'89.178.7.186',0),(95,665,'2a02:1205:5008:a680:4095:9f7c:8c',0),(96,665,'188.255.99.30',0),(97,665,'2a02:6b8:0:f09::5c',0),(98,665,'95.28.15.215',0),(99,665,'176.14.137.45',0),(100,665,'148.251.126.37',0),(101,665,'93.159.230.39',0),(102,665,'46.73.186.249',0),(103,665,'94.253.93.173',0),(104,665,'89.178.166.217',0),(105,665,'176.193.119.115',0),(106,665,'66.249.67.52',0),(107,665,'66.249.67.58',0),(108,665,'176.193.97.52',0),(109,665,'188.32.179.105',0),(110,665,'66.249.75.101',0),(111,665,'66.249.75.109',0),(112,665,'66.249.75.109',0),(113,665,'178.140.85.118',0),(114,665,'66.249.67.58',0),(115,665,'66.249.67.45',0),(116,665,'66.249.67.45',0),(117,665,'2a02:6b8:0:f09::5c',0),(118,665,'66.249.67.58',0),(119,665,'66.249.67.45',0),(120,665,'66.249.67.58',0),(121,665,'66.249.67.45',0),(122,665,'2a02:6b8:0:f09::5c',0),(123,665,'94.23.160.54',0),(124,665,'94.23.160.54',0),(125,665,'2a02:6b8:0:1a33:8ca8:91fa:d74b:2',0),(126,662,'66.249.67.58',0),(127,670,'79.134.4.59',0),(128,665,'109.167.220.21',0),(129,665,'70.164.255.174',0),(130,665,'66.249.78.129',0),(131,665,'183.83.239.44',0),(132,665,'182.178.248.112',0),(133,665,'174.108.5.93',0),(134,665,'182.186.56.166',0),(135,665,'176.83.48.13',0),(136,665,'5.18.134.228',0),(137,665,'14.202.234.41',0),(138,665,'46.242.113.191',0),(139,665,'37.144.12.236',0),(140,665,'66.249.64.248',0),(141,665,'109.173.23.91',0),(142,665,'66.102.9.37',0),(143,665,'159.224.159.2',0),(144,665,'66.249.64.243',0),(145,665,'71.178.0.51',0),(146,665,'2620:101:4035:324:150:70:173:6',0),(147,665,'5.1.9.151',0),(148,665,'70.210.16.184',0),(149,665,'5.254.65.17',0),(150,665,'111.188.14.6',0),(151,665,'109.173.45.59',0),(152,665,'176.14.31.90',0),(153,665,'46.242.126.96',0),(154,665,'46.147.98.162',0),(155,665,'176.195.81.247',0),(156,665,'188.32.70.113',0),(157,665,'109.195.91.69',0),(158,665,'89.178.70.166',0),(159,665,'176.77.7.76',0),(160,665,'72.185.91.143',0),(161,665,'83.237.55.220',0),(162,665,'176.77.46.174',0),(163,665,'176.193.97.127',0),(164,665,'176.14.175.92',0),(165,665,'95.24.196.234',0),(166,665,'176.195.224.177',0),(167,665,'46.200.143.132',0),(168,665,'66.249.67.58',0),(169,665,'66.249.67.45',0),(170,665,'104.236.57.54',0),(171,665,'109.251.76.104',0),(172,665,'24.133.238.161',0),(173,665,'92.247.55.254',0),(174,665,'37.214.73.197',0),(175,665,'176.193.221.7',0),(176,665,'93.81.116.186',0),(177,665,'109.86.20.105',0),(178,665,'5.164.90.224',0),(179,665,'5.164.253.166',0),(180,665,'87.169.25.77',0),(181,665,'77.37.220.232',0),(182,665,'95.24.202.248',0),(183,665,'95.27.1.172',0),(184,665,'128.69.147.202',0),(185,665,'95.221.221.176',0),(186,665,'149.210.171.70',0),(187,665,'46.216.168.146',0),(188,665,'109.205.248.213',0),(189,665,'72.69.226.10',0),(190,665,'46.216.172.193',0),(191,665,'63.92.242.25',0),(192,665,'191.189.108.47',0),(193,665,'5.107.21.247',0),(194,665,'188.162.64.25',0),(195,665,'37.204.15.159',0),(196,665,'66.249.78.136',0),(197,665,'200.24.214.35',0),(198,665,'176.9.139.227',0),(199,665,'216.55.177.85',0),(200,665,'188.32.66.55',0),(201,665,'37.204.81.37',0),(202,665,'93.80.219.17',0),(203,665,'176.77.119.76',0),(204,665,'178.140.98.167',0),(205,665,'66.249.64.218',0),(206,665,'5.251.86.212',0),(207,665,'66.249.64.208',0),(208,665,'93.31.101.229',0),(209,665,'37.212.162.164',0),(210,665,'66.249.93.183',0),(211,665,'188.162.64.18',0),(212,665,'178.140.84.251',0),(213,665,'109.173.57.103',0),(214,665,'77.37.220.232',0),(215,665,'46.242.69.57',0),(216,665,'188.255.99.66',0),(217,665,'176.77.23.89',0),(218,665,'109.173.22.133',0),(219,665,'176.195.59.143',0),(220,665,'188.255.65.232',0),(221,665,'5.165.246.48',0),(222,665,'37.145.125.180',0),(223,665,'95.27.200.84',0),(224,665,'188.255.23.221',0),(225,665,'176.193.102.127',0),(226,665,'109.95.18.165',0),(227,665,'83.149.9.92',0),(228,665,'66.249.79.201',0),(229,665,'37.204.56.111',0),(230,665,'66.249.79.201',0),(231,665,'89.178.90.81',0),(232,665,'77.223.81.130',0),(233,665,'168.235.198.217',0),(234,665,'66.249.79.187',0),(235,665,'77.37.174.99',0),(236,665,'46.39.35.229',0),(237,665,'87.5.118.252',0),(238,665,'176.195.216.245',0),(239,665,'46.151.24.30',0),(240,665,'109.205.253.166',0),(241,665,'95.153.135.48',0),(242,665,'41.169.1.98',0),(243,665,'66.249.67.243',0),(244,665,'109.173.57.80',0),(245,665,'93.80.71.174',0),(246,665,'93.80.94.82',0),(247,665,'78.26.162.59',0),(248,665,'217.118.78.117',0),(249,665,'78.109.36.86',0),(250,665,'190.139.39.125',0),(251,665,'66.249.65.194',0),(252,665,'66.249.78.136',0),(253,665,'66.102.9.48',0),(254,665,'178.140.37.90',0),(255,665,'176.195.45.106',0),(256,665,'109.173.53.213',0),(257,665,'5.164.208.70',0),(258,665,'5.164.205.26',0),(259,665,'66.249.78.136',0),(260,665,'66.249.78.129',0),(261,665,'176.77.116.27',0),(262,665,'176.36.3.22',0),(263,665,'92.107.141.133',0),(264,665,'178.219.32.40',0),(265,665,'66.249.69.53',0),(266,665,'66.249.69.61',0),(267,665,'98.114.92.228',0),(268,665,'197.37.216.157',0),(269,665,'83.143.251.102',0),(270,665,'109.205.253.166',0),(271,670,'79.134.4.59',0),(272,665,'66.249.78.129',0),(273,665,'66.249.78.136',0);
/*!40000 ALTER TABLE `user_log` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `user_referral` WRITE;
/*!40000 ALTER TABLE `user_referral` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_referral` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `user_sites` WRITE;
/*!40000 ALTER TABLE `user_sites` DISABLE KEYS */;
INSERT INTO `user_sites` VALUES (1,1,'http://pornoid.mcdir.ru',NULL,1),(4,1,'http://gdeporno.com',NULL,1),(5,1,'https://igra.msl.ua',NULL,1),(6,662,'http://fapteka.com',NULL,1),(7,1,'http://vkdirect.ru',NULL,0),(8,663,'http://antiplagiatpervi.ru',NULL,0),(9,665,'http://remontikvarti.ru',NULL,1),(10,670,'http://crp-centr.ru',NULL,1),(11,671,'http://vk.com/night_day72',NULL,0),(12,672,'http://vk.com',NULL,1),(13,676,'http://www.rostov-internet.ru/',NULL,1),(14,676,'http://www.rostov-internet.ru/',NULL,1);
/*!40000 ALTER TABLE `user_sites` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

