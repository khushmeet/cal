<?php

namespace App\Traits;

Trait ValidationTrait
{

    public $validation = '';

    // CI4 default validation
    protected function __construct()
    {
        $this->validation = \Config\Services::validation();
    }


    /**
     * Runs the validation check for registeration.
     */
	public function registerValidation(array $data)
	{
        // validate the request
        $this->validation->setRules([
            'email' => [
                'label'  => 'Email',
                'rules'  => 'trim|required|valid_email',
                'errors' => [
                    'required' => '{field} required',
                    'valid_email' => '{field} should be valid address'
                ]
            ],
            'name' => [
                'label'  => 'Name',
                'rules'  => 'trim|required',
                'errors' => [
                    'required' => '{field} required',
                    'valid_email' => '{field} should be valid name'
                ]
            ],
            'password' => [
                'label'  => 'Password ',
                'rules'  => 'trim|required',
                'errors' => [
                    'required' => '{field} required',
                ]
            ]
        ]);

	}

    /**
     * Runs the validation check for login.
     */
    public function loginValidation(array $data)
    {
        // validate the request
        $this->validation->setRules([
            'email' => [
                'label'  => 'Email',
                'rules'  => 'trim|required|valid_email',
                'errors' => [
                    'required' => '{field} required',
                    'valid_email' => '{field} should be valid address'
                ]
            ],
            'password' => [
                'label'  => 'Password ',
                'rules'  => 'trim|required',
                'errors' => [
                    'required' => '{field} required',
                ]
            ]
        ]);

    }


}