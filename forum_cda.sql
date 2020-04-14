-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           5.7.24 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour forum_cda
CREATE DATABASE IF NOT EXISTS `forum_cda` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `forum_cda`;

-- Listage de la structure de la table forum_cda. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `creationdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `closed` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_topic`),
  KEY `FK_topic_user` (`user_id`),
  CONSTRAINT `FK_topic_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Listage des données de la table forum_cda.topic : ~2 rows (environ)
/*!40000 ALTER TABLE `topic` DISABLE KEYS */;
INSERT INTO `topic` (`id_topic`, `title`, `creationdate`, `user_id`, `closed`) VALUES
	(1, 'Premier topic !', '2020-04-13 16:10:46', 3, 0),
	(2, 'Encore un sujet vide !', '2020-04-13 16:10:59', 2, 0);
/*!40000 ALTER TABLE `topic` ENABLE KEYS */;

-- Listage de la structure de la table forum_cda. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `registerdate` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Listage des données de la table forum_cda.user : ~6 rows (environ)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id_user`, `username`, `email`, `password`, `registerdate`) VALUES
	(1, 'Steph', 'kiki@kiki.fr', '$argon2i$v=19$m=1024,t=2,p=2$R2VvUG85dndsZGpnU2ZkYg$Oi+SnBQb+fiL4RJKlGGON8EYPWOMYcLjwJE8ekbXLGI', '2020-04-07 16:01:42'),
	(2, 'Audrey', 'audrey@gmail.com', '$argon2i$v=19$m=1024,t=2,p=2$T1FPOC9Tek5UY2h1VDl2eQ$Ej5sRSoyU6Yd8R7+3+/Nnh+eRPghUDEk7vIhIE/fSPo', '2020-04-07 16:30:27'),
	(3, 'Jeremie', 'jerem@gmail.com', '$argon2i$v=19$m=1024,t=2,p=2$SVRtRktma3lSeVpWN2llSw$jOiW2fbFNIvvZva8gnT+EBKSNUaVC432vJynPBROYMA', '2020-04-07 16:43:45'),
	(4, 'Roger', 'roger@gmail.com', '$argon2i$v=19$m=1024,t=2,p=2$cm01M0dUS1hyLjZmdnUueQ$wQqBoOM13DZN9pTSMoy2LlAQCzngO0FJRx0Lv1KhRyw', '2020-04-08 13:51:19'),
	(5, 'Steph', 's@g.lo', '$argon2i$v=19$m=1024,t=2,p=2$SlV1OVJiUTI1bGd4WDJmZQ$VIb6RwANF+tyU6sLpFT8RysyNpTgPXKsJRLtArl5U2Y', '2020-04-09 14:15:04'),
	(6, 'Squalli', 'squalli@gmail.com', '$argon2i$v=19$m=1024,t=2,p=2$RXZtWjVEdlQ0c0djTXI1dw$9WGgIs/Z84hIwFD4kdQSD9dufSw07m+Sg9nH6E0rDLQ', '2020-04-09 14:41:14');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
