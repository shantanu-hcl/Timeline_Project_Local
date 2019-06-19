<?php
//require_once('SugarClient.php');
class ProposalSugarClient{
	private $modulus = "LS010_Proposals"; //hardcoded, 1 class 1 modulus

	/**
	* Get Proposal by Id
	* @param, string 
	* @return, object/Exception
	*/
	public function __construct() {
		$this->ci =& get_instance();
	}

	public function findProposalByMaconomyNumber($maconomy_number_c){
		echo 112121; die;
	}
	
}
?>