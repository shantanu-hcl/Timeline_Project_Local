<?php
/*
* This class is the base class for client intergacted with sugar 
*/

class SugarClient{

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
	function __construct(){
		// step 1 load the base url from config;
		$this->base_url = self::getBaseUrlFromConfig();
		$this->ci =& get_instance();
		// step 2 load the data from aws dynamodb
		// if the data isn't found in dynamodb throw an exception
		// if the data is found in the dynamodb assign the variable, and return the object
	}
	/**
	* @return SugarClient
	*/
	static public function getInstance($username){
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
	static public function authenticate($username, $password){
		// step 1 load the base url from config;
		// step 2 call the /oauth2/token service to get the result
		// step 3 if successful 
		//	calculate when token will expire
		//  insert/update the all the data into dynamodb and the record should be deleted from dynamodb in "refresh_expires_in"
		// step 4 destory the cache copy in the $instance
		self::$instance[$username] = null;
		// step 5 return SugarClient
		return self::getInstance($username);
	}
	static public function getBaseUrlFromConfig(){
		// load the config
	}
	/**
	* @param $username
	* @return array($access_token, $refresh_token, $download_token)
	*/
	private function __load_user_token_from_aws($username){

	}
	private function __check_token_expires($username){

	}
	private function __refresh_token($username, $refresh_token){

	}
	/**
	* Every Http call should check if the token is about to expires or not, if so, refresh the token
	**/

	// get
	// protected function __get($method, $query_string = "", $params = null, $addtl_headers = array()){
	// }
	//post
	//put
	//error_handle

}


?>