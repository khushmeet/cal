<?php

namespace App\Controllers\API;

use CodeIgniter\Controller;

use App\Models\ScheduleModel;


class Schedule extends BaseAPIController
{

	protected $scheduleModel = '';
	
    protected $userdata = [];

    protected $taskid = '';

	public function __construct() {

        parent::__construct();

		$this->scheduleModel = new ScheduleModel();

	}

    /*
    * Fetch all the task related to user
    * @return String $response
    */
	public function index()
	{
        // Validate Auth and fetch data
        $this->validateRequest(1);

        // get task from db
        $task = $this->scheduleModel->where('user_id',  $this->userdata->data->id)->findAll();

        // set API response via helper
        $response = !empty($task) ? setAPIresponse(['Success'=>'Data Found'], 200, ['data' => $task] ) : setAPIresponse(['Success'=>'Data not Found'], 200 );

        // return response
        return $this->respond($response);
        
	}


	/*
    * Fetch single task 
    * @return string $response
    */
    public function show()
    {
        // Validate Auth and fetch data
        $this->validateRequest();

        // get task from db
        $task = $this->scheduleModel->where(['user_id'=>$this->userdata->data->id, 'id'=>$this->taskid ])->findAll();

        // set API response via helper
        $response = !empty($task) ? setAPIresponse(['Success'=>'Data Found'], 200, ['data' => $task] ) : setAPIresponse(['Success'=>'Data not Found'], 200 );

        // return response
        return $this->respond($response);
       
                
    }
 
    /*
    * Update task
    * @return string $response
    */
    public function update()
    {
        
        // validate user  and task
        $this->validateRequest();

        $data = [
                'title' => $this->request->getVar('title'),
                'start_time' => $this->request->getVar('start_time'),
        ];

        // validate user task data from traits
        $this->taskValidation($data);

        if ( $this->validation->withRequest($this->request)->run() == FALSE) {

                // Return the error response
                $data =   $this->validation->getErrors();

                // set API response via helper
                $response = setAPIresponse($data,400);
                
        } else {

            // check if id exist in db
            if($this->scheduleModel->where(['user_id'=>$this->userdata->data->id, 'id'=>$this->taskid ])->findAll()) {

                // delete task from db
                $this->scheduleModel->update(['id'=>$this->taskid, 'user_id' => $this->userdata->data->id], $data);

                $response = setAPIresponse(['Success'=>'Row updated'], 200);

            }else {

                // set API response via helper
                $response = setAPIresponse(['Failed'=>'Id does not exist.'], 400);

            }

        }
        
        return $this->respond($response);
    }

    public function insert()
    {

        $this->userdata =  $this->fetchHeaders();

        $data = [
                'user_id' => $this->userdata->data->id,
                'title' => $this->request->getVar('title'),
                'start_time' => $this->request->getVar('start_time'),
        ];

        // validate task data from traits
        $this->taskValidation($data);

        if ( $this->validation->withRequest($this->request)->run() == FALSE) {

                // Return the error response
                $data =   $this->validation->getErrors();

                // set API response via helper
                $response = setAPIresponse($data,400,);
                
        } else {

            // try to Register the user 
            if ($insert_id =  $this->scheduleModel->insert($data)) {

                // set API response via helper
                $response = setAPIresponse(['Success'=>'Added successfully.'], 200, ['Insert id' => $insert_id]);

            } else {

                // Unique task 
                $response = setAPIresponse(['Failed'=>'Failed. Task already exist.'], 500);
 
            }

        }
        
        return $this->respond($response);
    }
 
    /*
    * Delete the task
    * @return string $response
    */ 
    public function delete()
    {
        
        // validate user  and task
        $this->validateRequest();

        if($this->scheduleModel->where(['user_id'=>$this->userdata->data->id, 'id'=>$this->taskid ])->findAll()) {

            // delete task from db
            $this->scheduleModel->where(['user_id'=>$this->userdata->data->id, 'id'=>$this->taskid ])->delete();

            $response = setAPIresponse(['Success'=>'Row deleted.'], 200);

        }else {

            // set API response via helper
            $response = setAPIresponse(['Failed'=>'Id does not exist'], 400);

        }
            
        return $this->respond($response);

    }
        

    protected function validateRequest($bypass=0) {

        // get the Auth token to validate user   
        $this->userdata =  $this->fetchHeaders();
         
        // set the task id 
        $this->taskid =  $this->request->getVar("taskid") ?? '' ;

        // if parameter passed are valid
        if($bypass  ||  ( isset($this->userdata->data->id) && is_numeric($this->taskid)) )
        {

            $this->taskid;            

        }else{

            // if parameter is invalid
            $response = setAPIresponse(['Failed'=>'Invalid request'], 400);
   
            returnJson($response);

        }

    }


}
