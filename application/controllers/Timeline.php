<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * created by nilesh kumar
 * created date 18/06/2019
 */
class Timeline extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('url'); 
	}
	
	/**
	 * By default landing page 
	 * view of the form action 
	 */
	public function index()
	{
		$data['title'] = 'Timeline';
		$this->load->view('timeline',$data);
	}

	public function job_detail($maconomy_number_c){
	 	$this->load->library('proposalsugarclient');
	 	$this->proposalsugarclient->findProposalByMaconomyNumber($maconomy_number_c);
	}

}
