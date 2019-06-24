<?php
/*
* This class is the base class for client intergacted with sugar 
*/
require_once('config.php');
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
	* @return SugarClient
	*/
/*	static public function getInstance($username){
		if (is_null(self::$instance[$username])) {
          self::$instance[$username] = new SugarClient($username);
		}
		return self::$instance[$username];
	}
	/**
	* Reference https://support.sugarcrm.com/Documentation/Sugar_Developer/Sugar_Developer_Guide_8.2/Integration/Web_Services/REST_API/Endpoints/oauth2token_POST/index.html
	* @param string, $base_url 
	* @param string, $username
	* @param string, $password
	* @return SugarClient
	*/
	/*static public function authenticate($username, $password){
		// step 1 load the base url from config;
		// step 2 call the /oauth2/token service to get the result
		// step 3 if successful 
		//	calculate when token will expire
		//  insert/update the all the data into dynamodb and the record should be deleted from dynamodb in "refresh_expires_in"
		// step 4 destory the cache copy in the $instance
		self::$instance[$username] = null;
		// step 5 return SugarClient
		return self::getInstance($username);
	}*/
	public function getBaseUrlFromConfig()
	{
		// load the config
		global $config_cstm;
		$url = $config_cstm['sugar_base_url'];
		return $url;
	}
	/**
	* @param $username
	* @return array($access_token, $refresh_token, $download_token)
	*/
	protected function __load_user_token_from_aws($username, $password)
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
				
			setcookie("access_token_Cookie", $access_token, time()+ 3600,'/'); 	// expires after 1 hour
			setcookie("refresh_token_Cookie", $refresh_token, time()+ 3600,'/'); 
			return json_encode($responseArray);
		} else {
			$response = array(
					"status" => "Fail",
					"msg" => "Invalid access to CRM,Please contact to Administrator"
					);
			return json_encode($response);
		}
	}
	protected function __check_token_expires($token_key)
	{
		//unset($_COOKIE['access_token_Cookie']);
		
		if(empty($_COOKIE[$token_key])) {
			return false;
		} else {
			return $_COOKIE[$token_key];
		}
	}
	protected function __refresh_token($refresh_token)
	{
		
		if(!empty($_COOKIE['refresh_token_Cookie'])) {
			$httpHeader = array(
					"Content-Type: application/json"
				);
			$oauth2_payload = array(
				"grant_type" => "refresh_token",
				"client_id" => 'sugar', 
				"client_secret" => '',
				"refresh_token" => $refresh_token,
			);
			print_R(json_encode($oauth2_payload));
			$method = "POST";
			$curl_url = $this->getBaseUrlFromConfig();
			$auth_url = $curl_url . "/oauth2/token";
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
					
				setcookie("access_token_Cookie",'', time()- 3700,'/'); 	// expires after 1 hour
				setcookie("refresh_token_Cookie",'', time()- 3700,'/');
				setcookie("access_token_Cookie", $access_token, time()+ 3600,'/'); 	// expires after 1 hour
				setcookie("refresh_token_Cookie", $refresh_token, time()+ 3600,'/'); 
				return json_encode($responseArray);
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
	/*protected function __get($method, $query_string = "", $params = null, $addtl_headers = array()){
	}*/
	//post
	//put
	//error_handle
	protected function curlMethod($curl_url , $http_header, $payload, $method)
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
