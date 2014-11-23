# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.39)
# Database: IntraSMUrals
# Generation Time: 2014-11-23 06:44:10 +0000
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
  `studentID` int(11) NOT NULL,
  PRIMARY KEY (`teamID`,`studentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Involvement` WRITE;
/*!40000 ALTER TABLE `Involvement` DISABLE KEYS */;

INSERT INTO `Involvement` (`teamID`, `studentID`)
VALUES
	(0,0),
	(1,12345678),
	(1,13345678),
	(1,18345678),
	(1,24555679),
	(1,41345678),
	(2,12345679),
	(2,16345678),
	(2,21345678),
	(2,31345678),
	(2,51345678),
	(3,13345678),
	(3,19345678),
	(3,24555673),
	(3,38224059),
	(3,61345678),
	(4,14345678),
	(4,24555675),
	(4,33294059),
	(4,38294053),
	(4,71345678),
	(5,15345678),
	(5,24555676),
	(5,38294059),
	(5,81345678),
	(5,91345678),
	(6,17345678),
	(6,24555674),
	(6,24555678),
	(6,38294079),
	(10,12345678),
	(10,14345678),
	(10,16345678),
	(10,21345678),
	(10,24555678),
	(10,38224059),
	(10,38294079),
	(10,51345678),
	(11,12345679),
	(11,17345678),
	(11,24555673),
	(11,24555679),
	(11,38294053),
	(11,41345678),
	(11,61345678),
	(12,11345678),
	(12,18345678),
	(12,24555675),
	(12,31345678),
	(12,38294059),
	(13,15345678),
	(13,19345678),
	(13,24555676),
	(13,24555679),
	(13,33294059),
	(20,11345678),
	(20,18345678),
	(20,31345678),
	(20,41345678),
	(21,12345678),
	(21,12345679),
	(21,21345678),
	(21,38294053),
	(22,13345678),
	(22,24555673),
	(22,38224059),
	(22,38294059),
	(23,14345678),
	(23,24555674),
	(23,33294059),
	(23,51345678),
	(24,15345678),
	(24,24555675),
	(24,24555676),
	(24,61345678),
	(25,16345678),
	(25,24555678),
	(25,38294079),
	(25,71345678),
	(26,17345678),
	(26,19345678),
	(26,24555679),
	(26,81345678),
	(30,11345678),
	(30,24555676),
	(30,38224059),
	(31,12345679),
	(31,16345678),
	(31,24555678),
	(32,13345678),
	(32,15345678),
	(32,24555679),
	(33,17345678),
	(33,24555674),
	(33,31345678),
	(34,18345678),
	(34,24555675),
	(34,33294059),
	(35,19345678),
	(35,38294053),
	(35,91345678),
	(36,12345678),
	(36,21345678),
	(36,38294059),
	(37,14345678),
	(37,24555673),
	(37,38294079),
	(40,12345678),
	(40,12345679),
	(40,18345678),
	(40,24555675),
	(41,13345678),
	(41,19345678),
	(41,24555675),
	(41,24555676),
	(42,14345678),
	(42,21345678),
	(42,24555678),
	(42,24555679),
	(43,15345678),
	(43,24555673),
	(43,31345678),
	(43,38294079),
	(44,16345678),
	(44,17345678),
	(44,24555674),
	(44,91345678),
	(50,11345678),
	(50,19345678),
	(50,24555675),
	(51,12345678),
	(51,21345678),
	(51,24555674),
	(52,12345679),
	(52,24555673),
	(52,24555678),
	(53,13345678),
	(53,14345678),
	(53,24555676),
	(54,16345678),
	(54,24555675),
	(54,24555679),
	(55,17345678),
	(55,31345678),
	(55,71345678),
	(56,18345678),
	(56,33294059),
	(56,61345678),
	(101,24555673),
	(102,21345678),
	(103,24555679),
	(104,24555678),
	(105,24555676),
	(106,19345678),
	(107,24555675);

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
	(0,56790),
	(1,56790),
	(2,56790),
	(3,56790),
	(4,56790),
	(5,56791),
	(6,56791),
	(7,56791),
	(8,56792),
	(9,56792),
	(10,56792),
	(11,56792),
	(12,56793),
	(13,56793),
	(14,56793),
	(15,56793),
	(16,56794),
	(17,56794),
	(18,56794),
	(19,56795),
	(20,56795),
	(21,56795),
	(22,56795),
	(23,56795),
	(24,56795),
	(25,56795),
	(26,56795),
	(27,56795),
	(28,56795),
	(29,56796),
	(30,56796),
	(31,56796),
	(32,56796),
	(33,56796),
	(34,56796),
	(35,56796),
	(36,56796),
	(37,56796),
	(38,56796),
	(39,56796),
	(40,56796);

/*!40000 ALTER TABLE `Schedule` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Sport
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Sport`;

CREATE TABLE `Sport` (
  `sportID` int(11) NOT NULL AUTO_INCREMENT,
  `sportName` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`sportID`),
  UNIQUE KEY `sportName` (`sportName`)
) ENGINE=InnoDB AUTO_INCREMENT=56797 DEFAULT CHARSET=latin1;

LOCK TABLES `Sport` WRITE;
/*!40000 ALTER TABLE `Sport` DISABLE KEYS */;

INSERT INTO `Sport` (`sportID`, `sportName`)
VALUES
	(56796,'Cricket'),
	(56790,'Curling'),
	(56792,'Hockey'),
	(56795,'Judo'),
	(56793,'Quidditch'),
	(56794,'Rugby'),
	(56791,'Underwater Basket Weaving');

/*!40000 ALTER TABLE `Sport` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Student
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Student`;

CREATE TABLE `Student` (
  `studentID` int(11) NOT NULL DEFAULT '0',
  `fname` varchar(30) DEFAULT NULL,
  `lname` varchar(11) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`studentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Student` WRITE;
/*!40000 ALTER TABLE `Student` DISABLE KEYS */;

INSERT INTO `Student` (`studentID`, `fname`, `lname`, `email`)
VALUES
	(11345678,'Kurt','Browning','kBrowning@canada.edu'),
	(12345678,'Wayne','Gretzky','wGretzky@canada.edu'),
	(12345679,'Scott','Goodyear','sGoodyear@bc.edu'),
	(13345678,'Ned','Hanlan','nHanlan@bc.edu'),
	(14345678,'Gordie','Howe','gHowe@acadia.edu'),
	(15345678,'Ferguson ','Jenkins','fJenkins@quebec.edu'),
	(16345678,'Guy ','Lafleur','gLafleur@thisIsHisRealName.edu'),
	(17345678,'Mario ','Lemieux','mLemieux@france.edu'),
	(18345678,'Bronko ','Nagurski','bNagurski@canada.edu'),
	(19345678,'James','Naismith','jNaismith@wtf.edu'),
	(21345678,'Bobby','Orr','bOrr@sadname.edu'),
	(24555673,'Patrick','Roy','pRoy@france.edu'),
	(24555674,'Paul','Tracy','pTracy@quebec.edu'),
	(24555675,'Gilles','Villeneuve','gVelleneuve@acadia.edu'),
	(24555676,'Jacques','Villeneuve','jVilleneuve@france.edu'),
	(24555678,'Donovan','Bailey','dBailey@bc.edu'),
	(24555679,'Marilyn','Bell','mBell@seniorHome.com'),
	(31345678,'George','Chuvalo','gChuvalo@toronto.edu'),
	(33294059,'Greg','Moore','gMoore@gmail.com'),
	(38224059,'Joshua','Slocum','jSlocum@sunDance.com'),
	(38294053,'Larry','Walker','lWalker@hotmail.com'),
	(38294059,'Jeff','Zimmerman','jZimmerman@alberta.ca'),
	(38294079,'Bruno','Caboclo','bCaboclo@toronto.ca'),
	(41345678,'Toller','Cranston','tCranston@yukon.ca'),
	(51345678,'Ken','Dryden','kDryden@quebec.ca'),
	(61345678,'Terry','Fox','tFox@foxy.ca'),
	(71345678,'Rick','Hansen','rHansen@college.edu'),
	(81345678,'Brian','Orser','bOrser@coffee.ca'),
	(91345678,'Mary ','Pierce','mPierce@acadia.edu');

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
  `isApproved` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`teamID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Team` WRITE;
/*!40000 ALTER TABLE `Team` DISABLE KEYS */;

INSERT INTO `Team` (`sportID`, `teamID`, `teamName`, `captainID`, `isApproved`)
VALUES
	(56790,1,'Ottawa Ogres',13345678,1),
	(56790,2,'Edmonton Eagles',16345678,1),
	(56790,3,'Victoria Vixen',19345678,1),
	(56790,4,'Winnipeg Wisecrackers',33294059,1),
	(56790,5,'Fredericton',91345678,1),
	(56790,6,'Halifax Hunters',24555674,1),
	(56791,10,'Toronto Terrors',14345678,1),
	(56791,11,'Charlottetown Charlatans',12345679,1),
	(56791,12,'Regina Rulers',11345678,1),
	(56791,13,'Yelloknife Inmates',24555679,1),
	(56792,20,'Team Canada',41345678,1),
	(56792,21,'Quebec Killers',12345678,1),
	(56792,22,'Nunavut Numbskulls',38224059,1),
	(56792,23,'Winnipeg Wisecrackers',33294059,1),
	(56792,24,'Newfoundland',24555675,1),
	(56792,25,'Whitehorse Wilduns',38294079,1),
	(56792,26,'Victoria Vixen',19345678,1),
	(56793,30,'Nunavat Numbskulls',38224059,1),
	(56793,31,'Edmonton Eagles',16345678,1),
	(56793,32,'Ottawa Ogres',13345678,1),
	(56793,33,'Halifax Haunters',24555674,1),
	(56793,34,'Newfoundland',24555675,1),
	(56793,35,'Fredericton',91345678,1),
	(56793,36,'Quebec Killers',12345678,1),
	(56793,37,'Toronto Terrors',14345678,1),
	(56794,40,'Charlottetown Charlatans',12345679,1),
	(56794,41,'Regina Rulers',11345678,1),
	(56794,42,'Yellowknife Inmates',24555679,1),
	(56794,43,'Whitehorse Wilduns',38294079,1),
	(56794,44,'Edmonton Eagles',16345678,1),
	(56796,50,'Newfoundland',24555675,1),
	(56796,51,'Acadia',24555674,1),
	(56796,52,'Nova Scotia Scoundrels',24555678,1),
	(56796,53,'Toronto Terrors',14345678,1),
	(56796,54,'Edmonton Owls',16345678,1),
	(56796,55,'Serial Killers',71345678,1),
	(56796,56,'Ebola Eradicators',61345678,1),
	(56795,101,'Avril Lavigne',24555673,1),
	(56795,102,'Shania Twain',21345678,1),
	(56795,103,'Celine Dion',24555679,1),
	(56795,104,'Alanis Morissette',24555678,1),
	(56795,105,'Joni Mitchell',24555676,1),
	(56795,106,'Neil Young',19345678,1),
	(56795,107,'Justin Beiber',24555675,1);

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
	(0,1,2,23,9,'2014-11-02','18:00:00'),
	(1,1,3,32,18,'2014-11-14','18:00:00'),
	(2,1,4,8,1,'2014-11-22','18:00:00'),
	(3,2,4,2,97,'2014-11-14','18:30:00'),
	(4,4,5,32,10,'2014-10-03','18:00:00'),
	(5,10,12,NULL,NULL,'2014-11-28','07:00:00'),
	(6,12,13,NULL,NULL,'2014-12-03','08:00:00'),
	(7,11,13,1,87,'2014-10-23','08:30:00'),
	(8,20,21,1,32,'2014-11-14','15:30:00'),
	(9,22,23,23,43,'2014-08-10','18:00:00'),
	(10,24,25,12,64,'2014-10-03','19:00:00'),
	(11,23,26,NULL,NULL,'2014-12-05','19:30:00'),
	(12,30,31,NULL,NULL,'2014-12-01','14:00:00'),
	(13,30,34,182,256,'2014-11-17','18:00:00'),
	(14,30,36,NULL,NULL,'2014-12-08','05:40:00'),
	(15,35,37,NULL,NULL,'2014-12-07','15:00:00'),
	(16,40,41,NULL,NULL,'2014-12-01','15:00:00'),
	(17,40,42,NULL,NULL,'2014-12-01','15:30:00'),
	(18,40,43,NULL,NULL,'2014-12-01','16:00:00'),
	(19,101,102,NULL,NULL,'2014-12-03','16:00:00'),
	(20,102,103,NULL,NULL,'2014-12-03','16:30:00'),
	(21,103,104,NULL,NULL,'2014-12-03','17:00:00'),
	(22,104,105,NULL,NULL,'2014-12-03','17:30:00'),
	(23,105,106,NULL,NULL,'2014-12-03','18:00:00'),
	(24,106,107,NULL,NULL,'2014-12-03','18:30:00'),
	(25,101,103,NULL,NULL,'2014-12-03','19:00:00'),
	(26,103,105,NULL,NULL,'2014-12-03','19:30:00'),
	(27,105,107,NULL,NULL,'2014-12-03','20:00:00'),
	(28,101,107,NULL,NULL,'2014-12-03','20:30:00'),
	(29,50,51,23,87,'2014-10-02','16:30:00'),
	(30,50,52,23,87,'2014-11-06','16:30:00'),
	(31,52,53,84,34,'2014-11-07','16:30:00'),
	(32,52,54,2,6,'2014-11-08','16:30:00'),
	(33,53,54,9,6,'2014-11-09','16:30:00'),
	(34,53,55,7,2,'2014-11-10','16:30:00'),
	(35,55,56,23,84,'2014-11-11','02:30:00'),
	(36,55,50,82,69,'2014-11-12','16:30:00'),
	(37,55,54,83,32,'2014-11-13','16:30:00'),
	(38,50,53,4,5,'2014-11-14','16:30:00'),
	(39,56,51,NULL,NULL,'2014-11-29','16:30:00'),
	(40,56,53,NULL,NULL,'2014-12-04','16:30:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=91345680 DEFAULT CHARSET=latin1;

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;

INSERT INTO `User` (`studentID`, `Password`, `isAdmin`)
VALUES
	(11111111,'pwning',1),
	(11345678,'password',0),
	(12345678,'password',0),
	(12345679,'password',0),
	(13345678,'password',0),
	(14345678,'password',0),
	(15345678,'password',0),
	(16345678,'password',0),
	(17345678,'password',0),
	(18345678,'password',0),
	(19345678,'password',0),
	(21345678,'password',0),
	(24555673,'password',0),
	(24555674,'password',0),
	(24555675,'password',0),
	(24555676,'password',0),
	(24555678,'password',0),
	(24555679,'password',0),
	(31345678,'password',0),
	(33294059,'password',0),
	(38224059,'password',0),
	(38294053,'password',0),
	(38294059,'password',0),
	(38294079,'password',0),
	(41345678,'password',0),
	(51345678,'password',0),
	(61345678,'password',0),
	(71345678,'password',0),
	(81345678,'password',0),
	(91345678,'soTired',0),
	(91345679,'password',0);

/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
