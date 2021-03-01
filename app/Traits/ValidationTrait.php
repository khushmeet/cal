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
                'rules'  => 'trim|required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => '{field} required',
                    'valid_email' => '{field} should be valid address',
                    'is_unique' => '{ Email already exist.}'
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
                'rules'  => 'trim|required|min_length[6]',
                'errors' => [
                    'required' => '{field} required',
                    'min_length' => '{field} should be min 6 character long'
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

    /**
     * Runs the validation check for task data.
     */
    public function taskValidation(array $data)
    {
        // validate the request
        $this->validation->setRules([
            'title' => [
                'label'  => 'Title',
                'rules'  => 'trim|required|min_length[4]',
                'errors' => [
                    'required' => '{field} required',
                    'min_length' => '{field} should be min 4 character.',
                    'is_unique' => 'Task already exist.'
                ]
            ],
            'start_time' => [
                'label'  => 'Start time',
                'rules'  => 'trim|required',
                'errors' => [
                    'required' => '{field} required',
                    'integer' => '{field} must to be valid '
                ]
            ],
            
        ]);

    }


}