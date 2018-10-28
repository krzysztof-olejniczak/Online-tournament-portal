<?php
class ParticipantsOfTournamentsModel extends CI_Model {
	public function __construct() {
		$this -> load -> database();
		$this -> load -> helper('date');
		$this -> load -> helper('url');
	}
	
	public function getNumberOfParticipantsOfTournaments() {
		$this -> db -> select('tournamentId, count(*)');
		$this -> db -> from('participantsOfTournaments');
		$this -> db -> group_by('tournamentId');
		return $this -> db -> get() -> result_array();
	}
	
	public function participateInTournament($tournamentId, $userId) {
		$data = array(
			'tournamentId' => $tournamentId,
			'userId' => $userId,
			'numberOfLicence' => $this -> input -> post('licenceNumber'),
			'points' => 0,
			'actualRank' => $this -> input -> post('rank')
		);
		$this -> db -> insert('participantsOfTournaments', $data);
	}
	
	public function checkNumberOfParticipants($tournamentId) {
		$this -> db -> where('tournamentId', $tournamentId);
		return $this -> db -> count_all_results('participantsOfTournaments');
	}
	
	public function findByNumberOfLicence($tournamentId, $numberOfLicence) {
		$this -> db -> where('tournamentId', $tournamentId);
		$this -> db -> where('numberOfLicence', $numberOfLicence);
		$data = $this -> db -> get('participantsOfTournaments') -> row_array();
		if(sizeof($data) > 0) {
			return $data['userId'];
		} else {
			return false;
		}
	}
	
	public function findByRank($tournamentId, $actualRank) {
		$this -> db -> where('tournamentId', $tournamentId);
		$this -> db -> where('actualRank', $actualRank);
		$data = $this -> db -> get('participantsOfTournaments') -> row_array();
		if(sizeof($data) > 0) {
			return $data['userId'];
		} else {
			return false;
		}
	}
	
	public function checkIfParticipate($tournamentId, $userId) {
		$conditions = array(
			'tournamentId' => $tournamentId,
			'userId' => $userId
		);
		$this -> db -> select('numberOfLicence');
		if(sizeof($this -> db -> get_where('participantsOfTournaments', $conditions) -> row_array()) > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function otherParticipantsOfTournament($tournamentId, $meId) {
		$this -> db -> select('id, username');
		$this -> db -> join('participantsOfTournaments', 'participantsOfTournaments.userId = users.id');
		$this -> db -> where('participantsOfTournaments.tournamentId', $tournamentId);
		$this -> db -> where('users.id !=', $meId);
		return $this -> db -> get('users') -> result_array();
	}
	
	public function getPoints($tournamentId, $userId) {
		$conditions = array('tournamentId' => $tournamentId, 'userId' => $userId);
		$this -> db -> select('points');
		return $this -> db -> get_where('participantsOfTournaments', $conditions) -> row_array()['points'];
	}
	
	public function savePoints($tournamentId, $userId, $points) {
		$conditions = array('tournamentId' => $tournamentId, 'userId' => $userId);
		$this -> db -> where($conditions);
		$this -> db -> update('participantsOfTournaments', array('points' => $points));
	}
	
	public function getTournamentParticipants($tournamentId) {
		$this -> db -> select('username, points, numberOfLicence');
		$this -> db -> from('participantsOfTournaments');
		$this -> db -> where('participantsOfTournaments.tournamentId', $tournamentId);
		$this -> db -> join('users', 'participantsOfTournaments.userId = users.id');
		$this -> db -> order_by('points', 'desc'); 
		return $this -> db -> get() -> result_array();
	}
	
	public function getTournamentParticipantsIds($tournamentId) {
		$this -> db -> order_by('actualRank', 'desc');
		return $this -> db -> get_where('participantsOfTournaments', array('tournamentId' => $tournamentId)) -> result_array();
	}
}
?>