<?php
class MatchesModel extends CI_Model {
	public function __construct() {
		$this -> load -> database();
		$this -> load -> helper('date');
		$this -> load -> helper('url');
	}
	
	public function getMatches($tournamentId) {
		$this -> db -> select('m.id as id, m.tournamentId as tournamentId, m.userId1 as userId1,
			m.userId2 as userId2, m.winner1 as winner1, m.winner2 as winner2, m.nextMatchId as nextMatchId,
			m.leaf as leaf, m.greaterRank as greaterRank, us1.username as userUsername1, us2.username as userUsername2,
			us3.username as winnerUsername1, us4.username as winnerUsername2');
		$this -> db -> join('users us1', 'm.userId1 = us1.id', 'left');
		$this -> db -> join('users us2', 'm.userId2 = us2.id', 'left');
		$this -> db -> join('users us3', 'm.winner1 = us3.id', 'left');
		$this -> db -> join('users us4', 'm.winner2 = us4.id', 'left');
		$this -> db -> order_by('greaterRank', 'asc');
		return $this -> db -> get_where('matches m', array('tournamentId' => $tournamentId)) -> result_array();
	}
	
	public function newMatchResult($tournamentId, $playerA, $playerB, $rankA, $rankB, $leaf = false) {
		$data = array(
			'tournamentId' => $tournamentId,
			'userId1' => $playerA,
			'userId2' => $playerB,
			'winner1' => 0,
			'winner2' => 0,
			'nextMatchId' => 0,
			'greaterRank' => ($rankA > $rankB ? $rankA : $rankB),
			'leaf' => $leaf
		);
		$this -> db -> insert('matches', $data);
		return $this -> db -> insert_id();
	}
	
	public function checkIfExistsMatchResults($tournamentId, $userA, $userB, $meId) {
		$conditions = array(
			'tournamentId' => $tournamentId,
			'userId1' => $userA,
			'userId2' => $userB
		);
		if($meId == $userA) {
			$this -> db -> where('winner1', 0);
		} else if($meId == $userB) {
			$this -> db -> where('winner2', 0);
		}
		$this -> db -> select('id');
		if(sizeof($this -> db -> get_where('matches', $conditions) -> row_array()) > 0){
			return true;
		} else {
			return false;
		}
	}
	
	public function checkIfExistsMatchAreComplete($tournamentId, $userA, $userB) {
		$conditions = array(
			'tournamentId' => $tournamentId,
			'userId1' => $userA,
			'userId2' => $userB,
			'winner1 >' => 0,
			'winner2 >' => 0
		);
		if(sizeof($this -> db -> get_where('matches', $conditions) -> row_array()) > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	private function getWinner1val($tournamentId, $userA, $userB) {
		$conditions = array(
			'tournamentId' => $tournamentId,
			'userId1' => $userA,
			'userId2' => $userB,
			'winner1 >' => 0,
			'winner2 >' => 0
		);
		$this -> db -> select('winner1');
		return $this -> db -> get_where('matches', $conditions) -> row_array()['winner1'];
	}
	
	public function checkIfExistsMatchIsConflicting($tournamentId, $userA, $userB) {
		$conditions = array(
			'tournamentId' => $tournamentId,
			'userId1' => $userA,
			'userId2' => $userB,
			'winner1 >' => 0,
			'winner2 >' => 0,
			'winner2 !=' => $this -> getWinner1val($tournamentId, $userA, $userB)
		);
		if(sizeof($this -> db -> get_where('matches', $conditions) -> row_array()) > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function updateMatchReult($tournamentId, $playerA, $playerB, $resultA, $resultB) {
		$conditions = array(
			'tournamentId' => $tournamentId,
			'userId1' => $playerA,
			'userId2' => $playerB
		);
		$data = array();
		if($resultA >= 0) {
			$data = array_merge($data, array('winner1' => $resultA));
		}
		if($resultB >= 0) {
			$data = array_merge($data, array('winner2' => $resultB));
		}
		if(sizeof($data) > 0) {
			$this -> db -> where($conditions);
			$this -> db -> update('matches', $data);
		}
	}
	
	public function setNextMatch($tournamentId, $playerA, $playerB, $nextMatchId) {
		$conditions = array(
			'tournamentId' => $tournamentId,
			'userId1' => $playerA,
			'userId2' => $playerB
		);
		$this -> db -> where($conditions);
		$this -> db -> update('matches', array('nextMatchId' => $nextMatchId));
	}
	
	public function participantsPlayingWithMeNowAsB($tournamentId, $meId) {
		$conditions = array(
			'tournamentId' => $tournamentId,
			'userId1' => $meId,
			'winner1' => 0
		);
		$this -> db -> join('users', 'matches.userId2 = users.id');
		$this -> db -> select('users.id as id, username');
		return $this -> db -> get_where('matches', $conditions) -> result_array();
	}
	
	public function participantsPlayingWithMeNowAsA($tournamentId, $meId) {
		$conditions = array(
			'tournamentId' => $tournamentId,
			'userId2' => $meId,
			'winner2' => 0
		);
		$this -> db -> join('users', 'matches.userId1 = users.id');
		$this -> db -> select('users.id as id, username');
		return $this -> db -> get_where('matches', $conditions) -> result_array();
	}
	
	public function getLastFinishedMatches($tournamentId) {
		$conditions = array(
			'tournamentId' => $tournamentId,
			'winner1 >' => 0,
			'winner2 >' => 0,
			'nextMatchId' => 0
		);
		$this -> db -> order_by('id', 'desc');
		return $this -> db -> get_where('matches', $conditions) -> result_array();
	}
}
?>