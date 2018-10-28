<?php
class ForgottenPassword extends CI_Controller {
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
	
	public function forgottenPassword() {
		$this -> db -> trans_start();
		$data['title'] = 'Forgotten password';
		$data['userId'] = $this -> SessionsModel -> checkSession(get_cookie('userId'), get_cookie('sessionId'), get_cookie('sessionCode'));
		if($data['userId'] > 0) {
			$this -> db -> trans_complete();
			header('Location: http://'.base_url());
			return;
		}
		$this -> form_validation -> set_rules('email', 'email', 'required');
		$data['emailSent'] = false;
		$data['badEmail'] = false;
		if($this -> form_validation -> run() === TRUE) {
			$userId = $this -> UsersModel -> findUserByEmail($this -> input -> post('email'));
			if($userId > 0) {
				$forgottenPasswordCode = sha1(mcrypt_create_iv(FORGOTTEN_PASSWORD_CODE_LONG));
				$this -> ForgottenPasswordModel -> saveInitCodeForPasswordRestore($forgottenPasswordCode, $userId);
				$this -> sendRestorePasswordMessage($forgottenPasswordCode, $this -> input -> post('email'));
				$data['emailSent'] = true;
			} else {
				$data['badEmail'] = true;
			}
		}
		$this -> load -> view('templates/header', $data);
		$this -> load -> view('users/forgottenPassword', $data);
		$this -> load -> view('templates/footer');
		$this -> db -> trans_complete();
	}
	
	public function restorePassword($forgottenPasswordCode) {
		$this -> db -> trans_start();
		$data['title'] = 'Restore password';
		$data['forgottenPasswordCode'] = $forgottenPasswordCode;
		$data['userId'] = $this -> SessionsModel -> checkSession(get_cookie('userId'), get_cookie('sessionId'), get_cookie('sessionCode'));
		$userId = $this -> ForgottenPasswordModel -> checkInitCodeForPasswordRestore($forgottenPasswordCode);
		$this -> form_validation -> set_rules('password', 'password', 'required');
		$this -> form_validation -> set_rules('confirmPassword', 'confirmPassword', 'required');
		if($data['userId'] > 0 || $userId <= 0) {
			header('Location: http://'.base_url());
		} else if($this -> form_validation -> run() === TRUE && $userId >= 0) {
			$salt = sha1(mcrypt_create_iv(SALT_CODE_LONG));
			$this -> UsersModel -> changePassword($userId, $this -> input -> post('password'), $salt);
			$this -> ForgottenPasswordModel -> setRestoreTime($userId);
			$data['restored'] = true;
		} else {
			$data['restored'] = false;
		}
		$this -> load -> view('templates/header', $data);
		$this -> load -> view('users/restorePassword', $data);
		$this -> load -> view('templates/footer');
		$this -> db -> trans_complete();
	}
	
	private function sendRestorePasswordMessage($restoreCode, $email) {
		$data['title'] = 'Password restore';
		$data['restoreCode'] = $restoreCode;
		$this -> email -> from('olejniczakk80@gmail.com', 'Sail Contests');
		$this -> email -> to($email);
		$this -> email -> subject('Sail Contests - '.$data['title']);
		$this -> email -> message($this -> load -> view('templates/emailHeader', $data, true)
			.$this -> load -> view('email/restorePassword', $data, true).$this -> load -> view('templates/emailFooter', $data, true));
		return $this -> email -> send();
	}
}
?>