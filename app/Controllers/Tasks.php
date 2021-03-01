<?php

namespace App\Controllers;

/**
* Home Class is the main frontend class it control login/register
* main screen of the app
*/
class Tasks extends BaseController
{	

	public $LData ;

	public function __construct() 
	{

		// call date lib to talk to API
		$this->LData = new \App\Libraries\Data();
	}

	/**
	* List all the tasks task list view
	* @return string
	*/
	public function index()
	{

		loginCheck();

		// get all tasks
		$result = $this->LData->getAllTask();

		if(!empty($result['response']['data'])) {

			// load response 
			$response['html'] =   view('main\tasks',$result['response']);

		}else{

			$response['html'] = '';
		}
		
		returnJson($response);
	}


	/**
	* Deletes task list view
	* @return string
	*/
	public function addTask()
	{

		loginCheck();

		$time = isset($_POST['start_time'])  ? $_POST['start_time'] : 0;

		if(isset($_POST['title']) && $time) {

			$data = [ 'title'=>$_POST['title'], 'start_time'=>convertTime($_POST['start_time']) ];
			
			// call lib to insert task			
			$result = $this->LData->addTask($data);

			returnJson($result);

		}
		
	}	

	/**
	* Deletes task list view
	*/
	public function deleteTask()
	{

		loginCheck();

		if(isset($_POST['taskid']) && $_POST['taskid'] > 0) {

			$result = $this->LData->deleteTask($_POST['taskid']);

			returnJson($result);

		}
		
	}	

	/**
	* Edit task 
	* @param string title
	* @param string starttime 
	* @return  string
	*/
	public function editTask()
	{

		loginCheck();

		$time = isset($_POST['start_time'])  ? $_POST['start_time'] : 0;

		if(isset($_POST['taskid']) && $_POST['taskid'] > 0 && $time) {

			$data = [ 'title'=>$_POST['title'], 'start_time'=>convertTime($_POST['start_time']), 'taskid'=>$_POST['taskid'] ];

			$result = $this->LData->editTask($data);

			returnJson($result);

		}
		
	}

	/**
	* Show task 
	* @param int taskId
	* @return  string
	*/
	public function showTask()
	{

		loginCheck();
		$response['html'] = ''; 

		if(isset($_POST['taskid']) && $_POST['taskid'] > 0) {

			$result = $this->LData->showTask($_POST['taskid']);
			
			if($result['response']['data'])	{

				$response['html'] =   view('inc\modal_body', $result['response']);	
			
			}

			returnJson($response);

		}
	}	

	
}
