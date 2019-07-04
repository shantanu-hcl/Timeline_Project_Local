<?php
/*
* This class is the base class for client intergacted with sugar 
*/
require_once('config.php');
require 'awsSDK\aws-autoloader.php';
date_default_timezone_set('UTC');

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

class SugarClient {

    private $access_token = '';
    private $expires_datetime = '';
    private $refresh_token = '';
    private $download_token = '';
    private $base_url;
	private static $instance = array();

	/**
	* a private constructor to build a client base on the user 
	* @param string, username
	* @return SugarClient/Unauthenticate_SugarClientException
	*/
	public function __construct()
	{
			
		// step 1 load the base url from config;
		$this->base_url = self::getBaseUrlFromConfig();
		// step 2 load the data from aws dynamodb
		// if the data isn't found in dynamodb throw an exception
		// if the data is found in the dynamodb assign the variable, and return the object
	}
	/**
	*	@Connect TO DynamoDB  
	*/
	public function connectToDb()
	{
		$sdk = new Aws\Sdk([
			'endpoint'   => 'http://localhost:8000',
			'region'   => 'local',
			'version'  => 'latest'
		]);

		$dynamodb = $sdk->createDynamoDb();
		return $dynamodb;
	}
	
	/**
	*	@return base url for API 
	*/
	public function getBaseUrlFromConfig()
	{
		// load the config
		global $config_cstm;
		$url = $config_cstm['sugar_base_url'];
		return $url;
	}
	
