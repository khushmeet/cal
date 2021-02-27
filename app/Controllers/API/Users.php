<?php

namespace App\Controllers\API;

use App\Models\UsersModel;

use \Firebase\JWT\JWT;

class Users extends BaseAPIController
{

	public function __construct() {

        parent::__construct();
		$this->userModel = new UsersModel();

	}

	public function index()
	{
		$data = $this->model->findAll();

        return $this->respond($data);
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

                 $response = [
                    'messages' => $data,
                    'status' => 400
                ];
                

        } else {

            // try to Register the user 
            if ($this->userModel->insert($data)) {

                $response = [
                    'message' => 'User created successfully.',
                    'status' => 200
                ];

            } else {

                // OWASP : Dont reveal any info just say cannot create
                $response = [
                    'message' => 'Failed to create user.',
                    'status' => 500
                ];
 
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

            $data =   $this->validation->getErrors();

            $response = [
                    'messages' => $data,
                    'status' => 400
                ];

         } else {

            $userdata = $this->userModel->getWhere(['email' => $data['email'] ])->getResultArray();

            // verify password
            if (!empty($userdata)) { 

                // verify  user data with input password
                $response = $this->verifyPassword($userdata[0], $data);

            } else {

                // incorrect values 
                $response = [
                    'message' => 'Invalid email/password combination.',
                    'status' => 500
                ];
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

            $response = [
                    'token' => $token,
                    'message' => 'Login successfully.',
                    'status' => 200
                ];
            

        }else {

            $response = [
                    'message' => 'Invalid email/password combination.',
                    'status' => 500
                ];

        }

        return $response;

    }

     


    public function userDetails()
    {

        $authHeader = $this->request->getHeader("Authorization");
        
        if(!$authHeader) {

            return $this->failValidationError('Request Failed');

        }

        try {

            $token = $authHeader->getValue();

            $this->decodeToken($token);

            if ($decoded) {

                $response = [
                        'status' => 200,
                        'messages' => 'User details',
                        'data' => $decoded
                ];

                return $this->respondCreated($response);
            }
        } catch (Exception $ex) {
            
            $response = [
                    'status' => 401,
                    'messages' => 'Access denied'
            ];

            return $this->respondCreated($response);
        }
    }


}
