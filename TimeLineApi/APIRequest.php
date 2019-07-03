<?php
/*
* This file is for integration with Codeignitor 
*/

require_once('ProposalSugarClient.php');

$requestJSON = json_decode(file_get_contents('php://input'));

if ($requestJSON->request_type == 'Fetch') {
	
	$maconomyNo = $requestJSON->maconomyNo;
	$ProposalSugarClient = new ProposalSugarClient();
	$response = $ProposalSugarClient->findProposalByMaconomyNumber($maconomyNo,'webPage');
	echo $response;
	
} elseif ($requestJSON->request_type == 'Update') {
	$maconomyNo = $requestJSON->maconomyNo;
	$proposalId = $requestJSON->maconomyId;
	$lastDateModified = $requestJSON->lastDateModified;
	$startDate = $requestJSON->startDate;
	$closeDate = $requestJSON->closeDate;
	$estimatedCloseDate = $requestJSON->estimatedCloseDate;
	$ProposalSugarClient = new ProposalSugarClient();
	$updateResponse = $ProposalSugarClient->updateProposalByID($maconomyNo, $proposalId, $lastDateModified ,$startDate, $closeDate, $estimatedCloseDate);
	echo $updateResponse;
}
