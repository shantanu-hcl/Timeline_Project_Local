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
            $this->load->library('form_validation');
            $this->load->library('session');
            $this->load->helper(array('form', 'url'));
	}
	
	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function index()
	{
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
            $this->load->library('client');
            $response = $this->client->maconomyNumber($maconomy_number_c);
            log_message("debug", $response);
            echo json_encode($response);
		
	}

	public function update_timeline(){
            if(!empty($this->input->post('pst-date') && !empty($this->input->post('pet-date') && !empty($this->input->post('pct-date'))))){
                /**
                 * set post data
                 */
                try{
                    $postArray = array(
                        "request_type"=>"Update",
                        "maconomyNo"=> $this->input->post('maconomyNo'),
                        "maconomyId"=>  $this->input->post('proposal_id'),
                        "lastDateModified"=> $this->input->post('lastmodify'),
                        "startDate"=>$this->input->post('pst-date'),
                        "closeDate"=> $this->input->post('pct-date'),
                        "estimatedCloseDate"=> $this->input->post('pet-date')
                    );
                    $this->load->library('client');
                    $response = $this->client->proposalByID($postArray);
                    log_message("debug", $response);
                    $dataArray = json_decode($response,true);
                    if(is_array($dataArray)){
                        if($dataArray['status']=='Success'){
                            $this->session->set_flashdata('msg', 'Record Update sucessfully');
                            redirect('/timeline');
                        }else{
                            $this->session->set_flashdata('msg', 'Record not updated, Something went wrong.');
                        }
                    }else{
                        log_message("error", $response);
                        $this->session->set_flashdata('msg', 'Record not updated, Something went wrong.');
                    }
                } catch (Exception $e){
                   log_message("error", $e);
                }
            }else{
                $this->session->set_flashdata('msg', 'Required field will not empty ');
            }
            redirect('/timeline');
	}
}
