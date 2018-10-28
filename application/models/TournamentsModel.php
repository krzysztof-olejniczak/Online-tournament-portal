<?php
class TournamentsModel extends CI_Model {
	public function __construct() {
		$this -> load -> database();
		$this -> load -> helper('date');
		$this -> load -> helper('url');
	}
	
	public function getTournamentInfo($tournamentId) {
		$this -> db -> select('username, name, place, discipline, description,
			limitOfParticipants, deadlineOfApplication, registerTime, timeOfStart, duration, organizerId, status');
		$this -> db -> join('users', 'tournaments.organizerId = users.id');
		return $this -> db -> get_where('tournaments', array('tournaments.id' => $tournamentId)) -> row_array();
	}
	
	public function newTournament($userId) {
		$deadlineOfApplication = $this -> input -> post('deadlineOfApplicationDate').' '.
			$this -> input -> post('deadlineOfApplicationHours').':'.$this -> input -> post('deadlineOfApplicationMinutes');
		$timeOfStart = $this -> input -> post('timeOfStartDate').' '.
			$this -> input -> post('timeOfStartHours').':'.$this -> input -> post('timeOfStartMinutes');
		$duration = $this -> input -> post('durationHours').':'.$this -> input -> post('durationMinutes');
		$data = array(
			'place' => $this -> input -> post('place'),
			'registerTime' => date('Y-m-d H:i:s', now()),
			'limitOfParticipants' => $this -> input -> post('limitOfParticipants'),
			'name' => $this -> input -> post('name'),
			'description' => $this -> input -> post('description'),
			'discipline' => $this -> input -> post('discipline'),
			'organizerId' => $userId,
			'status' => 'planned',
			'deadlineOfApplication' => $deadlineOfApplication,
			'timeOfStart' => $timeOfStart,
			'duration' => $duration
		);
		$this -> db -> insert('tournaments', $data);
	}
	
	public function updateTournament($tournamentId) {
		$deadlineOfApplication = $this -> input -> post('deadlineOfApplicationDate').' '.
			$this -> input -> post('deadlineOfApplicationHours').':'.$this -> input -> post('deadlineOfApplicationMinutes');
		$timeOfStart = $this -> input -> post('timeOfStartDate').' '.
			$this -> input -> post('timeOfStartHours').':'.$this -> input -> post('timeOfStartMinutes');
		$duration = $this -> input -> post('durationHours').':'.$this -> input -> post('durationMinutes');
		$data = array(
			'place' => $this -> input -> post('place'),
			'limitOfParticipants' => $this -> input -> post('limitOfParticipants'),
			'name' => $this -> input -> post('name'),
			'description' => $this -> input -> post('description'),
			'discipline' => $this -> input -> post('discipline'),
			'deadlineOfApplication' => $deadlineOfApplication,
			'timeOfStart' => $timeOfStart,
			'duration' => $duration
		);
		$this -> db -> where(array('id' => $tournamentId));
		$this -> db -> update('tournaments', $data);
	}
	
	public function findTournamentByName($tournamentName) {
		$this -> db -> select('id');
		$data = $this -> db -> get_where('tournaments', array('name' => $tournamentName)) -> row_array();
		if(sizeof($data) >= 1) {
			return $data['id'];
		} else {
			return false;
		}
	}
	
	public function checkIfTournamentExists($tournamentId) {
		$this -> db -> select('id');
		if(sizeof($this -> db -> get_where('tournaments', array('id' => $tournamentId)) -> row_array()) >= 1) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getTournaments($userId = -1, $startRow = -1, $showRows = -1, $searchQuery = '') {
		if($startRow < 0 || $showRows < 0) {
			$startRow = TOURNAMENTS_START_ROW;
			$showRows = TOURNAMENTS_SHOW_ROWS;
		}
		$this -> db -> select('tournaments.id as id, name, place,
			limitOfParticipants, deadlineOfApplication, timeOfStart, duration, status, registerTime, username');
		$this -> db -> join('users', 'tournaments.organizerId = users.id');
		$searchWords = explode(' ', $searchQuery);
		foreach($searchWords as $searchWord) {
			$this -> db -> group_start();
			$this -> db -> like('name', $searchWord);
			$this -> db -> or_like('place', $searchWord);
			$this -> db -> or_like('description', $searchWord);
			$this -> db -> or_like('discipline', $searchWord);
			$this -> db -> or_like('status', $searchWord);
			$this -> db -> group_end();
		}
		if($userId > 0) {
			$this -> db -> join('participantsOfTournaments', 'participantsOfTournaments.tournamentId = tournaments.id');
			$this -> db -> where('participantsOfTournaments.userId', $userId);
		}
		$this -> db -> order_by('status', 'desc');
		if($showRows <= 0 || $startRow < 0) {
			return $this -> db -> get('tournaments') -> result_array();
		} else {
			return $this -> db -> get('tournaments', $showRows, $startRow) -> result_array();
		}
	}
	
	public function countTournaments($userId = -1, $searchQuery) {
		$this -> db -> select('tournaments.id as id, name, place,
			limitOfParticipants, deadlineOfApplication, timeOfStart, duration, status, registerTime, username');
		$this -> db -> join('users', 'tournaments.organizerId = users.id');
		$this -> db -> group_start();
		$this -> db -> like('name', $searchQuery);
		$this -> db -> or_like('place', $searchQuery);
		$this -> db -> or_like('description', $searchQuery);
		$this -> db -> or_like('discipline', $searchQuery);
		$this -> db -> or_like('status', $searchQuery);
		$this -> db -> group_end();
		if($userId > 0) {
			$this -> db -> join('participantsOfTournaments', 'participantsOfTournaments.tournamentId = tournaments.id');
			$this -> db -> where('participantsOfTournaments.userId', $userId);
		}
		return $this -> db -> count_all_results('tournaments');
	}
	
	public function checkLimitOfParticipants($tournamentId) {
		$this -> db -> select('limitOfParticipants');
		$data = $this -> db -> get_where('tournaments', array('id' => $tournamentId)) -> row_array();
		if(sizeof($data) == 1) {
			return $data['limitOfParticipants'];
		} else {
			return false;
		}
	}
	
	public function checkIfTournamentIsStatus($tournamentId, $status = 'taking place') {
		$conditions = array(
			'id' => $tournamentId,
			'status' => $status
		);
		$this -> db -> select('id');
		if(sizeof($this -> db -> get_where('tournaments', $conditions) -> row_array()) == 1) {
			return true;
		} else {
			return false;
		}
	}
	
	public function changeStatusInto($tournamentId, $status = 'taking place') {
		$this -> db -> where(array('id' => $tournamentId));
		$this -> db -> update('tournaments', array('status' => $status));
	}
	
	public function checkIfOrganizer($tournamentId, $userId) {
		$conditions = array(
			'id' => $tournamentId,
			'organizerId' => $userId
		);
		$this -> db -> select('id');
		if(sizeof($this -> db -> get_where('tournaments', $conditions) -> row_array()) == 1){
			return true;
		} else {
			return false;
		}
	}
}
?>