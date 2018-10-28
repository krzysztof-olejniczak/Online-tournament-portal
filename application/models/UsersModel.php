<?php
class UsersModel extends CI_Model {
	public function __construct() {
		$this -> load -> database();
		$this -> load -> helper('url');
	}
	
	public function registerUser($username, $password, $email, $firstname, $surname, $activateCode, $salt) {
		$data = array(
			'username' => $username,
			'encryptedPassword' => password_hash($password, PASSWORD_BCRYPT, array('salt' => $salt)),
			'email' => $email,
			'firstname' => $firstname,
			'surname' => $surname,
			'type' => 'user',
			'activateCode' => $activateCode,
			'salt' => $salt,
			'active' => false
		);
		$this -> db -> insert('users', $data);
	}
	
	public function findUserByEmail($email) {
		$this -> db -> select('id');
		$data = $this -> db -> get_where('users', array('email' => $email)) -> row_array();
		if(sizeof($data) == 1) {
			return $data['id'];
		} else {
			return false;
		}
	}
	
	public function getSaltCode($email) {
		$this -> db -> select('salt');
		$data = $this -> db -> get_where('users', array('email' => $email)) -> row_array();
		if(sizeof($data) == 1) {
			return $data['salt'];
		} else {
			return false;
		}
	}
	
	public function findUserByUsername($username) {
		$this -> db -> select('id');
		$data = $this -> db -> get_where('users', array('username' => $username)) -> row_array();
		if(sizeof($data) == 1) {
			return $data['id'];
		} else {
			return false;
		}
	}
	
	public function findActiveUserByEmailAndPassword($email, $password, $salt) {
		$conditions = array(
			'email' => $email,
			'encryptedPassword' => password_hash($password, PASSWORD_BCRYPT, array('salt' => $salt)),
			'active' => true
		);
		$this -> db -> select('id');
		$data = $this -> db -> get_where('users', $conditions) -> row_array();
		if(sizeof($data) == 1) {
			return $data['id'];
		} else {
			return false;
		}
	}
	
	public function checkActivateCode($activateCode) {
		$conditions = array(
			'active' => false,
			'activateCode' => $activateCode
		);
		$this -> db -> select('id');
		$data = $this -> db -> get_where('users', $conditions) -> row_array();
		if(sizeof($data) == 1) {
			return $data['id'];
		} else {
			return false;
		}
	}
	
	public function activateUser($id, $activateCode) {
		$this -> db -> where('id', $id);
		$this -> db -> where('activateCode', $activateCode);
		$this -> db -> update('users', array('active' => true));
	}
	
	public function changePassword($userId, $newPassword, $salt) {
		$this -> db -> where('id', $userId);
		$this -> db -> update('users', array('encryptedPassword' =>
			password_hash($newPassword, PASSWORD_BCRYPT, array('salt' => $salt)), 'salt' => $salt));
	}
}
?>