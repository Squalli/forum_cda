/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE IF NOT EXISTS `forum_cda` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `forum_cda`;

CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int(11) NOT NULL AUTO_INCREMENT,
  `text` text COLLATE utf8_bin NOT NULL,
  `creationdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id_post`),
  KEY `FK_post_user` (`user_id`),
  KEY `FK_post_topic` (`topic_id`),
  CONSTRAINT `FK_post_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`) ON DELETE CASCADE,
  CONSTRAINT `FK_post_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` (`id_post`, `text`, `creationdate`, `topic_id`, `user_id`) VALUES
	(1, 'Mais cette fois, avec un message !', '2020-04-16 11:25:48', 2, 8),
	(7, '<p>Mais &ccedil;a commence &agrave; faire beaucoup !</p>', '2020-04-17 14:39:16', 7, 8),
	(8, 'Youpi, en voilà un autre !', '2020-04-17 14:52:04', 2, 8),
	(9, 'C&#39;est super !', '2020-04-17 14:52:12', 2, 8),
	(10, 'Ca marche même avec des balises', '2020-04-17 14:52:33', 2, 8),
	(12, 'Moi aussi je trouve !!', '2020-04-17 15:08:02', 7, 9),
	(13, '<p>Oh allez, &ccedil;a va passer ! je peux modifier&nbsp;</p>', '2020-04-19 14:52:08', 7, 8),
	(23, 'First !', '2020-04-20 11:27:37', 1, 8),
	(30, '<p>Pas le temps de manger !</p>', '2020-04-20 17:56:18', 11, 10),
	(31, 'pas tout capté...\r\n', '2020-04-20 17:57:17', 11, 11),
	(32, '<p>Un chercheur d\'outre-Qui&eacute;vrain est sur le coup...</p>\r\n<p><img class="mimg" src="https://th.bing.com/th/id/OIP.wqfRrNcZM3-b03ST4Pm6XAHaFp?w=247&amp;h=181&amp;c=7&amp;o=5&amp;pid=1.7" alt="R&eacute;sultat d&rsquo;images pour beaver" width="247" height="181" data-thhnrepbd="1" data-bm="42" /></p>', '2020-04-21 10:48:35', 12, 8),
	(33, '<p>Oh c\'est trop chou les castors !!!</p>\r\n<p><img class="n3VNCb" src="https://www.pausecafein.fr/images/cafein/2019/04/bebes-castors/castor-bebe-chou.jpg" alt="24 photos de b&eacute;b&eacute;s castors pour vivre la meilleure journ&eacute;e ..." width="380" height="190" data-noaft="1" /></p>\r\n<p style="text-align: center;"><strong>TROP CHOU !!!</strong></p>', '2020-04-21 11:44:24', 12, 8);
/*!40000 ALTER TABLE `post` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `creationdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `closed` tinyint(4) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id_topic`),
  KEY `FK_topic_user` (`user_id`),
  CONSTRAINT `FK_topic_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40000 ALTER TABLE `topic` DISABLE KEYS */;
INSERT INTO `topic` (`id_topic`, `title`, `creationdate`, `closed`, `user_id`) VALUES
	(1, 'Premier', '2020-04-16 14:23:23', 0, 9),
	(2, 'Deuxième', '2020-04-16 11:25:47', 0, 9),
	(7, 'J&#39;aime beaucoup le confinement !', '2020-04-17 14:39:16', 1, 8),
	(11, 'Bon j&#39;ai du boulot', '2020-04-20 17:56:18', 0, 10),
	(12, 'Les castors lapons sont-ils hermaphrodites ?', '2020-04-21 10:48:35', 0, 8);
/*!40000 ALTER TABLE `topic` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `email` varchar(60) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `roles` json DEFAULT NULL,
  `registerdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id_user`, `username`, `email`, `password`, `roles`, `registerdate`) VALUES
	(8, 'squalli', 'squall@gmail.com', '$argon2i$v=19$m=1024,t=2,p=2$TVlxL1BGbVlPUkRIRUpsUg$PLnyIWfMYn347gm7lupj2LBve3muYnvkTsq4YCFdMxI', '["ROLE_USER"]', '2020-04-15 17:27:38'),
	(9, 'audrey', 'audrey@gmail.com', '$argon2i$v=19$m=1024,t=2,p=2$OXFUcG9NZTUudkR2QUlYMw$1CWZ3gkpudYvXtFEwR0N+5xx0ba2OJoxUgHQfx9p8+k', '["ROLE_USER", "ROLE_ADMIN"]', '2020-04-15 17:30:33'),
	(10, 'hulk', 'hulk@gmail.com', '$argon2i$v=19$m=1024,t=2,p=2$UlIyRmR5Yi5EalB0YURrWA$yltzCRpx/nnoHP5LqHgEmrCBDSUB+qpP2v8CkunSFfA', '["ROLE_USER"]', '2020-04-20 17:51:22'),
	(11, 'zzpapy', 'gregory.pace@hotmail.fr', '$argon2i$v=19$m=1024,t=2,p=2$ckNPM1FTbFBBeEtpSE5ZUw$IinEFbedM9kM4C/QTnQXnW4NtQ1PbGZn5mzIweAVfJE', '["ROLE_USER"]', '2020-04-20 17:52:12');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
