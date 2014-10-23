# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.39)
# Database: intramurals
# Generation Time: 2014-10-23 15:11:18 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP DATABASE IF EXISTS IntraSMUrals;
CREATE DATABASE IntraSMUrals;
USE IntraSMUrals;

# Dump of table Involvement
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Involvement`;

CREATE TABLE `Involvement` (
  `teamID` int(11) NOT NULL,
  `studentID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`studentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Involvement` WRITE;
/*!40000 ALTER TABLE `Involvement` DISABLE KEYS */;

INSERT INTO `Involvement` (`teamID`, `studentID`)
VALUES
	(9,18273942),
	(2,18392039),
	(9,19283910),
	(4,29182930),
	(2,83928192),
	(9,92837201);

/*!40000 ALTER TABLE `Involvement` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Schedule
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Schedule`;

CREATE TABLE `Schedule` (
  `matchID` int(11) NOT NULL DEFAULT '0',
  `sportID` int(11) DEFAULT NULL,
  PRIMARY KEY (`matchID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Schedule` WRITE;
/*!40000 ALTER TABLE `Schedule` DISABLE KEYS */;

INSERT INTO `Schedule` (`matchID`, `sportID`)
VALUES
	(1,43928),
	(2,43928),
	(12,10492),
	(49,56789),
	(100,56789),
	(102,56789),
	(123,12345),
	(234,12345),
	(294,56789),
	(402,56789),
	(403,12345),
	(421,12345),
	(445,10492),
	(446,10492),
	(447,10492),
	(653,12345),
	(654,12345);

/*!40000 ALTER TABLE `Schedule` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Sport
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Sport`;

CREATE TABLE `Sport` (
  `sportID` int(11) NOT NULL DEFAULT '0',
  `sportName` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`sportID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Sport` WRITE;
/*!40000 ALTER TABLE `Sport` DISABLE KEYS */;

INSERT INTO `Sport` (`sportID`, `sportName`)
VALUES
	(10492,'Quidditch'),
	(12345,'Soccer'),
	(43928,'Underwater Basket Weaving'),
	(56789,'Flag Football');

/*!40000 ALTER TABLE `Sport` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Student
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Student`;

CREATE TABLE `Student` (
  `studentID` int(11) NOT NULL DEFAULT '0',
  `studentName` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`studentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Student` WRITE;
/*!40000 ALTER TABLE `Student` DISABLE KEYS */;

INSERT INTO `Student` (`studentID`, `studentName`, `email`)
VALUES
	(18273942,'Some Person','person@smu.edu'),
	(18392039,'New Kid','kid@smu.edu'),
	(19283910,'Jock Wannabee','wannabee@smu.edu'),
	(29182930,'Jersey Kid','jkid@smu.edu'),
	(30182930,'Cowboys Fan','ckid@smu.edu'),
	(38291829,'Oddly Fit','ofit@smu.edu'),
	(43928392,'Unathletic Dude','dude@smu.edu'),
	(49182930,'Chahlie Albright','albright@smu.edu'),
	(92837201,'Joe Hutchinson','jhutch@smu.edu');

/*!40000 ALTER TABLE `Student` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Team
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Team`;

CREATE TABLE `Team` (
  `sportID` int(11) DEFAULT NULL,
  `teamID` int(11) NOT NULL DEFAULT '0',
  `teamName` varchar(30) DEFAULT NULL,
  `captainID` int(11) DEFAULT NULL,
  PRIMARY KEY (`teamID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Team` WRITE;
/*!40000 ALTER TABLE `Team` DISABLE KEYS */;

INSERT INTO `Team` (`sportID`, `teamID`, `teamName`, `captainID`)
VALUES
	(56789,1,'Alpha',19283910),
	(56789,2,'Pastafarians',19283910),
	(56789,4,'Beta',38291829),
	(12345,6,'Python',43928392),
	(12345,8,'Sigma Tau',18273942),
	(12345,9,'BAMF',92837201),
	(43928,41,'Sandusky',43928392),
	(43928,42,'Shawnee',19283910),
	(43928,43,'Cherokee',18273942);

/*!40000 ALTER TABLE `Team` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table TeamMatch
# ------------------------------------------------------------

DROP TABLE IF EXISTS `TeamMatch`;

CREATE TABLE `TeamMatch` (
  `matchID` int(11) NOT NULL DEFAULT '0',
  `AteamID` int(11) DEFAULT NULL,
  `BteamID` int(11) DEFAULT NULL,
  `ATeamScore` int(11) DEFAULT NULL,
  `BTeamScore` int(11) DEFAULT NULL,
  `dateOf` date DEFAULT NULL,
  `timeOf` time DEFAULT NULL,
  PRIMARY KEY (`matchID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `TeamMatch` WRITE;
/*!40000 ALTER TABLE `TeamMatch` DISABLE KEYS */;

INSERT INTO `TeamMatch` (`matchID`, `AteamID`, `BteamID`, `ATeamScore`, `BTeamScore`, `dateOf`, `timeOf`)
VALUES
	(1,41,42,91,81,'1600-03-12','04:02:10'),
	(2,41,43,12,106,'2013-06-02','06:07:00'),
	(100,1,4,5,7,'2014-11-23','18:30:00'),
	(123,9,8,0,0,'2014-10-04','18:30:00'),
	(234,9,6,0,0,'2014-10-05','18:30:00'),
	(402,2,4,0,0,'2014-10-07','18:30:00'),
	(403,6,8,0,0,'2014-10-06','18:30:00');

/*!40000 ALTER TABLE `TeamMatch` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table User
# ------------------------------------------------------------

DROP TABLE IF EXISTS `User`;

CREATE TABLE `User` (
  `studentID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Password` varchar(12) DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  PRIMARY KEY (`studentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;

INSERT INTO `User` (`studentID`, `Password`, `isAdmin`)
VALUES
	(18273942,'creative',0),
	(18392039,'xxxxxxxx',0),
	(19283910,'123456789',0),
	(29182930,'password!',0),
	(30182930,'sports',0),
	(38291829,'testpsswrd1',0),
	(49182930,'password',1);

/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
