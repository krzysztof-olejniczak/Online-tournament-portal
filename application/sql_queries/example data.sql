INSERT INTO `users` (`username`, `encryptedPassword`, `firstname`, `surname`, `email`, `type`, `activateCode`, `active`, `salt`)
	values('Chris', '$2y$10$8887bbd64b52f03feb9c8e4TCHYrCuNFoDPamm8/dOnhELYrauJ1m', 'Chris', 'Martin', 'chris@chris.com', 'administrator', 12345, true, '8887bbd64b52f03feb9c8f7f2855d390315001ea');
INSERT INTO `users` (`username`, `encryptedPassword`, `firstname`, `surname`, `email`, `type`, `activateCode`, `active`, `salt`)
	values('Adam', '$2y$10$0e6443ac1a347d8f6564eOrsTH175p87BBYWewGnOHbs6LuaY7otq', 'Adam', 'Brown', 'adam@adam.com', 'user', 12345, true, '0e6443ac1a347d8f6564ed1336e45f0ce1dbabf6');
INSERT INTO `users` (`username`, `encryptedPassword`, `firstname`, `surname`, `email`, `type`, `activateCode`, `active`, `salt`)
	values('Paul', '$2y$10$d6d96dfc25aa457a7c027OQB6jnz3Do6pCk9zeA4y/i4js0OLKmW.', 'Paul', 'Tremblay', 'paul@paul.com', 'user', 12345, true, 'd6d96dfc25aa457a7c027a4c15f8a0dca36f71ef');
INSERT INTO `users` (`username`, `encryptedPassword`, `firstname`, `surname`, `email`, `type`, `activateCode`, `active`, `salt`)
	values('Mary', '$2y$10$6b64ea1d9ba4577b88d7aueRRvswcuWvJIIjJkh2rHKhmvGTKkO92', 'Mary', 'Gagnon', 'mary@mary.com', 'user', 12345, true, '6b64ea1d9ba4577b88d7a17e53c72fe34fb9fe01');
INSERT INTO `users` (`username`, `encryptedPassword`, `firstname`, `surname`, `email`, `type`, `activateCode`, `active`, `salt`)
	values('Jane', '$2y$10$a78be93131a2af61557faO.qCR94fpAku88EeiiuWMJtB3nC1KNoq', 'Jane', 'Smith', 'jane@jane.com', 'user', 12345, true, 'a78be93131a2af61557faa434258367d33ac335d');

INSERT INTO `tournaments` (`place`, `registerTime`, `limitOfParticipants`, `name`, `description`, `discipline`, `organizerId`, `status`, `deadlineOfApplication`, `timeOfStart`, `duration`)
	values('Giżycko, Poland', '2016-08-01', 3, 'Race around Niegocin lake', 'The race around Niegocin lake', 'inland sailing', 2, 'planned', '2016-09-11 12:00:00', '2016-09-12 12:00:00', '24:00:00');
INSERT INTO `tournaments` (`place`, `registerTime`, `limitOfParticipants`, `name`, `description`, `discipline`, `organizerId`, `status`, `deadlineOfApplication`, `timeOfStart`, `duration`)
	values('Gdańsk, Poland', '2016-07-01', 4, 'Poland - Sweden race', 'The race to the Gotland island', 'ocean sailing', 3, 'planned', '2016-09-12 12:00:00', '2016-09-13 12:00:00', '24:00:00');
INSERT INTO `tournaments` (`place`, `registerTime`, `limitOfParticipants`, `name`, `description`, `discipline`, `organizerId`, `status`, `deadlineOfApplication`, `timeOfStart`, `duration`)
	values('Zurich, Switzerland', '2016-07-01', 5, 'Race around Zurich lakes', 'The race around lakes near Zurich', 'inland sailing', 2, 'planned', '2016-09-13 12:00:00', '2016-09-14 12:00:00', '12:00:00');
INSERT INTO `tournaments` (`place`, `registerTime`, `limitOfParticipants`, `name`, `description`, `discipline`, `organizerId`, `status`, `deadlineOfApplication`, `timeOfStart`, `duration`)
	values('Powidz, Poland', '2016-08-25', 2, 'From Powidz to Słupca', 'The race around lake Powidzkie', 'inland sailing', 1, 'planned', '2016-09-14 12:00:00', '2016-09-15 12:00:00', '12:00:00');
INSERT INTO `tournaments` (`place`, `registerTime`, `limitOfParticipants`, `name`, `description`, `discipline`, `organizerId`, `status`, `deadlineOfApplication`, `timeOfStart`, `duration`)
	values('Mamerki, Poland', '2016-06-25', 3, 'Bunkers race', 'The race from Mamerki to Dobskie lake', 'inland sailing', 5, 'taking place', '2016-09-10 12:00:00', '2016-09-11 12:00:00', '24:00:00');
INSERT INTO `tournaments` (`place`, `registerTime`, `limitOfParticipants`, `name`, `description`, `discipline`, `organizerId`, `status`, `deadlineOfApplication`, `timeOfStart`, `duration`)
	values('Balaton lake, Hungary', '2016-06-25', 5, 'Great race', 'The race around Balaton lake', 'inland sailing', 4, 'taking place', '2016-09-11 12:00:00', '2016-09-11 20:00:00', '24:00:00');
