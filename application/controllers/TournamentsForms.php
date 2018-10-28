<?php
class TournamentsForms extends CI_Controller{
	public function __construct() {
		parent::__construct();
		$models = array('TournamentsModel', 'ParticipantsOfTournamentsModel', 'MatchesModel',
			'SponsorLogosModel', 'UsersModel', 'SessionsModel', 'ForgottenPasswordModel');
		foreach($models as $model) {
			$this -> load -> model($model);
		}
		$helpers = array('url_helper', 'cookie', 'url', 'form');
		foreach($helpers as $helper) {
			$this -> load -> helper($helper);
		}
		$this -> load -> library('form_validation');
		$this -> db -> query('SET GLOBAL TRANSACTION ISOLATION LEVEL SERIALIZABLE;');
		require('/../procedures/updateTournamentsScripts.php');
		require('/../constants/constants.php');
	}
	
	public function participate($tournamentId) {
		$this -> db -> trans_start();
		setupStatusesAndMatchesScript($this);
		$data['title'] = 'Participate in tournament';
		$data['userId'] = $this -> SessionsModel -> checkSession(get_cookie('userId'), get_cookie('sessionId'), get_cookie('sessionCode'));
		$data['tournamentId'] = $tournamentId;
		if($data['userId'] <= 0) {
			$this -> db -> trans_complete();
			header('Location: http://'.base_url().'Users/login/');
			return;
		}
		if(!$this -> TournamentsModel -> checkIfTournamentExists($tournamentId)
				|| !$this -> TournamentsModel -> checkIfTournamentIsStatus($tournamentId, 'planned')
				|| time() >= mysql_to_unix($this -> TournamentsModel -> getTournamentInfo($tournamentId)['deadlineOfApplication'])) {
			$this -> db -> trans_complete();
			header('Location: http://'.base_url());
			return;
		}
		$data['_GET'] = $_GET;
		$this -> form_validation -> set_rules('licenceNumber', 'licenceNumber', 'required');
		$this -> form_validation -> set_rules('rank', 'rank', 'required');
		if($this -> form_validation -> run() === FALSE) {
			$this -> load -> view('templates/header', $data);
			$this -> load -> view('tournaments/participate', $data);
			$this -> load -> view('templates/footer');
		} else {
			if($this -> ParticipantsOfTournamentsModel -> checkIfParticipate($tournamentId, $data['userId'])) {
				header('Location: http://'.base_url().'/TournamentsForms/participate/'.$tournamentId.'/?alreadyTakingPart=true');
			} else if($this -> ParticipantsOfTournamentsModel -> checkNumberOfParticipants($tournamentId)
					>= $this -> TournamentsModel -> checkLimitOfParticipants($tournamentId)) {
				header('Location: http://'.base_url().'/TournamentsForms/participate/'.$tournamentId.'/?limitOfParticipantsAchieved=true');
			} else if($this -> ParticipantsOfTournamentsModel -> findByNumberOfLicence($tournamentId, $this -> input -> post('licenceNumber')) > 0) {
				header('Location: http://'.base_url().'/TournamentsForms/participate/'.$tournamentId.'/?licenceAlreadyExists=true');
			} else if($this -> ParticipantsOfTournamentsModel -> findByRank($tournamentId, $this -> input -> post('rank')) > 0) {
				header('Location: http://'.base_url().'/TournamentsForms/participate/'.$tournamentId.'/?rankAlreadyExists=true');
			} else {
				$this -> ParticipantsOfTournamentsModel -> participateInTournament($tournamentId, $data['userId']);
				header('Location: http://'.base_url().'/Tournaments/tournamentInfo/'.$tournamentId.'/?takingPart=true');
			}
		}
		$this -> db -> trans_complete();
	}
	