	/**
	* @param $username
	* @return array($itemList)
	*/
	public function __load_user_token_from_aws($username)
	{
		global $config_cstm;
		$dynamodb = $this->connectToDb();	
		$marshaler = new Marshaler();
		$tableName = $config_cstm['table'];
		$key = $marshaler->marshalJson('
			{
				"username": "' . $username . '"
			}
		');

		$params = [
			'TableName' => $tableName,
			'Key' => $key
		];

		try {
			$result = $dynamodb->getItem($params);
			return $result;

		} catch (DynamoDbException $e) {
			$response = array(
				"status" => "Fail",
				"msg" => "Unable to get tokens!"
				);
			//echo $e->getMessage() . "\n";
			return $response;
		}
	}
	
	
	/**
	* @param $username
	* @return array($status, $access_token, $refresh_token, $download_token)
	*/
	public function authenticate($username, $password)
	{
		global $config_cstm;
		$curl_url = $this->getBaseUrlFromConfig();
		$auth_url = $curl_url . "/oauth2/token";
		$clientID = $config_cstm['sugar_clientID'];
		$clientSecret = $config_cstm['sugar_clientSecret'];
		$grantType = $config_cstm['sugar_grant'];
		$platform = $config_cstm['platform'];
		$httpHeader = array(
				"Content-Type: application/json"
			);
		$oauth2_payload = array(
			"grant_type" => $grantType,
			"client_id" => $clientID, 
			"client_secret" => $clientSecret,
			"username" => $username,
			"password" => $password,
			"platform" => $platform 
		);
		$method = "POST";
		$curl_response = $this->curlMethod($auth_url, $httpHeader, $oauth2_payload, $method);
		$curl_response_array = json_decode($curl_response);
		if (isset($curl_response_array->access_token)) {
			$access_token = $curl_response_array->access_token;
			$refresh_token = $curl_response_array->refresh_token;
			$download_token =$curl_response_array->download_token;
			$responseArray = array(
				"status" => "Success",
				"access_token" => $access_token,
				"refresh_token" => $refresh_token,
				"download_token" => $download_token );
				
			//---put the All Token to dynamodb
			$current_dateTime = date('Y-m-d h:m:s');
			$dbRespone = $this->insertItemToDB($username,$access_token,$refresh_token,$download_token,$current_dateTime);
			$dbResponeArr = json_decode($dbRespone);
			if($dbResponeArr->status == 'Success') {
				return json_encode($responseArray);
			} elseif ($dbResponeArr->status == 'Fail') {
				$response = array(
					"status" => "Fail",
					"msg" => "Something went wrong, Please contact to Administrator"
					);
					
				return json_encode($response);
			}
			//------End------			
			
		} else {
			$response = array(
					"status" => "Fail",
					"msg" => "Invalid access to CRM,Please contact to Administrator"
				);
					
			return json_encode($response);
		}
	}
	
	/**
	* @param $username, $access_token, $refresh_token, $download_token
	* @return array($status)
	*/

	public function insertItemToDB($username,$access_token,$refresh_token,$download_token,$current_dateTime)
	{
		global $config_cstm;
		$dynamodb = $this->connectToDb();
		$marshaler = new Marshaler();
		$tableName = $config_cstm['table'];
		$item = $marshaler->marshalJson('
			{
				 "username": "' . $username . '",
				"access_token": "' .$access_token .'",
				"refresh_token": "' . $refresh_token . '",
				"download_token": "' . $download_token . '",
				"access_token_time": "' . $current_dateTime . '",
				"refresh_token_time": "' .  $current_dateTime . '"
			}
		');

		$params = [
			'TableName' => $tableName,
			'Item' => $item
		];

		try {
			$result = $dynamodb->putItem($params);
			$response = array(
					"status" => "Success",
					);
			
		} catch (DynamoDbException $e) {
			echo "Unable to add item:\n";
			echo $e->getMessage() . "\n";
			$response = array(
					"status" => "Fail",
					);
		}
		return json_encode($response);

	}
		
	/**
	* @param $refresh_token
	* @return array($status, $access_token, $refresh_token, $download_token)
	*/
	public function __refresh_token($refresh_token,$username)
	{
		
		global $config_cstm;
		
		if (isset($refresh_token)) {
			$httpHeader = array(
					"Content-Type: application/json"
				);
			$oauth2_payload = array(
				"grant_type" => "refresh_token",
				"client_id" => 'sugar', 
				"client_secret" => '',
				"refresh_token" => $refresh_token,
			);
			
			$method = "POST";
			$curl_url = $this->getBaseUrlFromConfig();
			$auth_url = $curl_url . "/oauth2/token";
			$curl_response = $this->curlMethod($auth_url, $httpHeader, $oauth2_payload, $method);
			$curl_response_array = json_decode($curl_response);
		
			if (isset($curl_response_array->error) && $curl_response_array->error_message == 'Invalid refresh token') {
				
				$password = $config_cstm['sugar_hash'];
				$getAccessTokenFromLogin = $this->authenticate($username, $password);
				return json_encode($getAccessTokenFromLogin);	
			}
			elseif (isset($curl_response_array->access_token)) {
				$access_token = $curl_response_array->access_token;
				$refresh_token = $curl_response_array->refresh_token;
				$download_token =$curl_response_array->download_token;
				$responseArray = array(
					"status" => "Success",
					"access_token" => $access_token,
					"refresh_token" => $refresh_token,
					"download_token" => $download_token );

				//---put the All Token to dynamodb
				$current_dateTime = date('Y-m-d h:m:s');
				$dbRespone = $this->insertItemToDB($username,$access_token,$refresh_token,$download_token,$current_dateTime);
				$dbResponeArr = json_decode($dbRespone);
			
				if($dbResponeArr->status == 'Success') {
					return json_encode($responseArray);
				} elseif ($dbResponeArr->status == 'Fail') {
					$response = array(
						"status" => "Fail",
						"msg" => "Something went wrong, Please contact to Administrator"
						);
						
					return json_encode($response);
				}
			//------End------	
			} else {
				$response = array(
						"status" => "Fail",
						"msg" => "Invalid access to CRM,Please contact to Administrator"
						);
				return json_encode($response);
			}
			
			
		} 

	}
	

	/**
	* Every Http call should check if the token is about to expires or not, if so, refresh the token
	**/

	// get
	/*public function __get($method, $query_string = "", $params = null, $addtl_headers = array()){
	}*/
	//post
	//put
	//error_handle
	public function curlMethod($curl_url , $http_header, $payload, $method)
	{ 
		$auth_curl_request = curl_init();
		if ($method == "POST" || $method == "PUT") {
			$json__payload = json_encode($payload);
			if($method == "PUT") {
				curl_setopt($auth_curl_request, CURLOPT_CUSTOMREQUEST, "PUT");
			}
			curl_setopt($auth_curl_request, CURLOPT_POSTFIELDS, $json__payload);
		}
		curl_setopt($auth_curl_request, CURLOPT_URL, $curl_url);
		curl_setopt($auth_curl_request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($auth_curl_request, CURLOPT_HEADER, false);
		curl_setopt($auth_curl_request, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($auth_curl_request, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($auth_curl_request, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($auth_curl_request, CURLOPT_HTTPHEADER, $http_header);

		//execute request
		$curl_response = curl_exec($auth_curl_request);
		//print_R($curl_response);
		return $curl_response;
	}
	
}


?>
