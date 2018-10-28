<?php
class Users extends CI_Controller {
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
		$this -> load -> library('email');
		$this -> db -> query('SET GLOBAL TRANSACTION ISOLATION LEVEL SERIALIZABLE;');
		require('/../constants/constants.php');
	}
	
	public function register() {
		$this-> db -> trans_start();
		$data['userId'] = $this -> SessionsModel -> checkSession(get_cookie('userId'), get_cookie('sessionId'), get_cookie('sessionCode'));
		if($data['userId'] > 0) {
			$this -> db -> trans_complete();
			header('Location: http://'.base_url());
			return;
		}
		$data['title'] = 'Register';
		$data['userExists'] = (isset($_GET['userExists']) && $_GET['userExists'] == true ? true : false);
		$validationFields = array('username', 'firstname', 'surname', 'email', 'password', 'confirmPassword');
		foreach($validationFields as $validationField) {
			$this -> form_validation -> set_rules($validationField, $validationField, 'required');
		}
		if($this -> form_validation -> run() === FALSE) {
			$this -> load -> view('templates/header', $data);
			$this -> load -> view('users/register', $data);
			$this -> load -> view('templates/footer');
		} else {
			if($this -> UsersModel -> findUserByUsername($this -> input -> post('username')) <= 0
					&& $this -> UsersModel -> findUserByEmail($this -> input -> post('email')) <= 0) {
				$activateCode = sha1(mcrypt_create_iv(ACTIVATE_CODE_LONG));
				$salt = sha1(mcrypt_create_iv(SALT_CODE_LONG));
				$this -> UsersModel -> registerUser($this -> input -> post('username'), $this -> input -> post('password'),
						$this -> input -> post('email'), $this -> input -> post('firstname'), $this -> input -> post('surname'), $activateCode, $salt);
				$this -> sendVerifyEmailMessage($activateCode, $this -> input -> post('email'));
				header('Location: http://'.base_url().'?register=true');
			} else {
				header('Location: http://'.base_url().'Users/register/?userExists=true');
			}
		}
		$this -> db -> trans_complete();
	}
	
	public function login() {
		$this -> db -> trans_start();
		$data['userId'] = $this -> SessionsModel -> checkSession(get_cookie('userId'), get_cookie('sessionId'), get_cookie('sessionCode'));
		if($data['userId'] > 0) {
			$this -> db -> trans_complete();
			header('Location: http://'.base_url());
			return;
		}
		$data['title'] = 'Login';
		$data['error'] = (isset($_GET['error']) && $_GET['error'] == true ? true : false);
		$this -> form_validation -> set_rules('email', 'email', 'required');
		$this -> form_validation -> set_rules('password', 'password', 'required');
		if($this -> form_validation -> run() === FALSE) {
			$this -> load -> view('templates/header', $data);
			$this -> load -> view('users/login', $data);
			$this -> load -> view('templates/footer');
		} else {
			$salt = $this -> UsersModel -> getSaltCode($this -> input -> post('email'));
			$userId = $this -> UsersModel -> findActiveUserByEmailAndPassword(
				$this -> input -> post('email'), $this -> input -> post('password'), $salt);
			if($userId > 0) {
				$sessionCode = sha1(mcrypt_create_iv(SESSION_CODE_LONG));
				$sessionId = $this -> SessionsModel -> newSession($userId, $sessionCode, date('Y-m-d H:i:s', now()));
				$this -> input -> set_cookie('userId', $userId, time() + LOGIN_TIME);
				$this -> input -> set_cookie('sessionCode', $sessionCode, time() + LOGIN_TIME);
				$this -> input -> set_cookie('sessionId', $sessionId, time() + LOGIN_TIME);
				header('Location: http://'.base_url().'?logIn=true');
			} else {
				header('Location: http://'.base_url().'Users/login/?error=true');
			}
		}
		$this -> db -> trans_complete();
	}
	
	public function logOut() {
		$this -> db -> trans_start();
		$data['userId'] = $this -> SessionsModel -> checkSession(get_cookie('userId'), get_cookie('sessionId'), get_cookie('sessionCode'));
		if($data['userId'] > 0) {
			$this -> SessionsModel -> endSession($data['userId'], get_cookie('sessionId'), get_cookie('sessionCode'));
			delete_cookie('userId');
			delete_cookie('sessionId');
			delete_cookie('sessionCode');
			header('Location: http://'.base_url().'?logOut=true');
		} else {
			header('Location: http://'.base_url());
		}
		$this -> db -> trans_complete();
	}
	
	public function verifyEmail($activateCode) {
		$this -> db -> trans_start();
		$data['title'] = 'Verify e-mail';
		$userId = $this -> UsersModel -> checkActivateCode($activateCode);
		if($userId <= 0) {
			header('Location: http://'.base_url());
		} else {
			$this -> UsersModel -> activateUser($userId, $activateCode);
			$this -> load -> view('templates/header', $data);
			$this -> load -> view('users/activateUser', $data);
			$this -> load -> view('templates/footer');
		}
		$this -> db -> trans_complete();
	}
	
	private function sendVerifyEmailMessage($activateCode, $email) {
		$data['title'] = 'Verify e-mail';
		$data['activateCode'] = $activateCode;
		$this -> email -> from('olejniczakk80@gmail.com', 'Sail Contests');
		$this -> email -> to($email);
		$this -> email -> subject('Sail Contests - '.$data['title']);
		$this -> email -> message($this -> load -> view('templates/emailHeader', $data, true)
			.$this -> load -> view('email/verifyEmail', $data, true).$this -> load -> view('templates/emailFooter', $data, true));
		return $this -> email -> send();
	}
}
?>