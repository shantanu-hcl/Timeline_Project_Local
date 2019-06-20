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

	public function job_detail(){
		//91231524
		$maconomy_number_c = $this->input->post('job_number');
		$this->load->library('proposalsugarclient');
		$dataArray = $this->proposalsugarclient->findProposalByMaconomyNumber($maconomy_number_c,'webPage');
		//print_r($dataArray); die;
		if(is_array($dataArray)){
			$response = $this->load->view('job_detail',$dataArray);
		}else{
			$response = "<div class='container'><div class='row'><div class='col-md-12 col-sm-3 timeline-margin-header'><h4>No Proposal Found .</h4></div></div></div>";
		}
		echo $response;
		
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