	public function submitMatchResult($tournamentId) {
		$this -> db -> trans_start();
		setupStatusesAndMatchesScript($this);
		$data['title'] = 'Submit match result';
		$data['tournamentId'] = $tournamentId;
		$data['userId'] = $this -> SessionsModel -> checkSession(get_cookie('userId'), get_cookie('sessionId'), get_cookie('sessionCode'));
		$this -> form_validation -> set_rules('enemy', 'enemy', 'required');
		$this -> form_validation -> set_rules('winner', 'winner', 'required');
		$data['otherParticipants'] = array_merge($this -> MatchesModel -> participantsPlayingWithMeNowAsB($tournamentId, $data['userId']),
			$this -> MatchesModel -> participantsPlayingWithMeNowAsA($tournamentId, $data['userId']));
		if(!$this -> TournamentsModel -> checkIfTournamentExists($tournamentId)
				|| !$this -> ParticipantsOfTournamentsModel -> checkIfParticipate($tournamentId, $data['userId'])
				|| !$this -> TournamentsModel -> checkIfTournamentIsStatus($tournamentId,'taking place')
				|| (sizeof($data['otherParticipants']) < 1 && $this -> input -> post('enemy') != null)) {
			$this -> db -> trans_complete();
			header('Location: http://'.base_url());
			return;
		} else if($this -> form_validation -> run() === FALSE) {
			$this -> load -> view('templates/header', $data);
			$this -> load -> view('tournaments/submitMatchResult', $data);
			$this -> load -> view('templates/footer');
		} else {
			$myWinnerId = ($this -> input -> post('winner') == 'me' ? $data['userId'] : $this -> input -> post('enemy'));
			$users = array($data['userId'], $this -> input -> post('enemy'), $data['userId']);
			$winners = array($myWinnerId, -1, $myWinnerId);
			for($i = 0; $i < sizeof($users) - 1; $i++) { 
				if($this -> MatchesModel -> checkIfExistsMatchResults($tournamentId, $users[$i], $users[$i + 1], $data['userId'])) {
					$this -> MatchesModel -> updateMatchReult($tournamentId, $users[$i], $users[$i + 1], $winners[$i], $winners[$i + 1]);
					if($this -> MatchesModel -> checkIfExistsMatchIsConflicting($tournamentId, $users[$i], $users[$i + 1])) {
						$this -> MatchesModel -> updateMatchReult($tournamentId, $users[$i], $users[$i + 1], 0, 0);
						$this -> db -> trans_complete();
						header('Location: http://'.base_url().'/Tournaments/tournamentInfo/'.$tournamentId.'/?matchResultWithdrawn=true');
						return;
					} else {
						if($this -> MatchesModel -> checkIfExistsMatchAreComplete($tournamentId, $users[$i], $users[$i + 1])) {
							$points = $this -> ParticipantsOfTournamentsModel -> getPoints($tournamentId, $myWinnerId);
							$points++;
							$this -> ParticipantsOfTournamentsModel -> savePoints($tournamentId, $myWinnerId, $points);
							$finishedMatches = $this -> MatchesModel -> getLastFinishedMatches($tournamentId);
							if(sizeof($finishedMatches) > 1) {
								$nextMatch = $this -> MatchesModel -> newMatchResult($tournamentId, $finishedMatches[0]['winner1'], $finishedMatches[1]['winner1'], $finishedMatches[0]['greaterRank'], $finishedMatches[1]['greaterRank']);
								$this -> MatchesModel -> setNextMatch($tournamentId, $finishedMatches[0]['userId1'], $finishedMatches[0]['userId2'], $nextMatch);
								$this -> MatchesModel -> setNextMatch($tournamentId, $finishedMatches[1]['userId1'], $finishedMatches[1]['userId2'], $nextMatch);
								echo $finishedMatches[1]['userId1'].' '.$finishedMatches[1]['userId2'].' ';
								echo $this -> MatchesModel -> checkIfExistsMatchIsConflicting($tournamentId, $users[$i], $users[$i + 1]);
							}
						}
						$this -> db -> trans_complete();
						header('Location: http://'.base_url().'/Tournaments/tournamentInfo/'.$tournamentId.'/?matchResultSubmitted=true');
					}
				}
			}
		}
		$this -> db -> trans_complete();
	}
	
