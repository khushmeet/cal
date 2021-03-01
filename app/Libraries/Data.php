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
	
	protected $_params = [];
	
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
			   
				'Authorization: '. $_SESSION['token'] .'',
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
		
		return $response = $this->request();
		
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

	/**
	 * Register User
	 * @return array 
	 */
	public function registerUser($data)
	{
		
		// set parameter 
		$this->_params = [ 'email' => $data['email'], 'password' => $data['password'], 'name' => $data['name']  ]; 
		
		// set header status
		$this->headers_required = false;

		// set request method
		$this->method = 'POST';

		return  $this->get_request('register', $this->_params );

	}

	/**
	 * Get all task
	 * @return array 
	 */
	public function getAllTask()
	{
		
		return  $this->get_request('get-schedule');

	}
	
	/**
	 * delete task
	 * @return array 
	 */
	public function deleteTask($taskid)
	{	

		$this->_params = ['taskid'=>$taskid ];
		
		return  $this->get_request('delete-schedule', $this->_params);

	}

	/**
	 * Add task
	 * @return array 
	 */
	public function addTask($data)
	{	

		$this->_params = $data;
		
		// set request method
		$this->method = 'POST';

		return  $this->get_request('create-schedule', $this->_params);

	}

	/**
	 * edit task
	 * @return array 
	 */
	public function editTask($data)
	{	

		$this->_params = $data;

		// set request method
		$this->method = 'POST';
		
		return  $this->get_request('update-schedule', $this->_params);

	}

	/**
	 * show task
	 * @return array 
	 */
	public function showTask($taskid)
	{	

		$this->_params = ['taskid'=>$taskid ];
		
		return  $this->get_request('show-schedule', $this->_params);

	}
}
