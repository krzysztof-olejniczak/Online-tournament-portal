<?php
class SponsorLogosModel extends CI_Model {
	public function __construct() {
		$this -> load -> database();
		$this -> load -> helper('date');
		$this -> load -> helper('url');
	}
	
	public function newSponsorLogo($tournamentId, $logoPath) {
		$data = array(
			'tournamentId' => $tournamentId,
			'logoName' => $logoPath
		);
		$this -> db -> insert('sponsorLogos', $data);
	}
	
	public function getSponsorLogosData($tournamentId) {
		$this -> db -> select('logoName');
		return $this -> db -> get_where('sponsorLogos', array('tournamentId' => $tournamentId)) -> result_array();
	}
}
?>