	public function addSponsorLogo($tournamentId) {
		$this -> db -> trans_start();
		$this -> load -> library('upload');
		$data['title'] = 'Add sponsor logo';
		$data['error'] = (isset($_GET['error']) && $_GET['error'] == true ? true : false);
		$data['userId'] = $this -> SessionsModel -> checkSession(get_cookie('userId'), get_cookie('sessionId'), get_cookie('sessionCode'));
		$data['tournamentId'] = $tournamentId;
		if(!$this -> TournamentsModel -> checkIfTournamentExists($tournamentId)
			|| !$this -> TournamentsModel -> checkIfOrganizer($tournamentId, $data['userId'])) {
			$this -> db -> trans_complete();
			header('Location: http://'.base_url());
			return;
		}
		if(!$this -> input -> post('add')) {
			$this -> load -> view('templates/header', $data);
			$this -> load -> view('tournaments/addSponsorLogo', $data);
			$this -> load -> view('templates/footer');
		} else {
			if(!$this -> upload -> do_upload('imageFile')) {
				header('Location: http://'.base_url().'/TournamentsForms/addSponsorLogo/'.$tournamentId.'/?error=true');
			} else {
				$this -> SponsorLogosModel -> newSponsorLogo($tournamentId, $this -> upload -> data('file_name'));
				header('Location: http://'.base_url().'/Tournaments/tournamentInfo/'.$tournamentId.'/?logoAdded=true');
			}
		}
		$this -> db -> trans_complete();
	}
	
	public function newTournament($tournamentId = -1) {
		$this -> db -> trans_start();
		setupStatusesAndMatchesScript($this);
		if($tournamentId < 0) {
			$data = array(
				'name' => '',
				'place' => '',
				'discipline' => '',
				'description' => '',
				'limitOfParticipants' => '',
				'deadlineOfApplication' => '',
				'timeOfStart' => '',
				'duration' => '',
			);
			$data['title'] = 'New tournament';
		} else {
			$data = $this -> TournamentsModel -> getTournamentInfo($tournamentId);
			$data['title'] = 'Edit tournament';
		}
		$data['tournamentId'] = $tournamentId;
		$data['userId'] = $this -> SessionsModel -> checkSession(get_cookie('userId'), get_cookie('sessionId'), get_cookie('sessionCode'));
		if($this -> TournamentsModel -> checkIfTournamentIsStatus($tournamentId, 'taking place')
				|| $this -> TournamentsModel -> checkIfTournamentIsStatus($tournamentId, 'finished')) {
			$this -> db -> trans_complete();
			header('Location: http://'.base_url());
			return;
		} else if($data['userId'] <= 0) {
			$this -> db -> trans_complete();
			header('Location: http://'.base_url().'Users/login/');
			return;
		} else if(!$this -> TournamentsModel -> checkIfOrganizer($tournamentId, $data['userId'])
				&& $tournamentId > 0) {
			$this -> db -> trans_complete();
			header('Location: http://'.base_url());
			return;
		}
		$data['tournamentAlreadyExists'] = (isset($_GET['tournamentAlreadyExists']) && $_GET['tournamentAlreadyExists'] == true ? true : false);
		$validation = array('place', 'limitOfParticipants', 'name', 'description', 'discipline', 'deadlineOfApplicationHours',
			'deadlineOfApplicationMinutes', 'deadlineOfApplicationDate', 'timeOfStartHours', 'timeOfStartMinutes',
			'timeOfStartDate', 'durationHours', 'durationMinutes');
		for($i=0; $i<sizeof($validation); $i++) {
			$this -> form_validation -> set_rules($validation[$i], $validation[$i], 'required');
		}
		if($this -> form_validation -> run() === FALSE) {
			$this -> load -> view('templates/header', $data);
			$this -> load -> view('tournaments/newTournament', $data);
			$this -> load -> view('templates/footer');
		} else {
			$existingTournamentId = $this -> TournamentsModel -> findTournamentByName($this -> input -> post('name'));
			if($existingTournamentId <= 0 && $tournamentId < 0) {
				$this -> TournamentsModel -> newTournament($data['userId']);
				header('Location: http://'.base_url().'?tournamentCreated=true');
			} else if($tournamentId >= 0 && ($existingTournamentId <= 0 || $existingTournamentId == $tournamentId)) {
				$this -> TournamentsModel -> updateTournament($tournamentId);
				header('Location: http://'.base_url().'Tournaments/tournamentInfo/'.$tournamentId.'/?tournamentUpdate=true');
			} else {
				header('Location: http://'.base_url().'TournamentsForms/newTournament/'.($tournamentId >= 0 ? $tournamentId.'/' : '')
					.'?tournamentAlreadyExists=true');
			}
		}
		$this -> db -> trans_complete();
	}
}
?>