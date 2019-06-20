<?php
require_once('SugarClient.php');

class ProposalSugarClient extends SugarClient{
	private $modulus = "LS010_Proposals"; //hardcoded, 1 class 1 modulus


	/**
	* Get Proposal by Id
	* @param, string 
	* @return, object/Exception
	*/
	public function __construct() {
		$this->ci =& get_instance();
		parent::__construct();
	
	}
	public function getHttpHeaders($action)
	{
		if($action == 'Fetch' || $action =='Update')
		{
			//-- Get Access token---
			$getAccessTokenExpiry = $this->__check_token_expires('access_token_Cookie');
			if($getAccessTokenExpiry != False)
			{
				$accessToken = $getAccessTokenExpiry;	
			}
			else
			{
				$authTokens = $this->__load_user_token_from_aws('admin','Password123');
				$accessToken = $authTokens['access_token'];
			}
			//-- End Access Token---
			$httpHeader = array(
				"Content-Type: application/json",
				"oauth-token: {$accessToken}"
			);
			return $httpHeader;
		}
	}
	public function findProposalByMaconomyNumber($maconomyNo, $source)
	{
		//-- Fetch Requested URL ---
		$curl_url = $this->getBaseUrlFromConfig();
		$proposal_url = $curl_url. "/LS010_Proposals/filter";
		$filter_arguments = array(
			"filter" => array(
				array(
						"maconomy_job_c" => array(
							'$equals'=>$maconomyNo,
						),
					),
			),
			"max_num" => 2,
			"offset" => 0,
			"fields" => 'id,name,maconomy_job_c,accounts_ls010_proposals_1_name,project_start_date_c,project_close_date_c,estimated_close_date_c,status_c,maconomy_status_c',
			"order_by" => "date_entered",
			"favorites" => false,
			"my_items" => false,
		);
		$proposal_url .= "?" . http_build_query($filter_arguments);
		//-- End Requested URL ---
		
		$method = 'GET'; 
		$httpHeader = $this->getHttpHeaders('Fetch');
		$proposalResponse = $this->curlMethod($proposal_url , $httpHeader, $filter_arguments, $method);
		$proposalJSON = json_decode($proposalResponse);
		if(empty($proposalJSON->records))
		{
		    	return "No Proposal Found";
		}
		else
		{ 
			$recordArray = $proposalJSON->records[0];
			if($source == 'UpdateFun')
			{
				return $recordArray;
			}
			else if ($source == 'webPage')
			{
				$proposalDetailsArray = array(
						"id" => $recordArray->id,
						"name" => $recordArray->name,
						"date_modified" => $recordArray->date_modified,
						"maconomy_job_c" => $recordArray->maconomy_job_c,
						"accountName" => $recordArray->accounts_ls010_proposals_1_name,
						"startDate" => $recordArray->project_start_date_c,
						"closeDate" => $recordArray->project_close_date_c,
						"estimatedCloseDate" => $recordArray->estimated_close_date_c,
						"status" => $recordArray->status_c,
						"maconomyStatus" => $recordArray->maconomy_status_c
					);
				return $proposalDetailsArray;
			}
		}
		
	}
	public function updateProposalByID($maconomyNo, $proposalId, $lastDateModified ,$startDate, $closeDate, $estimatedCloseDate)
	{
		$proposalDetails = $this->findProposalByMaconomyNumber($maconomyNo, 'UpdateFun');
		
		$lastCopyTime = strtotime($lastDateModified);
		$currentCopyTime = strtotime($proposalDetails->date_modified);

		if($lastCopyTime != $currentCopyTime)
		{
			return $this->findProposalByMaconomyNumber($maconomyNo, 'webPage');
		}
		else
		{
			//---Updated Details---
			$proposalDetails->project_start_date_c = $startDate;
			$proposalDetails->project_close_date_c = $closeDate;
			$proposalDetails->estimated_close_date_c = $estimatedCloseDate;
			// ----
			
			//-- Fetch Requested URL ---
			$curl_url = $this->getBaseUrlFromConfig();
			$proposal_url = $curl_url. "/LS010_Proposals/".$proposalId;
		
			//-- End Requested URL ---

			$method = 'PUT'; 
			$httpHeader =$this->getHttpHeaders('Update');

			$proposalResponse = $this->curlMethod($proposal_url , $httpHeader, $proposalDetails, $method);
			$proposalJSON = json_decode($proposalResponse);
			if(!empty($proposalJSON->id))
			{
				return "Proposal Updated Successfully";
			}
			else
			{
				return "Can't update the proposal,Please contact to Administrator";
			}
		}
		
	}
}
?>