INSERT INTO `tournaments` (`place`, `registerTime`, `limitOfParticipants`, `name`, `description`, `discipline`, `organizerId`, `status`, `deadlineOfApplication`, `timeOfStart`, `duration`)
	values('Ruciane-Nida, Poland', '2016-05-25', 3, 'From Ruciane to Mikołajki', 'The race from Ruciane to Mikołajki', 'inland sailing', 1, 'taking place', '2016-08-20 12:00:00', '2016-08-23 12:00:00', '24:00:00');
INSERT INTO `tournaments` (`place`, `registerTime`, `limitOfParticipants`, `name`, `description`, `discipline`, `organizerId`, `status`, `deadlineOfApplication`, `timeOfStart`, `duration`)
	values('Wigry, Poland', '2016-04-15', 3, 'Race around Wigry lake', 'Race around Wigry lake', 'inland sailing', 2, 'finished', '2016-06-20 12:00:00', '2016-06-23 12:00:00', '20:00:00');
INSERT INTO `tournaments` (`place`, `registerTime`, `limitOfParticipants`, `name`, `description`, `discipline`, `organizerId`, `status`, `deadlineOfApplication`, `timeOfStart`, `duration`)
	values('Świnoujście, Poland', '2016-03-10', 8, 'From Świnoujście to Borholm', 'Race from Świnoujście to Bornholm', 'ocean sailing', 3, 'finished', '2016-03-20 12:00:00', '2016-03-30 12:00:00', '20:00:00');
INSERT INTO `tournaments` (`place`, `registerTime`, `limitOfParticipants`, `name`, `description`, `discipline`, `organizerId`, `status`, `deadlineOfApplication`, `timeOfStart`, `duration`)
	values('Split, Croatia', '2015-03-12', 3, 'Adriatic sea', 'From Adriatic sea to Bologne', 'ocean sailing', 3, 'finished', '2016-03-22 11:00:00', '2016-04-01 15:00:00', '10:00:00');
INSERT INTO `tournaments` (`place`, `registerTime`, `limitOfParticipants`, `name`, `description`, `discipline`, `organizerId`, `status`, `deadlineOfApplication`, `timeOfStart`, `duration`)
	values('Odessa, Ukraine', '2016-01-16', 2, 'Black sea', 'Black Sea', 'ocean sailing', 2, 'finished', '2016-02-12 10:00:00', '2016-03-12 18:00:00', '22:00:00');

INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(1, 1, 'mnb121', 1, 0);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(1, 2, 'mnb122', 2, 0);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(1, 3, 'mnb123', 3, 0);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(2, 3, 'mnb123', 1, 0);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(2, 4, 'mnb124', 2, 0);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(2, 5, 'mnb125', 3, 0);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(3, 3, 'mnb123', 1, 0);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(3, 4, 'mnb124', 2, 0);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(3, 5, 'mnb125', 3, 0);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(3, 1, 'mnb121', 4, 0);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(5, 5, 'mnb125', 1, 1);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(5, 3, 'mnb123', 2, 0);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(6, 1, 'mnb121', 3, 0);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(6, 2, 'mnb122', 5, 1);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(6, 3, 'mnb123', 2, 1);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(6, 4, 'mnb124', 4, 0);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(6, 5, 'mnb125', 1, 1);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(7, 2, 'mnb122', 2, 0);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(7, 3, 'mnb123', 1, 1);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(8, 1, 'mnb121', 2, 0);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(8, 2, 'mnb122', 1, 0);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(8, 3, 'mnb123', 3, 2);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(9, 1, 'mnb121', 2, 2);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(9, 2, 'mnb122', 1, 0);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(9, 3, 'mnb123', 3, 1);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(9, 5, 'mnb125', 4, 0);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(10, 3, 'mnb123', 2, 0);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(10, 5, 'mnb125', 1, 1);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(11, 1, 'mnb121', 3, 0);
INSERT INTO `participantsOfTournaments` (`tournamentId`, `userId`, `numberOfLicence`, `actualRank`, `points`) values(11, 2, 'mnb122', 4, 1);

