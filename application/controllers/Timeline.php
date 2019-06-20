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
	 * Undocumented function
	 *
	 * @return void
	 */
	public function index()
	{
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$data['title'] = 'Timeline';
		$this->load->view('timeline',$data);
	}

	/**
	 * fetch propsal detail from SugarCrm and display on the view 
	 * Using ajax display view
	 * required data macronomy number from view 
	 */

	public function job_detail($maconomy_number_c){
	 	$this->load->library('proposalsugarclient');
	 	$this->proposalsugarclient->findProposalByMaconomyNumber($maconomy_number_c);
	}

	/**
	 * update sugar timeline date 
	 *
	 * @return void
	 */
	public function update_timeline(){
		if(!empty($this->input->post('datepicker') && !empty($this->input->post('datepicker_pet') && !empty($this->input->post('datepicker_pct'))))){
			// validate the datetime and convert as per need 
		}
		redirect('/timeline');
	}

}
