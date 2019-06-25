<?php
require_once('SugarClient.php');

class ProposalSugarClient extends SugarClient{

	/**
	* Get Proposal by Id
	* @param, string 
	* @return, object/Exception
	*/
	public function __construct()
	{
		parent::__construct();
	
	}
	public function getHttpHeaders($action)
	{
		$response = '';
		if ($action == 'Fetch' || $action == 'Update') {
			
			//-- Get Access token---
			
			$getAccessTokenExpiry = $this->__check_token_expires('access_token_Cookie');
			if ($getAccessTokenExpiry != False) {
				$accessToken = $getAccessTokenExpiry;	
			} else {
				//$authTokens = $this->__load_user_token_from_aws('admin','Password123');
				$authTokens = $this->__load_user_token_from_aws('AgrawalSa','Test1234');
				$authTokensArray=json_decode($authTokens);
				
				if ($authTokensArray->status == 'Fail') {
						$response = array(
						"status" => "Fail",
						"msg" => "Invalid access to CRM,Please contact to Administrator"
						);
				} else {
					$accessToken = $authTokensArray->access_token;	
				}	
			}
			
			//-- End Access Token---
			$response = array(
				'status' => 'Success',
				'httpHeader' => array(
				"Content-Type: application/json",
				"oauth-token: {$accessToken}"
				)
			);
			return json_encode($response);
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
			"fields" => 'id,name,proposal_id_c,maconomy_job_c,accounts_ls010_proposals_1_name,project_start_date_c,project_close_date_c,estimated_close_date_c,status_c,maconomy_status_c',
			"order_by" => "date_entered",
			"favorites" => false,
			"my_items" => false,
		);
		$proposal_url .= "?" . http_build_query($filter_arguments);
		//-- End Requested URL ---
		
		$method = 'GET'; 
		$httpHeaderResponse = $this->getHttpHeaders('Fetch');
		$httpHeaderResponseArr = json_decode($httpHeaderResponse);
		if ($httpHeaderResponseArr->status == 'Success') {
			$httpHeader = $httpHeaderResponseArr->httpHeader;
			$proposalResponse = $this->curlMethod($proposal_url, $httpHeader, $filter_arguments, $method);
			$proposalJSON = json_decode($proposalResponse);
			
			if (isset($proposalJSON->error) && $proposalJSON->error == 'invalid_grant') {
				
				$authRefresh = $this->__refresh_token($_COOKIE['refresh_token_Cookie']);
				//--- Recursive call---
				
				$this->findProposalByMaconomyNumber($maconomyNo,'webPage');
				
				//------
				
			}else if(empty($proposalJSON->records)) {
				
				$response = array(
					"status" => "Fail",
					"msg" => "No Proposal Found"
					);
				return json_encode($response);
				
				
				
			}else { 
			
				$recordArray = $proposalJSON->records[0];
				if ($source == 'UpdateFun') {
					return $recordArray;
				} elseif ($source == 'webPage')	{
					$proposalDetailsArray = array(
							"APIStatus" => "APISUCCESS",
							"id" => $recordArray->id,
							"name" => $recordArray->name,
							"date_modified" => $recordArray->date_modified,
							"maconomy_job_c" => $recordArray->maconomy_job_c,
							"proposalNO" => $recordArray->proposal_id_c,
							"accountName" => $recordArray->accounts_ls010_proposals_1_name,
							"startDate" => $recordArray->project_start_date_c,
							"closeDate" => $recordArray->project_close_date_c,
							"estimatedCloseDate" => $recordArray->estimated_close_date_c,
							"status" => $recordArray->status_c,
							"maconomyStatus" => $recordArray->maconomy_status_c
						);
					return json_encode($proposalDetailsArray);
				}
			}
		}
		else {
			$response = array(
					"status" => "Fail",
					"msg" => "Invalid access to CRM,Please contact to Administrator"
					);
			return json_encode($response);
		}
	}
	//---Start Of update Proposal----
	public function updateProposalByID($maconomyNo, $proposalId, $lastDateModified ,$startDate, $closeDate, $estimatedCloseDate)
	{
		$proposalDetails = $this->findProposalByMaconomyNumber($maconomyNo, 'UpdateFun');
		$lastCopyTime = strtotime($lastDateModified);
		$currentCopyTime = strtotime($proposalDetails->date_modified);
		if ($lastCopyTime != $currentCopyTime) {
			return $this->findProposalByMaconomyNumber($maconomyNo, 'webPage');
		} else	{
			//---Updated Details---
			$proposalDetails->project_start_date_c = $startDate;
			$proposalDetails->project_close_date_c = $closeDate;
			$proposalDetails->estimated_close_date_c = $estimatedCloseDate;
			
			//-- Fetch Requested URL ---
			$curl_url = $this->getBaseUrlFromConfig();
			$proposal_url = $curl_url. "/LS010_Proposals/".$proposalId;
			//-- End Requested URL ---

			$method = 'PUT'; 
			$httpHeaderResponseUpdate =$this->getHttpHeaders('Update');
			
			$httpHeaderResponse = $this->getHttpHeaders('Fetch');
			$httpHeaderResponseUpArr = json_decode($httpHeaderResponseUpdate);
			if ($httpHeaderResponseUpArr->status == 'Success')	{
				$httpHeader = $httpHeaderResponseUpArr->httpHeader;
				$proposalResponse = $this->curlMethod($proposal_url, $httpHeader, $proposalDetails, $method);
				$proposalJSON = json_decode($proposalResponse);
				if (!empty($proposalJSON->id)) {
					$response = array(
						"status" => "Success",
						"msg" => "Proposal updated successfully ."
						);
					return json_encode($response);
				} else {
					$response = array(
						"status" => "Fail",
						"msg" => "Can't update the proposal,Please contact to Administrator"
						);
					return json_encode($response);
				}
			} else {
				$response = array(
					"status" => "Fail",
					"msg" => "Invalid access to CRM,Please contact to Administrator"
					);
				return json_encode($response);
			}
		}	
	}
}
?>
