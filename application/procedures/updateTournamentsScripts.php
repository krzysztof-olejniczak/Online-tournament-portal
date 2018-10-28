<?php
	function setupStatusesAndMatchesScript($controller) {
		$tournaments = $controller -> TournamentsModel -> getTournaments(0, 0, 0, '');
		foreach($tournaments as $tournament) {
			if($tournament['status'] == 'planned' && time() >= mysql_to_unix($tournament['timeOfStart'])) {
				$controller -> TournamentsModel -> changeStatusInto($tournament['id'], 'taking place');
				$participants = $controller -> ParticipantsOfTournamentsModel -> getTournamentParticipantsIds($tournament['id']);
				for($i = 0; $i < sizeof($participants); $i+=2) {
					if($i + 1 == sizeof($participants)) {
						$controller -> MatchesModel -> newMatchResult($tournament['id'], $participants[$i]['userId'], $participants[$i]['userId'], $participants[$i]['actualRank'], $participants[$i]['actualRank'], true);
						$controller -> MatchesModel -> updateMatchReult($tournament['id'], $participants[$i]['userId'], $participants[$i]['userId'],
							$participants[$i]['userId'], $participants[$i]['userId']);
					} else {
						$controller -> MatchesModel -> newMatchResult($tournament['id'], $participants[$i]['userId'], $participants[$i + 1]['userId'], $participants[$i]['actualRank'], $participants[$i + 1]['actualRank'], true);
					}
				}
			}
			if($tournament['status'] == 'taking place' && time() >= mysql_to_unix($tournament['timeOfStart'])
					+ strtotime('1970-01-01 '.$tournament['duration']) + 3600) {
				$controller -> TournamentsModel -> changeStatusInto($tournament['id'], 'finished');
			}
		}
	}
	
?>