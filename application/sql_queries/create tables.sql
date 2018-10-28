DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
	`id` int NOT NULL AUTO_INCREMENT,
	`username` varchar(100) NOT NULL,
	`encryptedPassword` varchar(100) NOT NULL,
	`email` varchar(100) NOT NULL,
	`firstname` varchar(100) NOT NULL,
	`surname` varchar(100) NOT NULL,
	`type` varchar(20) NOT NULL,
	`salt` varchar(50) NOT NULL,
	`activateCode` varchar(100) NOT NULL,
	`active` boolean NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tournaments`;
CREATE TABLE `tournaments` (
	`id` int NOT NULL AUTO_INCREMENT,
	`place` varchar(100) NOT NULL,
	`registerTime` datetime NOT NULL,
	`limitOfParticipants` int NULL,
	`name` varchar(100) NOT NULL,
	`description` varchar(1000) NULL,
	`discipline` varchar(100) NULL,
	`organizerId` int NOT NULL references users(id),
	`status` varchar(20) NOT NULL,
	`deadlineOfApplication` datetime NOT NULL,
	`timeOfStart` datetime NOT NULL,
	`duration` time NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `participantsOfTournaments`;
CREATE TABLE `participantsOfTournaments` (
	`tournamentId` int NOT NULL references tournaments(id),
	`userId` int NOT NULL references users(id),
	`numberOfLicence` varchar(100) NOT NULL,
	`actualRank` int NULL,
	`points` int NOT NULL
);

DROP TABLE IF EXISTS `matches`;
CREATE TABLE `matches` (
	`id` int NOT NULL AUTO_INCREMENT,
	`tournamentId` int NOT NULL references tournaments(id),
	`userId1` int NOT NULL references users(id),
	`userId2` int NOT NULL references users(id),
	`winner1` int NOT NULL references users(id),
	`winner2` int NOT NULL references users(id),
	`nextMatchId` int NOT NULL references matches(id),
	`leaf` boolean NOT NULL,
	`greaterRank` int NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sponsorLogos`;
CREATE TABLE `sponsorLogos` (
	`id` int NOT NULL AUTO_INCREMENT,
	`tournamentId` int NOT NULL references tournaments(id),
	`logoName` varchar(100) NOT NULL references users(id),
	PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
	`id` int NOT NULL AUTO_INCREMENT,
	`sessionCode` varchar(100) NOT NULL,
	`userId` int NOT NULL references users(id),
	`loginTime` datetime NOT NULL,
	`logoutTime` datetime NULL,
	`ipAddress` varchar(20) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `forgottenPassword`;
CREATE TABLE `forgottenPassword` (
	`id` int NOT NULL AUTO_INCREMENT,
	`generatedNumber` varchar(100) NOT NULL,
	`userId` int NOT NULL references users(id),
	`forgottenTime` datetime NOT NULL,
	`restoreTime` datetime NULL,
	`ipAddress` varchar(20) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
