<?php
class Tournaments extends CI_Controller{
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
		require('/../procedures/ladderScripts.php');
		require('/../constants/constants.php');
	}
	
	public function index() {
		$arguments = '';
		$variables = array('logIn', 'logOut', 'register', 'tournamentCreated');
		foreach($variables as $variable) {
			if(isset($_GET[$variable]) && $_GET[$variable] == true) {
				$arguments = '?'.$variable.'=true';
			}
		}
		header('Location: http://'.base_url().'Tournaments/tournaments/'.$arguments);
	}
	
	public function tournamentInfo($tournamentId) {
		$this -> db -> trans_start();
		setupStatusesAndMatchesScript($this);
		$data['title'] = 'Tournament details';
		$data['tournamentId'] = $tournamentId;
		$data['_GET'] = $_GET;
		$data['userId'] = $this -> SessionsModel -> checkSession(get_cookie('userId'), get_cookie('sessionId'), get_cookie('sessionCode'));
		$data['tournament'] = $this -> TournamentsModel -> getTournamentInfo($tournamentId);
		$data['canEdit'] = false;
		$data['canParticipate'] = false;
		$data['canSubmitMatchResult'] = false;
		$data['canAddSponsorLogo'] = false;
		$data['participants'] = $this -> ParticipantsOfTournamentsModel -> getTournamentParticipants($tournamentId);
		$data['matches'] = $this -> MatchesModel -> getMatches($tournamentId);
		if($this -> TournamentsModel -> checkIfOrganizer($tournamentId, $data['userId'])) {
			$data['canAddSponsorLogo'] = true;
			if($this -> TournamentsModel -> checkIfTournamentIsStatus($tournamentId, 'planned')) {
				$data['canEdit'] = true;
			}
		}
		if(!$this -> ParticipantsOfTournamentsModel -> checkIfParticipate($tournamentId, $data['userId'])
				&& $this -> TournamentsModel -> checkIfTournamentIsStatus($tournamentId, 'planned')
				&& time() < mysql_to_unix($data['tournament']['deadlineOfApplication'])
				&& $this -> ParticipantsOfTournamentsModel -> checkNumberOfParticipants($tournamentId)
				< $this -> TournamentsModel -> checkLimitOfParticipants($tournamentId)) {
			$data['canParticipate'] = true;
		}
		if($this -> TournamentsModel -> checkIfTournamentIsStatus($tournamentId, 'taking place')
			&& $this -> ParticipantsOfTournamentsModel -> checkIfParticipate($tournamentId, $data['userId'])) {
			$data['canSubmitMatchResult'] = true;
		}
		$data['tournament']['numberOfParticipants'] = $this -> ParticipantsOfTournamentsModel -> checkNumberOfParticipants($tournamentId);
		$data['sponsorLogosLocation'] = 'assets/uploadedImgs/';
		$data['sponsorLogos'] = $this -> SponsorLogosModel -> getSponsorLogosData($tournamentId);
		if($data['tournament']['status'] != 'planned') {
			$data['matchesShow'] = ladderBuilder($data['matches']);
		}
		$this -> load -> view('templates/header', $data);
		$this -> load -> view('tournaments/tournamentInfo', $data);
		$this -> load -> view('templates/footer');
		$this -> db -> trans_complete();
	}
	
	public function tournaments($userTournaments = -1) {
		$this -> db -> trans_start();
		setupStatusesAndMatchesScript($this);
		$data['startRow'] = $startRow = (isset($_GET['startRow']) ? $_GET['startRow'] : TOURNAMENTS_START_ROW);
		$data['showRows'] = $showRows = (isset($_GET['showRows']) ? $_GET['showRows'] : TOURNAMENTS_SHOW_ROWS);
		$data['searchQuery'] = $searchQuery = (isset($_GET['searchQuery']) ? $_GET['searchQuery'] : '');
		$tournaments = $this -> TournamentsModel -> getTournaments($userTournaments, $startRow, $showRows, $searchQuery);
		$data['numberOfResults'] = $this -> TournamentsModel -> countTournaments($userTournaments, $searchQuery);
		if($userTournaments >= 0) {
			$data['title'] = 'My tournaments';
		} else {
			$data['title'] = 'Tournaments';
		}
		$data['userTournaments'] = $userTournaments;
		$data['userId'] = $this -> SessionsModel -> checkSession(get_cookie('userId'), get_cookie('sessionId'), get_cookie('sessionCode'));
		$data['_GET'] = $_GET;
		$numberOfParticipantsOfTournaments = $this -> ParticipantsOfTournamentsModel -> getNumberOfParticipantsOfTournaments();
		for($i = 0; $i < sizeof($tournaments); $i++) {
			$tournaments[$i]['numberOfParticipants'] = 0;
			for($j = 0; $j < sizeof($numberOfParticipantsOfTournaments); $j++) {
				if($numberOfParticipantsOfTournaments[$j]['tournamentId'] == $tournaments[$i]['id']) {
					$tournaments[$i]['numberOfParticipants'] = $numberOfParticipantsOfTournaments[$j]['count(*)'];
					break;
				}
			}
		}
		for($i = 0; $i < sizeof($tournaments); $i++) {
			switch($tournaments[$i]['status']) {
				case 'taking place': $tournaments[$i]['class'] = 'tournamentTakingPlace'; break;
				case 'planned': $tournaments[$i]['class'] = 'tournamentPlanned'; break;
				case 'finished': $tournaments[$i]['class'] = 'tournamentFinished'; break;
			}
		}
		$data['tournaments'] = $tournaments;
		$this -> load -> view('templates/header', $data);
		$this -> load -> view('tournaments/tournaments', $data);
		$this -> load -> view('templates/footer');
		$this -> db -> trans_complete();
	}
}
?>