INSERT INTO `matches` (`id`, `tournamentId`, `userId1`, `userId2`, `winner1`, `winner2`, `nextMatchId`, `leaf`, `greaterRank`) values(7, 5, 3, 5, 5, 0, 0, 1, 2);
INSERT INTO `matches` (`id`, `tournamentId`, `userId1`, `userId2`, `winner1`, `winner2`, `nextMatchId`, `leaf`, `greaterRank`) values(8, 6, 2, 4, 2, 2, 0, 1, 5);
INSERT INTO `matches` (`id`, `tournamentId`, `userId1`, `userId2`, `winner1`, `winner2`, `nextMatchId`, `leaf`, `greaterRank`) values(9, 6, 1, 3, 3, 3, 11, 1, 3);
INSERT INTO `matches` (`id`, `tournamentId`, `userId1`, `userId2`, `winner1`, `winner2`, `nextMatchId`, `leaf`, `greaterRank`) values(10, 6, 5, 5, 5, 5, 11, 1, 1);
INSERT INTO `matches` (`id`, `tournamentId`, `userId1`, `userId2`, `winner1`, `winner2`, `nextMatchId`, `leaf`, `greaterRank`) values(11, 6, 5, 3, 5, 0, 0, 0, 3);
INSERT INTO `matches` (`id`, `tournamentId`, `userId1`, `userId2`, `winner1`, `winner2`, `nextMatchId`, `leaf`, `greaterRank`) values(13, 7, 2, 3, 3, 3, 0, 1, 2);
INSERT INTO `matches` (`id`, `tournamentId`, `userId1`, `userId2`, `winner1`, `winner2`, `nextMatchId`, `leaf`, `greaterRank`) values(14, 8, 1, 3, 3, 3, 16, 1, 3);
INSERT INTO `matches` (`id`, `tournamentId`, `userId1`, `userId2`, `winner1`, `winner2`, `nextMatchId`, `leaf`, `greaterRank`) values(15, 8, 2, 2, 2, 2, 16, 1, 1);
INSERT INTO `matches` (`id`, `tournamentId`, `userId1`, `userId2`, `winner1`, `winner2`, `nextMatchId`, `leaf`, `greaterRank`) values(16, 8, 2, 3, 3, 3, 0, 0, 3);
INSERT INTO `matches` (`id`, `tournamentId`, `userId1`, `userId2`, `winner1`, `winner2`, `nextMatchId`, `leaf`, `greaterRank`) values(17, 9, 3, 5, 3, 3, 19, 1, 4);
INSERT INTO `matches` (`id`, `tournamentId`, `userId1`, `userId2`, `winner1`, `winner2`, `nextMatchId`, `leaf`, `greaterRank`) values(18, 9, 1, 2, 1, 1, 19, 1, 2);
INSERT INTO `matches` (`id`, `tournamentId`, `userId1`, `userId2`, `winner1`, `winner2`, `nextMatchId`, `leaf`, `greaterRank`) values(19, 9, 1, 3, 1, 1, 0, 0, 4);
INSERT INTO `matches` (`id`, `tournamentId`, `userId1`, `userId2`, `winner1`, `winner2`, `nextMatchId`, `leaf`, `greaterRank`) values(20, 10, 3, 5, 5, 5, 0, 1, 2);
INSERT INTO `matches` (`id`, `tournamentId`, `userId1`, `userId2`, `winner1`, `winner2`, `nextMatchId`, `leaf`, `greaterRank`) values(21, 11, 1, 2, 2, 2, 0, 1, 4);

INSERT INTO `sponsorLogos` (`tournamentId`, `logoName`) values(1, 'logo1.jpg');
INSERT INTO `sponsorLogos` (`tournamentId`, `logoName`) values(2, 'logo2.jpg');
INSERT INTO `sponsorLogos` (`tournamentId`, `logoName`) values(2, 'logo3.jpg');
INSERT INTO `sponsorLogos` (`tournamentId`, `logoName`) values(3, 'logo4.jpg');
INSERT INTO `sponsorLogos` (`tournamentId`, `logoName`) values(3, 'logo5.jpg');
INSERT INTO `sponsorLogos` (`tournamentId`, `logoName`) values(4, 'logo1.jpg');
INSERT INTO `sponsorLogos` (`tournamentId`, `logoName`) values(6, 'logo2.jpg');
INSERT INTO `sponsorLogos` (`tournamentId`, `logoName`) values(6, 'logo3.jpg');
INSERT INTO `sponsorLogos` (`tournamentId`, `logoName`) values(6, 'logo4.jpg');
INSERT INTO `sponsorLogos` (`tournamentId`, `logoName`) values(7, 'logo5.jpg');
INSERT INTO `sponsorLogos` (`tournamentId`, `logoName`) values(8, 'logo1.jpg');
INSERT INTO `sponsorLogos` (`tournamentId`, `logoName`) values(8, 'logo2.jpg');
INSERT INTO `sponsorLogos` (`tournamentId`, `logoName`) values(8, 'logo3.jpg');
INSERT INTO `sponsorLogos` (`tournamentId`, `logoName`) values(8, 'logo4.jpg');
INSERT INTO `sponsorLogos` (`tournamentId`, `logoName`) values(8, 'logo5.jpg');
INSERT INTO `sponsorLogos` (`tournamentId`, `logoName`) values(9, 'logo1.jpg');
INSERT INTO `sponsorLogos` (`tournamentId`, `logoName`) values(9, 'logo2.jpg');
INSERT INTO `sponsorLogos` (`tournamentId`, `logoName`) values(10, 'logo3.jpg');
INSERT INTO `sponsorLogos` (`tournamentId`, `logoName`) values(11, 'logo4.jpg');
INSERT INTO `sponsorLogos` (`tournamentId`, `logoName`) values(11, 'logo5.jpg');
