<?php

namespace App\Libraries;

/**
 * Data Library handles all the Data Request
 * And Also caches the request if necessary
 * User CI4 library naming standard
 * @category  Data Library
 */

class Data extends API {
	
	// API URL @TODO SET FROM ENV
	protected $api_host = 'http://localhost/cal/public/api';
	
	protected $timestamp = null;
	
	protected $data  = [];
	
	protected $params = [];
	
	// By Default header always required
	protected $headers_required = true;

	public function __construct()
    {
		
		$this->time_now = strtotime(date('Y-m-d H:i:s'));
		
    }
	
	/**
	* Set url for sending curl request
	*/
	protected function set_url($location=null)
	{

		$this->url = $this->api_host.$location;
		
	}
	
	/*
	* Set Request header
	*/
	protected function set_headers()
	{
		if($this->headers_required) { 

			$this->headers =  [
			    'Content-Type:application/json',
				'Authorization: Basic '. base64_encode($this->_partsarena_username . ":" . $this->_partsarena_pwd) // <---
			];

		}

	}

	/**
	* Make CURL request
	* @return array
	*/
	protected function call()
	{	
		$this->set_headers();
		
		$response = $this->request();
		
        return $response;
	}
	
	
	/*
	 * Set param that needs to be send to API to fetch data
	 * @param array  
	 */
	protected function build_query(array $params)
	{

		if(!empty($params)) {

			$this->build_query =  http_build_query($params);
			$this->url = $this->url.'?'.$this->build_query ;
		
		}

	}

	/**
	* Create the request 
	*/
	public function get_request($p_method=null, $params=null, $cache_time = null)
	{
		$loc = '/'.$p_method;
		
		$this->set_url($loc);
		
		if($params) {

			$this->build_query($params);
		
		}
		
		return $this->call(); 
				
	}

	
	
	/**
	 * Validate user request
	 * @return array 
	 */
	public function validateRequest($data)
	{
		
		if(isset($data['email']) && isset($data['password']) ) {

			// set parameter 
			$this->_params = [ 'email' => $data['email'], 'password' => $data['password']  ]; 
			
			// set header status
			$this->headers_required = false;

			// set request method
			$this->method = 'POST';


			return  $this->get_request('login', $this->_params );

		}		

	}
	
	
}
