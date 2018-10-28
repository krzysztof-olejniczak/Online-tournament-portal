<?php
class ForgottenPasswordModel extends CI_Model {
	public function __construct() {
		$this -> load -> database();
		$this -> load -> helper('url');
	}
	
	public function saveInitCodeForPasswordRestore($generatedNumber, $userId) {
		$data = array(
			'generatedNumber' => $generatedNumber,
			'userId' => $userId,
			'forgottenTime' => date('Y-m-d H:i:s', now()),
			'ipAddress' => $_SERVER['REMOTE_ADDR']
		);
		$this -> db -> insert('forgottenPassword', $data);
	}
	
	public function checkInitCodeForPasswordRestore($forgottenPasswordCode) {
		$conditions = array(
			'generatedNumber' => $forgottenPasswordCode,
			'forgottenTime >=' => date('Y-m-d H:i:s', now() - TIME_TO_RESTORE_PASSWORD),
			'restoreTime' => NULL
		);
		$this -> db -> select('userId');
		$data = $this -> db -> get_where('forgottenPassword', $conditions) -> row_array();
		if(sizeof($data) == 1) {
			return $data['userId'];
		} else {
			return false;
		}
	}
	
	public function setRestoreTime($userId) {
		$this -> db -> where('userId', $userId);
		$this -> db -> where('restoreTime', NULL);
		$this -> db -> update('forgottenPassword', array('restoreTime' => date('Y-m-d H:i:s', now())));
	}
}
?>