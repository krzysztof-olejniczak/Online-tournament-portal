<?php
class SessionsModel extends CI_Model {
	public function __construct() {
		$this -> load -> database();
		$this -> load -> helper('url');
	}
	
	public function newSession($userId, $sessionCode, $time) {
		$data = array(
			'sessionCode' => $sessionCode,
			'userId' => $userId,
			'loginTime' => $time,
			'logoutTime' => NULL,
			'ipAddress' => $_SERVER['REMOTE_ADDR']
		);
		$this -> db -> insert('sessions', $data);
		return $this -> db -> insert_id();
	}
	
	public function checkSession($userId, $sessionId, $sessionCode) {
		$data = array(
			'sessions.id' => $sessionId,
			'sessionCode' => $sessionCode,
			'userId' => $userId,
			'logoutTime' => NULL,
			'ipAddress' => $_SERVER['REMOTE_ADDR']
		);
		$this -> db -> join('users','users.id = sessions.userId');
		$this -> db -> where('loginTime >', date('Y-m-d H:i:s', time() - LOGIN_TIME)); 
		$this -> db -> select('userId');
		$data = $this -> db -> get_where('sessions', $data) -> row_array();
		if(sizeof($data) > 0) {
			return $data['userId'];
		} else {
			return false;
		}
	}
	
	public function endSession($userId, $sessionId, $sessionCode) {
		$this -> db -> where('userId', $userId);
		$this -> db -> where('id', $sessionId);
		$this -> db -> where('sessionCode', $sessionCode);
		$this -> db -> update('sessions', array('logoutTime' => date('Y-m-d H:i:s', now())));
	}
}
?>