<?php

namespace App\Controllers;


class Home extends BaseController
{

	public function index()
	{
		loginCheck();
		echo "string";
	}

	/*
	* Handle login and token 
	*/
	public function login()
	{
		if ($this->request->isAJAX() ) {

			$this->validateUser();
			
        }

		$data['body'] = view('form\login');

		return view('index', $data);
	}

	/**
	* Validate the user from api on success set token in session
	* @return string
	*/
	protected function validateUser() {

		 $LData = new \App\Libraries\Data();

            $response = $LData->validateRequest($_POST);
           
            if($response['status_code'] === 200 && isset($response['response']['token'])) {
 				
 				$this->session->set($response['response']);
           		
           		$response = ['message' =>$response['response']['message'], 'status' => $response['response']['status']];

            } else {

            	$response = $response['response'];
            	
            }

             returnJson($response);
	}

	/*
	* Main Dashboard screen once user data is set
	*/
	public function main($i=null)
	{
		loginCheck();

		print_r($_SESSION);
	}

	public function register()
	{

		$data['body'] = view('form\register');

		return view('index', $data);

	}

	public function logout()
	{
		$this->session->destroy();
		header("Location:".base_url()."/login");
		exit();

	}

	
}
