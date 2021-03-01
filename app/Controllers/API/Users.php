<?php

namespace App\Controllers\API;

use App\Models\UsersModel;

use \Firebase\JWT\JWT;

class Users extends BaseAPIController
{

	public function __construct() 
    {

        parent::__construct();

		$this->userModel = new UsersModel();

	}

    /**
    * This method create the new user
    * @param array POST
    * @return response
    */
	public function createUser()
    {
    
    	
        $data = [
                "name" => $this->request->getVar("name"),
                "email" => $this->request->getVar("email"),
                "password" => password_hash($this->request->getVar("password"), PASSWORD_DEFAULT),
        ];
        
        // validate user data from traits
        $this->registerValidation($data);

        if ( $this->validation->withRequest($this->request)->run() == FALSE) {

                // Return the error response
                $data =   $this->validation->getErrors();

                // set API response via helper
                $response = setAPIresponse($data,400);
                
        } else {

            // try to Register the user 
            if ($this->userModel->insert($data)) {

                // set API response via helper
                $response = setAPIresponse(['Success'=>'User created successfully.'], 200);

            } else {

                // OWASP : Dont reveal any info just say cannot create
                $response = setAPIresponse(['Failed'=>'Failed to create user.'], 500);
 
            }

        }
        
        return $this->respond($response);
    }


    /**
    * This method valide the login request 
    * @param array POST
    * @return response
    */
	public function validateUser() 
	{

		$data = [
                "email" => $this->request->getVar("email"),
                "password" => $this->request->getVar("password"),
        ];

        // validate user data from traits
        $this->loginValidation($data);

        if ( $this->validation->withRequest($this->request)->run() == FALSE) {

            // Get validation errors
            $data =   $this->validation->getErrors();

            // set API response via helper
            $response = setAPIresponse($data, 400);

        } else {

            $userdata = $this->userModel->getWhere(['email' => $data['email'] ])->getResultArray();

            // verify password
            if (!empty($userdata)) { 

                // verify  user data with input password
                $response = $this->verifyPassword($userdata[0], $data);

            } else {

                // incorrect values 
                $response = setAPIresponse(['Failed'=>'Invalid email/password combination.'], 500);

            }

        }

		return $this->respond($response);
	}

    /*
    * Vefiy the password 
    * @param array $userdata 
    * @param array $inputdata
    * @return array Response
    */
    protected function verifyPassword($userdata, $inputdata) 
    {
        
        if (password_verify($inputdata['password'], $userdata['password'])) {
     
            // lets not send the password!!!
            unset($userdata['password']);
     
            // password validated create jwt payload
            $token =  $this->createToken($userdata);

            // set API response via helper
            $response = setAPIresponse(['Success'=>'Login successfully.'], 200, ['token'=>$token]);

        }else {

            // set API response via helper
            $response = setAPIresponse(['Failed'=>'Invalid email/password combination.'], 500);

        }

        return $response;

    }

    /*
    * Fetch the user details from token
    * @return string Response
    */
    public function userDetails()
    {
        // fetch the header data
        $decoded = $this->fetchHeaders();

        // set API response via helper
        $response = setAPIresponse(['Success'=>'User detail found'], 200, ['data' => $decoded]);

        return $this->respond($response);
        
    }


}
